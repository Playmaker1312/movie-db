<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
   public function homepage(){
    $movies = Movie::latest()->paginate(6);
    return view('homepage', compact('movies'));
}
    // Method baru untuk menampilkan detail movie
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movies.detail', compact('movie'));
    }

public function create()
    {
        $categories = Category::all();
        return view('create-movies', compact('categories')); // Perbaiki nama view
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:movies,slug',
            'synopsis' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'actors' => 'nullable|string',
            'cover-image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $movie = new Movie();
        $movie->title = $validated['title'];
        $movie->slug = $validated['slug'] ?? Str::slug($validated['title']);
        $movie->synopsis = $validated['synopsis'];
        $movie->category_id = $validated['category_id'];
        $movie->year = $validated['year'];
        $movie->actors = $validated['actors'];
        if ($request->hasFile('cover-image')) {
            $movie->{'cover-image'} = $request->file('cover-image')->store('covers', 'public');
        }
        $movie->save();

        return redirect()->route('homepage')->with('success', 'Movie created successfully!');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        $categories = Category::all();
        return view('movies.edit', compact('movie', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:movies,slug,' . $id,
            'synopsis' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'actors' => 'nullable|string',
            'cover-image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $movie->title = $validated['title'];
        $movie->slug = $validated['slug'] ?? Str::slug($validated['title']);
        $movie->synopsis = $validated['synopsis'];
        $movie->category_id = $validated['category_id'];
        $movie->year = $validated['year'];
        $movie->actors = $validated['actors'];

        if ($request->hasFile('cover-image')) {
            // Delete old image if exists
            if ($movie->{'cover-image'}) {
                Storage::disk('public')->delete($movie->{'cover-image'});
            }
            $movie->{'cover-image'} = $request->file('cover-image')->store('covers', 'public');
        }

        $movie->save();

        return redirect()->route('homepage')->with('success', 'Movie updated successfully!');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        
        // Delete cover image if exists
        if ($movie->{'cover-image'}) {
            Storage::disk('public')->delete($movie->{'cover-image'});
        }
        
        $movie->delete();

        return redirect()->route('homepage')->with('success', 'Movie deleted successfully!');
    }
}
