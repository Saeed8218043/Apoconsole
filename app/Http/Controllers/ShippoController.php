<?php

namespace App\Http\Controllers;

use App\Models\PfWarehouseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ShippoController extends Controller
{

    public function Update_trackShipment(Request $request){
        $orders = PfWarehouseOrder::orderBy('id', 'desc')->get();

        foreach($orders as $order){

            $trackingData = trackShipmentWithCarrierFallback($orders[10]['tracking']);
            if($trackingData!==null && $trackingData['tracking_status']['status']==="DELIVERED"){
                $order->update([
                    'status'=>"Delivered"
                ]);
            }
       }
    }

    public function trackShipment(Request $request)
{
    $trackingNumber = $request->input('tracking_number');

    // Call the API function (using the code from your previous tracking function)
    $trackingData = trackShipmentWithCarrierFallback($trackingNumber);
    if ($trackingData !== null && isset($trackingData['tracking_history'])) {
        $trackingHistory = $trackingData['tracking_history'];

        // Sort the tracking history in descending order by 'status_date'
        usort($trackingHistory, function($a, $b) {
            $dateA = new \DateTime($a['status_date']);
            $dateB = new \DateTime($b['status_date']);

            // For descending order, compare in reverse
            return $dateB <=> $dateA;
        });

        // Prepare the HTML view with sorted tracking history
        $html = view('pages.warehouse_orders.tracking_history', compact('trackingHistory'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html,
            'tracking'=>$trackingNumber,
        ]);
    }else {
        return response()->json([
            'status' => 'error',
            'message' => 'No tracking data available'
        ]);
    }
}

public function label_download(Request $request)
{
    $orders = PfWarehouseOrder::where('label', '')->get();
    if ($orders !== null) {
        foreach ($orders as $order) {
            $trackingData = trackShipmentWithCarrierFallback($order->tracking);

            // Check if $trackingData is not null and contains the 'transaction' key
            if ($trackingData && isset($trackingData['transaction'])) {
                $label_data = $this->getLabel($trackingData['transaction']);
                if ($label_data && isset($label_data['label_url'])) {
                    // Call function to download and save the label (as an image)
                    $labelFileName = $this->downloadAndSaveLabel($label_data['label_url'], $order->id);
                    // If the label is downloaded and saved, update the label column in the database
                    if ($labelFileName) {
                        $order->label = $labelFileName;
                        $order->save();
                    }
                }
            } else {
                // Log or handle cases where trackingData is null or 'transaction' key is missing
                \Log::error("Tracking data or transaction not found for Order ID: {$order->id}");
            }
        }
    }
}


public function downloadAndSaveLabel($labelUrl, $orderId)
{
    // Generate a unique file name using the order ID and current timestamp for the PDF
    $pdfFileName = 'label_' . $orderId.'.png' ;

    // Define the storage path for the PDF label in the /public/warehousedataimage/ directory
    $pdfFilePath = public_path('warehousedataimage/' . $pdfFileName);

    try {
        // Download the label as PDF from the URL
        $labelContent = file_get_contents($labelUrl);
        // Ensure the directory exists
        if (!file_exists(dirname($pdfFilePath))) {
            mkdir(dirname($pdfFilePath), 0755, true);
        }

        // Save the PDF label content to the specified path
        file_put_contents($pdfFilePath, $labelContent);

        // Convert the PDF to an image
        $imageFileName = $this->convertPdfToImage($pdfFilePath, $pdfFileName);

        // If the image is successfully converted, return the image file name
        if ($imageFileName) {
            return $imageFileName;
        }

        // If the image conversion fails, return null
        return null;
    } catch (\Exception $e) {
        // Log any errors that occur during the process
        \Log::error("Failed to download and save label for Order ID: $orderId. Error: " . $e->getMessage());
        return null; // Return null on failure
    }
}


private function convertPdfToImage($pdfPath, $pdfFileName)
{
    // Generate a unique file name for the output PNG file
    $imageFileName = $pdfFileName; // PNG file name

    // Define the full path where the PNG file will be saved
    $imageFilePath = public_path('warehousedataimage/' . $imageFileName);

    try {
        // Initialize ImageMagick object
        $imagick = new \Imagick();

        // Set the resolution for the output image (higher values give better quality)
        $imagick->setResolution(300, 300); // You can adjust the resolution to improve quality

        // Read the PDF file (first page only)
        $imagick->readImage($pdfPath . '[0]');

        // Resample the image to match the desired density
        $imagick->setImageResolution(300, 300);
        $imagick->resampleImage(300, 300, \Imagick::FILTER_LANCZOS, 1);

        // Rotate the image 90 degrees to the right (clockwise)
        $imagick->rotateImage(new \ImagickPixel(), 90);

        // Automatically crop the image to remove empty space around the label
        $imagick->trimImage(0); // Trim using a fuzz factor of 0 (adjust if needed)

        // Optionally, expand the cropped image a bit if trimming is too tight
        $imagick->borderImage(new \ImagickPixel("white"), 10, 10); // Add white border

        // Convert PDF to an image (PNG format)
        $imagick->setImageFormat('png'); // You can change this to 'jpeg' if needed

        // Save the PNG image to the specified path
        $imagick->writeImage($imageFilePath);

        // Clear ImageMagick object after use
        $imagick->clear();
        $imagick->destroy();

        // Return the image file name (so it can be saved in the database)
        return $imageFileName;
    } catch (\Exception $e) {
        // Log any errors that occur during the conversion process
        \Log::error("Failed to convert PDF to image for Order ID: $orderId. Error: " . $e->getMessage());
        return null; // Return null if there is an error
    }
}







function getLabel($TransactionId)
{
    $apiToken = '';

    $carriers = ['UPS', 'FEDEX', 'USPS'];

    foreach ($carriers as $carrier) {
        // Make an API call for each carrier
        $response = Http::withHeaders([
            'Authorization' => 'ShippoToken ' . $apiToken,
        ])->asForm()->get('https://api.goshippo.com/transactions/'.$TransactionId, [
            'carrier' => $carrier,
        ]);

        // Check if the response is successful and contains tracking data
        if ($response->successful()) {
            $trackingData = $response->json();
            // If tracking information is found, return it
            if ($trackingData!==null) {
                return $trackingData;
            }else{
                continue;
            }
        }
    }

    // If no tracking data is found after checking all carriers, return an error message
    return null;
}

}
