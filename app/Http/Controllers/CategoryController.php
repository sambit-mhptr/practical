<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $categories= Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|min:2', 
            'icon' => 'required'
            ]);

        $cat = new Category();
        $cat->user_id = auth()->user()->id;
        $cat->name = $request->name;
        $cat->icon = $request->icon;
        $cat->save();

        return redirect('/categories')->with('status', 'category created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if(auth()->user()->id != $category->user_id){
            abort('403', 'unauthorized');
        }

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //dd($request->all());
        if(auth()->user()->id != $category->user_id){
            abort('403', 'unauthorized');
        }

        $request->validate([
            'name' => 'required|min:2', 
            'icon' => 'required'
            ]);

        $cat = $category;
        $cat->user_id = auth()->user()->id;
        $cat->name = $request->name;
        $cat->icon = $request->icon;
        $cat->save();

        return redirect('/categories/'.$cat->id.'/edit')->with('status', 'category updated successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if(auth()->user()->id != $category->user_id){
            abort('403', 'unauthorized');
        }
        $category->delete();

        return redirect('/categories')->with('status', 'category deleted successfully');
    }
}
