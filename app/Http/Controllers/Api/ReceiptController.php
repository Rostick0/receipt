<?php

namespace App\Http\Controllers\Api;

use App\Filters\Filter;
use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request) {
        return new JsonResponse([
            'data' => Filter::all($request, new Receipt)
        ]);
    }
}
