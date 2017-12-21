<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\User;
use App\Gift;

class ClientsController extends Controller
{
    public function index(Request $request){
		$clients = DB::table('orders')
					->join('order_product', 'orders.id', '=', 'order_product.order_id')
					->join('users', 'users.id', '=', 'orders.user_id')
					->join('products', 'order_product.product_id', '=', 'products.id')
					->leftJoin('devolutions', 'products.id', '=', 'devolutions.product_id')						
					->groupBy('users.id', 'users.name', 'users.email')													
					->select('users.id', 'users.name', 'users.email', DB::raw('coalesce(sum(order_product.amount * products.price),0) as compras'))
					->where('devolutions.id', null)					
					;
		$compras_min = $request->input('min');
		$compras_max = $request->input('max');
		if ($compras_min)
			$clients  = $clients->having('compras', '>=', $compras_min);
		
		if ($compras_max)
			$clients  = $clients->having('compras', '<=', $compras_max);
		
		$clients = $clients->orderBy('compras', 'desc')->get();
		$params = ['clients' => $clients];
		
		if ($compras_min)
			$params['min'] = $compras_min;
		
		if ($compras_max)
			$params['max'] = $compras_max;
		
		if ($request->action == "Enviar Descuento")
		{
			$discount = $request->input('discount');
			
			foreach($clients as $client){				
				$gift = new Gift;
				$gift->user_id = $client->id;
				$gift->discount = floatval($discount);
				$gift->save();
			}
			return redirect()->route('clients_index');
		}
		
		return view('clients.index', $params);
	}
}
