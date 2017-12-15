<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    public function index()
    {
		$categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }
	
	public function create()
    {
        return view('categories.create');		
    }
	
	public function store(Request $request){
		$this->validate(
			$request, 
			[
				'description' => 'required|string|min:1|',				
			],
			[
				'description.required' => 'Campo requerido',
				'description.min' => 'Campo requerido',				
			]
		);
		$category = new Category;
		$category->description = $request->input('description');
		$category->save();
		return redirect()->route('categories_index');
	}
	
	public function destroy(Category $category)
    {
        $category->delete();	
		return redirect()->route('categories_index');		
    }
	
}
