<?php

namespace App\Http\Controllers;

use App\Models\FolderReceipt;
use App\Http\Requests\StoreFolderReceiptRequest;
use App\Http\Requests\UpdateFolderReceiptRequest;
use App\Utils\AccessUtil;

class FolderReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFolderReceiptRequest $request)
    {
        
    }

    public function update(UpdateFolderReceiptRequest $request, int $id)
    {
        $data = FolderReceipt::findOrFail($id);

        if (AccessUtil::cannot('update', $data)) return AccessUtil::errorMessage();

        $data->update($request->validated());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FolderReceipt $folderReceipt)
    {
        //
    }
}
