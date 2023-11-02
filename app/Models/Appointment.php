<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\AppointmentStatus;

class Appointment extends Model
{
    use HasFactory;
    
    public $fillable = [
        'description',
        'pet_id',
        'pets',
        'date',
        'status',

        'start',
        'end'
    ];

    protected $casts = [
        'status' => AppointmentStatus::class
    ];
    
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}
