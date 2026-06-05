<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessEventJob implements ShouldQueue
{
    use Queueable;

    public $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function handle(): void
    {
        Log::channel('single')->info('==============================');
        Log::channel('single')->info('JOB INICIADO EVENTO: ' . $this->eventId);

        sleep(5);

        Log::channel('single')->info('JOB FINALIZADO EVENTO: ' . $this->eventId);
        Log::channel('single')->info('==============================');
    }
}