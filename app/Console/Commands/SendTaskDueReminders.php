<?php

namespace App\Console\Commands;

use App\Mail\TaskDueReminder;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskDueReminders extends Command
{
    /**
     * @var string
     */
    protected $signature = "app:send-task-due-reminders";

    /**
     * @var string
     */
    protected $description = "Command description";

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        $tasks = Task::whereDate("due_date", $tomorrow)->with("user")->get();

        foreach ($tasks as $task) {
            if ($task->user && $task->user->email) {
                Mail::to($task->user->email)->send(new TaskDueReminder($task));
            }
        }

        $this->info("command: send task due reminder");
    }
}
