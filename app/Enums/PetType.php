<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PetType: string implements HasLabel 
{
    case Cat = 'cat';
    case Dog = 'dog';
    case Rat = 'rat';
    case Lizard = 'lizard';
    case Fish = 'fish';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Cat => 'Cat',
            self::Dog => 'Dog',
            self::Rat => 'Rat',
            self::Lizard => 'Lizard',
            self::Fish => 'Fish',
        };
    }
    
    
}