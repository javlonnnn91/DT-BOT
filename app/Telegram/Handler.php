<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
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

    public function actions(): void
    {
        Telegraph::message('hello world')
            ->keyboard(function(Keyboard $keyboard){
                return $keyboard
                    ->button('Delete')->action('delete')->param('id', '42')
                    ->button('open')->url('https://test.it')
                    ->button('Web App')->webApp('https://web-app.test.it')
                    ->button('Login Url')->loginUrl('https://loginUrl.test.it');
            })->send();
    }
}
