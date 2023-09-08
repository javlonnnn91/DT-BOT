<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed|null $phone_number
 */
class Register extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'phone_number', 'created_at', 'updated_at'];

    public function add(int $phone_number): bool
    {
        $model = Register::query()->where('phone_number', $phone_number)->first();
        if (!$model)
            $model = new Register();

        $model->phone_number = $phone_number;
        return $model->save() ?? false;
    }
}
