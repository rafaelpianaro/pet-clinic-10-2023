<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
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

    // Delete file from storage, I did the same in PetResource
    // protected static function booted(): void
    // {
    //     self::deleted(function (Pet $petImage) {
    //         Storage::disk('public')->delete($petImage->avatar);
    //     });
    // }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
        // return $this->hasMany(Appointment::class, 'pet_id', 'id');
    }

    public function clinic(): BelongsToMany
    {
        return $this->belongsToMany(Clinic::class);
    }
}
