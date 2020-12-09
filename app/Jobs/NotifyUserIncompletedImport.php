<?php

namespace App\Jobs;

use App\Entities\User;
use App\Mail\ImportErrorsDueValidation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUserIncompletedImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private User $user;

    /**
     * @var array
     */
    private array $errors;


    /**
     * Create a new job instance.
     *
     * @param $user
     * @param array $errors
     */
    public function __construct($user, array $errors)
    {
        $this->user = $user;
        $this->errors = $errors;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send(new ImportErrorsDueValidation($this->user, $this->errors));
    }
}
