<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integration\StoreReceiptUploaderRequest;
use App\Models\User;
use App\Utils\ReceiptUploaderUtil;
use Illuminate\Http\JsonResponse;

class ReceiptUploaderController extends Controller
{
    public function store(StoreReceiptUploaderRequest $request)
    {
        $user = User::firstOrFail();

        return ReceiptUploaderUtil::upload($request, $user->id);
    }
}
