<?php

namespace App\Utils;

use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Validator;

class ReceiptUploaderUtil
{
    public static function upload($request, $user_id)
    {
        $errors = [];
        $access = 0;

        $for_load = [];

        $get_content = json_decode($request->file('upload')->getContent(), true);
        $data = $get_content[0] ?? false ? $get_content : [$get_content];

        collect($data)->lazy()->each(function ($item, $index) use (&$access, &$for_load, &$errors) {
            $validator = Validator::make(
                $item,
                (new StoreReceiptRequest)->rules()
            );

            $products = [];

            foreach ($item['products'] as $item_product) {
                $valid = Validator::make($item_product, (new UpdateProductRequest)->rules());

                if ($valid->passes()) {
                    $products[] = [
                        ...$valid->validated(),
                        'sum' => $item_product['price'] * $item_product['quantity']
                    ];
                }
            }

            if ($validator->passes()) {
                $access += 1;
                $for_load[] = [
                    'receipt' => [
                        ...$validator->validated(),
                        'totalSum' => 0
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

        collect($for_load)->lazy()->chunk(250)->each(function ($items) use ($user_id) {
            foreach ($items as $item) {
                $receipt = User::find($user_id)->receipts()->create($item['receipt']);

                $receipt->products()->createMany($item['products']);
            }

            sleep(0.05);
        });

        return new JsonResponse([
            'count' => $access,
            'errors' => $errors,
        ]);
    }
}