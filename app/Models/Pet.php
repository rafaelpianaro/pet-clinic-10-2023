<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\PetType;

class Pet extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => PetType::class
    ];

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
