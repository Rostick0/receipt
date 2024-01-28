<?php

namespace App\Http\Controllers\Api;

use App\Filters\Filter;
use App\Http\Controllers\Controller;
use App\Models\Folder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    private static function getWhere() {
        $where = [
            ['user_id', '=', auth()->id()],
        ];

        return $where;
    }

    public function index(Request $request)
    {
        $data = Filter::query($request, new Folder, $this::getWhere());     
    
        if ($request->has('receipt_id')) $data->with(['folder_receipts' => function (Builder $query) use ($request) {
            $query->where('receipt_id', $request->receipt_id);
        }]);

        return new JsonResponse([
            'data' => $data->paginate($request->limit ?? 20)
        ]);
    }
}
