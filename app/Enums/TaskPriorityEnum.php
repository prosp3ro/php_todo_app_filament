<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TaskPriorityEnum: string implements HasLabel
{
    case LOW = "low";
    case MEDIUM = "medium";
    case HIGH = "high";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::LOW => "Low",
            self::MEDIUM => "Medium",
            self::HIGH => "High"
        };
    }
}
