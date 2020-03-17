<?php

namespace App\Http\Requests\Messages;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'message' => ['required', 'string'],
        ];
    }

    public function authorize()
    {
        if (\Auth::guest()) {
            return false;
        }

        return true;
    }
}
