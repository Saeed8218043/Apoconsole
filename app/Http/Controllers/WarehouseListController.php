<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\User;
use App\Models\Warehouses;
use App\Models\PfWarehouse;
use App\Models\PfWarehouseOrder;
use App\Models\Warehouse;
use App\Models\InventoryOrder;
use App\Models\ReturnApproval;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DataTables;
use TCPDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use DB;

class WarehouseListController extends Controller
{
     public function bulkdelete(Request $request){
        if (isset($request->list) && $request->list != '') {
          $list = explode(',', $request->list);

          Warehouses::whereIn('id', $list)->delete();
        }
      }

     public function datatableapi(Request $request)
      {

        //$model = Orders::query();


          $model = Warehouses::orderBy('id','desc');


        // $model = $model->pluck('orders');
        // dd($model);
         if (isset($request->vendor) && $request->vendor != '') {
          $model->where('vendor',$request->vendor);
        }




        $model = $model->orderBy('name','asc')->get();

    $_GET['id']=1;

        return DataTables::of($model)
          ->setRowId(function ($data) {
            return '';
          })
          // ->setRowClass(function ($user) {

          ->setRowData([

          ])


          ->editColumn('created_at', function ($row) {
             return Carbon::parse($row->created_at)->diffForHumans();
          })


          ->addColumn('checkbox',  function ($row) {
            return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
      </div>';
          })

          ->addColumn('user', function ($row) {
            if ($row->user_id != null) {
                $userIds = explode(',', $row->user_id);
                $users = User::whereIn('id', $userIds)->pluck('email')->toArray();
                return implode('<br>', $users);
            }
            return '';
        })

         ->addColumn('user_id', function($row)  {
          if ($row->user != null){
              return $row->user->id;
          }
        })



            ->addColumn('total', function($row)  {
          return view('pages.warehouses.action',['row'=>$row]);
        })

          ->addColumn('action', function($row)  {
          return view('pages.warehouses.action',['row'=>$row]);
        })

          ->rawColumns(['checkbox','total', 'action','user'])
          ->make(true);



      }

    public function index()
      {
        $users = User::get();

        return view('pages.warehouses.main',['users'=>$users]);
      }

     public function store(Request $request)
    {
      //$request->name = ($request->name == NULL) ? 0 : 1;

        $vendor = Warehouses::create(
        [
            'name'         => $request->name,
            'user_id'         => $request->user,

       ]);


       if (isset($vendor->id)) {
         return response()->json(['message'=>'Warehouse Successfully Added'],200);
       } else {
         return response()->json(['message'=>'Unable To Process Request'],500);
       }
    }

    public function update(Request $request, $id)
    {
       $users = implode(',',$request->user);
      $vendor = Warehouses::find($id);
        $vendor->name  = $request->name;
        $vendor->user_id  = $users;

        $vendor->save();


   if (isset($vendor->id)) {
         return response()->json(['success' => true, 'message' => __('Warehouse Updated Successfully!!')]);

    //  return response()->json(['message'=>' Successfully Updated'],200);
   } else {
     return response()->json(['message'=>'Unable To Process Request'],500);
   }
    }





