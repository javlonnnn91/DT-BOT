<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
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
        $this->reply($text);
    }

    public function start(): void
    {
        $message = 'Salom! Bizning Botga hush helibsiz! Xizmat ko‘rsatish tilini tanlang<br>Привет! Добро пожаловать в наш бот! Выберите язык обслуживания';
        $this->chat->html($message)
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('Send Contact')->requestContact(),
                    ReplyButton::make('Send Location')->requestLocation(),
                ]))
            ->send();
    }

    public function phone(): void
    {
        $this->chat->message('hello world')
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('Send Contact')->requestContact()
                ])->resize(true)->oneTime())
            ->send();
    }


}
