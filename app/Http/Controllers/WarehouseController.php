<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Warehouse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $warehouses = Warehouse::latest()->get();
        return view('Warehouse.warehouse', compact('warehouses'));
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
            'warehouse_name' => 'required',
            'location' => 'required'
        ]);

        try{

            $product = Warehouse::create($request->all());

            if($product){
                return redirect()->route('warehouse.index')->with('success', 'Warehouse added successfully!');
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
        $inventories = Inventory::with('products')->where('warehouse_id', $id)->get();
        $warehouses = Warehouse::where('id', $id)->get();
        return view('Warehouse.detail', compact('warehouses', 'inventories'));
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
        $warehouse = Warehouse::where('id', $id)->firstOrFail();
        return response()->json([
            'data' => $warehouse
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
            $warehouse = Warehouse::where('id', $id)->firstOrFail()->update($request->all());

            if($warehouse){
                return redirect()->route('warehouse.index')->with('success', 'Warehouse edited successfully!');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $warehouse  = Warehouse::where('id', $id)->firstOrFail()->delete();
        if($warehouse){
            return redirect()->route('warehouse.index')->with('success', 'Warehouse deleted!');
        }else{
            return redirect()->back()->with('error', 'Some problem, please try again!');
        }
    }
}
