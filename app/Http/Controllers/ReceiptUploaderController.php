<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowReceiptUploaderRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UploadReceiptRequest;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\StoreReceiptUploaderRequest;
use App\Http\Requests\UploadReceiptUploaderRequest;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Validator;

class ReceiptUploaderController extends Controller
{
    public function show(ShowReceiptUploaderRequest $request, int $id) {
        $data = Receipt::with('products')->findOrFail($id);

        // dd($data);
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

        collect(json_decode($request->file('upload')->getContent(), true))->lazy()->each(function ($item, $index) use (&$access, &$for_load, &$errors) {
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
