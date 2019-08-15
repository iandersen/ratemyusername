<?php

namespace App\Jobs;

use App\Batch;
use App\Mail\BatchComplete;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendBatchMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $batchID;

    /**
     * Create a new job instance.
     *
     * @param $batchID
     */
    public function __construct($batchID)
    {
        $this->batchID = $batchID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $batch = Batch::where('id', $this->batchID)->first();
        $to = $batch->email;
        $link = "https://ratemyusername.com/batch/$this->batchID";
        $email = new BatchComplete($link);
        dump('Sending mail');
        Mail::to($to)->send($email);
    }
}
