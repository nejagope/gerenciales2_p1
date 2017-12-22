<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Shipping;
use App\Devolution;
use App\Reason;
use Auth;

class OrdersController extends Controller
{
    public function index(Request $request){
		$orders = Order::doesntHave('shippings')->orderBy('created_at')->with('products')->with('gifts')->paginate(10);
		if (!Auth::user()->is_admin)
			$orders = Order::with('products')->with('gifts')->where('user_id', Auth::user()->id)->orderBy('created_at')->paginate(10);
		$params = ['orders' => $orders];
		return view('orders.index', $params);
	}
	
	 public function view(Request $request){		 
		$order = Order::with('products')->with('gifts')->with('devolutions')->find($request->order);
		$reasons = Reason::all();
		//dd($reasons);
		$products = $order->products;
		$totalCompra = 0;
		foreach ($products as $product)
		{
			$devolutions = $order->devolutions->where('product_id', $product->id);
			//dd($devolutions);
			if ($devolutions->count() == 0)
				$totalCompra += $product->price * $product->pivot->amount;
		}
			
		
		$params = ['products' => $products, 
			'totalCompra' => $totalCompra,
			'order' => $order,
			'discount' => 0,
			'reasons' => $reasons];
			
		$gift = $order->gifts->first();
		if ($gift){
			$params['discount'] = round($totalCompra * $gift->discount, 2);
		}
		return view('orders.view', $params);
	}
	
	public function return(Request $request){		
		$devulution = new Devolution;
		$devulution->order_id = $request->order;
		$devulution->product_id = $request->product;
		$devulution->reason_id = $request->input('reason');
		$devulution->save();
				
		return redirect()->route('orders_view', ['order' => $request->order]);
	}
	
	public function despachar(Order $order){
		$shipping = new Shipping;
		$shipping->order_id = $order->id;
		$shipping->save();
		return redirect()->back()->withInput();
	}
}
