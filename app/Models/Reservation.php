<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['guest_id', 'start_date', 'end_date', 'number_of_rooms'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function room(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Room::class);
    }
}