    public function summary_csv_download()
    {
        $results = DB::table('warehouse_data')
        ->select('ASINItem_ID', DB::raw('COUNT(*) as part_count'))
        ->whereNotNull('ASINItem_ID')
        ->where(function ($query) {
            $query->whereNull('inlabel')
                ->orWhere('inlabel', '');
        })
        ->groupBy('ASINItem_ID')
        ->get();


        $date = Carbon::now()->format('d-m-Y H:i:s');
        $csvFileName = 'summary_' . $date . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $handle = fopen('php://temp', 'w+');

        // Add CSV headers
        fputcsv($handle, ['Sku', 'Counts']);

        // Add data rows
        foreach ($results as $row) {
            fputcsv($handle, [$row->ASINItem_ID, $row->part_count]);
        }

        fseek($handle, 0);

        // Use the stream method to generate the file download
        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
                fclose($handle);
            },
            200,
            $headers
        );
    }

    public function summary_label_download(Request $request)
    {
        $results = Warehouse::where('id', $request->id)->first();


           if(auth()->user()->email==="syedali@autooutletllc.com"){
               Warehouse::where('id', $request->id)->update([
                   'status' => 'Shipped'
               ]);
           }


        // Fetch the file content (PDF or image)
        $filePath = public_path('warehousedataimage/' . $results->inlabel);
        $fileContent = file_get_contents($filePath);
        $fileType = mime_content_type($filePath);

        // Return the file as a base64-encoded string in JSON response
        return response()->json([
            'success' => true,
            'file' => 'data:' . $fileType . ';base64,' . base64_encode($fileContent),
            'filename' => $results->inlabel
        ]);
    }



    public function download_orders_csv(Request $request)
    {

        // $results = PfWarehouseOrder::where('warehouse_name',$request->segment(2))->get();
        $results = $this->getFilteredData($request);
        $date = Carbon::now()->format('d-m-Y H:i:s');
        $csvFileName = 'orders_' . $date . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $handle = fopen('php://temp', 'w+');

        // Add CSV headers
        fputcsv($handle, ['Sku','Date' ,'Order ID','Label Price','Tracking','Status','Ordered Parts']);

        // Add data rows
        foreach ($results as $row) {
            // Preprocess the parts data to extract part numbers only
            $parts = explode(',', $row->part); // Split parts by comma
            $parts = array_map(function($part) {
                // Extract part number before ':' and trim any whitespace
                return trim(explode(':', $part)[0]);
            }, $parts);
            $parts = implode(PHP_EOL, $parts); // Concatenate parts with newline
            fputcsv($handle, [$parts,$row->ship_by_date ,$row->order_id,$row->label_price,$row->tracking,$row->status,$row->ordered_items]);
        }

        fseek($handle, 0);

        // Use the stream method to generate the file download
        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
                fclose($handle);
            },
            200,
            $headers
        );
    }

    private function getFilteredData(Request $request)
    {
        $query = PfWarehouseOrder::query();

        // Apply date range filter if both start_date and end_date are provided
        if (isset($request->start_date) && !empty($request->start_date) && isset($request->end_date) && !empty($request->end_date)) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Apply warehouse_name filter if provided
        if (isset($request->warehouse_name) && !empty($request->warehouse_name)) {
            $query->where('warehouse_name', $request->warehouse_name);
        }

        $statusMap = [
            1 => 'Unshipped',
            2 => 'Shipped',
            3 => 'Delivery Stuck',
            4 => 'Delivered',
            5 => 'Label Downloaded'
        ];

        // Apply status filter if provided
        if (isset($request->status) && !empty($request->status)) {
            $status = (int)$request->status; // Convert status to integer
            if (array_key_exists($status, $statusMap)) {
                $query->where('status', $statusMap[$status]);
            }
        }

        return $query->get();
    }

    public function download_orders_report(Request $request)
    {
        $results = PfWarehouse::orderBy('id', 'desc')->where('warehouse_name',$request['warehouse'])->get();
        $date = Carbon::now()->format('d-m-Y H:i:s');
        $csvFileName = 'Inventory' . $date . '.csv';


        $Allorders = InventoryOrder::select('part_number', DB::raw('SUM(qty) as total_qty'))
        ->groupBy('part_number')
        ->get();
        $thirtyDaysAgo = Carbon::now()->subDays(31);

    $monthlyOrders = InventoryOrder::select('part_number', DB::raw('SUM(qty) as total_qty'))
        ->where('created_at', '>', $thirtyDaysAgo)
        ->groupBy('part_number')
        ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $handle = fopen('php://temp', 'w+');

        // Add CSV headers
        fputcsv($handle, ['Sku','Price Per Unit','Monthly orders','All orders','Quantity']);

        // Add data rows
        foreach ($results as $row) {
            $allOrder = $Allorders->firstWhere('part_number', $row->part);
            $allorders = $allOrder ? $allOrder->total_qty : 0;

            $monthly = $monthlyOrders->firstWhere('part_number', $row->part);
            $monthlyOrder = $monthly ? $monthly->total_qty : 0;

            fputcsv($handle, [$row->part,$row->price_per_unit,$monthlyOrder,$allorders,$row->inventory_count]);
        }

        fseek($handle, 0);

        // Use the stream method to generate the file download
        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
                fclose($handle);
            },
            200,
            $headers
        );
    }



    public function download_returns_report(Request $request)
    {
        $results = ReturnApproval::orderBy('id', 'desc')->where('warehouse_name',$request['warehouse'])->get();
        $date = Carbon::now()->format('d-m-Y H:i:s');
        $csvFileName = 'Returns' . $date . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $handle = fopen('php://temp', 'w+');

        // Add CSV headers
        fputcsv($handle, ['Order ID','Part Number','Part Status','Tracking','Status','QTY']);

        // Add data rows
        foreach ($results as $row) {
            fputcsv($handle, [
                $row->order_id,
                $row->part,
                $row->part_status,
                "\t" . $row->tracking, // Add tab before the tracking number to force it as text
                $row->status,
                $row->returned_count
            ]);
        }

        fseek($handle, 0);

        // Use the stream method to generate the file download
        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
                fclose($handle);
            },
            200,
            $headers
        );
    }


     public function summary ()
      {


      $warehouse =  Warehouses::first();




    //    if (auth()->user()->is_admin()){
           $users = User::get();

        return view('pages.warehouse.summary',['users'=>$users,'warehouse'=>$warehouse,'all'=>1]);
    //    } else {
    //     return redirect()->back()->with(['error'=>'You donot allow to this Report']);
    //   }




      }


















}
