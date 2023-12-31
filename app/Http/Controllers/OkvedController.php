<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Okved;
use App\Http\Requests\StoreOkvedRequest;
use App\Http\Requests\UpdateOkvedRequest;
use App\Utils\AccessUtil;
use Illuminate\Http\Request;

class OkvedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $okveds = Filter::all($request, new Okved, []);     
    
        return view('pages.admin.okved.index', compact('okveds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.okved.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOkvedRequest $request)
    {
        $okved = Okved::create(
            $request->validated()
        );


        // return redirect()->route('')
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $okved = Okved::findOrFail($id);

        return view('pages.admin.okved.edit', compact('okved'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOkvedRequest $request, int $id)
    {
        $data = Okved::findOrFail($id);

        if (AccessUtil::cannot('update', $data)) return AccessUtil::errorMessage();

        $data->update(
            $request->validated()
        );

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $data = Okved::findOrFail($id);

        if (AccessUtil::cannot('delete', $data)) return AccessUtil::errorMessage();

        Okved::destroy($id);

        return redirect()->route('');
    }
}
