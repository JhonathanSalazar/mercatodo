<?php

namespace App\Jobs;

use App\Entities\Report;
use App\Entities\User;
use App\Notifications\ExportReady;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportReportCompleted implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var User
     */
    private User $user;
    private string $filePath;
    private string $type;


    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $filePath
     * @param string $type
     */
    public function __construct(User $user, string $filePath, string $type)
    {
        $this->user = $user;
        $this->filePath = $filePath;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Report::create([
            'type' => $this->type,
            'file_path' => $this->filePath,
            'created_by' => $this->user->id
        ]);

        $this->user->notify(new ExportReady());
    }
}
