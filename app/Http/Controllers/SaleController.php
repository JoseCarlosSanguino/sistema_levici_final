<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Customer;
use app\Models\Operationtype;
use app\Models\Groupoperationtype;
use app\Models\Operation;
use app\Models\Product;
use app\Models\Cylinder;
use app\Models\Cylindermove;
use app\Models\Sale;
use App;

use DB;
use Fpdf\Fpdf;
use URL;

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
        $operationtype_id = 1;
        $perPage = 25;

        if (!empty($keyword)) 
        {
            $operations = Sale::whereHas("operation", function($q){
                $q->wherein('operationtype_id',[1,2,3]);
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
                $q->wherein('operationtype_id',[1,2,3]);
            })
                ->with(['customer','operation'])
                ->latest()
                ->paginate($perPage);
        }

        $modelName = 'Facturas';
        $title      = 'Listado de ' . $modelName;
        $controller = 'facturas';

        return view('sales.index',compact('operations', 'title', 'modelName', 'controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title              = 'FACTURA';
        $modelName          = 'Venta';
        $controller         = 'facturas';
        $operationtype_id   = ($request->input('operationtype_id'))?$request->input('operationtype_id'):1;
        $groupoperationtypes= Groupoperationtype::whereIn('id',[1,3,4])->pluck('groupoperationtype','id');

        return view('sales.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'operationtype_id',
            'groupoperationtypes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function facturarRemito($id)
    {
        $title              = 'FACTURA';
        $modelName          = 'Venta';
        $controller         = 'facturas';
        $remito             = Sale::find($id);

        //ordernar esta negrada
        $ot = Operationtype::WhereHas("ivaconditions", function($q) use ($remito){
                        $q->where('ivacondition_id', $remito->customer->ivacondition_id);
                    })
                ->where('groupoperationtype_id', 1)
                ->first();
        
        $lastId = Operation::where('operationtype_id',$ot->id)
                            ->max('id');
        if(is_null($lastId))
        {
            $number = 1;
        }
        else
        {
            $number = Operation::find($lastId)->number+1;
        }
        $number = $ot->letter . '0002-' . str_pad($number,9,'0',STR_PAD_LEFT);
        $operationtype_id = $ot->id;
        
        $groupoperationtypes= Groupoperationtype::whereIn('id',[1,3,4])->pluck('groupoperationtype','id');

        return view('sales.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'groupoperationtypes',
            'remito',
            'number',
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
            'customer_id'           => 'required|numeric',
            'date_of'               => 'required',
            'groupoperationtype_id' => 'required'
        ]);

        //factura / nota de credito / nota de debito
        $data['user_id'] = \Auth::user()->id;

        //limpio el numero
        $data['number']      = explode('-',$data['number'])[1];
        $data['pointofsale'] = substr(explode('-', $data['number'])[0],-1);

        if($data['conditions'] == 'cta cte')
        {
            $data['status_id'] = Sale::STATUS['VTA_PENTIENTE'];
        }
        else
        {
            $data['status_id'] = Sale::STATUS['VTA_COBRO_TOTAL'];
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

                if(($data['remito_id']!= null))
                {
                    $prod->stock = $prod->stock - $data['product_quantity'][$idx];
                    $prod->save();
                }
              
            }
            $operation->save();

            //cancelamos el remito
            if(($data['remito_id']!= null))
            {
                $remito = Sale::find($data['remito_id']);
                $remito->operation->status_id = Sale::STATUS['REM_CANCELADO'];
                $remito->operation->save();
            }

            DB::commit();


        } catch (\Exception $e){
            dd($e);
            DB::rollBack();
        }

        //return redirect('sales/create')->with('operationtype_id', $data['operationtype_id']);
        return redirect('facturas');

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


    public function salePDF($id)
    {

        $sale = Sale::find($id);

        $bd = 0; //border debug
        //empiezo a crear el archivo PDF    

        $pdf = new fpdf('p','mm');

        $pdf->SetMargins(0,0,0);
        $pdf->SetAutoPageBreak(false);
            
        $pdf->Addpage();
        //$pdf->cMargin = 0;
        $pdf->SetFont('Times','',10);
        
        //marco exterior
        $pdf->SetLineWidth(0.6);
        $pdf->setXY(5,5);
        $pdf->Cell(200, 287,"",1);
        $pdf->Ln();
        $pdf->setXY(10,15);
        $pdf->SetLineWidth(0.5);

        /*
        * CABECERA
        */

        //X (tipo de documento)
        $pdf->setFont('Courier','B',30);
        $pdf->setXY(101,5);
        $pdf->Cell(8,12,$sale->operation->operationtype->letter,1,0,"C");
        $pdf->Line(109,5,109,47);

        //logo
        //$pdf->image(URL::to('img/logo.jpeg'), 12,7,0,12);
        $pdf->setXY(6,6);
        $pdf->Cell(40,40, 'LOGO',1);
        
        //titulo
        $pdf->setFont('Arial','B',18);
        $pdf->setXY(115,8);
        $pdf->Cell(28,6,"FACTURA",$bd);
            
        //info empresa
        $pdf->SetFont('Times','',9);
        $pdf->SetXY(48,15);
        $info = utf8_decode('Administración: Patricios 256. (5507) Luján de Cuyo. Mendoza. Base: Terrada y callejón Los Olivos 1. Perdriel. Luján de Cuyo. Mendoza. Tel: 0261 4987490 / 261 534-4469. E-mail: levicigroupsa@gmail.com');
        
        $pdf->MultiCell(51,4,$info,$bd,'R');
        $pdf->SetXY(48,42);
        $pdf->Cell(55,4, 'IVA RESPONSABLE INSCRIPTO', $bd,0,'C');
        
        $pdf->SetXY(120,26);
        $info2 = utf8_decode("CUIT: 30-71434762-0\n Ingresos Brutos: 0698400 \n Establecimiento Nº 06-0698400-00\nInicio de actividades: 15/01/2014.");
        $pdf->MultiCell(70,4,$info2,$bd,'C');
        
        
        
        //numero
        $pdf->setFont('Arial','B',18);
        $pdf->SetXY(146,8);
        $pdf->Cell(13,6,utf8_decode("Nº ") . $sale->operation->fullNumber,$bd);
        
        //fecha
        $pdf->SetXY(115,17);
        $pdf->Cell(38,6,"FECHA: ", $bd,0);
        $pdf->Cell(20,6,$sale->operation->date_of, $bd,0,'C');
        $pdf->Ln();
                
        //linea divisora
        $pdf->Line(5,47,205,47);

        /*
        * DATOS DEL CLIENTE
        */
        $pdf->SetXY(6,48);
        //cliente
        $pdf->setFont('Times','',13);
        $pdf->Cell(45,6,utf8_decode("Señor(es) destinatarios: ") , $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(153,6,$sale->customer->name,$bd);
        $pdf->Ln();
        $pdf->SetX(6);
        //direccion
        $pdf->setFont('Times','',13);
        $pdf->Cell(21,6,utf8_decode("Dirección: "), $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(177,6,$sale->customer->address .  ' - ' . ' ('. $sale->customer->province->province .')', $bd);
        $pdf->Ln();
        $pdf->SetX(6);
        //CUIT
        $pdf->setFont('Times','',13);
        $pdf->Cell(15,6,utf8_decode("CUIT: "), $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(183,6,$sale->customer->cuit, $bd);
        $pdf->Line(5,67,205,67);

        
        /*
        * DETALLE DEL PRESUPUESTO
        */
        
        $pdf->setXY(5,87);
        $pdf->SetFont('Times','B',13);
        $pdf->Cell(30,6,"CODIGO", 1,0,'C');
        $pdf->Cell(83,6,"DESCRIPCION",1,0,'C');
        $pdf->Cell(29,6,"CANTIDAD",1,0,'C');
        $pdf->Cell(29,6,"PRECIO",1,0,'C');
        $pdf->Cell(29,6,"SUBTOTAL",1,0,'C');
        $pdf->Line(176,87,176,292);
        $pdf->Line(35,87,35,292);
        $pdf->Line(118,87,118,292);
        $pdf->Line(147,87,147,292);
        $pdf->Line(176,87,176,292);
        
        $pdf->SetFont('Times','',13);
        $pdf->SetLineWidth(0.2);

        $pdf->SetXY(5,93);
        $pdf->setFont('Times','',12);

        $quantity = 0;
        foreach($sale->operation->products as $det)
        {
            $pdf->setX(5);
            $pdf->Cell(171,6,$det->product . $det->descripcion, $bd, 0);
            $pdf->Cell(29, 6, $det->pivot->quantity, $bd, 0, 'C');
            $pdf->Ln();
            $quantity = $quantity + $det->pivot->quantity;
        }

        $pdf->SetXY(5,272);
        $pdf->SetFont('Times','B',16);
        $pdf->Cell(30,6,"IVA21", 1,0,'C');
        $pdf->Cell(83,6,"IVA105",1,0,'C');
        $pdf->Cell(29,6,"DESCUENTOS",1,0,'C');
        $pdf->Cell(29,6,"TOTAL",1,0,'C');
        $pdf->Cell(171,12,"TOTAL",1,0,'R');
        $pdf->Line(176,87,176,292);
        $pdf->Cell(29,12, $quantity,1,0,'C');

        $pdf->Output();
        exit();

    }

}
