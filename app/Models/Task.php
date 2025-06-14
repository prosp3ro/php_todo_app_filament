<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Task extends Model
{
    protected static function booted(): void
    {
        static::updating(function (Task $task) {
            dd($task->getDirty());
        });
    }
}
