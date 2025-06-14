<?php

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Task extends Model
{
    protected static function booted(): void
    {
        static::updating(function (Task $task) {
            dd($task->getDirty());
        });

        // static::retrieved(function (Task $task) {
        //     // dla "multi tenancy" - kazdy user widzi tylko swoj task
        // })
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: "user_id", ownerKey: "id");
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "priority" => TaskPriorityEnum::class,
            "status" => TaskStatusEnum::class
        ];
    }
}
