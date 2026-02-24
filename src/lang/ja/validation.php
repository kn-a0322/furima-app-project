<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'required' => ':attributeを入力してください',
    'email' => ':attributeはメール形式で入力してください',
    'string' => ':attributeは文字列である必要があります',
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください',
    ],
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください',
    ],
    'confirmed' => ':attributeと一致しません',
    'unique' => 'この:attributeは既に登録されています',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'お名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => '確認用パスワード',
    ],

];
