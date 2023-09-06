<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

class Handler extends WebhookHandler
{
    public function hello(): void
    {
        $this->reply('gagagagaag');
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        $this->reply('Bunday komanda yoq');
    }

    protected function handleChatMessage(Stringable $text): void
    {
        if($text == "🇺🇿 O‘zbekcha"){
            $language_type = 1;
            $this->phone();
            $this->language($language_type);
        } elseif ($text == "🇷🇺 Русский"){
            $language_type = 2;
            $this->phone();
            $this->language($language_type);
        }
    }

    public function start(): void
    {
        $message = "<b>Salom!</b> Bizning Botga hush helibsiz! Xizmat ko‘rsatish tilini tanlang\n\n<b>Привет!</b> Добро пожаловать в наш бот! Выберите язык обслуживания";

        $this->chat->html($message)
            ->replyKeyboard(ReplyKeyboard::make()
                ->button("🇺🇿 O‘zbekcha")
                ->button("🇷🇺 Русский")
                ->chunk(2)
                ->resize(true))
            ->send();
    }

    public function phone(): void
    {
        $message = "Ro‘yxatdan o‘tish uchun telefon raqamingizni yuboring.\n\nTelefon raqamni yuborish uchun <b>Telefon raqamni yuborish</b> tugmasini bosing";
        $this->chat->html($message)
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('Send Contact')->requestContact()
                ])->resize(true))
            ->send();
    }

    public function language(int $language_type): void
    {
        DB::update('update telegraph_chats set language_type = '.$language_type.' where chat_id = ?', [$this->chat->chat_id]);
    }
}
