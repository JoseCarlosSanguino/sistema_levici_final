<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Customer;
use app\Models\Operationtype;
use app\Models\Operation;
use app\Models\Product;
use app\Models\Cylinder;
use app\Models\Sale;

use PDF;
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $operationtype_id = 13;
        $perPage = 25;

        if (!empty($keyword)) 
        {
            $operations = Sale::whereHas("operation", function($q){
                $q->where('operationtype_id','=', 13);
            })
                ->WhereHas("customer", function($q) use ($keyword){
                    $q->where('name','like', '%'.$keyword.'%');
                })
                ->orWhereHas("operation", function($q) use ($keyword){
                    $q->where('number','=', $keyword);
                })
                ->with(['customer','operation'])
                ->latest()
                ->paginate($perPage);
        }
        else
        {
            $operations = Sale::whereHas("operation", function($q){
                $q->where('operationtype_id','=', 13);
            })
                ->with(['customer','operation'])
                ->latest()
                ->paginate($perPage);
        }

        $modelName = 'Remito';
        $title      = 'Listado de ' . $modelName;
        $controller = 'sales';

        return view('sales.index',compact('operations', 'title', 'modelName', 'controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title              = 'REMITO';
        $modelName          = 'Venta';
        $controller         = 'sales';
        $operationtype_id   = ($request->input('operationtype_id'))?$request->input('operationtype_id'):13;

        return view('sales.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'operationtype_id'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validatedData = $request->validate([
            'customer_id' => 'required|numeric',
            'date_of'     => 'required'
        ]);

        //remito
        $data['user_id'] = \Auth::user()->id;
        if($data['operationtype_id'] == 13)
        {
            if(!isset($data['status_id']))
            {
                $data['status_id'] = Sale::STATUS['REM_PENDIENTE'];
            }
            $data['conditions']= Sale::CONDITION['CTACTE'];
        }

        try {
            DB::beginTransaction();
            $operation = new Operation($data);
            $operation->save();

            $sale = new Sale($data);
            $sale->operation_id = $operation->id;
            $sale->save();

            //products
            foreach($data['product_id'] as $idx => $prod_id)
            {
                $prod = Product::find($prod_id);
                $operation->products()->save($prod, [
                    'quantity'  => $data['product_quantity'][$idx],
                    'price'     => $data['product_price'][$idx]
                ]);
                $subtotal = floatval($data['product_price'][$idx]) * floatval($data['product_quantity'][$idx]);
                $operation->amount = floatval($operation->amount) + $subtotal;
            }
            $operation->save();

            //cylinders
            if(isset($data['cylinder_id']))
            {
                foreach($data['cylinder_id'] as $cyl_id)
                {
                    $cyl = Cylinder::find($cyl_id);
                    $operation->cylinders()->save($cyl);
                    $cyl->status_id = $cyl::STATUS['EN CLIENTE'];
                    $cyl->save();
                }
            }

            DB::commit();


        } catch (\Exception $e){
            DB::rollBack();
        }

        //return redirect('sales/create')->with('operationtype_id', $data['operationtype_id']);
        return redirect('sales');

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


    public function remitoPDF($id)
    {
        $sale = Sale::find($id);

        //return view('sales.pdf.remito', compact('sale'));

        $pdf = PDF::loadView('sales.pdf.remito', compact('sale'));
        return $pdf->stream('remito_'.$sale->operation->fullNumber.'.pdf');

    }

    /**
     * Show operation's next number
     *
     * @return \Illuminate\Http\Response
     */
    public function nextNumber(Request $request)
    {
        $lastId = Operation::where('operationtype_id',$request->input('operationtype_id'))
                        ->where('pointofsale', $request->input('pointofsale'))
                        ->max('id');
        if(is_null($lastId))
        {
            $nextNumber = 1;
        }
        else
        {
            $nextNumber = Operation::find($lastId)->number+1;
        }
        return response()->json($nextNumber);
    }
}
