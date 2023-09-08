<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'message_id' => ['required'],
            'phone_number' => ['required'],
            'module' => ['required'],
            'type' => ['required'],
            'status' => ['required'],
            'date' => ['required'],
            'title_uz' => ['required'],
            'title_ru' => ['required'],
            'text_uz' => ['required'],
            'text_ru' => ['required'],
        ];
    }
}
