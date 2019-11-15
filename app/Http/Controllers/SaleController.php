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

use app\Libs\My_afip;
use app\Libs\My_fpdf;

use DB;
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
                $q->wherein('operationtype_id',[1,2,3,15,16,17,18]);
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
                $q->wherein('operationtype_id',[1,2,3,15,16,17,18]);
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
        $sale               = Sale::find($id);

        $groupoperationtypes    = Groupoperationtype::whereIn('id',[1,3,4])->pluck('groupoperationtype','id');
        $ivacondition_id        = $sale->customer->ivacondition_id;
        $groupoperationtype_id  = 1;
        $remito_id              = $id;


        return view('sales.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'groupoperationtypes',
            'sale',
            'remito_id',
            'ivacondition_id',
            'groupoperationtype_id'
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
        $data['number']      = 0;
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
                $iva = ($data['product_price'][$idx] - $data['product_discount'][$idx]) / 100 * $prod->ivatype->percent;
                
                $operation->products()->save($prod, [
                    'quantity'  => $data['product_quantity'][$idx],
                    'price'     => $data['product_price'][$idx],
                    'discount'  => $data['product_discount'][$idx],
                    'iva'       => $iva
                ]);

                if(($data['remito_id']!= null))
                {
                    if($data['groupoperationtype_id'] == 3)
                    {
                        $prod->stock = $prod->stock + $data['product_quantity'][$idx];
                    }
                    else
                    {
                        $prod->stock = $prod->stock - $data['product_quantity'][$idx];
                    }
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

            //afip
            $my_afip = NEW My_afip();
            $afip_auth = $my_afip->generateVoucher($operation);

            $sale->cae_number = $afip_auth['CAE'];
            $sale->cae_expired= $afip_auth['CAEFchVto'];
            $sale->save();

            $operation->number     = $afip_auth['voucher_number'];
            $operation->pointofsale= $operation->operationtype->pointofsale;
            $operation->save();

            DB::commit();



        } catch (\Exception $e){

            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([ $e->getMessage()]);

        }
        
        return redirect('facturas');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $my_afip = NEw My_afip();
        dd($my_afip->afip->ElectronicBilling->GetVoucherTypes());
        
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
            $pdf->Cell(86,6,$sale->operation->operationtype->groupoperationtype->groupoperationtype,$bd, 0,'C');
                
            //info empresa
            $pdf->SetFont('Times','',9);
            $pdf->SetXY(48,25);
            $info = utf8_decode('Administración y base: Terrada y callejón Los Olivos 1. Perdriel. Luján de Cuyo. Mendoza. Tel: 0261 4987490 / 261 534-4469. E-mail: levicigroupsa@gmail.com');
            
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
            $pdf->Cell(200,25,"",1);
            
            //cliente
            $pdf->setXY(6,59);
            $pdf->setFont('Times','',12);
            $pdf->Cell(21,6,utf8_decode("CUIT: ") , $bd);
            $pdf->setFont('Times','B',12);
            $pdf->Cell(50,6,$sale->customer->cuit,$bd);

            $pdf->setFont('Times','',12);
            $pdf->Cell(28,6,utf8_decode("Razón social: ") , $bd);
            $pdf->setFont('Times','B',12);
            $pdf->Cell(80,6,$sale->customer->name,$bd);
            $pdf->Ln();

            //Condicion de iva
            $pdf->SetX(6);
            $pdf->setFont('Times','',12);
            $pdf->Cell(48,6,utf8_decode("Condición frente al IVA: ") , $bd);
            $pdf->setFont('Times','B',12);
            $pdf->Cell(60,6,$sale->customer->ivacondition->ivacondition,$bd);

            //condicion de venta
            $pdf->setFont('Times','',12);
            $pdf->Cell(40,6,utf8_decode("Condición de venta: ") , $bd);
            $pdf->setFont('Times','B',12);
            $pdf->Cell(60,6,$sale->conditions,$bd);
            $pdf->Ln();

            //direccion
            $pdf->SetX(6);
            $pdf->setFont('Times','',12);
            $pdf->Cell(21,6,utf8_decode("Dirección: "), $bd);
            $pdf->setFont('Times','B',12);
            $pdf->Cell(177,6,$sale->customer->address .  ' - ' . ' ('. $sale->customer->province->province .')', $bd);
            $pdf->Ln();
            $pdf->SetX(6);

            //direccion
            $pdf->SetX(6);
            $pdf->setFont('Times','',12);
            $pdf->Cell(27,6,utf8_decode("Observaciones: "), $bd);
            $pdf->setFont('Times','B',12);
            $pdf->Cell(177,6,$sale->operation->observation, $bd);
            $pdf->Ln();
            $pdf->SetX(6);
            
            /*
            * DETALLE DE LA FACTURA
            */
            
            $pdf->setXY(5,84);
            $pdf->SetFont('Times','',11);
            $pdf->Cell(20,8,utf8_decode("Código"), 1,0,'C');
            $pdf->Cell(75,8,"Producto",1,0,'C');
            $pdf->Cell(17,8,"Cantidad",1,0,'C');
            $pdf->Cell(15,8,"Unidad",1,0,'C');
            $pdf->Cell(17,8,"$ unit",1,0,'C');
            $pdf->Cell(17,8,"% Bonif",1,0,'C');
            $pdf->Cell(17,8,"$ Bonif",1,0,'C');
            $pdf->Cell(22,8,"$ Subtotal",1,0,'C');

            $pdf->SetLineWidth(0.2);
            $pdf->Line(5,84,5,240);
            $pdf->Line(25,84,25,240);
            $pdf->Line(100,84,100,240);
            $pdf->Line(117,84,117,240);
            $pdf->Line(132,84,132,240);
            $pdf->Line(149,84,149,240);
            $pdf->Line(166,84,166,240);
            $pdf->Line(183,84,183,240);
            $pdf->Line(205,84,205,240);
            
            $pdf->Ln();
            $pdf->SetFont('Times','',10);

            foreach($sale->operation->products as $p)
            {


                $pdf->setX(5);
                $pdf->Cell(20,6,$p->code, $bd, 0, 'C');
                $pdf->Cell(75,6, utf8_decode($p->product), $bd,0);
                $pdf->Cell(17,6,$p->pivot->quantity, $bd,0,'R');
                $pdf->Cell(15,6,$p->unittype->abrev, $bd,0,'C');
                $pdf->Cell(17,6,'$' . round($p->pivot->price,2), $bd,0,'R');
                if($p->pivot->price == 0)
                {
                    $pdf->Cell(17,6,round($p->pivot->price,2).'%', $bd,0,'C');
                }
                else
                {
                    $pdf->Cell(17,6,round(($p->pivot->discount * 100 / $p->pivot->price),2).'%', $bd,0,'C');
                }
                
                $pdf->Cell(17,6,'$' . round($p->pivot->discount * $p->pivot->quantity,2), $bd,0,'R');
                if($sale->operation->operationtype->letter == 'B')
                {
                    $pdf->Cell(22,6,"$" . round($p->pivot->quantity * ($p->pivot->price + $p->pivot->iva-$p->pivot->discount),2) , $bd,0,'R');
                }
                else
                {
                    $pdf->Cell(22,6,"$" . round($p->pivot->quantity * ($p->pivot->price-$p->pivot->discount),2), $bd,0,'R');
                }
                $pdf->Ln();
            }

            $pdf->SetXY(5,240);
            //marco totales
            $pdf->SetLineWidth(0.4);
            $pdf->Cell(200, 32,"",1);
            $pdf->setXY(130, 241);
            $pdf->SetFont('Times','B',11);
            $pdf->Cell(40,5,"Importe Neto Grabado: $");
            $pdf->SetFont('Times','',11);
            $pdf->Cell(35, 5 , $sale->operation->amount - $sale->operation->iva21 - $sale->operation->iva105, 0,0,'R');
            $pdf->Ln();
            $pdf->setX(130);
            $pdf->SetFont('Times','B',11);
            $pdf->Cell(40,5,"IVA 10.5%: $");
            $pdf->SetFont('Times','',11);
            $pdf->Cell(35, 5 , $sale->operation->iva105, 0,0,'R');
            $pdf->Ln();
            $pdf->setX(130);
            $pdf->SetFont('Times','B',11);
            $pdf->Cell(40,5,"IVA 21%: $");
            $pdf->SetFont('Times','',11);
            $pdf->Cell(35, 5 , $sale->operation->iva21, 0,0,'R');
            $pdf->Ln();
            $pdf->setX(130);
            $pdf->SetFont('Times','B',11);
            $pdf->Cell(40,5,"Importe Neto No Grabado: $");
            $pdf->SetFont('Times','',11);
            $pdf->Cell(35, 5 , 0, 0,0,'R');
            $pdf->Ln();
            $pdf->setX(130);
            $pdf->SetFont('Times','B',11);
            $pdf->Cell(40,5,utf8_decode('Bonificación: '));
            $pdf->SetFont('Times','',11);
            $pdf->Cell(35, 5 , round($sale->operation->discount,2), 0,0,'R');
            $pdf->Ln();
            $pdf->setX(130);
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(40,5,"Importe total: $");
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(35, 5 , round($sale->operation->amount,2), 0,0,'R');
            $pdf->Ln();


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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        $customer_id = $request->input('customer_id');
        if(is_null($customer_id) && !is_null($request->input('person_id') ))
        {
            $customer_id = $request->input('person_id');
        }

        if(!is_null($request->input('order')))
        {
            $operations = Sale::whereHas("operation", function($q) use ($request){
                $q->wherein('operationtype_id',[1,2,3,15,16,17,18]);
                $q->wherein('status_id', explode(',',$request->input('status_id')));
                $q->orderby('date_of',$request->input('order'));
            })
            ->where('customer_id',$customer_id)
            ->with(['customer','operation','payments'])
            ->get();
        }
        else
        {
            $operations = Sale::whereHas("operation", function($q) use ($request){
                    $q->wherein('operationtype_id',[1,2,3,15,16,17,18]);
                    $q->wherein('status_id', explode(',',$request->input('status_id')));
                })
                ->where('customer_id',$customer_id)
                ->with(['customer','operation','payments'])
                ->get();
        }   

        foreach($operations as $sale)
        {
            $sale->operation->operationtype;
            $sale->operation->operationtype->groupoperationtype;
            $sale->operation->dateof = $sale->operation->date_of;
        }
        return response()->json($operations);
    }

}
