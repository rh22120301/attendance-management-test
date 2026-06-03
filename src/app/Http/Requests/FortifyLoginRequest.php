<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequestBase;

class FortifyLoginRequest extends FortifyLoginRequestBase
{
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string','min:8'],
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
        ];
    }
}