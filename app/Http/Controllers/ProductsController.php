<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Order;
use App\Gift;
use Auth;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::paginate(10);
		if ($request->category)
			$products = Product::where('category_id', $request->category)->paginate(10);
		
		$categories = Category::all();
		$parameters = ['products' => $products, 'categories' => $categories];
		if ($request->category)
			$parameters['category_selected'] = Category::find($request->category);
        return view('products.index', $parameters);
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
		$product->description = $request->input('description');
				
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
	
	public function addProductToOrder(Request $request){		
		if (!$request->session()->has('order')) { 	
			$orden = array();
			$request->session()->put('order', $orden);
		}
		$request->session()->push('order', $request->product);
		
		//dd( $request->session()->pull('order'));
		return ( sizeof($request->session()->get('order')) );
		//return "si";
	}
	
	public function shoppingCart(Request $request){
		$order = $request->session()->get('order');	
		if ($order){
			$products = Product::find($order);
			$cantidades = [];
			if ($products)
				$cantidades = array_count_values($order);
			$totalCompra = 0;
			foreach($products as $product)
				$totalCompra += $product->price * $cantidades[$product->id];
				
			$gifts = Auth::user()->gifts()->doesntHave('orders')->get();			
			
			return view('products.shopping_cart', 
				[
					'products' => $products,
					'cantidades' => $cantidades,
					'totalCompra' => $totalCompra,
					'gifts' => $gifts,
				]);
		}
		return view('products.shopping_cart', 
				[
					'products' => [],
					'cantidades' => [],
					'totalCompra' => 0,
					'gifts' => [],
				]);
	}
	
	public function removeFromOrder(Request $request){
		$product = $request->product;
		
		$order = $request->session()->pull('order');
		$orden = array();
		$request->session()->put('order', $orden);
		foreach($order as $_product){
			if ($product != $_product)
				$request->session()->push('order', $_product);
		}
		
		return redirect()->route('products_shopping_cart');
	}
	
	public function createOrder(Request $request){
		$order = $request->session()->pull('order');		
		$products = Product::find($order);		
		$cantidades = array_count_values($order);
		
		$user = Auth::user();
		
		$order = new Order;
		$order->in_process = false;		
		if ($products->count() > 0){			
			$user->orders()->save($order);
		}
		foreach($products as $product){
			$order->products()->attach($product, ['amount' => $cantidades[$product->id]]);			
		}		
		if ($request->input('gift') != 0){
			$order->gifts()->attach(Gift::find($request->input('gift')));
		}
		return redirect()->route('questions_index');
	}
}
