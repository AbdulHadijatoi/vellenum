<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240', // 10MB max
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'is_public' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $uploadedFile = $request->file('file');
        $originalName = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->getClientOriginalExtension();
        $mimeType = $uploadedFile->getMimeType();
        $size = $uploadedFile->getSize();

        // Generate unique filename
        $filename = Str::uuid() . '.' . $extension;
        $path = $uploadedFile->storeAs('files', $filename, 'public');

        // Create file record
        $file = File::create([
            'original_name' => $originalName,
            'filename' => $filename,
            'path' => $path,
            'mime_type' => $mimeType,
            'extension' => $extension,
            'size' => $size,
            'disk' => 'public',
            'category' => $request->category,
            'description' => $request->description,
            'uploaded_by' => $request->user()->id,
            'is_public' => $request->boolean('is_public', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully',
            'data' => [
                'file' => $file,
                'url' => $file->url
            ]
        ], 201);
    }

    public function show($id)
    {
        $file = File::active()->find($id);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'file' => $file,
                'url' => $file->url
            ]
        ]);
    }

    public function download($id)
    {
        $file = File::active()->find($id);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        if (!$file->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'File not found on disk'
            ], 404);
        }

        return Storage::disk($file->disk)->download($file->path, $file->original_name);
    }

    public function update(Request $request, $id)
    {
        $file = File::find($id);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        // Check if user owns the file or is admin
        if ($file->uploaded_by !== $request->user()->id && !$request->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $file->update($request->only(['category', 'description', 'is_public', 'is_active']));

        return response()->json([
            'success' => true,
            'message' => 'File updated successfully',
            'data' => $file
        ]);
    }

    public function destroy($id)
    {
        $file = File::find($id);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        // Check if user owns the file or is admin
        if ($file->uploaded_by !== auth()->user()->id && !auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete file from disk
        $file->deleteFromDisk();

        // Delete file record
        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully'
        ]);
    }

    public function index(Request $request)
    {
        $query = File::active();

        // Filter by category
        if ($request->has('category')) {
            $query->category($request->category);
        }

        // Filter by uploaded by
        if ($request->has('uploaded_by')) {
            $query->where('uploaded_by', $request->uploaded_by);
        }

        // Filter by public files only
        if ($request->boolean('public_only')) {
            $query->public();
        }

        // Search by original name
        if ($request->has('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%');
        }

        $files = $query->with('uploader')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $files
        ]);
    }

    public function getByCategory($category)
    {
        $files = File::active()
            ->category($category)
            ->public()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $files
        ]);
    }

    public function bulkUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array|max:10',
            'files.*' => 'file|max:10240',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $uploadedFiles = [];
        $errors = [];

        foreach ($request->file('files') as $index => $uploadedFile) {
            try {
                $originalName = $uploadedFile->getClientOriginalName();
                $extension = $uploadedFile->getClientOriginalExtension();
                $mimeType = $uploadedFile->getMimeType();
                $size = $uploadedFile->getSize();

                // Generate unique filename
                $filename = Str::uuid() . '.' . $extension;
                $path = $uploadedFile->storeAs('files', $filename, 'public');

                // Create file record
                $file = File::create([
                    'original_name' => $originalName,
                    'filename' => $filename,
                    'path' => $path,
                    'mime_type' => $mimeType,
                    'extension' => $extension,
                    'size' => $size,
                    'disk' => 'public',
                    'category' => $request->category,
                    'description' => $request->description,
                    'uploaded_by' => $request->user()->id,
                    'is_public' => true,
                ]);

                $uploadedFiles[] = $file;
            } catch (\Exception $e) {
                $errors[] = [
                    'file' => $uploadedFile->getClientOriginalName(),
                    'error' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Files uploaded successfully',
            'data' => [
                'uploaded_files' => $uploadedFiles,
                'errors' => $errors
            ]
        ], 201);
    }
}