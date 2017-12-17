<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;
use App\Question;
use App\Reason;
use App\Order;
use App\Answers;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// $this->call(UsersTableSeeder::class);
		$totalUsuarios = 100;
		$totalCategorias = 20;
        $totalProductosPorCategoria = 20;
		$totalMotivosDevolucion = 10;
		
		//usuario administrador
		DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
			'password' => bcrypt('admin'),
			'is_admin' => true
        ]);
		
		//usuarios
		$users = factory(User::class, $totalUsuarios)->create();
		
		//categorías y productos
		$categories = factory(Category::class, $totalCategorias)->create()->each(function ($category) {
			//asociar productos a categorías
			for ($i = 0; $i < 20; $i++)
				$category->products()->save(factory(Product::class)->make());
		});
		
		//motivos de devolución
		$reasons = factory(Reason::class, $totalMotivosDevolucion)->create();
		
		//creación de preguntas para encuestas
		$totalPreguntas = 5;
		$questions = factory(Question::class, $totalPreguntas)->create();
		
		//creación de órdenes de usuarios
		foreach($users as $user){
			//cantidad de órdenes del usuario
			$cantidadOrdenes = rand(1, 20);
			//asociar órdenes al usuario
			for ($i = 0; $i < $cantidadOrdenes; $i++)
				$user->orders()->save(factory(Order::class)->make());
			
			foreach($user->orders as $order){
				//asociar productos a las ordenes
				$cantidadProductosOrden = rand(1, 5);
				$productos = [];
				for($i= 0; $i < $cantidadProductosOrden; $i++){
					array_push($productos, rand(1, $totalCategorias * $totalProductosPorCategoria - 2));
				}
				$order->products()->sync($productos);
				
				//crear envío de órden
				$fechaEnvio = $order->created_at;
				date_add($fechaEnvio, date_interval_create_from_date_string(rand(2, 15) . ' days'));
				
				$fechaEstimadaArribo = $order->created_at;
				date_add($fechaEstimadaArribo, date_interval_create_from_date_string(rand(2, 20) . ' days'));
				
				DB::table('shippings')->insert([
					'order_id' => $order->id,
					'created_at' => $fechaEnvio,
					'updated_at' => $fechaEnvio,
					'arrives_at' => $fechaEstimadaArribo,				
				]);
				
				//crear recepción de órden
				$fechaRecepcion = $fechaEstimadaArribo;
				date_add($fechaEstimadaArribo, date_interval_create_from_date_string(rand(0, 5)-1 . ' days'));
				DB::table('receptions')->insert([
					'order_id' => $order->id,
					'created_at' => $fechaRecepcion,
					'updated_at' => $fechaRecepcion,									
				]);
				
				//crear devolución  (5% de probabilidad)				
				if (rand(1,100) <= 5){
					$fechaDevolucion = $fechaRecepcion;
					date_add($fechaEstimadaArribo, date_interval_create_from_date_string(rand(0, 5). ' days'));
					
					DB::table('devolutions')->insert([
						'order_id' => $order->id,
						'created_at' => $fechaDevolucion,
						'updated_at' => $fechaDevolucion,
						'reason_id' => rand(1, $totalMotivosDevolucion),
						'product_id' => $order->products->first()->id,
					]);
				}
				
				//responder preguntas encuesta (40% de probabilidad)
				if (rand(1,100) <= 40){
					$fechaRespuesta = $order->created_at;
					if (rand(1,10)<6)
						$fechaRespuesta = $fechaRecepcion;
					
					foreach($questions as $question){
						DB::table('answers')->insert([
							'user_id' => $user->id,
							'question_id' => $question->id,
							'created_at' => $fechaRespuesta,
							'updated_at' => $fechaRespuesta,	
							'score' => rand(1,5),
						]);
					}
				}
			}
		}				
    }
}
