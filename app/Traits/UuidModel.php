<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidModel
{
    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
