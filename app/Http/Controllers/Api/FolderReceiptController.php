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
        Folder::whereIn('id', QueryString::convertToArray($request->folders))
            ->lazy()
            ->each(function ($item) use ($request) {
                $item->folder_receipts()->create([
                    'receipt_id' => $request->receipt_id,
                ]);
            });

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