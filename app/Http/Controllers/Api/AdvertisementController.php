<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisement;

class AdvertisementController extends Controller
{
    public function show($id)
    {
        $advertisements = Advertisement::find($id);

        if (!$advertisements) {
            return response()->json(['message' => 'Không tìm thấy quảng cáo'], 404);
        }

        return response()->json($advertisements, 200);
    }
}
