<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\UpdateRegisterRequest;
use App\Models\ChatInfo;
use App\Models\Register;
use App\Telegram\Handler;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\App;

class RegisterController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRegisterRequest $request
     * @return bool
     */
    public function store(StoreRegisterRequest $request): bool
    {
        $phone_number = $request->input(['phone_number']);

        $chat_info = ChatInfo::query()->where('phone_number', $phone_number)->first();
        if($chat_info){
            App::setLocale($chat_info->language);
            $chat = TelegraphChat::where('chat_id', $chat_info->chat_id)->first();
            $chat->html(__('app.REGISTER_SUCCESS'))->send();
        }

        $register = new Register();
        return $register->add($phone_number);
    }
}
