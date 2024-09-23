<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\hybridInventory;

class ScrapeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $records;

    public function __construct($records)
    {
        $this->records = $records;
    }

    public function handle()
    {
        try {
            foreach ($this->records as $record) {
                $url = $record->link; // Use the link field for the URL

                if (!empty($url)) {
                    $delay = rand(2, 15);
                    sleep($delay);
                    $html = $this->getHtml($url,$record);
                    if ($html) {
                        $jo = $this->parsingHtml($html);
                        if ($jo) {
                            $this->updateRecord($jo, $record);
                        } else {
                            echo "Robot and human error occurred while updating record ID: {$record->id}\n";
                            $record->status =2;
                            $record->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            echo "Please check your internet connection\n";
        }
    }

    public function getHtml($url,$record)
    {
        $parsedUrl = parse_url($url);
        if ($parsedUrl && isset($parsedUrl['scheme']) && isset($parsedUrl['host'])) {
            $encodedUrl = filter_var($url, FILTER_SANITIZE_URL);
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                    'Accept-Language' => '*',
                ])->get($encodedUrl);

                if ($response->successful()) {
                    return $response->body();
                } else {
                    throw new \Exception("Failed to fetch URL: " . $encodedUrl . " - Status: " . $response->status());
                    $record->status =3;
                    $record->save();
                }
            } catch (\Exception $e) {
                echo "Error fetching URL: " . $encodedUrl . "\n";
                echo $e->getMessage() . "\n";
                $record->status =3;
                $record->save();
                return null;
            }
        } else {
            echo "Invalid URL: " . $url . "\n";
            $record->status =3;
                $record->save();
            return null;
        }
    }

    public function parsingHtml($html)
    {
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $xpath = new \DOMXPath($doc);
        $content = $xpath->query('//*[@id="__NEXT_DATA__"]')->item(0);
        return $content ? json_decode($content->nodeValue, true) : null;
    }

    public function updateRecord($jo, $record)
    {
        $props = $jo['props'] ?? null;
        $pageProps = $props['pageProps'] ?? null;
        $initialData = $pageProps['initialData'] ?? null;
        $data = $initialData['data'] ?? null;
        $product = $data['product'] ?? null;
        if ($product) {
            $fulfillmentOptions = $product['fulfillmentOptions'] ?? [];
            if (!empty($fulfillmentOptions)) {
                $availableQuantity = $fulfillmentOptions[0]['availableQuantity'] ?? 'N/A';
                echo "availableQuantity of record ID {$record->id}: $availableQuantity\n";
                $record->walmart_qty = $availableQuantity === 'N/A' ? 0 : $availableQuantity;
                $record->status = $availableQuantity === 'N/A' ? 1 : 200;
                $record->walmart_price = $product['priceInfo']['currentPrice']['price'] ?? 0;
                $record->save();
            }
        }
    }
}
