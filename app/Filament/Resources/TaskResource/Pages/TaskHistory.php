<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\TaskHistory as TaskHistoryModel;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

final class TaskHistory extends Page
{
    protected static string $resource = TaskResource::class;

    protected static string $view = "filament.resources.task-resource.pages.task-history";

    public $record;

    public function mount($record): void
    {
        $this->record = TaskResource::getModel()::findOrFail($record);
    }

    public function getHistory()
    {
        return TaskHistoryModel::query()
            ->where("task_id", "=", $this->record->id)
            ->orderBy("created_at", "desc")
            ->get(["changes", "created_at"]);
    }

    public function getTitle(): string|Htmlable
    {
        return "Task history";
    }
}
