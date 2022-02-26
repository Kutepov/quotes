<?php

namespace App\Models\Share;

class Email implements Share
{
    public const TYPE = 'email';

    public const VALIDATE_RULES = [
        'recipient' => 'required|email',
    ];

    public $name = 'Email';

    public function send(): bool
    {
        sleep(rand(5, 20));
        return true;
    }
}
