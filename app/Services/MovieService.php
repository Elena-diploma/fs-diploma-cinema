<?php

namespace App\Services;

use App\Models\Movie;

class MovieService
{
    public function getAll() {
        return Movie::all();
    }
}
