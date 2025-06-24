<?php

use App\Mail\TaskDueReminder;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get("/mail", function () {
    $task = Task::firstOrFail();
    return Mail::to("test@example.com")->send(new TaskDueReminder($task));
});
