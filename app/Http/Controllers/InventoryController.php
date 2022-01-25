<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inventories = Inventory::with('products', 'warehouses')->get();

        return view('Inventory.inventory', compact('inventories'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $prod = Product::latest()->get(); // Add
        $ware = Warehouse::latest()->get(); // Add
        return response()->json([
            'products' => $prod,
            'warehouses' => $ware
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
            'warehouse_id' => 'required',
            'product_id' => 'required',
            'stock' => 'required'
        ]);

        try{

            if($request->warehouse_id)

            $product = Inventory::create($request->all());

            if($product){
                return redirect()->route('inventory.index')->with('success', 'Inventory added successfully!');
            }else{
                return redirect()->back()->with('error', 'Some problem, please try again!');
            }

        } catch(QueryException $e) {
    
            if($e->errorInfo[1] == 1062) {
    
                return redirect()->back()->with('error', 'Warehouse already exists');
    
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
        $inventories = Inventory::with('warehouses')->where('product_id', $id)->get();
        $products = Product::where('id', $id)->get();
        return view('Inventory.detail', compact('products', 'inventories'));
        // return response()->json([
        //     'products' => $products,
        //     'inventories' => $inventories
        // ]);
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
        $inven = Inventory::where('id', $id)->firstOrFail();
        $prod = Product::latest()->get();
        $ware = Warehouse::latest()->get();
        return response()->json([
            'inventory' => $inven,
            'products' => $prod,
            'warehouses' => $ware
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
            $inventory = Inventory::where('id', $id)->firstOrFail()->update($request->all());

            if($inventory){
                return redirect()->route('inventory.index')->with('success', 'Inventory edited successfully!');
            }else{
                return redirect()->back()->with('error', 'Some problem, please try again!');
            }
        } catch(QueryException $e) {
        
            if($e->errorInfo[1] == 1062) {

                return redirect()->back()->with('error', 'Inventory already exists');

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
        $inventory  = Inventory::where('id', $id)->firstOrFail()->delete();
        if($inventory){
            return redirect()->route('inventory.index')->with('success', 'Inventory deleted!');
        }else{
            return redirect()->back()->with('error', 'Some problem, please try again!');
        }
    }
}
