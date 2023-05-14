<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

class MovieService
{
    public function getAll(): Collection
    {
        return Movie::all();
    }
}
