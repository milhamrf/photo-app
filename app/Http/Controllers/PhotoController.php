<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::all();
        return view('photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('photos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $data = $request->validate([
                'title' => 'required',
                'image' => 'required|image',
                'description' => 'nullable',
            ]);
    
            $imagePath = $request->file('image')->store('public/photos');
            $data['image'] = $imagePath;
    
            Photo::create($data);
    
            return redirect()->route('photos.index')->with('success', 'Photo created successfully.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('photos.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $photo = Photo::find($id);
        return view('photos.edit', compact('photo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);
        $photo = Photo::find($id);
        if ($request->hasFile('image')) {
            // Menghapus gambar lama jika ada
            Storage::delete($photo->image);
    
            // Menyimpan gambar yang baru
            $imagePath = $request->file('image')->store('public/photos');
            $data['image'] = $imagePath;
        }
        
        $photo->update($data);

        return redirect()->route('photos.index')->with('success', 'Photo updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = Photo::find($id);
        Storage::delete($photo->image);
        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Photo deleted successfully.');
    }
}
