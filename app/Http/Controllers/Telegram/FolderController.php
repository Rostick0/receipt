<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTelegramFolderController;
use App\Models\Folder;
use App\Models\User;
use App\Utils\AccessUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function store(StoreTelegramFolderController $request)
    {
        $user = User::firstWhere('name', $request->user_name);

        if (!$user) return AccessUtil::errorMessage('Пользователь не найден');

        $data = Folder::create($request->validated());

        return new JsonResponse([
            'data' => $data
        ]);
    }
}
