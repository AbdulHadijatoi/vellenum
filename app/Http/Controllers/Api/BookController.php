<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $seller = $request->user()->seller;
        $books = Book::where('seller_id', $seller->id)->with(['coverFile', 'bookFile'])->paginate(15);
        return response()->json(['success' => true, 'data' => $books]);
    }

    public function store(Request $request)
    {
        $seller = $request->user()->seller;

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'genre' => 'nullable|string',
            'format' => 'nullable|string',
            'cover' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:10240',
            'book_file' => 'nullable|file|max:20480',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->only(['title', 'author', 'price', 'genre', 'format']);
        $data['seller_id'] = $seller->id;

        // handle files
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('files', $filename, 'public');
            $f = File::create([
                'original_name' => $file->getClientOriginalName(),
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'disk' => 'public',
                'category' => 'book',
                'uploaded_by' => $request->user()->id,
                'is_public' => true,
            ]);
            $data['cover_file_id'] = $f->id;
        }

        if ($request->hasFile('book_file')) {
            $file = $request->file('book_file');
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('files', $filename, 'public');
            $f = File::create([
                'original_name' => $file->getClientOriginalName(),
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'disk' => 'public',
                'category' => 'book',
                'uploaded_by' => $request->user()->id,
                'is_public' => true,
            ]);
            $data['book_file_id'] = $f->id;
        }

        $book = Book::create($data);
        return response()->json(['success' => true, 'data' => $book], 201);
    }

    public function show(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $book = Book::where('id', $id)->where('seller_id', $seller->id)->with(['coverFile','bookFile'])->firstOrFail();
        return response()->json(['success' => true, 'data' => $book]);
    }

    public function update(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $book = Book::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'genre' => 'nullable|string',
            'format' => 'nullable|string',
            'cover' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:10240',
            'book_file' => 'nullable|file|max:20480',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->only(['title','author','price','genre','format']);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('files', $filename, 'public');
            $f = File::create([
                'original_name' => $file->getClientOriginalName(),
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'disk' => 'public',
                'category' => 'book',
                'uploaded_by' => $request->user()->id,
                'is_public' => true,
            ]);
            $data['cover_file_id'] = $f->id;
        }

        if ($request->hasFile('book_file')) {
            $file = $request->file('book_file');
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('files', $filename, 'public');
            $f = File::create([
                'original_name' => $file->getClientOriginalName(),
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'disk' => 'public',
                'category' => 'book',
                'uploaded_by' => $request->user()->id,
                'is_public' => true,
            ]);
            $data['book_file_id'] = $f->id;
        }

        $book->update($data);
        return response()->json(['success' => true, 'data' => $book->fresh()]);
    }

    public function destroy(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $book = Book::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();

        // delete associated files if present
        if ($book->coverFile) {
            $book->coverFile->deleteFromDisk();
            $book->coverFile->delete();
        }
        if ($book->bookFile) {
            $book->bookFile->deleteFromDisk();
            $book->bookFile->delete();
        }

        $book->delete();
        return response()->json(['success' => true]);
    }
}
