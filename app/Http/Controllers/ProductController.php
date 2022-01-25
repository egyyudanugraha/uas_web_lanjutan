<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::latest()->get();
        return view('Product.product', compact('products'));
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

    public function list_category()
    {
        //
        $category = Category::get();
        return response()->json([
            'categories' => $category
        ]);
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
            'product_id' => 'required',
            'product_name' => 'required',
            'category' => 'required'
        ]);
        try{
            // $product = Product::create($request->all());
            $product = new Product;
            $product->product_name = $request->product_name;
            $product->product_id = $request->product_id;
            $product->save();

            $category = Category::find($request->category);

            $product->categories()->attach($category);

            if($product){
                return redirect()->route('product.index')->with('success', 'Product added successfully!');
            }else{
                return redirect()->back()->with('error', 'Some problem, please try again!');
            }
        } catch(QueryException $e) {

    
            if($e->errorInfo[1] == 1062) {
    
                return redirect()->back()->with('error', 'ID Product already exists');
    
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
        $product = Product::with('categories')->where('product_id', $id)->get();

        // return response()->json([
        //     'data' => $product
        // ]);
        return view('Product.detail', compact('product'));
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
        $product = Product::with('categories')->where('product_id', $id)->firstOrFail();
        return response()->json([
            'data' => $product
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
            $product = Product::where('product_id', $id)->firstOrFail();
            $product->update($request->all());

            $product->categories()->detach();
            
            $category = Category::find($request->category);
            $product->categories()->attach($category);
            

            if($product){
                return redirect()->route('product.index')->with('success', 'Product edited successfully!');
            }else{
                return redirect()->back()->with('error', 'Some problem, please try again!');
            }

        } catch(QueryException $e) {

            if($e->errorInfo[1] == 1062) {
    
                return redirect()->back()->with('error', 'ID Product already exists');
    
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
        $product = Product::where('product_id', $id)->firstOrFail()->delete();
        if($product){
            return redirect()->route('product.index')->with('success', 'Product deleted!');
        }else{
            return redirect()->back()->with('error', 'Some problem, please try again!');
        }
    }
}
