<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\AppointmentStatus;

class Appointment extends Model
{
    use HasFactory;

    public $fillable = [
        'pet_id',
        'slot_id',
        'clinic_id',
        'doctor_id',
        'date',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => AppointmentStatus::class
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function clinic(): BelongsToMany
    {
        return $this->belongsToMany(Clinic::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }
}
