<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Folder;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use App\Utils\AccessUtil;
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
        $folder = Filter::one($request, new Folder,$id, $this::getWhere());     
    
        return view('pages.folder.show', compact('folder'));
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
}
