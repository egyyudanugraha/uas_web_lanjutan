<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::latest()->get();
        return view('Category.category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'category_name' => 'required'
        ]);

        try{

            $product = Category::create($request->all());

            if($product){
                return redirect()->route('category.index')->with('success', 'Category added successfully!');
            }else{
                return redirect()->back()->with('error', 'Some problem, please try again!');
            }

        } catch(QueryException $e) {
    
            if($e->errorInfo[1] == 1062) {
    
                return redirect()->back()->with('error', 'Category already exists');
    
            } else {
                throw $e;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category = Category::with('products')->where('id', $id)->get();

        // return response()->json([
        //     'data' => $category
        // ]);
        return view('Category.detail', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = Category::where('id', $id)->firstOrFail();
        return response()->json([
            'data' => $category
          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try{
            $category = Category::where('id', $id)->firstOrFail()->update($request->all());

            if($category){
                return redirect()->route('category.index')->with('success', 'Category edited successfully!');
            }else{
                return redirect()->back()->with('error', 'Some problem, please try again!');
            }
        } catch(QueryException $e) {
        
            if($e->errorInfo[1] == 1062) {

                return redirect()->back()->with('error', 'Category already exists');

            } else {
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::where('id', $id)->firstOrFail()->delete();
        if($category){
            return redirect()->route('category.index')->with('success', 'Category deleted!');
        }else{
            return redirect()->back()->with('error', 'Some problem, please try again!');
        }
    }
}
