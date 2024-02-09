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
use App\Utils\PriceUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    public $fillable_block = [
        'nds_only',
        'no_nds_only',
    ];

    public $sort = [
        [
            'name' => 'По дате сканирования (возрастание)',
            'value' => '-id'
        ],
        [
            'name' => 'По дате сканирования (убывание)',
            'value' => 'id'
        ],
        [
            'name' => 'По дате покупки (возрастание)',
            'value' => '-dateTime'
        ],
        [
            'name' => 'По дате покупки (убывание)',
            'value' => 'dateTime'
        ],
        [
            'name' => 'По сумме итого (возрастание)',
            'value' => '-totalSum'
        ],
        [
            'name' => 'По сумме итого (убывание)',
            'value' => 'totalSum'
        ],
    ];

    private static function getWhere()
    {
        return [];
    }

    public function requestMergePrice(&$request, $filter, $name)
    {
        if (isset($request[$filter][$name])) $request->merge([$filter => [
            ...$request->input($filter),
            $name => $request[$filter][$name] * 100
        ]]);
    }

    public function index(Request $request)
    {
        $operation_types = OperationType::get();
        $taxation_types = TaxationType::get();

        $this->requestMergePrice($request, 'filterLEQ', 'products.price');
        $this->requestMergePrice($request, 'filterGEQ', 'products.price');
        $this->requestMergePrice($request, 'filterLEQ', 'products.sum');
        $this->requestMergePrice($request, 'filterGEQ', 'products.sum');
        $this->requestMergePrice($request, 'filterLEQ', 'totalSum');
        $this->requestMergePrice($request, 'filterGEQ', 'totalSum');
        $this->requestMergePrice($request, 'filterLEQ', 'cashTotalSum');
        $this->requestMergePrice($request, 'filterGEQ', 'cashTotalSum');
        $this->requestMergePrice($request, 'filterLEQ', 'creditSum');
        $this->requestMergePrice($request, 'filterGEQ', 'creditSum');

        if (!isset($request['sort'])) $request->merge(['sort' => 'id']);

        $sort = $this->sort;

        $receipts = Filter::query($request, new Receipt, $this->fillable_block, $this::getWhere());

        if ($request->has('nds_only')) {
            $receipts = $receipts->where('nds18', '>=', 1)->union(
                Filter::query($request, new Receipt, $this->fillable_block, $this::getWhere())->where('nds10', '>=', 1)
            );
        }

        if ($request->has('no_nds_only')) {
            $receipts = $receipts->where('nds0', '>=', 1)->union(
                Filter::query($request, new Receipt, $this->fillable_block, $this::getWhere())->where('ndsNo', '>=', 1)
            );
        }

        $receipts = $receipts->paginate(20);

        return view('pages.receipt.index', compact(['operation_types', 'taxation_types', 'receipts', 'sort']));
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
        $request->merge([
            'cashTotalSum' => PriceUtil::checkAndMultiplication($request->cashTotalSum),
            'creditSum' => PriceUtil::checkAndMultiplication($request->creditSum),
            'ecashTotalSum' => PriceUtil::checkAndMultiplication($request->ecashTotalSum),
            'prepaidSum' => PriceUtil::checkAndMultiplication($request->prepaidSum),
            'provisionSum' => PriceUtil::checkAndMultiplication($request->provisionSum),
        ]);

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

        $request->merge([
            'cashTotalSum' => PriceUtil::checkAndMultiplication($request->cashTotalSum),
            'creditSum' => PriceUtil::checkAndMultiplication($request->creditSum),
            'ecashTotalSum' => PriceUtil::checkAndMultiplication($request->ecashTotalSum),
            'prepaidSum' => PriceUtil::checkAndMultiplication($request->prepaidSum),
            'provisionSum' => PriceUtil::checkAndMultiplication($request->provisionSum),
        ]);

        $data->update($request->validated());

        return redirect()->back();
    }

    public function destroy(int $id)
    {
        $data = Receipt::findOrFail($id);

        if (AccessUtil::cannot('delete', $data)) return AccessUtil::errorMessage();

        Receipt::destroy($id);

        return redirect()->route('receipt.index');
    }

    public function restore(int $id)
    {
        $data = Receipt::withTrashed()->findOrFail($id);

        if (AccessUtil::cannot('restore', $data)) return AccessUtil::errorMessage();

        $data->restore();

        return redirect()->back();
    }

    public function trash(Request $request)
    {
        $operation_types = OperationType::get();
        $taxation_types = TaxationType::get();

        $this->requestMergePrice($request, 'filterLEQ', 'products.price');
        $this->requestMergePrice($request, 'filterGEQ', 'products.price');
        $this->requestMergePrice($request, 'filterLEQ', 'products.sum');
        $this->requestMergePrice($request, 'filterGEQ', 'products.sum');
        $this->requestMergePrice($request, 'filterLEQ', 'totalSum');
        $this->requestMergePrice($request, 'filterGEQ', 'totalSum');
        $this->requestMergePrice($request, 'filterLEQ', 'cashTotalSum');
        $this->requestMergePrice($request, 'filterGEQ', 'cashTotalSum');
        $this->requestMergePrice($request, 'filterLEQ', 'creditSum');
        $this->requestMergePrice($request, 'filterGEQ', 'creditSum');

        if (!isset($request['sort'])) $request->merge(['sort' => 'id']);

        $sort = $this->sort;

        $receipts = Filter::query($request, new Receipt, $this->fillable_block, $this::getWhere());

        if ($request->has('nds_only')) {
            $receipts = $receipts->where('nds18', '>=', 1)->union(
                Filter::query($request, new Receipt, $this->fillable_block, $this::getWhere())->where('nds10', '>=', 1)
            );
        }

        if ($request->has('no_nds_only')) {
            $receipts = $receipts->where('nds0', '>=', 1)->union(
                Filter::query($request, new Receipt, $this->fillable_block, $this::getWhere())->where('ndsNo', '>=', 1)
            );
        }

        $receipts = $receipts->onlyTrashed()->paginate(20);

        return view('pages.receipt.trash', compact(['operation_types', 'taxation_types', 'receipts', 'sort']));
    }

    public function forceDelete(int $id)
    {
        $data = Receipt::withTrashed()->findOrFail($id);

        if (AccessUtil::cannot('forceDelete', $data)) return AccessUtil::errorMessage();

        $data->forceDelete();

        return redirect()->back();
    }

    public function clearRemoved()
    {
        $count = Receipt::onlyTrashed()->count();
        $limit = 1000;

        for ($i = 0; $i < ceil($count / $limit); $i++) {
            Receipt::onlyTrashed()
                ->limit($limit)
                ->forceDelete();
            sleep(0.01);
        }

        return redirect()->back();
    }

    public function removeDuplicate()
    {
        $limit = 1000;
        $counter = 0;

        DB::table('')
            ->where('count', '>', '1')
            ->from(
                Receipt::select('fiscalDocumentNumber', 'fiscalDriveNumber', 'fiscalSign', 'id', DB::raw('COUNT(*) as count'))
                    ->groupBy('fiscalDocumentNumber', 'fiscalDriveNumber', 'fiscalSign')
            )
            ->orderBy('id')
            ->chunk(500, function ($receipts) use ($limit, &$counter) {
                foreach ($receipts as $receipt) {
                    $where_receipt = [
                        [
                            'fiscalDocumentNumber', '=', $receipt->fiscalDocumentNumber,
                        ], [
                            'fiscalDriveNumber', '=', $receipt->fiscalDriveNumber,
                        ], [
                            'fiscalSign', '=', $receipt->fiscalSign,
                        ]
                        ];

                    $count = Receipt::where('id', '!=', $receipt->id)
                        ->where($where_receipt)
                        ->count();

                    $counter += $count;

                    for ($i = 0; $i < ceil($count / $limit); $i++) {
                        Receipt::where('id', '!=', $receipt->id)
                            ->where($where_receipt)
                            ->limit($limit)
                            ->delete();
                        sleep(0.01);
                    }
                }

                sleep(0.05);
            });

        return redirect()->back()->with([
            'remove_duplicate_count' => $counter,
        ]);
    }
}
