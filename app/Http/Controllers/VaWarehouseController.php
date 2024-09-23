<?php

namespace App\Http\Controllers;

use App\Models\Warehouses;
use App\Models\VaEssandent;
use App\Models\VaEssandentOrder;
use App\Models\Warehouse;
use App\Models\VaEssandentAverage;
use App\Models\InventoryAverage;
use App\Models\VaEssandentApproval;
use App\Models\VaEssandentReturn;
use App\Models\WarehouseDataImages;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use TCPDF;
use DB;
use Illuminate\Support\Facades\Session;

class VaWarehouseController extends Controller
{
     public function bulkdelete(Request $request,$warehouse){
         $warehouse =  Warehouses::find($warehouse);


      if (!isset($warehouse->user_id)){

          return false;

      }



           if (isset($request->list) && $request->list != '') {
          $list = explode(',', $request->list);

          Warehouse::whereIn('id', $list)->delete();
        }



      }
     public function delete(Request $request){
        // dd($request->all());
        if (isset($request->list) && $request->list != '') {
            $list = explode(',', $request->list);

            // Get warehouse records to delete
            $warehouses = VaEssandent::whereIn('id', $list)->get();

            // Delete images and corresponding records
            foreach ($warehouses as $warehouse) {

                $warehouse->delete();
            }
        }
      }
        public function approval_delete(Request $request){
        // dd($request->all());
        if (isset($request->list) && $request->list != '') {
            $list = explode(',', $request->list);

            // Get warehouse records to delete
            $warehouses = VaEssandentApproval::whereIn('id', $list)->get();

            // Delete images and corresponding records
            foreach ($warehouses as $warehouse) {

                $warehouse->delete();
            }
        }
      }


      public function order_delete(Request $request){

        if (isset($request->list) && $request->list != '') {
            $list = explode(',', $request->list);

            $warehouses = VaEssandentOrder::whereIn('id', $list)->get();
            foreach ($warehouses as $warehouse) {

                $warehouse->delete();
            }
        }
      }

