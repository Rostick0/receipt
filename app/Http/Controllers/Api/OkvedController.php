<?php

namespace App\Http\Controllers\Api;

use App\Filters\Filter;
use App\Http\Controllers\Controller;
use App\Models\Okved;
use App\Http\Requests\StoreOkvedRequest;
use App\Http\Requests\UpdateOkvedRequest;
use App\Utils\AccessUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OkvedController extends Controller
{
    public function index(Request $request)
    {
        return new JsonResponse([
            'data' => Filter::all($request, new Okved)
        ]);
    }
}
