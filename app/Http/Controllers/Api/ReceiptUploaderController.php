<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowReceiptUploaderRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReceiptUploaderRequest;
use App\Models\Folder;
use App\Models\Receipt;
use App\Utils\ReceiptUploaderUtil;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;
use Symfony\Component\String\UnicodeString;
use ZipArchive;

class ReceiptUploaderController extends Controller
{
    public function index(Request $request)
    {
        $data = collect();

        $folder = Folder::find($request->folder_id);

        $folder?->folder_receipts()->whereHas('receipt', function ($query) {
            $query->whereNull('deleted_at');
        })->chunk(200, function ($item) use (&$data) {
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

        if (!$data->count()) return new JsonResponse([
            'message' => 'Not found'
        ], 404);

        $zip = new ZipArchive();
        $zip_name = random_int(10, 99) . Carbon::now()->valueOf() . '.zip';

        if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE) {
            foreach ($data as $fileContent) {
                $user = str_replace('"', '_', $fileContent['ticket']['document']['receipt']['user']) ?? 'no-name';
                $name = 'receipts/' . ReceiptUploaderUtil::getPrice($fileContent['ticket']['document']['receipt']);
                file_put_contents($name, json_encode([$fileContent], JSON_UNESCAPED_UNICODE));

                $zip->addFile($name, basename($name));
            }

            $zip->close();
        }

        return response()->download($zip_name, $folder->name . '.zip')->deleteFileAfterSend();
    }

    public function show(ShowReceiptUploaderRequest $request, int $id)
    {
        $data = Receipt::findOrFail($id);

        return response(json_encode([
            [
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
            ]
        ], JSON_UNESCAPED_UNICODE));
    }

    public function store(StoreReceiptUploaderRequest $request)
    {
        return ReceiptUploaderUtil::upload($request, auth()->id());
    }
}
