<?php

namespace App\Filament\Resources;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;

final class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->scopes("onlyOwner");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make("name")
                    ->label("Task name")
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make("description")
                    ->columnSpanFull(),
                Radio::make("status")
                    ->options(TaskStatusEnum::class),
                Radio::make("priority")
                    ->options(TaskPriorityEnum::class),
                Forms\Components\DatePicker::make("due_date")
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->label("Task name")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("priority")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("status")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("due_date")
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort("due_date", "asc")
            ->filters([
                Filter::make("priority_low")
                    ->name("Priority: Low")
                    ->query(fn(Builder $query): Builder => $query->where("priority", "low"))
                    ->toggle(),
                Filter::make("priority_medium")
                    ->name("Priority: Medium")
                    ->query(fn(Builder $query): Builder => $query->where("priority", "medium"))
                    ->toggle(),
                Filter::make("priority_high")
                    ->name("Priority: High")
                    ->query(fn(Builder $query): Builder => $query->where("priority", "high"))
                    ->toggle(),
                Filter::make("status_to_do")
                    ->name("Status: To Do")
                    ->query(fn(Builder $query): Builder => $query->where("status", "to-do"))
                    ->toggle(),
                Filter::make("status_in_progress")
                    ->name("Status: In Progress")
                    ->query(fn(Builder $query): Builder => $query->where("status", "in progress"))
                    ->toggle(),
                Filter::make("status_done")
                    ->name("Status: Done")
                    ->query(fn(Builder $query): Builder => $query->where("status", "done"))
                    ->toggle(),
            ])
            ->actions([
                // TODO dont show all actions in a table row
                // TODO add option to change task status and priority
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make("history")
                    ->label("History")
                    ->icon("heroicon-o-clock")
                    ->url(fn(Task $record) => static::getUrl("history", ["record" => $record])),
                Action::make("create public link")
                    ->icon("heroicon-o-link")
                    ->action(function (Task $task) {
                        // tworzenie linku publicznego
                        $signedUrl = URL::temporarySignedRoute(name: "public.task.view", expiration: now()->addMinutes(30), parameters: ["task" => $task->id]);

                        \Filament\Notifications\Notification::make()
                            ->title("Temporary public URL")
                            // TODO make it be clickable
                            ->body(function () use ($signedUrl) {
                                return url($signedUrl);
                            })
                            ->persistent()
                            ->send();
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                // TODO add options for bulk change status/priority
            ])
            ->recordUrl(function ($record) {
                return static::getUrl(name: "view", parameters: ["record" => $record]);
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListTasks::route("/"),
            "create" => Pages\CreateTask::route("/create"),
            "edit" => Pages\EditTask::route("/{record}/edit"),
            "history" => Pages\TaskHistory::route("/{record}/history"),
            "view" => Pages\ViewTask::route("/{record}"),
        ];
    }
}
