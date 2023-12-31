<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Receipt;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use App\Models\Okved;
use App\Models\OperationType;
use App\Models\TaxationType;
use App\Utils\AccessUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    private static function getWhere()
    {
        return [];
    }

    public function index(Request $request)
    {
        $operation_types = OperationType::get();
        $receipts = Filter::all($request, new Receipt, [], $this::getWhere());     
        // $receipts = [];

        // app('routeByName') 
        return view('pages.receipt.index', compact(['operation_types', 'receipts']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $operation_types = OperationType::get();
        $taxation_types = TaxationType::get();
        $okveds = Okved::limit(40)->get();

        return view('pages.receipt.create', compact(['operation_types', 'taxation_types', 'okveds']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReceiptRequest $request)
    {
        $receipt = Receipt::create([
            ...$request->validated(),
            'user_id' => auth()->id()
        ]);

        return redirect()->route('receipt.update', ['receipt' => $receipt->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $receipt = Receipt::findOrFail($id);

        return view('pages.receipt.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $receipt = Receipt::findOrFail($id);

        
        $operation_types = OperationType::get();
        $taxation_types = TaxationType::get();;
        $okveds = Okved::limit(40)->get();

        return view('pages.receipt.edit', compact(['receipt', 'operation_types', 'taxation_types', 'okveds']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceiptRequest $request, int $id)
    {
        $data = Receipt::findOrFail($id);

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
        $data = Receipt::findOrFail($id);

        if (AccessUtil::cannot('delete', $data)) return AccessUtil::errorMessage();

        Receipt::destroy($id);

        return redirect()->route('receipt.index');
    }
}
