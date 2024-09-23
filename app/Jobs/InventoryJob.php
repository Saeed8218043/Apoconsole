<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InventoryJob implements ShouldQueue
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
                // Retrieve tracking data once and check if it's valid
                $trackingData = trackShipmentWithCarrierFallback($record->tracking);
                // Ensure tracking data is not null and tracking status exists
                if ($trackingData !== null && isset($trackingData['tracking_status']['status'])) {
                    $status = $trackingData['tracking_status']['status'];

                    switch ($status) {
                        case "DELIVERED":
                            $newStatus = "Delivered";
                            break;
                        case "TRANSIT":
                            $newStatus = "Shipped";
                            break;
                        case "PRE_TRANSIT":
                            continue 2;
                    }

                        $record->update([
                            'status' => $newStatus
                        ]);
                        echo "Updated inventory {$record->id} to status {$newStatus} \n";
                }
            }

        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            echo "Please check your internet connection\n";
        }
    }
}
