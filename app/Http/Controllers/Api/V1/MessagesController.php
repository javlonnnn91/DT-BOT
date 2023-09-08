<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessagesRequest;
use App\Http\Requests\UpdateMessagesRequest;
use App\Models\ChatInfo;
use App\Models\Messages;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class MessagesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMessagesRequest $request
     * @return bool
     */
    public function store(StoreMessagesRequest $request): bool
    {
        $message_id = $request->input(['message_id']);
        $phone_number = $request->input(['phone_number']);
        $photo = $request->input(['photo']);
        $module = $request->input(['module']);
        $type = $request->input(['type']);
        $status = $request->input(['status']);
        $date = $request->input(['date']);
        $title_uz = $request->input(['title_uz']);
        $title_ru = $request->input(['title_ru']);
        $title_en = $request->input(['title_en']);
        $text_uz = $request->input(['text_uz']);
        $text_ru = $request->input(['text_ru']);
        $text_en = $request->input(['text_en']);
        $link = $request->input(['link']);
        $messages = new Messages();
        $messages_add = $messages->add($message_id,$phone_number,$photo,$module,$type,$status,$date,$title_uz,$title_ru,$title_en,$text_uz,$text_ru,$text_en);
        if($messages_add){
            $chat_info = ChatInfo::query()->where('phone_number', $phone_number)->first();
            if($chat_info){
                $lang = $chat_info->language;
                App::setLocale($lang);
                $chat = TelegraphChat::where('chat_id', $chat_info->chat_id)->first();
                if ($lang == 'uz'){
                    $message = $title_uz."\n\n".$text_uz;
                } elseif ($lang == 'ru'){
                    $message = $title_ru."\n\n".$text_ru;
                } else {
                    $message = $title_en."\n\n".$text_en;
                }
                $message_last = $messages::moduleLabel()[$module]."\n\n".$message;
                $chat->html($message_last)
                    ->keyboard(Keyboard::make()->buttons([
                        Button::make("👀 Open")->url($link)
                    ]))
                    ->send();
            }
        }
        return $messages_add;

    }
}
