<?php

namespace App\Http\Controllers;

use App\Models\store;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OnlineStoreController extends Controller
{
    public function index()
    {
        $prodect = store::where('category', 'Home')->get();
        return view('OnlineStore.index', compact('prodect'));
    }

    public function woman()
    {
        $prodect = store::where('category', 'woman')->get();

        return view('OnlineStore.woman',compact('prodect'));
    }

    public function man()
    {
        $prodect = store::where('category', 'man')->get();

        return view('OnlineStore.man',compact('prodect'));
    }

    public function Kids()
    {

        $prodect = store::where('category', 'Kids')->get();

        return view('OnlineStore.Kids', compact('prodect'));
    }

    public function admain()
    {
        return view('OnlineStore.admain');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store( 'products', 'public');
            $validatedData['image'] = $imagePath;
        }

        store::create($validatedData);

        return redirect()->route('onlineStore')->with('success', 'Product added successfully!');
    }
}