      public function va_report(Request $request)
      {
          $results = VaEssandent::orderBy('id', 'desc')->get();
          $date = Carbon::now()->format('d-m-Y H:i:s');
          $csvFileName = 'Inventory' . $date . '.csv';


          $Allorders = VaEssandentAverage::select('part_number', DB::raw('SUM(qty) as total_qty'))
          ->groupBy('part_number')
          ->get();
          $thirtyDaysAgo = Carbon::now()->subDays(31);

      $monthlyOrders = VaEssandentAverage::select('part_number', DB::raw('SUM(qty) as total_qty'))
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


      public function datatableapi(Request $request)
      {
        $model = VaEssandent::query();
        $warehouse_name =$request->name;
        // Apply status filter if provided
        if ($request->has('status') && $request->status != '') {
            switch ($request->status) {
                case 1:
                    $model->where('status', 'Stocked in');
                    break;
                case 2:
                    $model->where('status', 'Stocked out');
                    break;
                case 3:
                    $model->where('status', 'Shipped');
                    break;
                case 4:
                    $model->where('status', 'Low quantity');
                    break;
            }
        }

        // Apply custom ordering

        // Fetch data
        $data = $model
        ->orderBy('Inventory_count', 'desc')
        ->get();

        return DataTables::of($data)
            ->setRowId(function ($row) {
                return '';
            })
          // ->setRowClass(function ($user) {

          ->setRowData([

          ])


          ->editColumn('created_at', function ($row) {
             return Carbon::parse($row->created_at)->diffForHumans();
          })
          ->addColumn('status', function ($row) {
            if($row->inventory_count ==0){
                $row->update(['status' => "Stocked out",'price_per_unit'=>0]);
              return '<span class="badge badge-danger">Stocked out</span>';
            }elseif($row->inventory_count>=1 && $row->inventory_count>5){
                $row->update(['status' => "Stocked in"]);
              return '<span class="badge badge-success">Stocked in</span>';
            }elseif($row->inventory_count<=5 && $row->inventory_count>0){
                $row->update(['status' => "Low quantity"]);
                return '<span class="badge badge-warning">Low quantity</span>';
            }else{
                return $row->status;
            }
          })





          ->addColumn('checkbox',  function ($row) {
            return '<div class="form-check form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
      </div>';
          })

          ->addColumn('Part', function($row)  {
          if ($row->part != null){
              return $row->part;
          }
        })


        ->addColumn('price_per_unit', function($row)  {
            return number_format($row->price_per_unit,2);
        })

        ->addColumn('price', function($row)  {
            $price = $row->price_per_unit * $row->inventory_count;
            $row->update(['price' => round($price, 2)]); // Update with rounded price to 2 decimal places
            return number_format($price, 2);
          })


        ->addColumn('Picture', function($row) {
            $imagePath = asset('warehousedataimage/' . $row->picture);
            return $imagePath;
        })


        ->addColumn('Title', function($row)  {
         if ($row->title != null){
             return $row->title;
         }


        })

         ->addColumn('user_id', function($row)  {
          if ($row->user != null){
              return $row->user->id;
          }
        })
         ->addColumn('ASINItem_ID', function($row)  {
              return $row->asin;
        })


        ->addColumn('Tracking', function($row)  {

         return $row->tracking;
        })

        ->addColumn('average', function($row)  {
            $average =$row->average;

            $totalPriceSum = InventoryAverage::where('part_number', $row->part)
            ->where('price', '!=', 0)
            ->sum('total_price');

            $qtySum = InventoryAverage::where('part_number', $row->part)
                ->where('price', '!=', 0)
                ->sum('qty');

            if($totalPriceSum>0 && $qtySum>0){
                $average = $totalPriceSum/$qtySum;
                VaEssandent::where('id', $row->id)
                ->update(['average' => $average]);
            }

                return round($average,2);

        })
        ->addColumn('returned_count', function($row)  {

         return $row->returned_count;
        })
        ->addColumn('Inventory_count', function($row)  {

         return $row->inventory_count;
        })
         ->addColumn('total_count', function($row)  {

         return $row->returned_count + $row->inventory_count;
        })


          ->addColumn('action', function($row)  {
          return view('pages.va_essandent.action',['row'=>$row]);
        })

          ->rawColumns(['checkbox','total', 'action','status','label'])
          ->make(true);



      }

 public function approval_datatableapi(Request $request)
      {

         $model = VaEssandentApproval::orderBy('id','desc');
         if (isset($request->status) && $request->status != ''){
            if ($request->status == 1){
                $model = VaEssandentApproval::where('status','Shipped');
            }
            if ($request->status == 2){
                $model = VaEssandentApproval::where('status','Delivered');
            }
            if ($request->status == 3){
                $model = VaEssandentApproval::where('status','Missing parts');
            }


        }
         $model = $model->orderBy('id','desc')->get();
        // dd($model);
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
          ->addColumn('status', function ($row) {
            if($row->status ==="Stocked out" || $row->status ==="Missing parts"){
              return '<span class="badge badge-danger">'.$row->status.'</span>';
            }else{
                return $row->status;
            }
          })





          ->addColumn('checkbox',  function ($row) {
            return '<div class="form-check form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
      </div>';
          })

          ->addColumn('Part', function($row)  {
          if ($row->part != null){
              return $row->part;
          }
        })





        ->addColumn('Picture', function($row) {
            $imagePath = asset('warehousedataimage/' . $row->picture);
            return $imagePath;
        })


        ->addColumn('Title', function($row)  {
         if ($row->title != null){
             return $row->title;
         }


        })

         ->addColumn('user_id', function($row)  {
          if ($row->user != null){
              return $row->user->id;
          }
        })
         ->addColumn('ASINItem_ID', function($row)  {
              return $row->asin;
        })
         ->addColumn('price', function($row)  {
              return $row->price;
        })


        ->addColumn('Tracking', function($row)  {

         return $row->tracking;
        })

        ->addColumn('expected_delivery', function($row)  {

         return $row->expected_delivery;
        })
        ->addColumn('Inventory_count', function($row)  {

         return $row->inventory_count;
        })


          ->addColumn('action', function($row)  {
          return view('pages.va_essandent.warehouse_new_inventory.action',['row'=>$row]);
        })

          ->rawColumns(['checkbox','total', 'action','status','label'])
          ->make(true);



      }


      public function orders_datatableapi(Request $request)
      {
         $model = VaEssandentOrder::orderBy('id','desc');
         if (isset($request->status) && $request->status != ''){
               if ($request->status == 1){
             $model = VaEssandentOrder::where('status','Unshipped');
            }
            if ($request->status == 2){
             $model = VaEssandentOrder::where('status','Shipped');
            }
            if ($request->status == 3){
              $model = VaEssandentOrder::where('status','Delivery Stuck');
            }
            if ($request->status == 4){
              $model = VaEssandentOrder::where('status','Delivered');
            }
        }
            $model = $model->orderBy('id','desc')->get();
            $_GET['id']=1;

            return DataTables::of($model)
            ->setRowId(function ($data) {
                return '';
            })

            ->setRowData([

            ])


            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })
            ->addColumn('status', function ($row) {
                if($row->status ==="Unshipped" || $row->status ==="Delivery Stuck"){
                    return '<span class="badge badge-danger">'.$row->status.'</span>';
                }elseif($row->status ==="Shipped" ){
                    return '<span class="badge badge-success">'.$row->status.'</span>';
                }else{
                    return $row->status;
                }
            })





            ->addColumn('checkbox',  function ($row) {
                return '<div class="form-check form-check-sm form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
        </div>';
            })

