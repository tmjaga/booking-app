<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RoomType extends Model
{
    use HasFactory;

    public $timestamps = false;


    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
