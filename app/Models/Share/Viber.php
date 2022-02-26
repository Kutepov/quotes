<?php

namespace App\Models\Share;

class Viber implements Share
{
    public const TYPE = 'viber';

    public const VALIDATE_RULES = [
        'recipient' => 'required|phone:ru',
    ];

    public $name = 'Viber';

    public function send(): bool
    {
        sleep(rand(5, 20));
        return true;
    }
}
