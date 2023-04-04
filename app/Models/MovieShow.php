<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class MovieShow extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'hall_id', 'movie_id', 'start_time'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Hall::class);
    }
}
