<?php

namespace App\Jobs;

use App\Entities\User;
use App\Notifications\ExportReady;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $user;
    public $filePath;

    /**
     * Create a new job instance.
     * @param User $auth
     * @param string $filePath
     */
    public function __construct(User $auth, string $filePath)
    {
        $this->user = $auth;
        $this->filePath = $filePath;
    }


    /**
     * Notified the export ready.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new ExportReady());
    }
}
