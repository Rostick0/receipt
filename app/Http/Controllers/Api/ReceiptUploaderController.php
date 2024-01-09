<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowReceiptUploaderRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\StoreReceiptUploaderRequest;
use App\Models\Receipt;
use App\Models\User;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\JsonResponse;
use Validator;

class ReceiptUploaderController extends Controller
{
    public function show(ShowReceiptUploaderRequest $request, int $id)
    {
        $data = Receipt::findOrFail($id);

        return new JsonResponse($data);
    }

    public function store(StoreReceiptUploaderRequest $request)
    {
        $errors = [];
        $access = 0;

        $for_load = [];

        // $valid_json =  Validator::make([
        //     'content' => $request->file('upload')->getContent()
        // ], [
        //     'content' => 'json'
        // ]);

        // if (!$valid_json->passes()) return new JsonResponse($valid_json->errors(), 422);

        $get_content = json_decode($request->file('upload')->getContent(), true);
        $data = is_array($get_content) ? $get_content : [$get_content];

        collect($data)->lazy()->each(function ($item, $index) use (&$access, &$for_load, &$errors) {
            $validator = Validator::make(
                $item,
                (new StoreReceiptRequest)->rules()
            );

            if ($validator->passes()) {
                $access += 1;
                $for_load[] = $validator->validated();
            } else {
                $errors[] = [
                    'index' => $index + 1,
                    'errors' => $validator->errors()?->getMessages() ?? null,
                ];
            }
        });

        collect($for_load)->lazy()->chunk(250)->each(function ($items) {
            User::find(auth()->id())->receipts()->createMany($items);

            sleep(0.05);
        });

        return new JsonResponse([
            'count' => 'Количество загруженных чеков - ' . $access,
            'invalid data' => $errors,
        ]);
    }
}
