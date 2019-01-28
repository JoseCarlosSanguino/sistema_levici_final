<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;

use app\Models\Paycheck;
use app\Models\Bank;

class PaycheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) 
        {
            $paychecks = Paycheck::where('number', 'LIKE', "%$keyword%")
                ->orWhere('owner_name', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->orWhere('owner_cuit', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $paychecks  = Paycheck::latest()->paginate($perPage);
        }

        $title      = 'Listado de cheques';
        $modelName  = 'Cheque';
        $controller = 'paychecks';

        return view('paychecks.index',compact('paychecks', 'title', 'modelName', 'controller'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title      = 'Nuevo cheque';
        $modelName  = 'Cheque';
        $controller = 'paychecks';
        $banks = Bank::pluck('bank','id');
        return view('paychecks.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'banks'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'number'    => 'required|max:32',
            'amount'    => 'required'
            ]);
    
        $requestData = $request->all();
        $requestData['status_id']  = Paycheck::STATUS['CARTERA'];
        $requestData['receipt']    = date('d/m/Y');

        Paycheck::create($requestData);

        return redirect('paychecks')->with('flash_message', 'Cheque creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un cheque';
        $modelName  = 'Cheque';
        $controller = 'paychecks';

        $paycheck = Paycheck::findOrFail($id);

        return view('paychecks.show', compact('paycheck','title', 'modelName', 'controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un cheque';
        $modelName  = 'Cheque';
        $controller = 'paychecks';

        $paycheck = Paycheck::findOrFail($id);
        $banks = Bank::pluck('bank','id');
        return view('paychecks.edit', compact(
            'paycheck',
            'title', 
            'modelName', 
            'controller', 
            'banks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $paycheck = Paycheck::findOrFail($id);
        $paycheck->update($requestData);

        return redirect('paychecks')->with('flash_message', 'Cheque actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {

        $paycheck = Paycheck::findOrFail($id);
        $paycheck->status_id = Paycheck::STATUS['DEPOSITADO'];
        $paycheck->save();
        //Paycheck::destroy($id);

        return redirect('paychecks')->with('flash_message', 'Cheque depositado!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {

        $data = Paycheck::wherein("status_id", explode(',',$request->input('status_id')))
                    ->get();

        return response()->json($data);
    }
}
