<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function getImage($path = null)
    {
        if (!$path) {
            return response()->json(['error' => 'Path not found'], 404);
        }
        if (Storage::disk('public')->exists($path)) {
            $data = Storage::disk('public')->mimeType($path);
            return response()->make(Storage::disk('public')->get($path), 200, ['Content-Type' => $data]);
        }
        return response()->json(['error' => 'File not found'], 404);
    }
}
