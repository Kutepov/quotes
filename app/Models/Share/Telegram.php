<?php

namespace App\Models\Share;

class Telegram implements Share
{
    public const TYPE = 'telegram';

    public const VALIDATE_RULES = [
        'recipient' => 'required',
    ];

    public $name = 'Telegram';

    public function send(): bool
    {
        sleep(rand(5, 20));
        return true;
    }
}
