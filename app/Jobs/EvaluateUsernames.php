<?php

namespace App\Jobs;

use App\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class EvaluateUsernames implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $process = new Process(['evaluate_username_script']);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $newlyProcessed = Batch::where('is_processed', false)->get();
        foreach($newlyProcessed as $batch){
            if($batch->email){
                dump('Trying to send an email');
                $email = new SendBatchMail($batch->id);
                $email->dispatch($batch->id);
            }
        }
        DB::statement("UPDATE username_ranking.batches SET is_processed = 1");

    }
}
