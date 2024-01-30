<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowReceiptUploaderRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReceiptUploaderRequest;
use App\Models\Folder;
use App\Models\Receipt;
use App\Utils\ReceiptUploaderUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\LazyCollection;

class ReceiptUploaderController extends Controller
{
    public function index(Request $request)
    {
        $data = collect();

        Folder::find($request->folder_id)?->folder_receipts()->chunk(200, function ($item) use (&$data) {
            foreach ($item as $elem) {
                $receipt = $elem->receipt;

                $data->push([
                    '_id' => $receipt['id'],
                    'createdAt' => $receipt->created_at,
                    'ticket' => [
                        'document' => [
                            'receipt' => [
                                ...$receipt->makeHidden(['user_id', 'deleted_at', 'created_at', 'updated_at'])->toArray(),
                                'items' => $receipt->products
                            ],
                        ],
                    ]
                ]);
            }

            sleep(0.05);
        });

        return new JsonResponse($data->lazy());
    }

    public function show(ShowReceiptUploaderRequest $request, int $id)
    {
        $data = Receipt::findOrFail($id);
        // with('products')

        return new JsonResponse([
            '_id' => $data['id'],
            'createdAt' => $data->created_at,
            'ticket' => [
                'document' => [
                    'receipt' => [
                        ...$data->makeHidden(['user_id', 'deleted_at', 'created_at', 'updated_at'])->toArray(),
                        'items' => $data->products
                    ],
                ],
            ]
        ]);
    }

    public function store(StoreReceiptUploaderRequest $request)
    {
        return ReceiptUploaderUtil::upload($request, auth()->id());
    }
}
