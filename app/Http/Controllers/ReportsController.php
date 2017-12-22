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
					->select(DB::raw('categories.description as category'), DB::raw('sum(products.price * order_product.amount) as amount_ordered'))
					;
					
		//total de productos ordenados por categoría
		$productos_ordenados = DB::table('orders')
					->join('order_product', 'orders.id', '=', 'order_product.order_id')
					->join('products', 'order_product.product_id', '=', 'products.id')
					->join('categories', 'categories.id', '=', 'products.category_id')					
					->groupBy('categories.description')
					->select(DB::raw('categories.description as category'), DB::raw('sum(order_product.amount) as ordered_products'))
					;
					
		$productos_devueltos = DB::table('devolutions')
					->join('products', 'products.id', '=', 'devolutions.product_id')										
					->join('categories', 'categories.id', '=', 'products.category_id')
					->groupBy('categories.description')
					->select(DB::raw('categories.description as category'), DB::raw('count(*) as devolutions'))
					;
		
		$total_orders = DB::table('orders');
		
		$total_envios = DB::table('orders')
							->join('shippings', 'orders.id', '=', 'shippings.order_id');
		
		$total_productos_ordenados = DB::table('orders')
					->join('order_product', 'orders.id', '=', 'order_product.order_id')
					->select(DB::raw('coalesce(sum(order_product.amount),0) as ordered_products'))
					;
					
		$total_devoluciones = DB::table('orders')
							->join('devolutions', 'orders.id', '=', 'devolutions.order_id');
							
		//devoluciones por motivo
		$total_devoluciones_reason = DB::table('devolutions')
							->join('reasons', 'reasons.id', '=', 'devolutions.reason_id')										
							->groupBy('reasons.description')													
							->select(DB::raw('reasons.description as reason'),DB::raw('count(*) as total'));
							
				//total de productos ordenados por categoría
		$top10_productos = DB::table('orders')
					->join('order_product', 'orders.id', '=', 'order_product.order_id')
					->join('products', 'order_product.product_id', '=', 'products.id')
					->leftJoin('devolutions', 'products.id', '=', 'devolutions.product_id')										
					->groupBy('products.name')													
					->select(DB::raw('products.name as product'), DB::raw('coalesce(sum(order_product.amount),0) as ordered_products'))
					->where('devolutions.id', null)
					;
					
		$answers = DB::table('answers')
						->join('questions', 'questions.id', '=', 'answers.question_id')
						->groupBy('questions.question')
						->select(DB::raw('questions.question as question'), DB::raw('coalesce(avg(answers.score),0) as score'));
						
						
		//total monto devuelto
		$total_monto_devuelto = DB::table('devolutions')					
					->join('orders', 'orders.id', '=', 'devolutions.order_id')	
					->join('order_product', 'order_product.order_id', '=', 'orders.id')																							
					->join('products', 'devolutions.product_id', '=', 'products.id')																							
					
					->select(DB::raw('sum(products.price * order_product.amount) as total'))
					;
							
		//aplicación de filtro de año a consultas en caso de que viniera el año  como parámetro en el request
		if ($request->year){
			$amounts_orders = $amounts_orders->whereBetween('orders.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$productos_ordenados = $productos_ordenados->whereBetween('orders.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$total_orders = $total_orders->whereBetween('orders.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$total_envios = $total_envios->whereBetween('orders.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$total_devoluciones = $total_devoluciones->whereBetween('devolutions.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$total_productos_ordenados = $total_productos_ordenados->whereBetween('orders.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$productos_devueltos = $productos_devueltos->whereBetween('devolutions.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$top10_productos = $top10_productos->whereBetween('orders.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$answers = $answers->whereBetween('answers.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$total_monto_devuelto= $total_monto_devuelto->whereBetween('devolutions.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
			
			$total_devoluciones_reason = $total_devoluciones_reason->whereBetween('devolutions.created_at', [$request->year. '-01-01', $request->year . '-12-31']);
		}
		
		
		$amounts_orders = $amounts_orders->get();
		$productos_ordenados = $productos_ordenados->get();
		$productos_devueltos = $productos_devueltos->get();	
		$answers = $answers->get();
		$top10_productos = $top10_productos->orderBy('ordered_products', 'desc')->get();	
	
		$total_productos_ordenados = $total_productos_ordenados->get();
		$total_productos_ordenados = $total_productos_ordenados[0]->ordered_products;
		$total_orders = $total_orders->count();
		$total_envios = $total_envios->count();
		$total_devoluciones = $total_devoluciones->count();
		$total_monto_devuelto = $total_monto_devuelto->get();
		$total_devoluciones_reason = $total_devoluciones_reason->get();
		
			
		$parametros = [
			'years' => $years,
			'amounts_orders' => $amounts_orders,
			'total_orders' => $total_orders,			
			'total_shippings' => $total_envios,
			'ordered_products' => $productos_ordenados,
			'total_ordered_products' => $total_productos_ordenados,
			'total_devolutions' => $total_devoluciones,
			'devolutions' => $productos_devueltos,
			'top10_products' => $top10_productos,
			'answers' => $answers,
			'total_monto_devuelto' => $total_monto_devuelto[0]->total,
			'devolutions_reasons' => $total_devoluciones_reason,
		];
        return view('reports.index', $parametros);
    }
}
