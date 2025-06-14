<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TaskStatusEnum: string implements HasLabel
{
    case TODO = "to-do";
    case IN_PROGRESS = "in progress";
    case DONE = "done";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TODO => "To Do",
            self::IN_PROGRESS => "In Progress",
            self::DONE => "Done"
        };
    }
}
