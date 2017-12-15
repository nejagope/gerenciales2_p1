<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->validate(
			$request, 
			[
				'name' => 'required|string|min:1|',				
				'price' => 'required|numeric|',				
			],
			[
				'name.required' => 'Campo requerido',
				'name.min' => 'Campo requerido',	
				'price.required' => 'Campo requerido',				
				'price.numeric' => 'Entrada no válida',				
			]
		);
		
        $product = new Product;
		$product->name = $request->input('name');
		$product->price = floatval($request->input('price'));
		$product->image_url = $request->input('image_url');
		
		$product->save();
		if ($request->input('category')){
			$category = Category::find($request->input('category'));
			if ($category)
				$product->category()->associate($category);
		}
		return redirect()->route('products_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete(Product $product)
    {
        $product->delete();
		return redirect()->route('products_index');
    }
}
