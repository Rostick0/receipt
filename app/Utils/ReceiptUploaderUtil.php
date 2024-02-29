<?php

namespace App\Utils;

use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Validator;

class ReceiptUploaderUtil
{
    public static function upload($request, $user_id, $folder_id = null)
    {


        $folder = null;

        if ($folder_id) {
            $folder = Folder::where([
                [
                    'user_id', '=', $user_id,
                ],
                [
                    'id', '=', $folder_id,
                ]
            ])->first();

            if (!$folder) return AccessUtil::errorMessage(
                'Данного чека не существует',
                400
            );
        }

        $errors = [];
        $access = 0;

        $for_load = [];

        $get_content = json_decode($request->file('upload')->getContent(), true);
        $data = $get_content[0] ?? false ? $get_content : [$get_content];

        collect($data)->lazy()->each(function ($item, $index) use (&$access, &$for_load, &$errors) {
            if (!isset($item['ticket']['document']['receipt'])) return;

            $validator = Validator::make(
                $item['ticket']['document']['receipt'],
                (new StoreReceiptRequest)->rules()
            );

            $products = [];

            if (!empty($item['ticket']['document']['receipt']['items'] ?? null)) {
                foreach ($item['ticket']['document']['receipt']['items'] as $item_product) {
                    $valid = Validator::make($item_product, (new UpdateProductRequest)->rules());

                    if ($valid->passes()) {
                        $products[] = [
                            ...$valid->validated(),
                            'sum' => $item_product['price'] * $item_product['quantity']
                        ];
                    }
                }
            }

            if ($validator->passes()) {
                $access += 1;
                $for_load[] = [
                    'receipt' => [
                        ...$validator->validated(),
                    ],
                    'products' => $products
                ];
            } else {
                $errors[] = [
                    'index' => $index + 1,
                    'errors' => $validator->errors()?->getMessages() ?? null,
                ];
            }
        });

        collect($for_load)->lazy()->chunk(250)->each(function ($items) use ($user_id, $folder) {
            foreach ($items as $item) {
                $receipt = User::find($user_id)->receipts()->create($item['receipt']);

                $receipt->products()->createMany($item['products']);

                if ($folder) {
                    $folder->folder_receipts()->create([
                        'receipt_id' => $receipt->id,
                    ]);
                }
            }

            sleep(0.05);
        });

        return new JsonResponse([
            'count' => $access,
            'errors' => $errors,
        ]);
    }

    public static function getNameFile($receipt, $format = 'json')
    {
        $type = $receipt['cashTotalSum'] > 0 ? 'Наличные' : 'Безналичные';

        return $receipt['id'] . '-' . (str_replace('"', '_', $receipt['user']) ?? 'no-name') . '-' . substr($receipt['totalSum'], 0, -2) . '.' . substr($receipt['totalSum'], -2) . "($type)" . '.' . $format;
    }
}
