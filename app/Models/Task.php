<?php

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Task extends Model
{
    protected static function booted(): void
    {
        static::updating(function (Task $task) {
            $task->user_id = auth()->user()->id;

            // zapisywanie historii
            $task_history = collect($task->getDirty())->except("user_id")->toArray();
            if (empty($task_history)) {
                return;
            }

            $task_changes = [];
            foreach ($task_history as $history_key => $history_value) {
                $task_changes[$history_key] = [
                    $task->getOriginal($history_key),
                    $history_value
                ];
            }

            TaskHistory::create([
                "task_id" => $task->id,
                "changes" => $task_changes // laravel automatycznie zmieni array na json
            ]);
        });

        static::creating(function (Task $task) {
            $task->user_id = auth()->user()->id;
        });

        static::addGlobalScope(function (Builder $query) {
            $query->whereBelongsTo(auth()->user());
        });
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
