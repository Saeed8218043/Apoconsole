<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Writer;
use App\Models\VendorPercentage; // Adjust namespace as per your application's structure

class CsvController extends Controller
{
    public function updateCsvWithSalePrice()
    {
        // Set maximum execution time to 5 minutes (300 seconds)
        ini_set('max_execution_time', 300);

        // Directory where the CSV files are located
        $directory = '/home/apoconsole/app.apoconsole.com/cron/trq_inventory/';

        // Get the latest CSV file in the directory
        $latestCsvFile = $this->getLatestCsvFile($directory);

        if (!$latestCsvFile) {
            abort(500, 'No CSV file found in the directory');
        }

        // Process the fetched CSV file
        return $this->processCsvFile($latestCsvFile);
    }

    private function getLatestCsvFile($directory)
    {
        // Get all files in the directory
        $files = scandir($directory);

        // Filter CSV files
        $csvFiles = array_filter($files, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'csv';
        });

        // Sort CSV files by last modified time (descending order)
        usort($csvFiles, function ($a, $b) use ($directory) {
            return filemtime($directory . $b) - filemtime($directory . $a);
        });

        // Get the first (latest) CSV file
        $latestCsvFile = reset($csvFiles);

        if (!$latestCsvFile) {
            return null;
        }

        return $directory . $latestCsvFile;
    }

    private function processCsvFile($csvFilePath)
    {
        $newCsvFilePath = storage_path('app/newfile.csv'); // Path to the new CSV file
        $batchSize = 1000; // Number of rows to process at a time

        // Fetch vendor percentage for 'trq'
        $vp = VendorPercentage::where('vendor', 'trq')->first();
        $percentage = $vp ? (100 - $vp->percentage) / 100 : 0;

        $reader = Reader::createFromPath($csvFilePath, 'r');
        $reader->setHeaderOffset(0); // Assuming the first row is the header

        $headers = $reader->getHeader();
        $headers[] = 'Sale Price';

        $writer = Writer::createFromPath($newCsvFilePath, 'w+');
        $writer->insertOne($headers);

        $records = $reader->getRecords();
        $batch = [];

        foreach ($records as $index => $row) {
            $price = (float)$row['Price'];
            $mapPrice = isset($row['map_price']) ? (float)$row['map_price'] : 0;
            $salePrice = $price; // Default sale price is the original price

            if (empty($mapPrice) || $mapPrice < $price / $percentage) {
                $salePrice = $price / $percentage; // Adjusted sale price using percentage
            } else {
                $salePrice = $mapPrice; // Use the map price
            }

            $row['Sale Price'] = number_format($salePrice, 2); // Add the sale price to the row
            $batch[] = $row;

            // If batch size is reached, write to the file and reset the batch
            if (count($batch) >= $batchSize) {
                $this->writeBatchToCsv($writer, $batch);
                $batch = [];
            }
        }

        // Write any remaining records
        if (count($batch) > 0) {
            $this->writeBatchToCsv($writer, $batch);
        }

        return response()->download($newCsvFilePath);
    }

    private function writeBatchToCsv(Writer $writer, array $batch)
    {
        foreach ($batch as $row) {
            $writer->insertOne($row);
        }
    }


    public function updateCsvPercentage(Request $request){
        VendorPercentage::updateOrCreate(
            ['vendor' => $request->warehouse_name],
            [
                'walmart_percentage' => $request->walmart_percentage,
                'pf_percentage' => $request->pf_percentage,
                'zero_qty' => $request->zero_qty,
                'percentage' => $request->percentage
            ]
        );


        return redirect()->back();
    }
}
