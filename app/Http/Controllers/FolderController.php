<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\File;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class FolderController extends Controller
{
    public function store(Request $request, $classroomId)
    {
        Log::info('Incoming folder request:', $request->all());
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $folder = Folder::create([
            'classroom_id' => $classroomId,
            'name' => $request->name
        ]);

        return response()->json(['success' => true, 'folder' => $folder]);
    }

    

    public function list($classroomId)
    {
        $folders = Folder::where('classroom_id', $classroomId)->get();
        return response()->json($folders);
    }

    public function getFiles($classroomId, $folderId)
    {
        $files = File::where('classroom_id', $classroomId)
                    ->where('folder_id', $folderId)
                    ->with('uploader:id,name') // if you want modified_by
                    ->get()
                    ->map(function ($file) {
                        return [
                            'file_name' => $file->file_name,
                            'file_path' => $file->file_path,
                            'modified_at' => $file->updated_at->format('M d, Y'),
                            'modified_by' => $file->uploader->name ?? 'Unknown',
                            'id' => $file->id
                        ];
                    });
    
        return response()->json($files);
    }
    


}
