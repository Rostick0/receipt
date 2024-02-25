<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Folder;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use App\Models\OperationType;
use App\Models\Receipt;
use App\Models\TaxationType;
use App\Utils\AccessUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolderController extends Controller
{

    private static function getWhere()
    {
        $where = [
            ['user_id', '=', auth()->id()],
        ];

        return $where;
    }

    public function index(Request $request)
    {
        $folders = Filter::all($request, new Folder, $this::getWhere());

        return view('pages.folder.index', compact('folders'));
    }

    public function create()
    {
        return view('pages.folder.create');
    }

    public function store(StoreFolderRequest $request)
    {
        $folder = Folder::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('folder.edit', ['folder' => $folder->id]);
    }

    public function show(Request $request, int $id)
    {
        $folder = Filter::one($request, new Folder, $id, $this::getWhere(), true);
        $sum_query = DB::select('select sum(`receipt_sum_sum`) as `sum` from (select `folder_receipts`.*, (select sum(`receipts`.`totalSum`) from `receipts` where `folder_receipts`.`receipt_id` = `receipts`.`id` and `receipts`.`deleted_at` is null) as `receipt_sum_sum` from `folder_receipts` where `folder_receipts`.`folder_id` = ' . $id . ' and `folder_receipts`.`folder_id` is not null) as `helper`;');
        

        $operation_types = OperationType::get();
        $taxation_types = TaxationType::get();

        (new ReceiptController)->mergePriceAll($request);
        (new ReceiptController)->dateTimeAddDay($request);

        if (!isset($request['sort'])) $request->merge(['sort' => 'id']);

        $sort = (new ReceiptController)->sort;

        $receipts = Filter::query($request, new Receipt, (new ReceiptController)->fillable_block);

        if ($request->has('nds_only')) {
            $receipts = $receipts->where('nds18', '>=', 1)->union(
                Filter::query($request, new Receipt, (new ReceiptController)->fillable_block)->where('nds10', '>=', 1)
            );
        }

        if ($request->has('no_nds_only')) {
            $receipts = $receipts->where('nds0', '>=', 1)->union(
                Filter::query($request, new Receipt, (new ReceiptController)->fillable_block)->where('ndsNo', '>=', 1)
            );
        }

        $receipts = $receipts
            ->whereHas('folder_receipts', function ($query) use ($folder) {
                $query->where('folder_id', $folder->id);
            })
            ->paginate(20);

        (new ReceiptController)->mergePriceAll($request, '/');

        return view('pages.folder.show', compact(['folder', 'sum_query', 'operation_types', 'taxation_types', 'receipts', 'sort']));
    }

    public function edit(int $id)
    {
        $folder = Folder::findOrFail($id);

        return view('pages.folder.edit', compact('folder'));
    }

    public function update(UpdateFolderRequest $request, int $id)
    {
        $data = Folder::findOrFail($id);

        if (AccessUtil::cannot('update', $data)) return AccessUtil::errorMessage();

        $data->update(
            $request->validated()
        );

        return redirect()->back();
    }

    public function destroy(int $id)
    {
        $data = Folder::findOrFail($id);

        if (AccessUtil::cannot('delete', $data)) return AccessUtil::errorMessage();

        Folder::destroy($id);

        return redirect()->route('folder.index');
    }

    public function trash(Request $request)
    {
        $folders = Filter::query($request, new Folder, $this::getWhere());

        $folders = $folders->onlyTrashed()->paginate(20);

        return view('pages.folder.trash', compact('folders'));
    }

    public function restore(int $id)
    {
        $data = Receipt::withTrashed()->findOrFail($id);

        if (AccessUtil::cannot('restore', $data)) return AccessUtil::errorMessage();

        $data->restore();

        return redirect()->back();
    }

    public function clear(int $id)
    {
        $data = Folder::findOrFail($id);

        if (AccessUtil::cannot('update', $data)) return AccessUtil::errorMessage();

        $data->folder_receipts()->delete();

        return redirect()->back();
    }
}
