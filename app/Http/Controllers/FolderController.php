<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Folder;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
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
        $folder = Filter::one($request, new Folder, $id, $this::getWhere());
        $sum_query = DB::select('select sum(`receipt_sum_sum`) as `sum` from (select `folder_receipts`.*, (select sum(`receipts`.`totalSum`) from `receipts` where `folder_receipts`.`receipt_id` = `receipts`.`id` and `receipts`.`deleted_at` is null) as `receipt_sum_sum` from `folder_receipts` where `folder_receipts`.`folder_id` = ' . $id . ' and `folder_receipts`.`folder_id` is not null) as `helper`;');

        return view('pages.folder.show', compact('folder', 'sum_query'));
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

    public function clear(int $id)
    {
        $data = Folder::findOrFail($id);

        if (AccessUtil::cannot('update', $data)) return AccessUtil::errorMessage();

        $data->folder_receipts()->delete();

        return redirect()->back();
    }
}