<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaLibraryHolder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeDeleted;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Project;

class MediaController extends Controller
{
    private function getHolder()
    {
        return MediaLibraryHolder::firstOrCreate(['id' => 1]);
    }

    public function index(Request $request): View|JsonResponse
    {
        $currentFolder = $request->input('folder', '/');
        
        // 1. Obtener los ítems de medios en la carpeta actual
        $mediaItemsQuery = $this->getHolder()
            ->media()
            ->where('mime_type', 'like', 'image/%')
            ->where('custom_properties->folder_path', $currentFolder);

        // 2. Obtener las subcarpetas que existen dentro de la carpeta actual
        $subfoldersQuery = $this->getHolder()->media()
            ->select(DB::raw("DISTINCT JSON_UNQUOTE(JSON_EXTRACT(custom_properties, '$.folder_path')) as path"))
            ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(custom_properties, '$.folder_path'))"), 'LIKE', $currentFolder . '%')
            ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(custom_properties, '$.folder_path'))"), '!=', $currentFolder)
            ->get()
            ->map(function ($item) use ($currentFolder) {
                // Extraemos solo el nombre de la siguiente subcarpeta
                $relativePath = str_replace($currentFolder, '', $item->path);
                return explode('/', trim($relativePath, '/'))[0];
            })
            ->unique()
            ->filter(); // Eliminar valores vacíos

        if ($request->filled('search')) {
            $mediaItemsQuery->where('name', 'LIKE', '%' . $request->input('search') . '%');
            // La búsqueda deshabilita la vista de carpetas para evitar complejidad
            $subfolders = collect();
        } else {
            $subfolders = $subfoldersQuery;
        }

        $mediaItems = $mediaItemsQuery->latest()->paginate(12);

        $viewData = [
            'mediaItems' => $mediaItems,
            'subfolders' => $subfolders,
            'currentFolder' => $currentFolder
        ];
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.media.partials._items', $viewData)->render(),
                'currentFolder' => $currentFolder // Enviar la carpeta actual
            ]);
        }

        return view('admin.media.index', $viewData);
    }

    // public function store(Request $request): JsonResponse
    // {
    //     $request->validate([
    //         'files.*' => 'required|image|max:4096',
    //         'folder_path' => 'required|string' // El path donde se subirán los archivos
    //     ]);

    //     $holder = $this->getHolder();
    //     $folderPath = $request->input('folder_path', '/');

    //     foreach ($request->file('files') as $file) {
    //         $holder->addMedia($file)
    //                ->withCustomProperties(['folder_path' => $folderPath]) // <-- Guardamos la ruta
    //                ->toMediaCollection('default');
    //     }

    //     return response()->json(['success' => true]);
    // }

    // public function store(Request $request): JsonResponse   //SECOND VERSION
    // {
    //     $request->validate([
    //         'files.*' => 'required|image|max:4096',
    //         'folder_path' => 'required|string',
    //         'alt_text.*' => 'nullable|string|max:255' // Nuevo campo
    //     ]);

    //     $holder = $this->getHolder();
    //     $folderPath = $request->input('folder_path', '/');
    //     $altTexts = $request->input('alt_text', []);

    //     foreach ($request->file('files') as $index => $file) {
    //         $media = $holder->addMedia($file)
    //             ->withCustomProperties(['folder_path' => $folderPath])
    //             ->toMediaCollection('default');
                
    //         // Asignar texto alternativo
    //         $media->alt_text = $altTexts[$index] ?? '';
    //         $media->save();
    //     }

    //     return response()->json(['success' => true]);
    // }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'files.*' => 'required|image|max:4096',
            'folder_path' => 'required|string',
            'alt_text.*' => 'nullable|string|max:255'
        ]);

        $holder = $this->getHolder();
        $folderPath = $request->input('folder_path', '/');
        $altTexts = $request->input('alt_text', []);
        
        // Manejar caso cuando no hay textos alternativos
        if (empty($altTexts)) {
            $altTexts = array_fill(0, count($request->file('files')), '');
        }

        foreach ($request->file('files') as $index => $file) {
            $media = $holder->addMedia($file)
                ->withCustomProperties(['folder_path' => $folderPath])
                ->toMediaCollection('default');
                
            $media->alt_text = $altTexts[$index] ?? '';
            $media->save();
        }

        return response()->json(['success' => true]);
    }





     public function upload_new(Request $request,$id,$extension): JsonResponse 
     {

        $request->validate([
            'files.*' => 'required|image|max:4096',
            'folder_path' => 'required|string',
            'alt_text.*' => 'nullable|string|max:255'
        ]);

        $holder = $this->getHolder();
        $folderPath = $request->input('folder_path', '/');
        $altTexts = $request->input('alt_text', []);
        
        // Manejar caso cuando no hay textos alternativos
        if (empty($altTexts)) {
            $altTexts = array_fill(0, count($request->file('files')), '');
        }

        foreach ($request->file('files') as $index => $file) {
            $media = $holder->addMedia($file)
                ->withCustomProperties(['folder_path' => $folderPath])
                ->toMediaCollection('default');
                
            $media->alt_text = $altTexts[$index] ?? '';
            $media->save();
        }

        return response()->json(['success' => true]);
    }


    public function uploadFromStorage($id, $extension): JsonResponse
{
   //busqueda por la extension en la carpeta public

    $sourcePath = public_path("images/{$extension}");


}















    public function createFolder(Request $request): JsonResponse
    {
        $request->validate([
            'folder_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s_-]+$/',
            'current_folder' => 'required|string'
        ]);
        
        // Nota: No creamos nada en la base de datos aquí. Una carpeta "existe"
        // virtualmente en cuanto se le asigna un archivo. Este método es solo
        // para validación futura o para lógicas más complejas si se necesitaran.
        // La creación real la maneja el Javascript al pasar la nueva ruta a 'store'.
        
        return response()->json(['success' => true, 'message' => 'Folder ready to be used.']);
    }

    // public function destroy(Media $media): JsonResponse
    // {
    //     try {
    //         $media->delete();
    //         return response()->json(['success' => true]);
            
    //     } catch (\Exception $e) {
    //         // Verificar si el mensaje contiene indicios de error de archivo
    //         if (str_contains($e->getMessage(), 'unlink') || 
    //             str_contains($e->getMessage(), 'permission') || 
    //             str_contains($e->getMessage(), 'file not found')) {
                
    //             Log::error('File deletion error: ' . $e->getMessage());
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'File error: ' . $e->getMessage()
    //             ], 422);
    //         }
            
    //         Log::error('Deletion error for media ' . $media->id . ': ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Server error: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    public function destroy($id): JsonResponse
    {
        try {
            // Buscar el medio por ID
            $media = Media::findOrFail($id);
            
            // Verificar que pertenece al holder
            $holder = $this->getHolder();
            if ($media->model_id !== $holder->id || $media->model_type !== MediaLibraryHolder::class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Media does not belong to this library'
                ], 403);
            }

            // Eliminar físicamente
            $media->forceDelete();
            
            // Eliminar directorio físico
            $directory = storage_path("app/public/{$media->id}");
            if (file_exists($directory)) {
                \Illuminate\Support\Facades\File::deleteDirectory($directory);
            }
            
            return response()->json([
                'success' => true,
                'id' => $id,
                'message' => 'Media deleted successfully'
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Media not found'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error("Force delete failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download(Media $media)
    {
        // Devuelve el archivo original para su descarga
        return response()->download($media->getPath(), $media->file_name);
    }

    public function updateAltText(Request $request, $id): JsonResponse
    {
        $request->validate([
            'alt_text' => 'required|string|max:255'
        ]);

        $media = Media::findOrFail($id);
        $media->alt_text = $request->alt_text;
        $media->save();

        return response()->json(['success' => true]);
    }
}