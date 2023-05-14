<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{
    use HasFactory;
    public $timestamps = false;
    public static int $ACTIVE = 1;
    public static int $NOT_ACTIVE = 0;
    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'is_active' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seances(): HasMany
    {
        return $this->hasMany(\App\Models\MovieShow::class);
    }

    /**
     * @return HasMany
     */
    public function seats(): HasMany
    {
        return $this->hasMany(\App\Models\Place::class);
    }

    /**
     * @return HasMany
     */
    public function takenSeat(): HasMany
    {
        return $this->hasMany(\App\Models\TakenPlace::class);
    }
}
