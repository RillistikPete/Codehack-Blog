<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AdminMediaController extends Controller
{
    public function index()
    {
        $photos = Photo::with(['posts', 'users'])->latest()->paginate(24);

        return view('admin.media.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $file = $request->file('file');
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('', $name, 's3');
        $photo = Photo::create(['file' => $name]);

        return response()->json(['id' => $photo->id], 201);
    }

    public function destroy($id): RedirectResponse
    {
        $photo = Photo::findOrFail($id); // if this was find(), it would need if(! $photo){...}

        Storage::disk('s3')->delete($photo->file);
        $photo->delete();

        return redirect()->route('media.index')->with('success', 'Media deleted.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'photos'   => 'required|array',
            'photos.*' => 'integer|exists:photos,id',
        ]);
        
        // findOrFail throws if any id is missing
        // whereIn just returns what exists
        $photos = Photo::whereIn('id', $validated['photos'])->get(); 

        foreach ($photos as $photo) {
            Storage::disk('s3')->delete($photo->file);
            $photo->delete(); // sets posts.photo_id/users.photo_id - nullOnDelete() in migration (fks)
        }

        $count = $photos->count();

        return redirect()->route('media.index')
            ->with('success', $count === 1 ? 'Photo deleted.' : "{$count} photos deleted.");
    }



}
