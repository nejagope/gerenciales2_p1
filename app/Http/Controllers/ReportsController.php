<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
		//DB::select('select distinct year(created_at) year from orders order by year')
		//años para filtrar el reporte
		$years = DB::table('orders')
                     ->select(DB::raw('distinct year(created_at) year'))
                     ->where('in_process', '<>', true)
                     ->orderBy('year')
                     ->get();
		
		//total de dinero en órdenes por categoría
		$amounts_orders = DB::table('orders')
					->join('order_product', 'orders.id', '=', 'order_product.order_id')
					->join('products', 'order_product.product_id', '=', 'products.id')
					->join('categories', 'categories.id', '=', 'products.category_id')
					->groupBy('categories.description')
					->select(DB::raw('categories.description as category'), DB::raw('sum(products.price) as amount_ordered'))
					;
		
		$total_orders = DB::table('orders');
		$total_envios = DB::table('orders')
							->join('shippings', 'orders.id', '=', 'shippings.order_id');
							
		//aplicación de filtro de año a consultas en caso de que viniera el año  como parámetro en el request
		if ($request->year){
			$amounts_orders = $amounts_orders->whereBetween('orders.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$total_orders = $total_orders->whereBetween('orders.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$total_envios = $total_envios->whereBetween('orders.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
		}
		
		
		$amounts_orders = $amounts_orders->get();
		$total_orders = $total_orders->count();
		$total_envios = $total_envios->count();
		
		$parametros = [
			'years' => $years,
			'amounts_orders' => $amounts_orders,
			'total_orders' => $total_orders,
			'total_shippings' => $total_envios,
		];
        return view('reports.index', $parametros);
    }
}
