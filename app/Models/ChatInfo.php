<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed|null $phone_number
 * @property string|mixed|null $language
 * @property int|mixed|null $chat_id
 */
class ChatInfo extends Model
{
    use HasFactory;

    public function add(int|null $chat_id, string|null $language, int|null $phone_number): bool
    {
        $model = ChatInfo::query()->where('chat_id', $chat_id)->first();
        if(!$model)
            $model = new ChatInfo();

        $model->chat_id = $chat_id;

        if ($language != null)
            $model->language = $language;

        if ($phone_number != null)
            $model->phone_number = $phone_number;

        return $model->save() ?? false;
    }
}
