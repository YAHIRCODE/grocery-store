<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    /**
     * Mostrar todos los archivos multimedia
     */
    public function index()
    {
        // Separar por tipo
        $carouselImages = MediaContent::where('section', 'carousel')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $heroVideos = MediaContent::where('section', 'hero_video')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('media.index', compact('carouselImages', 'heroVideos'));
    }

    /**
     * Subir imagen o video
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi,webm|max:51200', // 50MB
            'file_type' => 'required|in:image,video',
            'section' => 'required|in:carousel,hero_video,banner',
        ], [
            'file.required' => 'Debes seleccionar un archivo',
            'file.mimes' => 'Solo se permiten imágenes (JPG, PNG, WebP) o videos (MP4, MOV, AVI, WebM)',
            'file.max' => 'El archivo no debe superar los 50MB',
        ]);

        try {
            if (!$request->hasFile('file')) {
                return back()->with('error', 'No se recibió ningún archivo');
            }

            $file = $request->file('file');

            // Validar que el tipo coincida con el archivo
            $mimeType = $file->getMimeType();
            
            if ($request->file_type === 'image' && !str_starts_with($mimeType, 'image/')) {
                return back()->with('error', 'El archivo seleccionado no es una imagen válida');
            }
            
            if ($request->file_type === 'video' && !str_starts_with($mimeType, 'video/')) {
                return back()->with('error', 'El archivo seleccionado no es un video válido');
            }

    // Guardar en carpetas separadas
    $folder = $request->file_type === 'image' ? 'public/media/images' : 'public/media/videos';
    $path = $file->storeAs(
        ($request->file_type === 'image' ? 'media/images' : 'media/videos'), 
        $file->hashName(), 
        'public'
    );
    
    // Obtener URL pública
    $url = Storage::url($path);

            // Crear registro
            MediaContent::create([
                'file_path' => $url,
                'file_type' => $request->file_type,
                'section' => $request->section,
                'is_active' => true,
            ]);

            Log::info('Archivo multimedia subido', [
                'type' => $request->file_type,
                'section' => $request->section,
            ]);

            $mensaje = $request->file_type === 'image' ? 'Imagen' : 'Video';
            return back()->with('success', "{$mensaje} subido correctamente");

        } catch (\Exception $e) {
            Log::error('Error al subir archivo', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error al subir el archivo');
        }
    }

    /**
     * Activar/Desactivar
     */
    public function toggleActive($id)
    {
        try {
            $media = MediaContent::findOrFail($id);
            $media->is_active = !$media->is_active;
            $media->save();

            $status = $media->is_active ? 'activado' : 'desactivado';
            return back()->with('success', "Archivo {$status} correctamente");

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cambiar el estado');
        }
    }

    /**
     * Eliminar archivo
     */
    public function destroy($id)
    {
        try {
            $media = MediaContent::findOrFail($id);

            // Eliminar archivo físico
            $filePath = str_replace('/storage/', 'public/', $media->file_path);
            
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Eliminar registro
            $media->delete();

            Log::info('Archivo multimedia eliminado', ['id' => $id]);

            return back()->with('success', 'Archivo eliminado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar archivo', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error al eliminar el archivo');
        }
    }
}