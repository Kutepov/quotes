<?php

namespace App\Models\Share;

interface Share
{
    public function send(): bool;
}