        ->addColumn('download_label', function($row) {
            if ($row->label != NULL){
                return '<button class="btn-sm btn-primary download_label_button" row_id="'.$row->id.'" data-href-url="'.asset('public/warehousedataimage/ordersPdf').'/'.$row->label.'" data-download="'.$row->label.'">Download</button>';
             }
        })


        ->addColumn('ship_by_date', function($row)  {
         if ($row->ship_by_date != null){
             return $row->ship_by_date;
         }


        })

        ->addColumn('orders', function($row)  {

         return $row->ordered_items;
        })
        ->addColumn('title', function($row)  {

         return $row->title;
        })

          ->addColumn('action', function($row)  {
          return view('pages.va_essandent.warehouse_orders.action',['row'=>$row]);
        })

          ->rawColumns(['checkbox','total', 'action','status','download_label'])
          ->make(true);



      }



      public function order_label_download(Request $request)
      {
          $results = VaEssandentOrder::where('id', $request->id)->first();

             if(auth()->user()->email==="syedali@autooutletllc.com"){
                VaEssandentOrder::where('id', $request->id)->update([
                     'status' => 'Shipped'
                 ]);
             }

          $filePath = public_path('warehousedataimage/ordersPdf/' . $results->label);
          $fileContent = file_get_contents($filePath);
          $fileType = mime_content_type($filePath);

          return response()->json([
              'success' => true,
              'file' => 'data:' . $fileType . ';base64,' . base64_encode($fileContent),
              'filename' => $results->label
          ]);
      }


      public function warehouse_report_csv(Request $request )
      {
        // dd($request->segment(2));
        $results = Warehouse::where('warehouse_id', $request->segment(2))->orderByRaw('inlabel IS NULL, inlabel = "", id DESC')->get();
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
          fputcsv($handle, ['Part','Part_Condition']);

          // Add data rows
          foreach ($results as $row) {
              // Preprocess the parts data to extract part numbers only
              $parts = explode(',', $row->ASINItem_ID); // Split parts by comma
              $parts = array_map(function($ASINItem_ID) {
                  // Extract part number before ':' and trim any whitespace
                  return trim(explode(':', $ASINItem_ID)[0]);
              }, $parts);
              $parts = implode(PHP_EOL, $parts); // Concatenate parts with newline
              fputcsv($handle, [$parts,$row->Part_Condition]);
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

      public function index(Request $request){
            $inventory ='';
            $statusCounts = VaEssandent::select('status', DB::raw('count(*) as count'))->groupBy('status')->get();
            $price = VaEssandent::select(DB::raw('SUM(price) as total_price'))->first();
          return view('pages.va_essandent.main',['users'=>$inventory,'net_price'=>$price->total_price,'statusCounts'=>$statusCounts,'warehouse'=>'pf_warehouse']);
    }
      public function returns_index(Request $request){
          $users = VaEssandentReturn::get();
          return view('pages.va_essandent.warehouse_returns.main',['users'=>$users,'warehouse'=>'pf_warehouse']);

    }
      public function inventory_approval(Request $request){
          $users = VaEssandentApproval::get();
          $needToApprove = VaEssandentApproval::where('status','Delivered')->count();
          $intransit = VaEssandentApproval::where('status','Shipped')->count();

          return view('pages.va_essandent.warehouse_new_inventory.main',['users'=>$users,'warehouse'=>'pf_warehouse','needToApprove'=>$needToApprove,'intransit'=>$intransit]);

    }

      public function inventory_orders(Request $request){

             $users = VaEssandentOrder::get();
             $UnshippedOrders = VaEssandentOrder::where('status', 'Unshipped')->get();
            return view('pages.va_essandent.warehouse_orders.main',['users'=>$users,'orders'=>count($UnshippedOrders),'warehouse'=>'pf_warehouse']);

    }

     public function store(Request $request,$warehouse)
    {

      //$request->name = ($request->name == NULL) ? 0 : 1;



      $request->validate([

            'inlabel' => 'mimes:jpg,jpeg,png,pdf,doc,docx',
            'warehousedataimage' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx'
        ]);



        $inlabel = '';
        if ($request->inlabel != null){
          $inlabel = time().'.'.$request->inlabel->extension();

        $request->inlabel->move(public_path('warehousedataimage'), $inlabel);
        }



        $vendor = Warehouse::create(
        [
            'Tracking_ID'            => $request->Tracking_ID,
            'Customer_Name'            => $request->Customer_Name,
            'ASINItem_ID'            => $request->ASINItem_ID,
            'Part_Condition'            => $request->Part_Condition,
            'status'            => "Stock In",
            'Picture'            => ' ',
            'Ship_button'            => $request->Ship_button,
            'Shipped_Button'            => $request->Shipped_Button,
            'user_id'            => auth()->user()->id,
            'warehouse_id'            => $warehouse,

       ]);



       $fileName = '';
        if ($request->Picture != null){
          foreach ($request->Picture as $picture){
              $fileName = time().'.'.$picture->extension();
      $picture->move(public_path('warehousedataimage'), $fileName);


      $vendor->images()->create([
          'user_id' => auth()->user()->id,
          'image'   => $fileName,
          ]);

       sleep(1);
          }
        }


       if (isset($vendor->id)) {
         return response()->json(['message'=>'Warehouse Data Successfully Added'],200);
       } else {
         return response()->json(['message'=>'Unable To Process Request'],500);
       }
    }

     public function pf_warehouse_store(Request $request)
    {


      $request->validate([
            'warehousedataimage' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx'
        ]);



        $pictures = [];
        if ($request->hasFile('picture')) {
            foreach ($request->file('picture') as $key => $file) {
                $fileName = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('warehousedataimage'), $fileName);
                $pictures[] = $fileName;
            }
        }

        // Convert the array of filenames to a comma-separated string
        $pictureString = implode(',', $pictures);

        $vendor = VaEssandent::create(
        [
            'asin'            => $request->asin??'',
            'part'            => $request->part,
            'picture'            => $pictureString,
            'title'            => $request->title,
            // 'tracking'            => $request->tracking,
            'status'            => $request->status,
            'inventory_count'            => $request->inventory_count,

       ]);


       if (isset($vendor->id)) {
         return response()->json(['message'=>'Warehouse Inventory Successfully Added'],200);
       } else {
         return response()->json(['message'=>'Unable To Process Request'],500);
       }
    }

     public function inventory_store(Request $request)
    {
        // dd($request->all());
      $request->validate([
            'warehousedataimage' => 'nullable|mimes:jpg,jpeg,png'
        ]);

        $price = $request->price * $request->inventory_count;
        $formattedPrice = number_format($price, 2);
        $pictures = [];
        if ($request->hasFile('picture')) {
            foreach ($request->file('picture') as $key => $file) {
                $fileName = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('warehousedataimage'), $fileName);
                $pictures[] = $fileName;
            }
        }

        // Convert the array of filenames to a comma-separated string
        $pictureString = implode(',', $pictures);

            $vendor = VaEssandentApproval::create([
                'order_id'            => $request->order_id??'',
                'asin'            => $request->asin??'',
                'part'            => $request->part,
                'price_per_unit'  => $request->price_per_unit,
                'picture'         => $pictureString,
                'title'           => $request->title,
                'tracking'        => $request->tracking,
                'expected_delivery'        => $request->expected_delivery,
                'status'          => $request->status,
                'inventory_count' => $request->inventory_count,
            ]);

            return response()->json(['message'=>'Warehouse Inventory Approval Successfully created'],200);

    }


    public function order_store(Request $request)
    {
        $request->validate([
            'labels' => 'nullable|mimes:pdf'
        ]);

        $fileName = null;
        if ($request->hasFile('labels')) {
            // Get the uploaded file
            $file = $request->file('labels');

            // Create a unique file name
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Move the file to the specified directory
            $file->move(public_path('warehousedataimage/ordersPdf/'), $fileName);
        }

        VaEssandentOrder::create([
            'title'              => $request->title,
            'ship_by_date'  => $request->ship_by_date,
            'status'             => "Unshipped",
            'ordered_items'    => $request->ordered_items,
            'label'           => $fileName,
        ]);

        return response()->json(['message' => 'Warehouse Inventory Approval Successfully created'], 200);
    }

    public function approval_approve(Request $request){
        $inventory = VaEssandentApproval::where('id', $request->inventory_id)->first();
        $pf = VaEssandent::where('part', $request->part)->first();
        // Retrieve the inventory approval details
        $inventory_approval = VaEssandentAverage::where('part_number', $request->part)->first();

        // Calculate the total price for the current inventory count
        $total = ($inventory->price_per_unit ?? 0) * $request->inventory_count;

        // Calculate the updated price, quantity, and total price
        $price = ($inventory_approval->price_per_unit ?? 0) + ($inventory->price_per_unit ?? 0);
        $qty = $request->inventory_count;

        // Update or create the inventory average record
        VaEssandentAverage::create(
                [
                'part_number' => $inventory->part,
                'price' => $inventory->price_per_unit,
                'qty' => $qty,
                'total_price' => $total,
                ]);

                $inventory_sums = VaEssandentAverage::where('part_number', $request->part)->where('warehouse_name',$request->warehouse_name)
                ->selectRaw('CAST(SUM(qty) AS UNSIGNED) as total_qty, SUM(total_price) as total_price')
                ->first();
                $sum =$inventory_sums->total_qty??1;
               $average = $inventory_sums->total_price/$sum;
               $average = round($average, 2);

        $qty='';
        $vendor ='';
        $status ='';
        if(isset($inventory) && $request->inventory_count > $inventory->inventory_count){
            return response()->json(['message'=>'You entered the wrong inventory'],500);
        }

        if(isset($inventory) &&$request->inventory_count < $inventory->inventory_count){
            $qty = $inventory->inventory_count - $request->inventory_count;
            VaEssandentApproval::where('id', $request->inventory_id)->update([
                'status' => "Missing parts",
                'inventory_count' => $qty
            ]);
        $count = $pf->inventory_count??0;
            $qty = $count+ $request->inventory_count;
            if($qty>5){
                $status ="Stocked in";
            }elseif($qty<5){
                $status ="Low quantity";
            }
            // dd($inventory->price_per_unit);
            VaEssandent::updateOrCreate(
                    ['part' => $inventory->part,
                    ],
                    [
                        'asin' => $request->asin??'',
                        'picture' => $inventory->picture,
                        'price_per_unit' => $inventory->price_per_unit??0,
                        'title' => $inventory->title,
                        'average' => $average,
                        'tracking' => $inventory->tracking,
                        'status' => $status,
                        'inventory_count' => $qty,
                    ]
                );

        }elseif($request->inventory_count == $inventory->inventory_count){
            $count = $pf->inventory_count??0;
            $qty = $count+ $request->inventory_count;
            if($qty>5){
                $status ="Stocked in";
            }elseif($qty<5){
                $status ="Low quantity";
            }
            VaEssandent::updateOrCreate(
                ['part' => $inventory->part,
                ],
                [
                    'asin' => $request->asin??"",
                    'picture' => $inventory->picture,
                    'title' => $inventory->title,
                    'average' => $average,
                    'price_per_unit' => $inventory->price_per_unit??0,
                    'tracking' => $inventory->tracking,
                    'status' => $status,
                    'inventory_count' => $qty,
                ]
            );
               $inventory->delete();
        }
            return response()->json(['message'=>'Warehouse Inventory Approved Successfully'],200);

    }



    public function return_approve(Request $request){
        $return = VaEssandentReturn::where('id', $request->id)->first();
        $parts = []; // Array to store parts
        $statuses = []; // Array to store statuses

        foreach($request->part as $key => $part){
            $inventory_count = $request->inventory_count[$key]; // Get inventory count using the key
            $status = $request->status[$key]; // Get status using the key

            $inventory = VaEssandent::where('part', $part)->where('warehouse_name',$request->warehouse_name)->first();
            if($status === "approved"){
                // Decrement inventory count only when status is "approved"
                $inventory->inventory_count += $inventory_count;
                $return->returned_count -= $inventory_count;

                // Remove matched picture
                $returnPictures = explode(',', $return->picture);
                foreach ($returnPictures as $index => $returnPicture) {
                    if (strpos($returnPicture, $inventory->picture) !== false) {
                        unset($returnPictures[$index]); // Remove matched picture from array
                    }
                }
                $return->picture = implode(',', $returnPictures); // Update return picture

                // Update part's quantity in return
                $returnParts = explode(',', $return->part);
                foreach ($returnParts as $index => $returnPart) {
                    list($partName, $quantity) = explode(':', $returnPart);
                    if ($partName === $part) {
                        // Decrement quantity
                        $quantity -= $inventory_count;
                            $returnParts[$index] = $partName . ':' . $quantity;
                            $statuses[$index] = "Approved part"; // Update status according to the index

                    }
                }
                $return->part = implode(',', $returnParts);
                $inventory->warehouse_name = $request->warehouse_name;
                $inventory->save();
                // if(empty($returnParts)){
                //     VaEssandentReturn::where('id', $request->id)->delete(); // Delete the return if there are no remaining approved parts
                // }
            } else {
                // For non-approved status, just store the part and its status
                $parts[] = $part;
                $statuses[] = $status;

            }
        }

        // Update return part status
        $return->part_status = implode(',', $statuses);
        $return->warehouse_name = $request->warehouse_name;
        // Convert parts with quantities array to string
        $partsString = implode(',', $parts);
            // Save changes to the database
            $return->save();
        return response()->json(['message' => 'Warehouse return Approval submitted successfully', 'parts_with_quantity' => $partsString], 200);
    }



    public function open_return(Request $request){
        $order = VaEssandentReturn::where('tracking',$request->tracking)->first();
        if($order !=null){
            return response()->json(['message'=>'Tracking is already exist in '.$order->warehouse_name.' warehouse'],500);
        }

        $inventory = VaEssandent::where('id',$request->row_id)->first();
            VaEssandentReturn::create(
                [
                        'part' => $inventory->part.': '.$request->inventory,
                        'order_id' => $request->order_id??'',
                        'picture' => $inventory->picture,
                        'warehouse_name' => $request->warehouse_name,
                        'tracking' => $request->tracking,
                        'status' => "Returning",
                        'returned_count' => $request->inventory,
                    ]
                );
            return response()->json(['message'=>'Warehouse Return opened Successfully'],200);

    }

    public function reOrder(Request $request){
        $inventory = VaEssandent::where('id',$request->row_id)->first();
        if($inventory->status ==="Low quantity" || $inventory->status ==="Stocked out"){
            VaEssandentApproval::create(
                [
                    'part' => $inventory->part,
                    'asin' => $inventory->asin ?? '',
                    'order_id' => $request->order_id,
                    'picture' => $inventory->picture,
                    'title' => $inventory->title,
                    'warehouse_name' => "va_essandant",
                    'tracking' => $request->tracking,
                    'status' => "Shipped",
                    'inventory_count' => $request->inventory
                ]
            );

            return response()->json(['message'=>'Warehouse parts re-ordered Successfully'],200);
        }
        else{
            return response()->json(['message'=>'Status should be Low quantity or Stocked out'],500);
        }
    }

    public function open_bulk_return(Request $request){
        $order = VaEssandentReturn::where('tracking',$request->tracking)->first();
        if($order !=null){
            $title = 'Success'; // Define your title here
        $message = 'Tracking is already exist in order inventory'; // Define your message here

        Session::flash('title', $title);
        Session::flash('error', $message);

        return redirect()->back();
        }

        $mergedData = [];
        $picture=[];
        foreach ($request->part as $key => $part) {
            // Check if the corresponding inventory exists
            if (isset($request->inventory[$key])) {
                // Retrieve the PfWarehouse by ID
                $warehouse = VaEssandent::where('part',$part)->first();
                // Check if the inventory count is sufficient
                $picture[] = isset($warehouse)?$warehouse->picture:'';
                    $mergedData[] = $part . ': ' . $request->inventory[$key];
            }
        }
        $parts = implode(',',$mergedData);
        $inventories = VaEssandent::whereIn('id', $request->row_id)->get();
        $pictures = $inventories->pluck('picture')->implode(',');
        $totalOrderedItems = array_sum($request->inventory);
           VaEssandentReturn::create(
            [
                    'part' => $parts,
                    'order_id' => $request->order_id??'',
                    'picture' => $pictures,
                    'warehouse_name' => $request->warehouse_name,
                    'tracking' => $request->tracking,
                    'status' => "Returning",
                    'returned_count' => $totalOrderedItems,
                ]
            );

        $title = 'Success'; // Define your title here
        $message = 'Warehouse inventory label created Successfully'; // Define your message here

        Session::flash('title', $title);
        Session::flash('success', $message);

           return redirect()->back();

    }

    public function order_ship(Request $request)
    {
        $order = VaEssandentOrder::where('tracking',$request->tracking)->first();
        if($order !=null){
            return response()->json(['message'=>'Tracking is already exist in order inventory'],500);
        }
            $request->validate([
                'label.*' => 'required|mimes:jpg,jpeg,png',
                'inventory' => 'required|numeric|min:1',
            ]);
                $warehouse = VaEssandent::where('part',$request->part)->first();
                $qty='';
                if (isset($warehouse) && $warehouse->inventory_count>0) {
                 $qty = $warehouse->inventory_count - $request->inventory;
                 if($qty<0){
                 return response()->json(['message'=>'Entered the invalid inventory'],500);
                 }
                    $mergedData =[];
                    if ($warehouse && $request->inventory <= $warehouse->inventory_count && $warehouse->inventory_count>0) {
                        // If inventory count is sufficient, proceed with creating VaEssandentOrder
                        $mergedData[] = $request->part . ': ' . $request->inventory;
                        $warehouse->update([
                            'inventory_count'=>$warehouse->inventory_count - $request->inventory
                        ]);
                    }
                $PartsWithInventory = implode(',', $mergedData);

        $status="Stocked in";

         if($qty==0){
             $status = "Stocked out";
         }elseif($qty>0 && $request->status!="Shipped"){
        $status="Stocked in";
         }elseif($qty<5){
        $status="Low quantity";
         }else{
            $status = $request->status;
         }
         $warehouse->update([
             'status' => $status,
         ]);
     }

        $label = '';
        if ($request->hasFile('label')) {
            $labelFile = $request->file('label')[0];
            $labelFileName = time() . '.' . $labelFile->getClientOriginalExtension();
            $labelFile->move(public_path('warehousedataimage'), $labelFileName);
            $label = $labelFileName;
        }


        $picture = isset($warehouse)?$warehouse->picture:'';

    $vendor = VaEssandentOrder::create(
        [
            'order_id'            => $request->order_id,
            'ship_by_date'            => $request->ship_by_date,
            'label_price'            => $request->label_price??0,
            'label'            => $label,
            'asin'            => $request->asin??'',
            'part'            => $PartsWithInventory,
            'picture'            => $picture,
            'tracking'            => $request->tracking??'',
            'status'            => "Unshipped",
            'ordered_items' => $request->inventory,

       ]);
       VaEssandentAverage::create([
        'part_number' =>$request->part,
        'qty'=>$request->inventory,

       ]);
       if (isset($vendor->id)) {
         return response()->json(['message'=>'Warehouse Inventory order Successfully created'],200);
       } else {
         return response()->json(['message'=>'Unable To Process Request'],500);
       }
    }








    public function update(Request $request,  $warehouses_id, $warehouse)
    {


         $request->validate([

            'inlabel' => 'mimes:jpg,jpeg,png,pdf,doc,docx',
            'warehousedataimage' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx'
        ]);

        $warehouses_id = Warehouses::find($warehouses_id);


        if (! auth()->user()->is_admin()){
    if (!auth()->user()->has_perm('warehousealldataaccess') && isset($warehouses_id->user_id) && $warehouses_id->user_id != auth()->user()->id){

          return response()->json(['message'=>'Unable To Proces Request'],500);

      }
        }

      if (!isset($warehouses_id->user_id)){

          return response()->json(['message'=>'Unable To Process Request'],500);

      }




         $inlabel = '';
        if ($request->inlabel != null){
          $inlabel = time().'.'.$request->inlabel->extension();

        $request->inlabel->move(public_path('warehousedataimage'), $inlabel);
        }
        $status ="Stock In";
        if($request->inlabel !=null){
            $status = "Ready to Ship";
        }
        $vendor = Warehouse::find($warehouse)->update(
        [

            'Tracking_ID'            => $request->Tracking_ID,
            'Customer_Name'            => $request->Customer_Name,
            'Part'            => $request->Part,
            'status'            => $status,
            'inlabel'           =>   $inlabel,
            'ASINItem_ID'            => $request->ASINItem_ID??'',
            'Part_Condition'            => $request->Part_Condition,
            'Shipped_Button'            => $request->Shipped_Button,
       ]);
         $vendor = Warehouse::find($warehouse);


         $fileName = '';
        if ($request->Picture != null){
          foreach ($request->Picture as $picture){
              $fileName = time().'.'.$picture->extension();
      $picture->move(public_path('warehousedataimage'), $fileName);


      $vendor->images()->create([
          'user_id' => auth()->user()->id,
          'image'   => $fileName,
          ]);
      sleep(1);

          }
        }

   if (isset($vendor->id)) {
         return response()->json(['success' => true, 'message' => __('Warehouse Data Updated Successfully!!')]);

    //  return response()->json(['message'=>' Successfully Updated'],200);
   } else {
     return response()->json(['message'=>'Unable To Processs Request'],500);
   }
    }

    public function edit(Request $request)
    {
        $total = ($request->price ?? 0) * $request->inventory_count;
        $qty = $request->inventory_count;
        if($qty>0 && $request->price>0){

            VaEssandentAverage::create(
                    [
                    'part_number' => $request->part,
                    'price' => $request->price,
                    'qty' => $qty,
                    'total_price' => $total,
                    ]);
        }

                $inventory_sums = VaEssandentAverage::where('part_number', $request->part)
                ->selectRaw('CAST(SUM(qty) AS UNSIGNED) as total_qty, SUM(total_price) as total_price')
                ->first();
                $warehouse = VaEssandent::find($request->inventory_id);
                $average = $warehouse->average;
                if($inventory_sums->total_qty>0){
                    $average = $inventory_sums->total_price/$inventory_sums->total_qty;
                    $average = round($average, 2);
                }
         $request->validate([
            'picture.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);
        $price = $request->price * $request->inventory_count;
        $roundedPrice = round($price, 2);
        $formattedPrice = number_format($roundedPrice, 2);
        $pictures = [];
        if (isset($request->picture) && $request->hasFile('picture')) {
            foreach ($request->file('picture') as $key => $file) {
                $fileName = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('warehousedataimage'), $fileName);
                $pictures[] = $fileName;
            }
        }

        // Convert the array of filenames to a comma-separated string
        $pictureString = implode(',', $pictures);
        $vendorData = [
            'asin' => $request->asin??'',
            'part' => $request->part,
            'average' => $average,
            'price' => $formattedPrice,
            'price_per_unit' => $request->price??0,
            'title' => $request->title,
            'tracking' => $request->tracking??'',
            'status' => ($request->inventory_count == 0) ? "Stocked out" : $request->status,
            'inventory_count' => $request->inventory_count,
        ];

        if (!empty($pictureString)) {
            $vendorData['picture'] = $pictureString;
        }

        $vendor = VaEssandent::where('id', $request->inventory_id)->update($vendorData);




         return response()->json(['success' => true, 'message' => __('Warehouse Data Updated Successfully!!')]);

    }
    public function approval_edit(Request $request)
    {
         $request->validate([
            'picture.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $price = $request->price * $request->inventory_count;
        $formattedPrice = number_format($price, 2);

        $warehouses_id = VaEssandentApproval::find($request->inventory_id);
        $pictures = [];
        if (isset($request->picture) && $request->hasFile('picture')) {
            foreach ($request->file('picture') as $key => $file) {
                $fileName = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('warehousedataimage'), $fileName);
                $pictures[] = $fileName;
            }
        }

        // Convert the array of filenames to a comma-separated string
        $pictureString = implode(',', $pictures);
        $vendorData = [
            'order_id'            => $request->order_id??'',
            'expected_delivery'        => $request->expected_delivery,
            'part' => $request->part,
            'title' => $request->title,
            'price_per_unit' => $request->price_per_unit,
            'tracking' => $request->tracking,
            'status' => ($request->inventory_count == 0) ? "Stocked out" : $request->status,
            'inventory_count' => $request->inventory_count,
        ];

        if (!empty($pictureString)) {
            $vendorData['picture'] = $pictureString;
        }

            $vendor = VaEssandentApproval::where('id', $request->inventory_id)->update($vendorData);

         return response()->json(['success' => true, 'message' => __('Warehouse Data Updated Successfully!!')]);

    }

        public function return_edit(Request $request)
    {
         $request->validate([
            'picture.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $warehouses_id = VaEssandentReturn::find($request->inventory_id);
        $pictures = [];
        if (isset($request->picture) && $request->hasFile('picture')) {
            foreach ($request->file('picture') as $key => $file) {
                $fileName = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('warehousedataimage'), $fileName);
                $pictures[] = $fileName;
            }
        }

        // Convert the array of filenames to a comma-separated string
        $pictureString = implode(',', $pictures);
        $vendorData = [
            'part' => $request->part,
            'tracking' => $request->tracking,
            'status' => 'Returning',
            'returned_count' => $request->inventory_count,
        ];

        if (!empty($pictureString)) {
            $vendorData['picture'] = $pictureString;
        }

        $vendor = VaEssandentReturn::where('id', $request->inventory_id)->update($vendorData);

         return response()->json(['success' => true, 'message' => __('Warehouse Data Updated Successfully!!')]);

    }

    public function orders_edit(Request $request)
    {
        $request->validate([
            'labels' => 'nullable|mimes:pdf'
        ]);

        $fileName = null;
        if ($request->hasFile('labels')) {
            // Get the uploaded file
            $file = $request->file('labels');

            // Create a unique file name
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Move the file to the specified directory
            $file->move(public_path('warehousedataimage/ordersPdf/'), $fileName);
        }
        VaEssandentOrder::where('id', $request->inventory_id)
        ->update([
            'title'              => $request->title,
            'ship_by_date'  => $request->ship_by_date,
            'ordered_items'    => $request->ordered_items,
        ]);
        if ($fileName!==null) {
            VaEssandentOrder::where('id', $request->inventory_id)
        ->update([
            'label'            => $fileName
            ]);
        }

         return response()->json(['success' => true, 'message' => __('Warehouse Data Updated Successfully!!')]);

    }








     public function ship(Request $request,  $warehouses_id, $warehouse)
    {
         $request->validate([

            'inlabel' => 'mimes:jpg,jpeg,png,pdf,doc,docx',
            'warehousedataimage' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx'
        ]);



          $inlabel = time().'.'.$request->outlabel->extension();

        $request->outlabel->move(public_path('warehousedataimage'), $inlabel);

        // dd($inlabel);
        $vendor = Warehouse::find($warehouse)->update(
        [

            'inlabel'                  => $inlabel,

       ]);


        $warehouses_id = Warehouses::find($warehouses_id);


    if (!auth()->user()->has_perm('warehousealldataaccess') && !auth()->user()->is_admin() && isset($warehouses_id->user_id) && $warehouses_id->user_id != auth()->user()->id ){

          return response()->json(['message'=>'Unable To Proces Request'],500);

      }

      if (!isset($warehouses_id->user_id)){

          return response()->json(['message'=>'Unable To Process Request'],500);

      }



        $vendor = Warehouse::find($warehouse)->update(
        [
            'outMarket_Place'            => $request->outMarket_Place,
            'outOrder_ID'            => $request->outOrder_ID,
            'Shipping_Label'            => $request->Shipping_Label,


       ]);


       if (auth()->user()->is_admin()){
         $vendor = Warehouse::find($warehouse)->update(
        [
            'admin'            => auth()->user()->id,

       ]);
       return response()->json(['success' => true, 'message' => __('Item Ready to Shipped!')]);
       }




        if (!auth()->user()->is_admin()){
         $vendor = Warehouse::find($warehouse)->update(
        [
            'userr'            => auth()->user()->id,

       ]);

       }





   if ($vendor) {
         return response()->json(['success' => true, 'message' => __('Item Shipped!')]);

    //  return response()->json(['message'=>' Successfully Updated'],200);
   } else {
     return response()->json(['message'=>'Unable To Processs Request'],500);
   }
    }





    public function del_image(Request $request){
      $image  =  WarehouseDataImages::find($request->id);
      if (isset($image->id)){
          $image->delete();
      }
    }



    public function del_inlabel(Request $request){
      $image  =  Warehouse::find($request->id);
      if (isset($image->id)){
          $image->update(['inlabel'=>'']);
      }
    }



}
