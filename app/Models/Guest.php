<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone_number'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
