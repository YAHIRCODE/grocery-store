<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaContent;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4,mov|max:20000', // Máx 20MB
            'file_type' => 'required|in:image,video',
            'section' => 'required|in:carousel,hero_video',
        ]);

        if ($request->hasFile('file')) {
            // Guardar en la carpeta pública del storage
            $path = $request->file('file')->store('public/media');
            $url = Storage::url($path);

            MediaContent::create([
                'file_path' => $url,
                'file_type' => $request->file_type,
                'section' => $request->section,
            ]);
        }

        return back()->with('success', 'Archivo subido correctamente');
    }
}