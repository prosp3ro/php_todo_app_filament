<?php

namespace App\Filament\Resources;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Filter::make("low_priority")->query(fn(Builder $query): Builder => $query->where("priority", "low"))->toggle(),
                Filter::make("medium_priority")->query(fn(Builder $query): Builder => $query->where("priority", "medium"))->toggle(),
                Filter::make("high_priority")->query(fn(Builder $query): Builder => $query->where("priority", "high"))->toggle(),
                Filter::make("to_do")->query(fn(Builder $query): Builder => $query->where("status", "to-do"))->toggle(),
                Filter::make("in_progress")->query(fn(Builder $query): Builder => $query->where("status", "in progress"))->toggle(),
                Filter::make("done")->query(fn(Builder $query): Builder => $query->where("status", "done"))->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make("history")
                    ->label("History")
                    ->icon("heroicon-o-clock")
                    ->url(fn(Task $record) => static::getUrl("history", ["record" => $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            "history" => Pages\TaskHistory::route("/{record}/history")
        ];
    }
}
