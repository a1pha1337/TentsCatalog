<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Manufacturer;
use App\Models\Tent;
use App\Models\TentType;

use Auth;

class SiteController extends Controller
{
    // INDEX
    public function index()
    {
        return view('index', [
            'user' => Auth::user(),
            'tents' => Tent::all(),
        ]);
    }

    // READ AJAX
    public function showTent($id)
    {
        $tent = Tent::find($id);

        return response()->json([
            'name' => $tent->Name,
            'type' => $tent->tentType->Name,
            'maximizedDimensions' => $tent->MaximizedDimensions,
            'minimizedDimensions' => $tent->MinimizedDimensions,
            'price' => $tent->Price,
            'description' => $tent->Description,
        ]);
    }

    // READ
    public function viewTent($id)
    {
        $tent = Tent::find($id);

        return view('showtent', [
            'user' => Auth::user(),
            'tent' => Tent::find($id),
        ]);
    }

    // DELETE
    public function deleteTent($id)
    {
        $deletingTent = Tent::find($id);

        if ($deletingTent)
        {
            // Delete image from a server
            if ($deletingTent->ImgPath != '')
            {
                Storage::disk('public')->delete($deletingTent->ImgPath);
            }

            $deletingTent->delete();
        }

        return redirect()->route('index');
    }

    // CREATE RENDER
    public function createTentRender()
    {
        $tentTypes = TentType::all();
        $manufacturers = Manufacturer::all();

        return view('createtent', [
            'user' => Auth::user(),
            'tentTypes' => $tentTypes,
            'manufacturers' => $manufacturers,
        ]);
    }

    // CREATE
    public function createTent(Request $req)
    {
        $data = $req->all();
        $newTent = new Tent($data);

        if ($req->file('image') != '')
        {
            $path = $req->file('image')->store('uploads', 'public');
            $newTent->ImgPath = $path;
        }

        if ($newTent)
        {
            $newTent->save();
        }
        
        return response()->json();
    }

    // UPDATE RENDER
    public function updateTentRender($id)
    {
        $tent = Tent::find($id);
        $tentTypes = TentType::all();
        $manufacturers = Manufacturer::all();

        return view('createtent', [
            'user' => Auth::user(),
            'tent' => $tent,
            'tentTypes' => $tentTypes,
            'manufacturers' => $manufacturers,
        ]);
    }

    // UPDATE
    public function updateTent(Request $req, $id)
    {
        $editingTent = Tent::find($id);

        $data = $req->all();
        $editedTent = $editingTent->fill($data);

        if ($req->file('image') != '')
        {
            $path = $req->file('image')->store('uploads', 'public');
            $editedTent->ImgPath = $path;
        }

        $editedTent->save();

        if($editedTent)
            return redirect()->route('index');
    }
}
