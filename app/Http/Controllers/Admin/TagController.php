<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.en' => 'required|string|max:255',
            'name.es' => 'required|string|max:255',
            'color_bg' => 'required|string|size:7',
            'color_text' => 'required|string|size:7',
            'slug' => 'required|string|unique:tags,slug'
        ]);

        Tag::create($request->all());
        
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully!');
    }

    public function edit($id)
    {   
        $tag = Tag::findOrFail($id);
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {

        $tag = Tag::findOrFail($id);

        $request->validate([
            'name.en' => 'required|string|max:255',
            'name.es' => 'required|string|max:255',
            'color_bg' => 'required|string|size:7',
            'color_text' => 'required|string|size:7',
            'slug' => 'required|string|unique:tags,slug,'.$tag->id
        ]);

        $tag->update($request->all());
        
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully!');
    }

    public function destroy($id)
    {

        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully!');
    }
}