<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Customer;
use app\Models\Operationtype;
use app\Models\Operation;
use app\Models\Product;
use app\Models\Cylinder;
use app\Models\Cylindermove;
use app\Models\Sale;

use DB;
use app\Libs\My_fpdf;
use URL;
use Fpdf\Fpdf;

class RemitoController extends Controller
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
        $controller = 'remitos';

        return view('remitos.index',compact('operations', 'title', 'modelName', 'controller'));
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
        $controller         = 'remitos';
        $operationtype_id   = ($request->input('operationtype_id'))?$request->input('operationtype_id'):13;

        return view('remitos.create',compact( 
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
            $operation->pointofsale = $operation->operationtype->pointofsale;
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

                $prod->stock = $prod->stock - $data['product_quantity'][$idx];
                $prod->save();
            }
            $operation->save();

            //cylinders
            if(isset($data['cylinder_id']))
            {
                foreach($data['cylinder_id'] as $cyl_id)
                {
                    $cyl = Cylinder::find($cyl_id);
                    if(!is_null($cyl))
                    {
                        $operation->cylinders()->save($cyl);
                        $cyl->status_id = $cyl::STATUS['EN CLIENTE'];
                        $cyl->save();

                        //mov
                        $cylmove = NEW Cylindermove([
                            'person_id'  => $sale->customer_id,
                            'movetype_id'=> Cylindermove::MOVETYPE['ENVIO_A_CLIENTE'],
                            'date_of'    => date('d/m/Y H:i:s')
                        ]);
                        $cyl->moves()->save($cylmove);
                    }
                }
            }

            DB::commit();


        } catch (\Exception $e){
            DB::rollBack();
        }

        //return redirect('sales/create')->with('operationtype_id', $data['operationtype_id']);
        return redirect('remitos');

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


    public function remitoPDFOld($id)
    {


        $sale = Sale::find($id);

        $bd = 0; //border debug
        //empiezo a crear el archivo PDF    

        $pdf = new My_fpdf('p','mm');

        $pdf->SetMargins(0,0,0);
        $pdf->SetAutoPageBreak(false);

        $pages = ['ORIGINAL','DUPLICADO'];
            
        foreach($pages as $page)
        {

            $pdf->Addpage();
            //$pdf->cMargin = 0;
            $pdf->SetFont('Times','B',14);
            $pdf->SetLineWidth(0.4);
      
            //marco exterior
            //pagina
            $pdf->setXY(5,5);
            $pdf->Cell(200, 10,$page,1,0,'C');
            $pdf->Ln();
            
            /*
            * CABECERA
            */
            $pdf->setXY(5,5);
            $pdf->Cell(200, 52,"",1);
            $pdf->Ln();


            //X (tipo de documento)
            $pdf->setFont('Courier','B',30);
            $pdf->setXY(99,15);
            $pdf->Cell(12,12,$sale->operation->operationtype->letter,1,0,"C");
            $pdf->Line(105,27,105,57);

            //logo
            $pdf->image('img/logo.jpg', 8,18,40,37);
            $pdf->setXY(6,16);
            
            //titulo
            $pdf->setFont('Arial','B',18);
            $pdf->setXY(115,16);
            $pdf->Cell(86,6,'REMITO', $bd, 0,'C');
                
            //info empresa
            $pdf->SetFont('Times','',9);
            $pdf->SetXY(48,25);
            $info = utf8_decode('Administración: Patricios 256. (5507) Luján de Cuyo. Mendoza. Base: Terrada y callejón Los Olivos 1. Perdriel. Luján de Cuyo. Mendoza. Tel: 0261 4987490 / 261 534-4469. E-mail: levicigroupsa@gmail.com');
            
            $pdf->MultiCell(51,4,$info,$bd,'R');
            $pdf->SetXY(48,52);
            $pdf->Cell(55,4, 'IVA RESPONSABLE INSCRIPTO', $bd,0,'C');
            
            $pdf->SetXY(120,40);
            $info2 = utf8_decode("CUIT: 30-71434762-0\n Ingresos Brutos: 0698400 \n Establecimiento Nº 06-0698400-00\nInicio de actividades: 15/01/2014.");
            $pdf->MultiCell(70,4,$info2,$bd,'C');
            
            
            
            //numero
            $pdf->setFont('Arial','B',18);
            $pdf->SetXY(120,24);
            $pdf->Cell(35,6,utf8_decode("Nº: ") ,$bd);
            $pdf->Cell(40,6,$sale->operation->fullNumber, $bd, 0,'R');
            
            //fecha
            $pdf->SetXY(120,31);
            $pdf->Cell(35,6,"FECHA: ", $bd,0);
            $pdf->Cell(40,6,$sale->operation->date_of, $bd,0,'R');
            $pdf->Ln();
                    

            /*
            * DATOS DEL CLIENTE
            */
            $pdf->SetXY(5,58);
            $pdf->Cell(200,20,"",1);

            $pdf->SetXY(6,59);
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
            $pdf->Cell(177,6,$sale->customer->address .  ' - ' .' ('. $sale->customer->province->province .')', $bd);
            $pdf->Ln();
            $pdf->SetX(6);
            //CUIT
            $pdf->setFont('Times','',13);
            $pdf->Cell(15,6,utf8_decode("CUIT: "), $bd);
            $pdf->setFont('Times','B',13);
            $pdf->Cell(183,6,$sale->customer->cuit, $bd);

            $pdf->Ln();
            $pdf->SetX(6);

            /** 
             * Transportista
             * 
             */

            $pdf->SetXY(5,79);
            $pdf->Cell(200,20,"",1);
            $pdf->SetXY(6,80);
            
            $pdf->setFont('Times','',13);
            $pdf->Cell(45,6,utf8_decode("Señor(es) transportista: ") , $bd);
            $pdf->setFont('Times','B',13);
            $pdf->Cell(153,6,'',$bd);
            $pdf->Ln();
            $pdf->SetX(6);
            //direccion
            $pdf->setFont('Times','',13);
            $pdf->Cell(21,6,utf8_decode("Dirección: "), $bd);
            $pdf->setFont('Times','B',13);
            $pdf->Cell(177,6,'', $bd);
            $pdf->Ln();
            $pdf->SetX(6);
            //CUIT
            $pdf->setFont('Times','',13);
            $pdf->Cell(15,6,utf8_decode("CUIT: "), $bd);
            $pdf->setFont('Times','B',13);
            $pdf->Cell(183,6,'', $bd);
            /*
            * DETALLE DE LA FACTURA
            */
            
            $pdf->setXY(5,100);
            $pdf->SetFont('Times','',12);
            $pdf->Cell(175,8,utf8_decode("Descripción del contenido"), 1,0,'C');
            $pdf->Cell(25,8,"Cantidad",1,0,'C');

            $pdf->SetLineWidth(0.2);
            $pdf->Line(5,101,5,260);
            $pdf->Line(180,101,180,260);
            $pdf->Line(205,101,205,260);
            
            $pdf->SetXY(5,108);
            $pdf->setFont('Times','',12);

            $quantity = 0;
            foreach($sale->operation->products as $det)
            {
                if(count($det->cylindertypes) == 0)
                {
                    $pdf->setX(5);
                    $pdf->Cell(171,6,$det->product . $det->descripcion, $bd, 0);
                    $pdf->Cell(29, 6, $det->pivot->quantity, $bd, 0, 'C');
                    $pdf->Ln();
                    $quantity = $quantity + $det->pivot->quantity;
                }
            }

            foreach($sale->operation->cylinders as $cyl)
            {
                $pdf->setX(5);
                $pdf->Cell(171,6,$cyl->cylindertype->products[0]->product . '. Cod: ' . $cyl->code . '. Capacidad: ' . $cyl->cylindertype->capacity . $cyl->cylindertype->products[0]->unittype->abrev , $bd, 0);
                $pdf->Cell(29,6,1,$bd, 0,'C');
                $pdf->Ln();
                $quantity++;
            }

            $pdf->SetXY(5,260);
            $pdf->SetFont('Times','B',16);
            $pdf->Cell(175,12,"TOTAL",1,0,'R');
            $pdf->Cell(25,12, $quantity,1,0,'C');



            $pdf->SetXY(5,260);
            
            $barcode = env('AFIP_CUIT') . $sale->operation->operationtype->afip_id . str_pad($sale->operation->operationtype->pointofsale,4,0,STR_PAD_LEFT) . $sale->cae_number . str_replace('/','',$sale->cae_expired) . '6';

            $pdf->i25(10,277,$barcode,0.5,8);

            $pdf->SetXY(130,278);
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(40, 5, utf8_decode('CAE Nº: '),0,0,'R');
            $pdf->SetFont('Times','',12);
            $pdf->Cell(40, 5, $sale->cae_number,0,0);
            $pdf->Ln();
            $pdf->SetXY(130,283);
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(40, 5, 'Fecha de vencimiento de CAE: ',0,0,'R');
            $pdf->SetFont('Times','',12);
            $pdf->Cell(40, 5, $sale->cae_expired,0,0);

        }

        

        $pdf->Output();
        exit();

    }



    public function remitoPDF($id)
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
        
        /*
        //marco exterior
        $pdf->SetLineWidth(0.5);
        $pdf->setXY(5,5);
        $pdf->Cell(200, 287,"",1);
        $pdf->Ln();
        $pdf->setXY(10,15);
        $pdf->SetLineWidth(0.4);
        */
        /*
        * CABECERA
        */
        /*
        //X (tipo de documento)
        $pdf->setFont('Courier','B',30);
        $pdf->setXY(101,5);
        $pdf->Cell(8,12,"X",1,0,"C");
        $pdf->Line(109,5,109,47);

        //logo
        //$pdf->image(URL::to('img/logo.jpeg'), 12,7,0,12);
        $pdf->setXY(6,6);
        $pdf->Cell(40,40, 'LOGO',1);
        
        //titulo
        $pdf->setFont('Arial','B',18);
        $pdf->setXY(115,8);
        $pdf->Cell(28,6,"REMITO",$bd);
            
        //info empresa
        $pdf->SetFont('Times','',9);
        $pdf->SetXY(48,15);
        $info = utf8_decode('Administración: Patricios 256. (5507) Luján de Cuyo. Mendoza. Base: Terrada y callejón Los Olivos 1. Perdriel. Luján de Cuyo. Mendoza. Tel: 0261 4987490 / 261 534-4469. E-mail: levicigroupsa@gmail.com');
        
        $pdf->MultiCell(51,4,$info,$bd,'R');
        $pdf->SetXY(48,42);
        $pdf->Cell(55,4, 'IVA RESPONSABLE INSCRIPTO', $bd,0,'C');
        
        $pdf->SetXY(120,26);
        $info2 = utf8_decode("CUIT: 30-71434762-0\n Ingresos Brutos: 0698400 \n Establecimiento Nº 06-0698400-00\nInicio de actividades: 15/01/2014.\n DOCUMENTO NO VALIDO COMO FACTURA");
        $pdf->MultiCell(70,4,$info2,$bd,'C');
        
        
        
        //numero
        $pdf->setFont('Arial','B',18);
        $pdf->SetXY(146,8);
        $pdf->Cell(13,6,utf8_decode("Nº ") . $sale->operation->fullNumber,$bd);
        */
        //fecha
        $pdf->SetXY(145,28);
        //$pdf->Cell(38,6,"FECHA: ", $bd,0);
        $pdf->setFont('Arial','B',14);
        $pdf->Cell(20,6,$sale->operation->date_of, $bd,0,'C');
        $pdf->Ln();
                
        //linea divisora
        //$pdf->Line(5,47,205,47);

        /*
        * DATOS DEL CLIENTE
        */
        $pdf->SetXY(50,50);
        //cliente
        //$pdf->setFont('Times','',13);
        //$pdf->Cell(45,6,utf8_decode("Señor(es) destinatarios: ") , $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(153,7,$sale->customer->name,$bd);
        $pdf->Ln();
        $pdf->SetX(30);
        //direccion
        //$pdf->setFont('Times','',13);
        //$pdf->Cell(21,6,utf8_decode("Dirección: "), $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(177,7,$sale->customer->address .  ' - ' .' ('. $sale->customer->province->province .')', $bd);
        $pdf->Ln();
        $pdf->SetX(25);
        //CUIT
        //$pdf->setFont('Times','',13);
        //$pdf->Cell(15,6,utf8_decode("CUIT: "), $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(183,7,$sale->customer->cuit, $bd);
        //$pdf->Line(5,67,205,67);

        /*
        * DATOS DEL TANSPORTISTA
        */
        /*
        $pdf->SetXY(6,68);
        //cliente
        $pdf->setFont('Times','',13);
        $pdf->Cell(45,6,utf8_decode("Señor(es) transportista: ") , $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(153,6,'',$bd);
        $pdf->Ln();
        $pdf->SetX(6);
        //direccion
        $pdf->setFont('Times','',13);
        $pdf->Cell(21,6,utf8_decode("Dirección: "), $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(177,6,'', $bd);
        $pdf->Ln();
        $pdf->SetX(6);
        //CUIT
        $pdf->setFont('Times','',13);
        $pdf->Cell(15,6,utf8_decode("CUIT: "), $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(183,6,'', $bd);
        
        $pdf->Line(5,87,205,87);
        */
        /*
        * DETALLE DEL PRESUPUESTO
        */
        
        /*
        $pdf->setXY(5,87);
        $pdf->SetFont('Times','B',13);
        $pdf->Cell(171,6,"DESCRIPCION DEL CONTENIDO",1,0,'C');
        $pdf->Line(176,87,176,292);
        $pdf->Cell(29,6,"CANTIDAD",1,0,'C');
        */

        $pdf->SetFont('Times','',13);
        $pdf->SetLineWidth(0.2);

        $pdf->SetXY(10,106);
        $pdf->setFont('Times','',12);

        $quantity = 0;
        $total = 0;

        foreach($sale->operation->products as $det)
        {
            if(count($det->cylindertypes) == 0)
            {
                $pdf->setX(10);
                $pdf->Cell(171,6,$det->product . $det->descripcion, $bd, 0);
                $pdf->Cell(29, 6, $det->pivot->quantity, $bd, 0, 'C');
                $pdf->Ln();
                $quantity = $quantity + $det->pivot->quantity;
            }
            $total = $total + ($det->pivot->quantity * $det->pivot->price);
    	}

    	foreach($sale->operation->cylinders as $cyl)
    	{
    		$pdf->setX(5);
    		$pdf->Cell(171,6,$cyl->cylindertype->products[0]->product . '. Cod: ' . $cyl->code . '. Capacidad: ' . $cyl->cylindertype->capacity . $cyl->cylindertype->products[0]->unittype->abrev , $bd, 0);
    		$pdf->Cell(29,6,1,$bd, 0,'C');
    		$pdf->Ln();
            $quantity++;
    	}

        $pdf->SetFont('Times','B',16);
        $pdf->SetXY(45,254);
        $pdf->Cell(50,12, 'Valor declarado: $' . number_format($total,2,',','.'),0,0,'C');
        $pdf->SetXY(170,257);
        $pdf->Cell(29,12, $quantity,0,0,'C');

        $pdf->Output();
        exit();

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
