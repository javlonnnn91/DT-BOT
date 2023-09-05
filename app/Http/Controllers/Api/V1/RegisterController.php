<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;

class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRegisterRequest $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(StoreRegisterRequest $request): \Illuminate\Database\Eloquent\Model
    {
        $phone_number = $request->input(['phone_number']);
        $chat = TelegraphChat::query()->latest()->first();


        $botModel = config('telegraph.models.bot');
        $bot = rescue(fn () => $botModel::fromId(1), report: false);

        return $bot->chats()->create([
            'chat_id' => (int)$chat->chat_id + 1,
            'name' => '[private] '.$phone_number,
        ]);
    }
}
