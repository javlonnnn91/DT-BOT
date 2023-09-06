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
        $this->chat->message('Tilni tanlang / Выберите язык')
            ->keyboard(Keyboard::make()->buttons([
                Button::make("🇺🇿 o`zbek tili ")->action("phone")->param('type', '1'),
                Button::make("🇷🇺 русский язык")->action("phone")->param('type', '2'),
            ])->chunk(2))->send();
    }

    public function phone(): void
    {
        $this->chat->message('hello world')
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('Send Contact')->requestContact(),
                    ReplyButton::make('Send Location')->requestLocation(),
                ])
                ->row([
                    ReplyButton::make('Quiz')->requestQuiz(),
                ]))->send();
    }


}
