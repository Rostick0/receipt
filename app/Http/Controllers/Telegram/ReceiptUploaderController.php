<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowReceiptUploaderRequest;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\StoreReceiptUploaderRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Receipt;
use App\Models\User;
use App\Models\UserTelegram;
use App\Utils\ReceiptUploaderUtil;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\JsonResponse;

class ReceiptUploaderController extends Controller
{
    public function store(StoreReceiptUploaderRequest $request)
    {
        $user_telegram = UserTelegram::where('telegram_user_id', $request->chat_id)->firstOrFail();

        return ReceiptUploaderUtil::upload($request, $user_telegram->user_id);
    }
}
