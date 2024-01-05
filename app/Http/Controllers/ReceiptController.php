<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Receipt;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use App\Http\Requests\UploadReceiptRequest;
use App\Models\User;
use App\Utils\AccessUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ReceiptController extends Controller
{
    private static function getWhere()
    {
        return [];
    }

    public function index(Request $request)
    {
        // $receipts = Filter::all($request, new Receipt, [], $this::getWhere());     
        $receipts = [];

        // app('routeByName') 
        return view('pages.receipt.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.receipt.create');
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

        return view('pages.receipt.edit', compact('receipt'));
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

    public function upload(UploadReceiptRequest $request)
    {
        $errors = [];
        $access = 0;

        $for_load = [];

        collect(json_decode($request->file('upload')->getContent(), true))->lazy()->each(function ($item, $index) use (&$access, &$for_load, &$errors) {
            $validator = Validator::make(
                $item,
                (new StoreReceiptRequest)->rules()
            );

            if ($validator->passes()) {
                $access += 1;
                $for_load[] = $validator->validated();
            } else {
                $errors[] = [
                    'index' => $index + 1,
                    'errors' => $validator->errors()?->getMessages() ?? null,
                ];
            }
        });

        collect($for_load)->lazy()->chunk(250)->each(function ($items) {
            User::find(auth()->id())->receipts()->createMany($items);

            sleep(0.05);
        });

        return new JsonResponse([
            'count' => 'Количество загруженных чеков - ' . $access,
            'invalid data' => $errors,
        ]);
    }
}
