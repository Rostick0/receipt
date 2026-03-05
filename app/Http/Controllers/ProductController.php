<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\NdsProcentService;
use App\Utils\AccessUtil;
use App\Utils\PriceUtil;

class ProductController extends Controller
{
    public function __construct(
        private NdsProcentService $ndsProcentService
    ) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nds_list = $this->ndsProcentService->getList();

        return view('pages.product.create', compact(['nds_list']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $formData = $request->validated();

        $formData = array_merge($formData, [
            'price' => PriceUtil::checkAndMultiplication($request->price),
        ]);

        $product = Product::create([
            ...$formData,
            'sum' => $formData['price'] * $formData['quantity']
        ]);

        return redirect()->route('product.edit', ['product' => $product->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $product = Product::findOrFail($id);

        if (AccessUtil::cannot('update', $product)) return AccessUtil::errorMessage();

        $nds_list = $this->ndsProcentService->getList();

        return view('pages.product.edit', compact('product', 'nds_list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $data = Product::findOrFail($id);

        if (AccessUtil::cannot('update', $data)) return AccessUtil::errorMessage();

        $formData = $request->validated();

        $formData = array_merge($formData, [
            'price' => PriceUtil::checkAndMultiplication($request->price),
        ]);

        $data->update([
            ...$formData,
            'sum' => $formData['price'] * $formData['quantity']
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $data = Product::findOrFail($id);

        if (AccessUtil::cannot('delete', $data)) return AccessUtil::errorMessage();

        Product::destroy($id);

        return redirect()->route('receipt.edit', ['receipt' => $data->receipt_id]);
    }
}
