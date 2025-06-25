<?php

use App\Mail\TaskDueReminder;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Route::get("/mail", function () {
//     $task = Task::firstOrFail();
//     return Mail::to("test@example.com")->send(new TaskDueReminder($task));
// });

Route::get("/public/task/{task}", function (Request $request, Task $task) {
    // TODO always return custom 404 page for security
    abort_unless($request->hasValidSignature(), 403);

    // TODO make this view better, add protection if some values are not present
    return view("tasks.public-view", ["task" => $task]);
})->name("public.task.view")->middleware("signed");
