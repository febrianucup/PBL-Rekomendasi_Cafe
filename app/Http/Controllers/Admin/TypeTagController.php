<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeTagController extends Controller
{
    public function index()
    {
        $types = Type::orderBy('created_at', 'desc')->get();
        $tags = Tags::orderBy('created_at', 'desc')->get();

        return view('admin.type_tags', compact('types', 'tags'));
    }

    public function storeType(Request $request)
    {
        $validated = $request->validate([
            'type_name' => 'required|string|max:255|unique:types,type_name',
        ]);

        Type::create($validated);

        return redirect()->route('admin.type_tags.index')->with('success', 'Jenis berhasil ditambahkan.');
    }

    public function storeTag(Request $request)
    {
        $validated = $request->validate([
            'tag_name' => 'required|string|max:255|unique:tags,tag_name',
        ]);

        Tags::create($validated);

        return redirect()->route('admin.type_tags.index')->with('success', 'Tag berhasil ditambahkan.');
    }

    public function updateType(Request $request, $id)
    {
        $type = Type::findOrFail($id);

        $validated = $request->validate([
            'type_name' => 'required|string|max:255|unique:types,type_name,' . $type->id,
        ]);

        $type->update($validated);

        return redirect()->route('admin.type_tags.index')->with('success', 'Jenis berhasil diperbarui.');
    }

    public function updateTag(Request $request, $id)
    {
        $tag = Tags::findOrFail($id);

        $validated = $request->validate([
            'tag_name' => 'required|string|max:255|unique:tags,tag_name,' . $tag->id,
        ]);

        $tag->update($validated);

        return redirect()->route('admin.type_tags.index')->with('success', 'Tag berhasil diperbarui.');
    }

    public function destroyType($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return redirect()->route('admin.type_tags.index')->with('success', 'Jenis berhasil dihapus.');
    }

    public function destroyTag($id)
    {
        $tag = Tags::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.type_tags.index')->with('success', 'Tag berhasil dihapus.');
    }
}
