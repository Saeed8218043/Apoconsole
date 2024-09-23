<?php
namespace App\Http\Controllers;
use App\Jobs\ScrapeJob;
use App\Jobs\ReturnJob;
use App\Jobs\InventoryJob;
use App\Models\hybridInventory;
use App\Models\PfWarehouseOrder;
use App\Models\ReturnApproval;
use App\Models\apexInventory;
use Illuminate\Http\Request;

class ScrapperController extends Controller
{
    public function scrape(Request $request)
    {
        $batchSize = 10;

        $totalRecords = hybridInventory::count();
        for ($i = 0; $i < $totalRecords; $i += $batchSize) {
            $records = hybridInventory::orderBy('item_no', 'desc')->skip($i)->take($batchSize)->get();
            ScrapeJob::dispatch($records)->onQueue('hybrid');
        }

        // Dispatch jobs for apexInventory
        $total = apexInventory::count();
        for ($i = 0; $i < $total; $i += $batchSize) {
            $records = apexInventory::orderBy('item_no', 'desc')->skip($i)->take($batchSize)->get();
            ScrapeJob::dispatch($records)->onQueue('apex');
        }


        $orders = PfWarehouseOrder::count();

        for ($i = 0; $i < $orders; $i += $batchSize) {
            $records = PfWarehouseOrder::orderBy('id', 'desc')->skip($i)->take($batchSize)->get();
            InventoryJob::dispatch($records)->onQueue('inventory');
       }

       $orders = ReturnApproval::count();

        for ($i = 0; $i < $orders; $i += $batchSize) {
            $records = ReturnApproval::orderBy('id', 'desc')->skip($i)->take($batchSize)->get();
            ReturnJob::dispatch($records)->onQueue('returns');
       }

        return response()->json(['message' => 'Scrape job has been dispatched']);
    }
}
