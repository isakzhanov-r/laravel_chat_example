<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contact_id' => ['required', Rule::exists('users', 'id'), Rule::unique('user_contacts', 'contact_id')->where('user_id', auth()->id())],
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