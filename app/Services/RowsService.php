<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Row;

class RowsService
{
    public function get(): array
    {
        return Row::query()->get()->groupBy('date');
    }
}
