<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort', 'id'); // domyślnie sortujemy po ID
        $direction = $request->query('direction', 'asc');

        $products = Product::when($search, function ($query, $search) {
            $query->where('nazwa', 'like', "%{$search}%")
                ->orWhere('opis', 'like', "%{$search}%");
        })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products', 'search', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nazwa' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'cena' => 'required|numeric',
            'ilosc' => 'required|integer',
        ]);
        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Produkt dodany!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nazwa' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'cena' => 'required|numeric',
            'ilosc' => 'required|integer',
        ]);
        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produkt został edytowany!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produkt usunięty');
    }
}
