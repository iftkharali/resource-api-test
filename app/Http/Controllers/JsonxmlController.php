<?php

namespace App\Http\Controllers;

use App\JsonXmlTransformer;

class JsonxmlController extends Controller
{
    public function jsonToXml()
    {
        $transformer = new JsonXmlTransformer();
        if ($transformer->transformAndOutput()) {
            return response()->json(['message' => 'XML generated successfully in stoage/app'], 200);
        } else {
            return response()->json(['message' => 'Error generating XML'], 500);
        }
    }
}
