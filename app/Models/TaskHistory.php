<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TaskHistory extends Model
{
    protected $table = "task_history";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(related: Task::class, foreignKey: "task_id", ownerKey: "id");
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "changes" => "array",
            "created_at" => "datetime"
        ];
    }
}
