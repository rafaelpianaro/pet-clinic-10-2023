<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'date_of_birth',
        'type',
        'avatar',
        'owner_id',
        'owners',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
        // return $this->hasMany(Appointment::class, 'pet_id', 'id');
    }
}
