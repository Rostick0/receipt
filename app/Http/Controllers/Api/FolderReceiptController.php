<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFolderReceiptRequest;
use App\Models\Folder;
use App\Models\FolderReceipt;
use App\Models\Receipt;
use App\Utils\AccessUtil;
use App\Utils\QueryString;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FolderReceiptController extends Controller
{
    public function store(StoreFolderReceiptRequest $request)
    {
        $receipts = QueryString::convertToArray($request->receipt_id);

        if (count($receipts) > 1) {
            foreach ($receipts as $receipt_id) {
                Folder::whereIn('id', QueryString::convertToArray($request->folders))
                    ->lazy()
                    ->each(function ($item) use ($receipt_id) {
                        $item->folder_receipts()->firstOrCreate([
                            'receipt_id' => $receipt_id,
                        ]);
                    });
            }
        } else {
            $receipt_id = $receipts[0];

            Folder::whereNotIn('id', QueryString::convertToArray($request->folders))
                    ->where('user_id', auth()->id())
                    ->lazy()
                    ->each(function ($item) use ($receipt_id) {
                        $item->folder_receipts()
                            ->where([
                                'receipt_id' => $receipt_id,
                            ])
                            ->delete();
                    });

                Folder::whereIn('id', QueryString::convertToArray($request->folders))
                    ->lazy()
                    ->each(function ($item) use ($receipt_id) {
                        $item->folder_receipts()->firstOrCreate([
                            'receipt_id' => $receipt_id,
                        ]);
                    });
        }

        return new JsonResponse([
            'message' => 'Created'
        ]);
    }

    public function destroy(int $id)
    {
        $data = FolderReceipt::findOrFail($id);

        if (AccessUtil::cannot('delete', $data)) return AccessUtil::errorMessage();

        FolderReceipt::destroy($id);

        return new JsonResponse([
            'message' => 'Deleted'
        ]);
    }
}
