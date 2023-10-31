<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;
    
    public $fillable = [
        'description',
        'pet_id',
        'pets'
    ];
    
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}
