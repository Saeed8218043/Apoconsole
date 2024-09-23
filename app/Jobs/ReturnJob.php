<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReturnJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $records;

    public function __construct($records)
    {
        $this->records = $records;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            foreach ($this->records as $record) {
                $trackingData = trackShipmentWithCarrierFallback($record->tracking);
            if($trackingData!==null && $trackingData['tracking_status']['status']==="DELIVERED"){
                $record->update([
                    'status'=>"Returned"
                ]);
                echo "updated return $record->id \n";
            }
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            echo "Please check your internet connection\n";
        }
    }
}
