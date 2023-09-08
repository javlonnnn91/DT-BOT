<?php

namespace App\Telegram;

use App\Models\ChatInfo;
use App\Models\Register;
use DefStudio\Telegraph\DTO\CallbackQuery;
use DefStudio\Telegraph\DTO\InlineQuery;
use DefStudio\Telegraph\DTO\Message;
use DefStudio\Telegraph\Exceptions\TelegramWebhookException;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Handler extends WebhookHandler
{
    protected function setupChat(): void
    {
        $telegramChat = $this->message?->chat() ?? $this->callbackQuery?->message()?->chat();

        assert($telegramChat !== null);

        /** @var TelegraphChat $chat */
        $chat = $this->bot->chats()->firstOrNew([
            'chat_id' => $telegramChat->id(),
        ]);
        $this->chat = $chat;

        if (!$this->chat->exists) {
            if (!$this->allowUnknownChat()) {
                throw new NotFoundHttpException();
            }

            if (config('telegraph.security.store_unknown_chats_in_db', false)) {
                $this->chat->name = Str::of("")
                    ->append("[", $telegramChat->type(), ']')
                    ->append(" ", $telegramChat->title());
                $this->chat->save();
            }
        }else{
            $chat_info = ChatInfo::query()->where('chat_id', $this->chat->chat_id)->first();
            if(!empty($chat_info->language))
                App::setLocale($chat_info->language);
        }
    }

    public function hello(): void
    {
        $this->reply(__('app.HELLO'));
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        $this->reply('Bunday komanda yoq');
    }

    protected function handleChatMessage(Stringable $text): void
    {
        if ($text == "🇺🇿 O‘zbekcha"){
            App::setLocale('uz');
            $this->chatInfo('uz', null);
            $this->phone();
        } elseif ($text == "🇷🇺 Русский"){
            App::setLocale('ru');
            $this->chatInfo('ru', null);
            $this->phone();
        } elseif (!empty($this->message->contact())){
            $this->handleContact($this->message->contact()->phoneNumber());
        } elseif ($text == 'Tilni o‘zgartirish' || $text == 'Изменить язык') {
            $message = __('app.SELECT_LANGUAGE');
            $this->language($message);
        }
    }

    protected function handleContact(string $contact): void
    {
        $phone_number = (int)str_replace('+', '', $contact);

        $this->chatInfo(null, $phone_number);

        $registers = Register::query()->where('phone_number', $phone_number)->first();
        $message = $registers ? __('app.REGISTER_SUCCESS') : __('app.REGISTER_FAIL');
        $this->bot->registerCommands([

        ]);

        $this->chat->message($message)
            ->removeReplyKeyboard(true)
            ->send();
    }

    public function start(): void
    {
        $chat_info = new ChatInfo();
        $chat_info->add($this->chat->chat_id,null,null);

        $message = "<b>Salom!</b> Bizning Botga hush helibsiz! Xizmat ko‘rsatish tilini tanlang\n\n<b>Привет!</b> Добро пожаловать в наш бот! Выберите язык обслуживания";
        $this->language($message);
    }

    public function phone(): void
    {
        $chat_info = ChatInfo::query()->where('chat_id', $this->chat->chat_id)->first();
        if(empty($chat_info->phone_number)){
            $this->chat->html(__('app.SEND_CONTACT_MESSAGE'))
                ->replyKeyboard(ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make(__('app.SEND_CONTACT'))->requestContact()
                    ])->resize(true))
                ->send();
        } else {
            $this->chat->message(__('app.LANGUAGE_CHANGED'))
                ->removeReplyKeyboard(true)
                ->send();
        }

    }

    public function chatInfo(string|null $language, int|null $phone_number): void
    {
        $chat_info = new ChatInfo();
        $chat_info->add($this->chat->chat_id, $language, $phone_number);
    }

    public function language($message): void
    {
        $this->chat->html($message)
            ->replyKeyboard(ReplyKeyboard::make()
                ->button("🇺🇿 O‘zbekcha")
                ->button("🇷🇺 Русский")
                ->chunk(2)
                ->resize(true))
            ->send();
    }

    public function settings(): void
    {
        $message = __('app.SELECT_SETTINGS');
        $this->chat->html($message)
            ->replyKeyboard(ReplyKeyboard::make()
                ->button(__("app.CHANGE_LANGUAGE"))
                ->chunk(1)
                ->resize(true))
            ->send();
    }
}
