<?php

namespace App\Jobs;

use App\Models\SharedQuote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ProcessShareQuote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private $shareQuote;


    public function __construct(SharedQuote $shareQuote)
    {
        $this->shareQuote = $shareQuote;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->shareQuote->getShare()->send()) {
            $this->shareQuote->save();
        }
    }
}
