<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string|null $date
 * @property int|mixed|null $status
 * @property int|mixed|null $type
 * @property int|mixed|null $module
 * @property mixed|string|null $photo
 * @property mixed|int|null $phone_number
 * @property int|mixed|null $message_id
 * @property mixed|string|null $text_en
 * @property mixed|string|null $text_ru
 * @property mixed|string|null $text_uz
 * @property mixed|string|null $title_en
 * @property mixed|string|null $title_ru
 * @property mixed|string|null $title_uz
 * @property mixed|string|null $link
 */
class Messages extends Model
{
    use HasFactory;

    const MODULE_MARKET = 1;
    const MODULE_FINDOC = 2;

    const TYPE_SIGNED = 1;
    const TYPE_WAITING = 2;
    const TYPE_CANCEL = 3;

    public static function moduleLabel(): array
    {
        return [
            self::MODULE_MARKET => 'Market',
            self::MODULE_FINDOC => 'FinDoc'
        ];
    }

    public static function typeLabel(): array
    {
        return [
            self::TYPE_SIGNED => '🟢 ' . __('app.TYPE_SIGNED'),
            self::TYPE_WAITING => '🟡 ' . __('app.TYPE_WAITING'),
            self::TYPE_CANCEL => '🔴 ' . __('app.TYPE_CANCEL')
        ];
    }

    public function add(int|null $message_id, int|null $phone_number, string|null $photo, int|null $module, int|null $type, int|null $status, string|null $date, string|null $title_uz, string|null $title_ru, string|null $title_en, string|null $text_uz, string|null $text_ru, string|null $text_en, string|null $link): bool
    {
        $model = Messages::query()->where('message_id', $message_id)->first();
        if($model){
            return false;
        }else{
            $model = new Messages();
            $model->message_id = $message_id;
            $model->phone_number = $phone_number;
            $model->photo = $photo;
            $model->module = $module;
            $model->type = $type;
            $model->status = $status;
            $model->date = $date;
            $model->title_uz = $title_uz;
            $model->title_ru = $title_ru;
            $model->title_en = $title_en;
            $model->text_uz = $text_uz;
            $model->text_ru = $text_ru;
            $model->text_en = $text_en;
            $model->link = $link;
            return $model->save() ?? false;
        }
    }
}
