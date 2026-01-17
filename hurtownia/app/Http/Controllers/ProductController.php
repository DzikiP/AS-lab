<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $sort = $request->query('sort', 'id');
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';
        $products = $query->orderBy($sort, $direction)->paginate(10)->withQueryString();

        return view('products.index', compact('products', 'search', 'sort', 'direction'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'unit' => 'nullable|string|max:50',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produkt został dodany!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'unit' => 'nullable|string|max:50',
        ]);

        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Produkt został edytowany!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produkt został usunięty!');
    }
}
