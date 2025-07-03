<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;
use App\Models\Folder;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    // Upload a file to the classroom root (no folder)
    public function uploadToRoot(Request $request, $classroomId)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $path = $file->store("classrooms/$classroomId/files", 'public');

        File::create([
            'classroom_id' => $classroomId,
            'folder_id' => null,
            'uploaded_by' => auth()->id(),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return response()->json(['success' => true]);
    }

    // Upload a file into a specific folder
    public function uploadToFolder(Request $request, $classroomId, $folderId)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $file = $request->file('file');
        $path = $file->store("classrooms/$classroomId/folders/$folderId", 'public');

        File::create([
            'classroom_id' => $classroomId,
            'folder_id' => $folderId,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'uploaded_by' => auth()->id()
        ]);


        return response()->json(['success' => true]);
    }

    // List all files in classroom root (no folder)
    public function listRootFiles($classroomId)
    {
        $files = File::where('classroom_id', $classroomId)
            ->whereNull('folder_id') // only root files
            ->with('uploader') // if you're showing modified_by
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

    // Delete a file
    public function destroy($classroomId, $fileId)
    {
        $file = File::where('id', $fileId)
            ->where('classroom_id', $classroomId)
            ->firstOrFail();

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return response()->json(['success' => true]);
    }
}
