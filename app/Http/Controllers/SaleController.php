<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Customer;
use app\Models\Operationtype;
use app\Models\Operation;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    /**
     * REMITOS
     */

    /**
     * Show the form for creating a new remito.
     *
     * @return \Illuminate\View\View
     */
    public function orderCreate()
    {
        $title      = 'Orden de entrega';
        $modelName  = 'Venta';
        $controller = 'Sale';
        $customers  = Customer::where('persontype_id','=',1)->orderBy('name')->pluck('name','id');
        $letter     = Operationtype::find(14)->letter;
        $number     = Operation::where('operationtype_id','=',14)->max('number');

        return view('sales.ordercreate',compact( 
            'title', 
            'modelName', 
            'controller',
            'customers',
            'number'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function orderStore(Request $request)
    {
        $this->validate($request, [
            'code'          => 'required|unique:products|max:32',
            'product'       => 'required|max:32',
            'ivatype_id'    => 'required',
            'producttype_id'=> 'required'
            ]);
    
        $requestData = $request->all();
        Product::create($requestData);

        return redirect('products')->with('flash_message', 'Producto creado!');
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
    }
}
