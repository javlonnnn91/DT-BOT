<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

class Handler extends WebhookHandler
{
    public function hello(): void
    {
        Log::info(json_encode($this->message->toArray(), JSON_UNESCAPED_UNICODE));
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

        Telegraph::dice()->send();
    }
}
