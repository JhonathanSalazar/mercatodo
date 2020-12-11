<?php

namespace App\Jobs;

use App\Entities\Report;
use App\Notifications\ExportReady;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $user;
    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param $user
     * @param string $filePath
     */
    public function __construct($user, string $filePath)
    {
        $this->user = $user;
        $this->filePath = $filePath;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Report::create([
            'type' => 'product-export',
            'file_path' => $this->filePath,
            'created_by' => $this->user->id
        ]);

        $this->user->notify(new ExportReady());
    }
}
