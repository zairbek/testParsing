<?php

namespace App\Jobs;

use App\Events\ErrorInJobEvent;
use App\Events\ParsingCompletedSuccessfullyEvent;
use App\Models\Row;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class InsertToDBJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly array  $data,
        private readonly string $fingerprint,
    ) {
    }

    public function handle(): void
    {
        try {
            foreach ($this->data as $datum) {
                Row::updateOrCreate([
                    'externalId' => $datum['id'],
                ], [
                    'name' => $datum['name'],
                    'date' => Carbon::createFromFormat('j.n.y', $datum['date'])
                ]);

                Redis::incr($this->fingerprint . '_done');


                $total = Redis::get($this->fingerprint . '_count');
                $done = Redis::get($this->fingerprint . '_done');
                if ($total === $done) {
                    ParsingCompletedSuccessfullyEvent::dispatch($this->fingerprint);
                }
            }
        } catch (Exception $e) {
            ErrorInJobEvent::dispatch($this->fingerprint, $e->getMessage(), $e->getTrace());
        }
    }
}
