<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class JsonXmlTransformer
{
    public function transformAndOutput()
    {
        $jsonFilePath = storage_path('app/input.json');
        $jsonContent = Storage::get('input.json');

        $jsonData = json_decode($jsonContent, true);
        if ($jsonData === null && json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('Error decoding JSON: ' . json_last_error_msg());
            return false;
        }
    
        $filteredData = $this->filterData($jsonData);
        $sortedData = $this->sortData($filteredData);


        $xmlData = $this->convertToXml($sortedData);
        
        if ($xmlData !== false) {
            Storage::put('output.xml', $xmlData);
            return true; 
        }

        return false;

    }
    

    /** Implementing filteration logic */
    private function filterData($data)
    {
        return array_filter($data, function ($item) {
            return $item['age'] <= 30;
        });
    }

    /** Implementing sorting logic */
    private function sortData($data)
    {
        usort($data, function ($a, $b) {
            return $a['age'] - $b['age'];
        });

        return $data;
    }

    /** XML conversion*/
    private function convertToXml($data)
    {
        try {
            $xml = new SimpleXMLElement('<root/>');
            array_walk_recursive($data, array($xml, 'addChild'));
            return $xml->asXML();
        } catch (\Exception $e) {
            \Log::error('Error generating XML: ' . $e->getMessage());
            return false; 
        }

    }
}
