<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Receipt;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    private static function getWhere()
    {
        return [];
    }
    
    public function index(Request $request)
    {
        $receipts = Filter::all($request, new Receipt, [], $this::getWhere());     
    
        return view('pages.' . app('routeByName') . 'receipt.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReceiptRequest $request)
    {
        $receipts = Receipt::create([
            ...$request->validated(),
            'user_id' => auth()->id()
        ]);

        // return redirect()->route('');
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceiptRequest $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        //
    }
}
