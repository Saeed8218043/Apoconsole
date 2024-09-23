<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\User;
use App\Models\Warehouses;
use App\Models\PfWarehouse;
use Illuminate\Support\Facades\Response;
use App\Models\PfWarehouseOrder;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Http;
use App\Models\InventoryOrder;
use App\Models\InventoryAverage;
use App\Models\Inventory;
use App\Models\ReturnApproval;
use App\Models\WarehouseDataImages;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use DataTables;
use Carbon\Carbon;
use TCPDF;
use DB;
use Illuminate\Support\Facades\Session;

class WarehouseController extends Controller
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
     public function pf_warehouse_delete(Request $request){
        // dd($request->all());
        if (isset($request->list) && $request->list != '') {
            $list = explode(',', $request->list);

            // Get warehouse records to delete
            $warehouses = PfWarehouse::whereIn('id', $list)->get();

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
            $warehouses = Inventory::whereIn('id', $list)->get();

            // Delete images and corresponding records
            foreach ($warehouses as $warehouse) {

                $warehouse->delete();
            }
        }
      }

      public function insertcsv(Request $request)
      {
          $filePath = public_path('uploads') . '/pf/' . $request->file_name;
          $extension = pathinfo($filePath, PATHINFO_EXTENSION);

          if (in_array($extension, ['csv'])) {
              $file = fopen($filePath, "r");
              fgetcsv($file); // Skip headers
              $missingParts = [];
              $orders = []; // To store parts grouped by order_id

              // Read file and group data by order_id
              while (!feof($file)) {
                  $data = fgetcsv($file);
                  if ($data) {
                      $orderId = trim($data[$request['order_id']]); // Trim to handle spaces
                      $partNo = $data[$request['part_no']];
                      $qty = $data[$request['qty']];

                      // Check if the part exists in the warehouse
                      $warehouse = Pfwarehouse::where('part', $partNo)
                          ->where('warehouse_name', $request['warehouse_name'])
                          ->first();

                      if ($warehouse) {
                          if (isset($warehouse) && $warehouse->inventory_count > 0) {
                              $warehouse->inventory_count -= $qty;
                              $warehouse->save();
                          }

                          // Group all parts by order_id
                          if (!isset($orders[$orderId])) {
                              $orders[$orderId] = [
                                  'parts' => [],
                                  'ship_by_date' => $data[$request['date']],
                                  'label_price' => $data[$request['label_price']],
                                  'tracking' => $data[$request['tracking']] ?? '',
                                  'warehouse_name' => $warehouse->warehouse_name,
                                  'picture' => $warehouse->picture,
                                  'asin' => $warehouse->asin ?? '',
                                  'total_qty' => 0,
                              ];
                          }

                          // Append part and quantity
                          $orders[$orderId]['parts'][] = "$partNo:$qty";
                          $orders[$orderId]['total_qty'] += $qty;
                      } else {
                          $missingParts[] = $partNo;
                      }
                  }
              }
              fclose($file);

              // Insert a single entry per order_id
              foreach ($orders as $orderId => $orderData) {
                  $partsWithInventory = implode(',', $orderData['parts']); // Combine all parts into one string

                  PfWarehouseOrder::create([
                      'order_id'        => $orderId,
                      'ship_by_date'    => $orderData['ship_by_date'],
                      'label_price'     => $orderData['label_price'],
                      'warehouse_name'  => $orderData['warehouse_name'],
                      'asin'            => $orderData['asin'],
                      'part'            => $partsWithInventory, // All parts combined
                      'picture'         => $orderData['picture'],
                      'tracking'        => $orderData['tracking'],
                      'status'          => "Unshipped",
                      'ordered_items'   => $orders[$orderId]['total_qty'],
                  ]);
              }

              // If there are missing parts, return them
              if (!empty($missingParts)) {
                  return response()->json(['message' => "These parts do not exist in the warehouse: " . implode(', ', $missingParts)], 200);
              }

              return response()->json(['message' => 'Bulk Shipped successful'], 200);
          } elseif (in_array($extension, ['xls', 'xlsx'])) {
              // Handle Excel similarly to CSV
              $spreadsheet = IOFactory::load($filePath);
              $sheet = $spreadsheet->getActiveSheet();

              $firstRow = true;
              $missingParts = [];
              $orders = [];

              foreach ($sheet->getRowIterator() as $row) {
                  if ($firstRow) {
                      $firstRow = false; // Skip headers
                      continue;
                  }

                  $cellIterator = $row->getCellIterator();
                  $cellIterator->setIterateOnlyExistingCells(false);

                  $data = [];
                  foreach ($cellIterator as $cell) {
                      $data[] = $cell->getValue();
                  }

                  if ($data) {
                      $orderId = trim($data[$request['order_id']]); // Trim to handle spaces
                      $partNo = $data[$request['part_no']];
                      $qty = $data[$request['qty']];

                      $warehouse = Pfwarehouse::where('part', $partNo)
                          ->where('warehouse_name', $request['warehouse_name'])
                          ->first();

                      if ($warehouse) {
                          if (isset($warehouse) && $warehouse->inventory_count > 0) {
                              $warehouse->inventory_count -= $qty;
                              $warehouse->save();
                          }

                          if (!isset($orders[$orderId])) {
                              $orders[$orderId] = [
                                  'parts' => [],
                                  'ship_by_date' => $data[$request['date']],
                                  'label_price' => $data[$request['label_price']],
                                  'tracking' => $data[$request['tracking']] ?? '',
                                  'warehouse_name' => $warehouse->warehouse_name,
                                  'picture' => $warehouse->picture,
                                  'asin' => $warehouse->asin ?? '',
                                  'total_qty' => 0,
                              ];
                          }

                          $orders[$orderId]['parts'][] = "$partNo:$qty";
                          $orders[$orderId]['total_qty'] += $qty;
                      } else {
                          $missingParts[] = $partNo;
                      }
                  }
              }

              // Insert a single entry per order_id
              foreach ($orders as $orderId => $orderData) {
                  $partsWithInventory = implode(',', $orderData['parts']); // Combine all parts

                  PfWarehouseOrder::create([
                    'order_id'        => $orderId,
                    'ship_by_date'    => $orderData['ship_by_date'],
                    'label_price'     => $orderData['label_price'],
                    'warehouse_name'  => $orderData['warehouse_name'],
                    'asin'            => $orderData['asin'],
                    'part'            => $partsWithInventory, // All parts combined
                    'picture'         => $orderData['picture'],
                    'tracking'        => $orderData['tracking'],
                    'status'          => "Unshipped",
                    'ordered_items'   => $orders[$orderId]['total_qty'],
                ]);
              }

              if (!empty($missingParts)) {
                  return response()->json(['message' => "These parts do not exist in the warehouse: " . implode(', ', $missingParts)], 200);
              }

              return response()->json(['message' => 'Bulk Shipped successful'], 200);
          } else {
              // Handle unsupported file types
              return response()->json(['message' => 'Unsupported file type'], 400);
          }
      }



      public function return_delete(Request $request){
        // dd($request->all());
        if (isset($request->list) && $request->list != '') {
            $list = explode(',', $request->list);

            // Get warehouse records to delete
            $warehouses = ReturnApproval::whereIn('id', $list)->get();

            // Delete images and corresponding records
            foreach ($warehouses as $warehouse) {

                $warehouse->delete();
            }
        }
      }

      public function warehouse_order_delete(Request $request){

        if (isset($request->list) && $request->list != '') {
            $list = explode(',', $request->list);

            $warehouses = PfWarehouseOrder::whereIn('id', $list)->get();

            // Delete images and corresponding records
            foreach ($warehouses as $warehouse) {
                if($warehouse->status ==="Unshipped"){

                $partQuantityArray = [];
                $parts = explode(',', $warehouse->part);

            // Iterate through each part
            foreach ($parts as $part) {
                // Split part and quantity
                list($partName, $quantity) = explode(':', $part);

                // Trim any leading/trailing whitespace
                $partName = trim($partName);
                $quantity = intval(trim($quantity));

                // Add part and quantity to the array
                $partQuantityArray[$partName] = $quantity;
            }

            // Fetch warehouse items for the parts extracted from the order
            $warehouseItems = PfWarehouse::whereIn('part', array_keys($partQuantityArray))->get();

            // Update quantities in the warehouse based on the order
            foreach ($warehouseItems as $warehouseItem) {
                $partName = $warehouseItem->part;
                $newQuantity = $warehouseItem->inventory_count + $partQuantityArray[$partName];
                // Update the quantity in the warehouse item
                $warehouseItem->update([
                    'inventory_count' => $newQuantity,
                    'status'=>'Stocked in'
            ]);
               }
            }

                $warehouse->delete();
            }
        }
      }

      public function download_labels(Request $request) {
        $pdf = new TCPDF();

        try {
            // Find all orders with status 'Unshipped'
            $orders = PfWarehouseOrder::where('status', 'Unshipped')
                ->where('warehouse_name', $request['warehouse'])
                ->get();

            // Disable header
            $pdf->setPrintHeader(false);

            foreach ($orders as $order) {
                // Load and process the original PNG image
                $imagePath = public_path('warehousedataimage/' . $order['label']);
                $processedImagePath = $this->processImage($imagePath);

                // Initialize variables for pagination and dynamic font sizing
                $maxPartsPerPage =7; // Maximum number of parts per page
                $defaultFontSize = 8;
                $parts = explode(',', $order['part']);
                $totalParts = count($parts);
                $currentPageParts = 0;

                // Add the first page with the label
                $pdf->AddPage('L', 'A4');

                // Set starting position for elements
                $pdf->setXY(0, 0);

                // Calculate positioning of the image (Right side)
                $pageWidth = $pdf->getPageWidth();
                $pageHeight = $pdf->getPageHeight();
                $imageTargetWidth = $pageWidth * 0.45;
                $imageTargetHeight = $pageHeight;

                // Embed the label image on the right side (Only once per order)
                $pdf->Image($processedImagePath, $pageWidth * 0.55, 10, $imageTargetWidth, $imageTargetHeight, '', '', '', false, 300, '', false, false, 0, 'LT', false, false);

                // Add dashed vertical line in the center
                $pdf->SetLineStyle(['width' => 0.5, 'dash' => '5,5']);
                $pdf->Line($pageWidth * 0.5, 0, $pageWidth * 0.5, $pageHeight);

                // Handle dynamic font size adjustment if more than 4 parts
                $pdf->SetFont('helvetica', '', $defaultFontSize);

                // Display the parts on the left side (only parts get paginated if they exceed space)
                $partText = '';
                $yPosition = 10;  // Initial vertical position for the first part
                $partBlockHeight = 24;  // Height allocated for each part (adjust based on content)

                for ($partIndex = 0; $partIndex < $totalParts; $partIndex++) {
                    // Add a new page only if current parts exceed the page limit (but do not repeat the label)
                    if ($currentPageParts >= $maxPartsPerPage) {
                        $pdf->AddPage('L', 'A4');

                        // Reset position for parts on the new page
                        $yPosition = 8;
                        $currentPageParts = 0; // Reset part counter for new page
                    }

                    // Fetch part details for the current part
                    $partData = explode(':', $parts[$partIndex]);
                    if (count($partData) >= 1) {
                        $parttable = PfWarehouse::where('part', $partData[0])
                            ->where('warehouse_name', $request['warehouse'])
                            ->first();

                        if ($parttable) {
                            $title = $parttable->title ?? 'N/A';  // Part title
                            $quantity = isset($partData[1]) ? $partData[1] : 'N/A';  // Quantity

                            // Set image position and width
                            $imageXPosition = 8;  // Left margin for the image
                            $imageWidth = $pageWidth * 0.08;  // Image width (adjustable)
                            $textXPosition = $imageXPosition + $imageWidth + 5;  // Start text to the right of the image

                            // Display the part image
                            if ($parttable->picture) {
                                $partImagePath = public_path('warehousedataimage/' . $parttable->picture);
                                $pdf->Image($partImagePath, $imageXPosition, $yPosition, $imageWidth, $pageHeight * 0.08);
                            }

                            // Display part title, part number, and quantity to the right of the image
                            $pdf->SetXY($textXPosition, $yPosition);  // Set X position for text after the image
                            $pdf->MultiCell($pageWidth * 0.45 - $textXPosition, 10, "$title \nPart: $partData[0] \nQuantity: $quantity", 0, 'L');

                            // Increment the currentPageParts and update yPosition for the next part
                            $currentPageParts++;
                            $yPosition += $partBlockHeight;  // Move down for the next part
                        }
                    }
                }

                // Warehouse-specific logic (update status)
                $warehouseMapping = [
                    "syedali@autooutletllc.com" => ["Pfwarehouse", "Essandent_AO"],
                    "wakel@app.apoconsole.com" => ["FL"],
                    "Dr.akram@ech.com" => ["PA_warehouse"]
                ];

                // Get the authenticated user's email
                $userEmail = auth()->user()->email;

                // Check if the user's email is in the mapping array and if the requested warehouse is in the list
                if (isset($warehouseMapping[$userEmail]) && in_array($request['warehouse'], $warehouseMapping[$userEmail])) {
                    PfWarehouseOrder::where('id', $order['id'])->update([
                        'status' => "Label Downloaded"
                    ]);
                }
            }

        } catch (\Exception $e) {
            \Log::error('Error processing image: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // Close and output PDF
        $pdfContent = $pdf->Output('modified_images.pdf', 'S');

        // Return the PDF file as a download response
        return response()->streamDownload(
            function () use ($pdfContent) {
                echo $pdfContent;
            },
            'modified_images.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }




    private function processImage($imagePath) {
        $outputPath = public_path('warehousedataimage/processed_' . basename($imagePath));

        // Use ImageMagick to convert the image to grayscale and remove ICC profiles
        $command = "convert {$imagePath} -strip -colorspace Gray {$outputPath}";
        exec($command);

        return $outputPath;
    }




            public function get_parts_data(Request $request){
                $ids = explode(',',$request->ids);
                $inventory =PfWarehouse::find($ids);
                return response()->json($inventory);
            }

            public function inventory_bulk_ship(Request $request){
                $order = PfwarehouseOrder::where('tracking',$request->tracking)->where('warehouse_name',$request->warehouse_name)->first();
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
                        $warehouse = PfWarehouse::where('part',$part)->where('warehouse_name',$request->warehouse_name)->first();
                        $picture[] = isset($warehouse)?$warehouse->picture:'';
                        if ($warehouse && $request->inventory[$key] <= $warehouse->inventory_count && $warehouse->inventory_count>0) {
                            // If inventory count is sufficient, proceed with creating PfWarehouseOrder
                            $mergedData[] = $part . ': ' . $request->inventory[$key];
                            $warehouse->update([
                                'inventory_count'=>$warehouse->inventory_count - $request->inventory[$key]
                            ]);
                        } else {
                            $title = 'Success'; // Define your title here
                            $message = 'Insufficient inventory count for part: ' . $part; // Define your message here

                            Session::flash('title', $title);
                            Session::flash('error', $message);

                            return redirect()->back();
                            // If inventory count is insufficient, return an error response
                            // return response()->json(['message' => 'Insufficient inventory count for part: ' . $part]);
                        }
                    }
                }
                $picture = implode(',',$picture);
                $totalOrderedItems = array_sum($request->inventory);
                // Join the merged data array with a comma to create the final string
                $PartsWithInventory = implode(',', $mergedData);
                $label = '';
                if ($request->hasFile('label')) {
                    $labelFile = $request->file('label')[0];
                    $labelFileName = time() . '.' . $labelFile->getClientOriginalExtension();
                    $labelFile->move(public_path('warehousedataimage'), $labelFileName);
                    $label = $labelFileName;
                }
                $vendor = PfWarehouseOrder::create(
                    [
                        'order_id'            => $request->order_id,
                        'ship_by_date'            => $request->ship_by_date,
                        'label_price'            => $request->label_price,
                        'warehouse_name'            => $request->warehouse_name,
                        'label'            => $label,
                        'asin'            => $request->asin??'',
                        'part'            => $PartsWithInventory,
                        'picture'            => $picture,
                        'tracking'            => $request->tracking,
                        'status'            => "Unshipped",
                        'ordered_items' => $totalOrderedItems,

                   ]);


                $title = 'Success'; // Define your title here
                $message = 'Warehouse inventory label created Successfully'; // Define your message here

                Session::flash('title', $title);
                Session::flash('success', $message);

                   return redirect()->back();

            }


     public function datatableapi(Request $request,$warehouse)
      {

        //$model = Orders::query();


        $warehouse =  Warehouses::find($warehouse);


// Default query setup
$model = Warehouse::orderByRaw('inlabel IS NULL, inlabel = "", id DESC');

// Conditional logic based on permissions and request parameters
if (!auth()->user()->has_perm('warehousealldataaccess') && isset($warehouse->user_id) && $warehouse->user_id != auth()->user()->id) {
    $model = Warehouse::where('user_id', 'no')->orderByRaw('inlabel IS NULL, inlabel = "", id DESC');
}

if (!isset($warehouse->user_id)) {
    $model = Warehouse::where('user_id', 'no')->orderByRaw('inlabel IS NULL, inlabel = "", id DESC');
}

$model = Warehouse::where('warehouse_id', $warehouse->id)->orderByRaw('inlabel IS NULL, inlabel = "", id DESC');

if (isset($request->status) && $request->status != '') {
    if ($request->status == 1) {
        $model = Warehouse::orderByRaw('inlabel IS NULL, inlabel = "", id DESC')
                          ->where('warehouse_id', $warehouse->id)
                          ->whereNull('admin')
                          ->has('warehouse');
    }
    if ($request->status == 2) {
        $model = Warehouse::orderByRaw('inlabel IS NULL, inlabel = "", id DESC')
                          ->where('warehouse_id', $warehouse->id)
                          ->whereNotNull('admin')
                          ->whereNull('userr')
                          ->has('warehouse');
    }
    if ($request->status == 3) {
        $model = Warehouse::orderByRaw('inlabel IS NULL, inlabel = "", id DESC')
                          ->where('warehouse_id', $warehouse->id)
                          ->whereNotNull('admin')
                          ->whereNotNull('userr')
                          ->has('warehouse');
    }
}

if (isset($request->all) && auth()->user()->is_admin()) {
    $model = Warehouse::orderByRaw('inlabel IS NULL, inlabel = "", id DESC')->has('warehouse');

    if (isset($request->status) && $request->status != '') {
        if ($request->status == 1) {
            $model = Warehouse::orderByRaw('inlabel IS NULL, inlabel = "", id DESC')
                              ->whereNull('admin')
                              ->has('warehouse');
        }
        if ($request->status == 2) {
            $model = Warehouse::orderByRaw('inlabel IS NULL, inlabel = "", id DESC')
                              ->whereNotNull('admin')
                              ->whereNull('userr')
                              ->has('warehouse');
        }
        if ($request->status == 3) {
            $model = Warehouse::orderByRaw('inlabel IS NULL, inlabel = "", id DESC')
                              ->whereNotNull('admin')
                              ->whereNotNull('userr')
                              ->has('warehouse');
        }
    }
}



        // $model = $model->pluck('orders');
        // dd($model);





        // if (isset($request->email_verify) && $request->email_verify != '') {
        //   if ($request->email_verify == 'Verifyed') {
        //     $model->whereNotNull('email_verified_at');
        //   } else {
        //     $model->whereNull('email_verified_at');
        //   }
        // }


        $model = $model->orderBy('id','desc')->get();

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

              return $row->status;
          })





          ->addColumn('checkbox',  function ($row) {
            return '<div class="form-check form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
      </div>';
          })

          ->addColumn('user', function($row)  {
          if ($row->user != null){
              return $row->user->email;
          }
        })





          ->addColumn('label', function($row)  {
         if ($row->inlabel != NULL){
            return '<button class="btn-sm btn-primary download_label_button" row_id="'.$row->id.'" data-href-url="'.asset('public/warehousedataimage').'/'.$row->inlabel.'" data-download="'.$row->inlabel.'">Download</button>';
         }
        })


        ->addColumn('warehouse', function($row)  {
         if ($row->warehouse != null){
             return $row->warehouse->name;
         }


        })

         ->addColumn('user_id', function($row)  {
          if ($row->user != null){
              return $row->user->id;
          }
        })


        ->addColumn('images', function($row)  {
         $res = [];
         foreach ($row->images as $image){
            array_push($res,['id' => $image->id, 'images'=> $image->image]);
         }
         return $res;
        })



            ->addColumn('total', function($row)  {
          return view('pages.warehouse.action',['row'=>$row]);
        })

          ->addColumn('action', function($row)  {
          return view('pages.warehouse.action',['row'=>$row]);
        })

          ->rawColumns(['checkbox','total', 'action','status','label'])
          ->make(true);



      }

      public function pf_datatableapi(Request $request)
      {
        $model = PfWarehouse::query();
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
        $data = $model->where('warehouse_name', $warehouse_name)
        ->orderBy('Inventory_count', 'desc')
        ->get();
        $allOrders = PfWarehouseOrder::select('part')
        ->where('warehouse_name', $warehouse_name)
        ->get();

    $partQuantities = [];

    foreach ($allOrders as $order) {
        $parts = explode(',', $order->part);
        foreach ($parts as $partQty) {
            // Check if the part has a quantity specified
            if (strpos($partQty, ':') !== false) {
                list($part, $qty) = explode(':', $partQty);
                $part = trim($part);
                $qty = intval(trim($qty));
            } else {
                $part = trim($partQty);
                $qty = 1; // Default quantity is 1 if not specified
            }

            if (!isset($partQuantities[$part])) {
                $partQuantities[$part] = 0;
            }

            $partQuantities[$part] += $qty;
        }
    }

    // Convert to desired format
    $allOrdersFormatted = [];
    foreach ($partQuantities as $part => $totalQty) {
        $allOrdersFormatted[] = (object) [
            'part' => $part,
            'total_qty' => $totalQty
        ];
    }

    // Fetch monthly orders
    $thirtyDaysAgo = Carbon::now()->subDays(31);

    $monthlyOrders = PfWarehouseOrder::select('part')
        ->where('created_at', '>', $thirtyDaysAgo)
        ->where('warehouse_name', $warehouse_name)
        ->get();

    $partQuantities = [];

    foreach ($monthlyOrders as $order) {
        $parts = explode(',', $order->part);
        foreach ($parts as $partQty) {
            // Check if the part has a quantity specified
            if (strpos($partQty, ':') !== false) {
                list($part, $qty) = explode(':', $partQty);
                $part = trim($part);
                $qty = intval(trim($qty));
            } else {
                $part = trim($partQty);
                $qty = 1; // Default quantity is 1 if not specified
            }

            if (!isset($partQuantities[$part])) {
                $partQuantities[$part] = 0;
            }

            $partQuantities[$part] += $qty;
        }
    }

    // Convert to desired format
    $monthlyOrdersFormatted = [];
    foreach ($partQuantities as $part => $totalQty) {
        $monthlyOrdersFormatted[] = (object) [
            'part' => $part,
            'total_qty' => $totalQty
        ];
    }

    $allOrdersCollection = collect($allOrdersFormatted);
    $monthlyOrdersCollection = collect($monthlyOrdersFormatted);




            $monthlyOrders = PfWarehouseOrder::select(
                DB::raw('SUBSTRING_INDEX(part, ":", 1) as part'),
                DB::raw('SUM(ordered_items) as total_qty')
            )
            ->where('warehouse_name', $warehouse_name)
            ->where('created_at', '>', $thirtyDaysAgo)
            ->groupBy(DB::raw('SUBSTRING_INDEX(part, ":", 1)'))
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

        ->addColumn('monthly_order', function ($row) use ($monthlyOrdersCollection) {
            $monthlyOrder = $monthlyOrdersCollection->firstWhere('part', $row->part);
            return $monthlyOrder ? $monthlyOrder->total_qty : 0;
        })
        ->addColumn('all_orders', function ($row) use ($allOrdersCollection) {
            $allOrder = $allOrdersCollection->firstWhere('part', $row->part);
            return $allOrder ? $allOrder->total_qty : 0;
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
                PfWarehouse::where('id', $row->id)
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
          return view('pages.warehouse.pf_warehouse_action',['row'=>$row]);
        })

          ->rawColumns(['checkbox','total', 'action','status','label'])
          ->make(true);



      }

 public function inventory_datatableapi(Request $request)
      {

         $model = Inventory::orderBy('id','desc');
         if (isset($request->status) && $request->status != ''){
            if ($request->status == 1){
                $model = Inventory::where('status','Shipped');
            }
            if ($request->status == 2){
                $model = Inventory::where('status','Delivered');
            }
            if ($request->status == 3){
                $model = Inventory::where('status','Missing parts');
            }


        }
         $model = $model->orderBy('id','desc')->where('warehouse_name',$request->name)->get();
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
          return view('pages.warehouse_new_inventory.action',['row'=>$row]);
        })

          ->rawColumns(['checkbox','total', 'action','status','label'])
          ->make(true);



      }


      public function warehouse_orders(Request $request)
      {
         $model = PfWarehouseOrder::orderBy('id','desc');
         if (isset($request->status) && $request->status != ''){
               if ($request->status == 5){
             $model = PfWarehouseOrder::where('status','Label Downloaded');
            }
             if ($request->status == 6){
             $model = PfWarehouseOrder::where('status','Out of Stock');
            }
            if ($request->status == 1){
             $model = PfWarehouseOrder::where('status','Unshipped');
            }
            if ($request->status == 2){
             $model = PfWarehouseOrder::where('status','Shipped');
            }
            if ($request->status == 3){
              $model = PfWarehouseOrder::where('status','Delivery Stuck');
            }
            if ($request->status == 4){
              $model = PfWarehouseOrder::where('status','Delivered');
            }
        }
        if ($request->start_date && $request->end_date) {
            $startDate = $request->start_date . ' 00:00:00';
            $endDate = $request->end_date . ' 23:59:59';

            $model = $model->whereBetween('created_at', [$startDate, $endDate]);
          }

            $model = $model->orderBy('id','desc')->where('warehouse_name',$request->name)->get();
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
                if ($row->status === "Unshipped" || $row->status === "Delivery Stuck") {
                    return '<span style="border: solid 0px;" data-tracking="'.$row->tracking.'" data-toggle="modal" data-target="#trackingModal" class="badge badge-danger track-shipment">'.$row->status.'</span>';
                } elseif ($row->status === "Shipped" || $row->status === "Delivered" ) {
                    return '<span style="border: solid 0px;" data-tracking="'.$row->tracking.'" data-toggle="modal" data-target="#trackingModal" class="badge badge-success track-shipment">'.$row->status.'</span>';
                }  elseif ($row->status === "Label Downloaded") {
                    return '<span style="border: solid 0px;" data-tracking="'.$row->tracking.'" data-toggle="modal" data-target="#trackingModal" class="badge badge-warning track-shipment">'.$row->status.'</span>';
                }  elseif ($row->status === "Out of Stock") {
                    return '<span style="border: solid 0px;" data-tracking="'.$row->tracking.'" data-toggle="modal" data-target="#trackingModal" class="badge badge-dark track-shipment">'.$row->status.'</span>';
                } else {
                    return $row->status;
                }
            })






            ->addColumn('checkbox',  function ($row) {
                return '<div class="form-check form-check-sm form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
        </div>';
            })

          ->addColumn('Part', function($row) {
            if ($row->part != null) {
                return $row->part;
            }
        })



        ->addColumn('Picture', function($row) {
            $imagePath = asset('warehousedataimage/' . $row->picture);
            return $imagePath;
        })

        ->addColumn('label', function($row) {
            if ($row->label === '') {
                return ['message' => "Label is required", 'imagePath' => null];
            }
            $imagePath = asset('warehousedataimage/' . $row->label);
            return $imagePath;
        })


        ->addColumn('ship_by_date', function($row)  {
         if ($row->ship_by_date != null){
             return $row->ship_by_date;
         }


        })

         ->addColumn('label_price', function($row)  {
              return $row->label_price >0?$row->label_price:'';
        })
         ->addColumn('ASINItem_ID', function($row)  {
              return $row->asin;
        })
         ->addColumn('order_id', function($row)  {
              return $row->order_id;
        })


        ->addColumn('Tracking', function($row)  {

         return $row->tracking;
        })
        ->addColumn('orders', function($row)  {

         return $row->ordered_items;
        })

          ->addColumn('action', function($row)  {
          return view('pages.warehouse_orders.action',['row'=>$row]);
        })

          ->rawColumns(['checkbox','total', 'action','status','label'])
          ->make(true);



      }

      public function returns(Request $request)
      {
         $model = ReturnApproval::orderBy('id','desc');
         if (isset($request->status) && $request->status != ''){
               if ($request->status == 0){
                $model = ReturnApproval::where('status','Returned');
                }
            if ($request->status == 1){
             $model = ReturnApproval::where('status','Returning');
            }
            if ($request->status == 2){
             $model = ReturnApproval::where('part_status','LIKE','%Damage part%');
            }
            if ($request->status == 3){
              $model = ReturnApproval::where('part_status','LIKE','%Missing part%');
            }
            if($request->status==4){

                $model = ReturnApproval::where('part_status','Pending');
            }

        }
            $model = $model->orderBy('id','desc')->where('warehouse_name',$request->name)->get();
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
                if ($row->status === "Returning" || $row->status === "Delivery Stuck") {
                    return '<span style="border: solid 0px;" data-tracking="'.$row->tracking.'" data-toggle="modal" data-target="#trackingModal" class="badge badge-danger track-shipment">'.$row->status.'</span>';
                } elseif ($row->status === "Returned" ) {
                    return '<span style="border: solid 0px;" data-tracking="'.$row->tracking.'" data-toggle="modal" data-target="#trackingModal" class="badge badge-success track-shipment">'.$row->status.'</span>';
                } else {
                    return $row->status;
                }
            })


            ->addColumn('checkbox',  function ($row) {
                return '<div class="form-check form-check-sm form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
        </div>';
            })

          ->addColumn('Part', function($row) {
            if ($row->part != null) {
                return $row->part;
            }
        })



        ->addColumn('Picture', function($row) {
            $imagePath = asset('warehousedataimage/' . $row->picture);
            return $imagePath;
        })



         ->addColumn('order_id', function($row)  {
              return $row->order_id;
        })

         ->addColumn('return_date', function($row)  {
            return $row->created_at->format('Y-m-d');

        })


        ->addColumn('part_status', function($row)  {

         return $row->part_status;
        })
        ->addColumn('Tracking', function($row)  {

         return $row->tracking;
        })
        ->addColumn('orders', function($row)  {

         return $row->ordered_items;
        })
        ->addColumn('purchase_price', function($row)  {
            return $row->purchase_price;
      })  ->addColumn('reason', function($row)  {
            return $row->reason;
      })
          ->addColumn('action', function($row)  {
          return view('pages.warehouse_returns.action',['row'=>$row]);
        })

          ->rawColumns(['checkbox','total', 'action','status','label'])
          ->make(true);

      }

      public function index($warehouseId)
      {
          // Find the warehouse by ID
          $warehouse = Warehouses::find($warehouseId);

          // If warehouse is not found, redirect back with an error message
          if (!$warehouse) {
              return redirect()->back()->with(['error' => 'Warehouse not found']);
          }

          // Check if the authenticated user has permission to access the warehouse
          $userHasAccess = auth()->user()->has_perm('warehousealldataaccess') || auth()->user()->is_admin();
          $userIds = explode(',', $warehouse->user_id);

          // Check if the user ID matches any of the warehouse's user IDs
          if ($userHasAccess || in_array(auth()->user()->id, $userIds)) {
              // Get all users
              $users = User::get();

              // Pass the data to the view
              return view('pages.warehouse.main', [
                  'users' => $users,
                  'warehouse' => $warehouse,
                  'warehouse_name' => $warehouse->name
              ]);
          } else {
              return redirect()->back()->with(['error' => "You do not have permission to access this warehouse"]);
          }
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

      public function Pfwarehouse(Request $request){
            $inventory ='';
            $warehouse_name =$request->segment(1);
            $statusCounts = PfWarehouse::select('status', DB::raw('count(*) as count'))->where('warehouse_name',"$warehouse_name")->groupBy('status')->get();
            $price = PfWarehouse::select(DB::raw('SUM(price) as total_price'))->where('warehouse_name',"$warehouse_name")->first();
          return view('pages.warehouse.pf_warehouse',['users'=>$inventory,'net_price'=>$price->total_price,'statusCounts'=>$statusCounts,'warehouse'=>'pf_warehouse','warehouse_name'=>"$warehouse_name"]);
    }
      public function returns_index(Request $request){
          $users = ReturnApproval::get();
          $warehouse_name = $request->segment(3);
          return view('pages.warehouse_returns.main',['users'=>$users,'warehouse'=>'pf_warehouse','warehouse_name'=>"$warehouse_name"]);

    }
      public function inventory(Request $request){
          $warehouse_name = $request->segment(3);
          $users = Inventory::get();
          $needToApprove = Inventory::where('status','Delivered')->where('warehouse_name',$warehouse_name)->count();
          $intransit = Inventory::where('status','Shipped')->where('warehouse_name',$warehouse_name)->count();

          return view('pages.warehouse_new_inventory.main',['users'=>$users,'warehouse'=>'pf_warehouse','warehouse_name'=>"$warehouse_name",'needToApprove'=>$needToApprove,'intransit'=>$intransit]);

    }

      public function Pfwarehouse_orders(Request $request){

             $users = PfWarehouseOrder::get();
             $warehouse_name = $request->segment(3);
             Http::get(url('/label_shippo_download'));
             $UnshippedOrders = PfWarehouseOrder::where('status', 'Unshipped')->where('warehouse_name',$warehouse_name)->get();
            return view('pages.warehouse_orders.main',['users'=>$users,'orders'=>count($UnshippedOrders),'warehouse'=>'pf_warehouse','warehouse_name'=>$warehouse_name]);

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

        $vendor = PfWarehouse::create(
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
        // $pf = PfWarehouse::where('part', $request->part)->first();
        // $inventory = Inventory::where('part', $request->part)->first();

        // if ($pf !== null || $inventory !== null) {
        //     $warehouseName = $pf !== null ? $pf->warehouse_name : $inventory->warehouse_name;
        //     return response()->json(['message' => "Duplicate entry for part. This part already exists in " . $warehouseName], 409);
        // }

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

            $vendor = Inventory::create([
                'order_id'            => $request->order_id??'',
                'asin'            => $request->asin??'',
                'part'            => $request->part,
                'price_per_unit'  => $request->price_per_unit,
                'warehouse_name'  => $request->warehouse_name,
                'picture'         => $pictureString,
                'title'           => $request->title,
                'tracking'        => $request->tracking,
                'expected_delivery'        => $request->expected_delivery,
                'status'          => $request->status,
                'inventory_count' => $request->inventory_count,
            ]);

            return response()->json(['message'=>'Warehouse Inventory Approval Successfully created'],200);

    }

    public function inventory_approve(Request $request){
        $inventory = Inventory::where('id', $request->inventory_id)->where('warehouse_name',$request->warehouse_name)->first();
        $pf = Pfwarehouse::where('part', $request->part)->where('warehouse_name',$request->warehouse_name)->first();
        // Retrieve the inventory approval details
        $inventory_approval = InventoryAverage::where('part_number', $request->part)->where('warehouse_name',$request->warehouse_name)->first();

        // Calculate the total price for the current inventory count
        $total = ($inventory->price_per_unit ?? 0) * $request->inventory_count;

        // Calculate the updated price, quantity, and total price
        $price = ($inventory_approval->price_per_unit ?? 0) + ($inventory->price_per_unit ?? 0);
        $qty = $request->inventory_count;

        // Update or create the inventory average record
        InventoryAverage::create(
                [
                'part_number' => $inventory->part,
                'warehouse_name'=>$request->warehouse_name,
                'price' => $inventory->price_per_unit,
                'qty' => $qty,
                'total_price' => $total,
                ]);

                $inventory_sums = InventoryAverage::where('part_number', $request->part)->where('warehouse_name',$request->warehouse_name)
                ->selectRaw('CAST(SUM(qty) AS UNSIGNED) as total_qty, SUM(total_price) as total_price')
                ->first();

               $average = $inventory_sums->total_price/$inventory_sums->total_qty;
               $average = round($average, 2);

        $qty='';
        $vendor ='';
        $status ='';
        if(isset($inventory) && $request->inventory_count > $inventory->inventory_count){
            return response()->json(['message'=>'You entered the wrong inventory'],500);
        }

        if(isset($inventory) &&$request->inventory_count < $inventory->inventory_count){
            $qty = $inventory->inventory_count - $request->inventory_count;
            Inventory::where('id', $request->inventory_id)->update([
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
                Pfwarehouse::updateOrCreate(
                    ['part' => $inventory->part,
                     'warehouse_name' => $request->warehouse_name,
                    ],
                    [
                        'asin' => $request->asin??'',
                        'picture' => $inventory->picture,
                        'price_per_unit' => $inventory->price_per_unit??0,
                        'warehouse_name' => $request->warehouse_name,
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
            Pfwarehouse::updateOrCreate(
                ['part' => $inventory->part,
                 'warehouse_name' => $request->warehouse_name,
                ],
                [
                    'asin' => $request->asin??"",
                    'picture' => $inventory->picture,
                    'title' => $inventory->title,
                    'average' => $average,
                    'price_per_unit' => $inventory->price_per_unit??0,
                    'tracking' => $inventory->tracking,
                    'warehouse_name' => $request->warehouse_name,
                    'status' => $status,
                    'inventory_count' => $qty,
                ]
            );
               $inventory->delete();
        }
            return response()->json(['message'=>'Warehouse Inventory Approved Successfully'],200);

    }



    public function return_approve(Request $request){
        $return = ReturnApproval::where('id', $request->id)->first();
        $parts = []; // Array to store parts
        $statuses = []; // Array to store statuses

        foreach($request->part as $key => $part){
            $inventory_count = $request->inventory_count[$key]; // Get inventory count using the key
            $status = $request->status[$key]; // Get status using the key

            $inventory = Pfwarehouse::where('part', $part)->where('warehouse_name',$request->warehouse_name)->first();
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
                //     ReturnApproval::where('id', $request->id)->delete(); // Delete the return if there are no remaining approved parts
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
        $order = ReturnApproval::where('tracking',$request->tracking)->first();
        if($order !=null){
            return response()->json(['message'=>'Tracking is already exist in '.$order->warehouse_name.' warehouse'],500);
        }

        $inventory = Pfwarehouse::where('id',$request->row_id)->first();
            ReturnApproval::create(
                [
                        'part' => $inventory->part.': '.$request->inventory,
                        'order_id' => $request->order_id??'',
                        'picture' => $inventory->picture,
                        'warehouse_name' => $request->warehouse_name,
                        'tracking' => $request->tracking,
                        'status' => "Returning",
                        'returned_count' => $request->inventory,
                        'reason' => $request->reason,
                        'purchase_price' => $request->purchase_price,
                    ]
                );
            return response()->json(['message'=>'Warehouse Return opened Successfully'],200);

    }

    public function reOrder(Request $request){
        $inventory = Pfwarehouse::where('id',$request->row_id)->first();

            Inventory::create(
                [
                    'part' => $inventory->part,
                    'asin' => $inventory->asin ?? '',
                    'order_id' => $request->order_id,
                    'picture' => $inventory->picture,
                    'title' => $inventory->title,
                    'warehouse_name' => $request->warehouse_name,
                    'tracking' => $request->tracking,
                    'status' => "Shipped",
                    'inventory_count' => $request->inventory
                ]
            );
            return response()->json(['message'=>'Warehouse parts re-ordered Successfully'],200);
    }

    public function open_bulk_return(Request $request){
        $order = ReturnApproval::where('tracking',$request->tracking)->first();
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
                $warehouse = PfWarehouse::where('part',$part)->where('warehouse_name',$request->warehouse_name)->first();
                // Check if the inventory count is sufficient
                $picture[] = isset($warehouse)?$warehouse->picture:'';
                    $mergedData[] = $part . ': ' . $request->inventory[$key];
            }
        }
        $parts = implode(',',$mergedData);
        $inventories = Pfwarehouse::whereIn('id', $request->row_id)->get();
        $pictures = $inventories->pluck('picture')->implode(',');
        $totalOrderedItems = array_sum($request->inventory);
           ReturnApproval::create(
            [
                    'part' => $parts,
                    'order_id' => $request->order_id??'',
                    'picture' => $pictures,
                    'warehouse_name' => $request->warehouse_name,
                    'tracking' => $request->tracking,
                    'status' => "Returning",
                    'returned_count' => $totalOrderedItems,
                    'reason' => $request->reason,
                    'purchase_price' => $request->purchase_price,
                ]
            );

        $title = 'Success'; // Define your title here
        $message = 'Warehouse inventory label created Successfully'; // Define your message here

        Session::flash('title', $title);
        Session::flash('success', $message);

           return redirect()->back();

    }

    public function warehouse_order_store(Request $request)
    {
        $order = PfwarehouseOrder::where('tracking',$request->tracking)->first();
        if($order !=null){
            return response()->json(['message'=>'Tracking is already exist in order inventory'],500);
        }
            $request->validate([
                'label.*' => 'required|mimes:jpg,jpeg,png',
                'inventory' => 'required|numeric|min:1',
            ]);
                $warehouse = Pfwarehouse::where('part',$request->part)->where('warehouse_name',$request->warehouse_name)->first();
                $qty='';
                if (isset($warehouse) && $warehouse->inventory_count>0) {
                 $qty = $warehouse->inventory_count - $request->inventory;
                 if($qty<0){
                 return response()->json(['message'=>'Entered the invalid inventory'],500);
                 }
                    $mergedData =[];
                    if ($warehouse && $request->inventory <= $warehouse->inventory_count && $warehouse->inventory_count>0) {
                        // If inventory count is sufficient, proceed with creating PfWarehouseOrder
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

    $vendor = PfWarehouseOrder::create(
        [
            'order_id'            => $request->order_id,
            'ship_by_date'            => $request->ship_by_date,
            'label_price'            => $request->label_price??0,
            'warehouse_name' => $request->warehouse_name,
            'label'            => $label,
            'asin'            => $request->asin??'',
            'part'            => $PartsWithInventory,
            'picture'            => $picture,
            'tracking'            => $request->tracking??'',
            'status'            => "Unshipped",
            'ordered_items' => $request->inventory,

       ]);
       InventoryOrder::create([
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

    public function pf_warehouse_edit(Request $request)
    {
        $total = ($request->price ?? 0) * $request->inventory_count;
        $qty = $request->inventory_count;
        if($qty>0 && $request->price>0){

            InventoryAverage::create(
                    [
                    'part_number' => $request->part,
                    'price' => $request->price,
                    'warehouse_name'=>$request->warehouse_name,
                    'qty' => $qty,
                    'total_price' => $total,
                    ]);
        }

                $inventory_sums = InventoryAverage::where('part_number', $request->part)->where('warehouse_name',$request->warehouse_name)
                ->selectRaw('CAST(SUM(qty) AS UNSIGNED) as total_qty, SUM(total_price) as total_price')
                ->first();
                $warehouse = PfWarehouse::find($request->inventory_id);
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

        $vendor = PfWarehouse::where('id', $request->inventory_id)->update($vendorData);




         return response()->json(['success' => true, 'message' => __('Warehouse Data Updated Successfully!!')]);

    }
    public function inventory_edit(Request $request)
    {
         $request->validate([
            'picture.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $price = $request->price * $request->inventory_count;
        $formattedPrice = number_format($price, 2);

        $warehouses_id = Inventory::find($request->inventory_id);
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

            $vendor = Inventory::where('id', $request->inventory_id)->update($vendorData);

         return response()->json(['success' => true, 'message' => __('Warehouse Data Updated Successfully!!')]);

    }

        public function return_edit(Request $request)
    {
         $request->validate([
            'picture.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $warehouses_id = ReturnApproval::find($request->inventory_id);
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

        $vendor = ReturnApproval::where('id', $request->inventory_id)->update($vendorData);

         return response()->json(['success' => true, 'message' => __('Warehouse Data Updated Successfully!!')]);

    }

    public function warehouse_edit(Request $request)
    {
        $request->validate([
            'label.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);
        $label = [];
        if (isset($request->label) && $request->hasFile('label')) {
            foreach ($request->file('label') as $key => $file) {
                $fileName = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('warehousedataimage'), $fileName);
                $label[] = $fileName;
            }
        }
        PfWarehouseOrder::where('id', $request->inventory_id)
        ->update([
            'order_id'            => $request->order_id,
            'ship_by_date'            => $request->ship_by_date,
            'label_price'            => $request->label_price,
            'asin'            => $request->asin??'',
            'part'            => $request->part,
            'tracking'            => $request->tracking,
            'status'            => $request->status,
        ]);
        if (count($label)>0) {
            PfWarehouseOrder::where('id', $request->inventory_id)
        ->update([
            'label'            => $label[0]
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
