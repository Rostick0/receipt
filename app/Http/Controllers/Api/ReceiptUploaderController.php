<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowReceiptUploaderRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReceiptUploaderRequest;
use App\Models\Receipt;
use App\Utils\ReceiptUploaderUtil;
use Illuminate\Http\JsonResponse;

class ReceiptUploaderController extends Controller
{
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
