<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Payment;
use app\Models\Paycheck;
use app\Models\Sale;
use app\Models\Transfer;
use app\Models\Bank;
use app\Models\Operation;
use app\Models\Operationtype;
use app\Models\User;
use app\Models\Person;

use DB;
use Fpdf\Fpdf;

Class ReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $operationtype_id = 11;
        $perPage = 25;

        if (!empty($keyword)) 
        {
            $operations = Payment::whereHas("operation", function($q) use ($operationtype_id){
                $q->where('operationtype_id','=', $operationtype_id);
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
            $operations = Payment::whereHas("operation", function($q) use ($operationtype_id){
                $q->where('operationtype_id','=', $operationtype_id);
            })
                ->with(['customer','operation'])
                ->latest()
                ->paginate($perPage);
        }

        $modelName = 'Recibo';
        $title      = 'Listado de ' . $modelName;
        $controller = 'receives';

        return view('payments.index',compact('operations', 'title', 'modelName', 'controller','operationtype_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $saldo_favor = \Auth::user()->saldo_favor;

        $title              = 'RECIBO';
        $modelName          = 'Recibo';
        $controller         = 'receives';
        $operationtype_id   = 11;
        $banks = Bank::orderBy('bank')->pluck('bank','id');

        return view('payments.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'operationtype_id',
            'banks',
            'saldo_favor'
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


        //remito
        $data['user_id']    = \Auth::user()->id;
        $data['status_id']  = Payment::STATUS['COBRO_EMITIDO'];
        $data['customer_id']= $data['person_id'];
        $data['amount']     = $data['payment_amount'];
        $data['number']     = $data['payment_number'];
        
        $data['pointofsale']= Operationtype::Find($data['operationtype_id'])->pointofsale;
        $data['observation']= $data['observation_receive'];
        $saldo =$data['saldo_favor_final'];


        try {
            DB::beginTransaction();
            $operation = new Operation($data);
            $operation->save();

            $payment = new Payment($data);

            $payment->operation_id = $operation->id;
            $payment->save();

            //cheques
            if(isset($data['cheque_number']))
            {
                foreach($data['cheque_number'] as $idx => $number)
                {
                    $cheque = NEW Paycheck();
                    $cheque->number     = $number;
                    $cheque->bank_id    = $data['cheque_bank_id'][$idx];
                    $cheque->paymentdate= $data['cheque_paymentdate'][$idx];
                    $cheque->expiration = $data['cheque_expiration'][$idx];
                    $cheque->amount     = $data['cheque_amount'][$idx];
                    $cheque->type       = $data['cheque_type'][$idx];
                    $cheque->owner_name = $data['cheque_owner_name'][$idx];
                    $cheque->owner_cuit = $data['cheque_owner_cuit'][$idx];
                    $cheque->observation= $data['cheque_observation'][$idx];
                    $cheque->status_id  = Paycheck::STATUS['CARTERA'];
                    $cheque->receipt    = date('d/m/Y');

                    $cheque->save();
                    $operation->paychecks()->save($cheque);
                }
            }

            //transferencias
            if(isset($data['transfer_number']))
            {
                foreach($data['transfer_number'] as $idx => $number)
                {
                    $transfer = NEW Transfer();
                    $transfer->number       = $number;
                    $transfer->date_of      = $data['transfer_dateof'][$idx];
                    $transfer->amount       = $data['transfer_amount'][$idx];
                    $transfer->observation  = $data['transfer_observation'][$idx];
                    $transfer->bank_id      = $data['transfer_bank_id'][$idx];
                    
                    $transfer->save();

                    $operation->transfers()->save($transfer);
                }
            }

            //facturas caceladas
            foreach($data['fact_id'] as $idx => $factid)
            {
                if($data['fact_canceled'][$idx] != 0)
                {
                    $sale = Sale::find($factid);

                    $payment->sales()->attach($sale,[
                        'total'     => $sale->operation->amount,
                        'canceled'  => $data['fact_canceled'][$idx],
                        'residue'   => $data['fact_residue'][$idx] - $data['fact_canceled'][$idx]
                    ]);

                    if($data['fact_canceled'][$idx] == $data['fact_residue'][$idx])
                    {
                        $sale->operation->status_id = Sale::STATUS['VTA_COBRO_TOTAL'];
                    }
                    else
                    {
                        $sale->operation->status_id = Sale::STATUS['VTA_COBRO_PARCIAL'];
                    }
                    $sale->operation->save();
                }
            }
            // User::where('id',$data['user_id'])->update(['saldo_favor'=>$saldo]);
            Person::where('id',$data['person_id'])->update(['saldo_favor'=>$saldo]);
            DB::commit();
            return redirect('receives');

        } catch (\Exception $e){

            dd($e);
            DB::rollBack();
        }
        //return redirect('sales/create')->with('operationtype_id', $data['operationtype_id']);
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


    public function reciboPDF($id)
    {
        $bd = 0;

        $payment = Payment::find($id);

        $pdf = new fpdf('p','mm');

        $pdf->SetMargins(0,0,0);
        $pdf->SetAutoPageBreak(false);
            
        $pdf->Addpage();
        //$pdf->cMargin = 0;
        $pdf->SetFont('Times','',10);
        
        //marco exterior
        $pdf->SetLineWidth(0.5);
        $pdf->setXY(5,5);
        $pdf->Cell(200, 287,"",1);
        $pdf->Ln();
        $pdf->setXY(10,15);
        $pdf->SetLineWidth(0.4);

        /*
        * CABECERA
        */

        //X (tipo de documento)
        $pdf->setFont('Courier','B',30);
        $pdf->setXY(101,5);
        $pdf->Cell(8,12,"X",1,0,"C");
        $pdf->Line(109,5,109,47);

        //logo
        $pdf->image('img/logo.jpg', 8,8,40,37);
        $pdf->setXY(6,6);
        
        
        //titulo
        $pdf->setFont('Arial','B',18);
        $pdf->setXY(115,8);
        $pdf->Cell(28,6,"RECIBO",$bd);
            
        //info empresa
        $pdf->SetFont('Times','',9);
        $pdf->SetXY(48,15);
        $info = utf8_decode('Administración: Patricios 256. (5507) Luján de Cuyo. Mendoza. Base: Terrada y callejón Los Olivos 1. Perdriel. Luján de Cuyo. Mendoza. Tel: 261 534-4469. E-mail: levicigroupsa@gmail.com');
        
        $pdf->MultiCell(51,4,$info,$bd,'R');
        $pdf->SetXY(48,42);
        $pdf->Cell(55,4, 'IVA RESPONSABLE INSCRIPTO', $bd,0,'C');
        
        $pdf->SetXY(120,26);
        $info2 = utf8_decode("CUIT: 30-71434762-0\n Ingresos Brutos: 0698400 \n Establecimiento Nº 06-0698400-00\nInicio de actividades: 15/01/2014.\n DOCUMENTO NO VALIDO COMO FACTURA");
        $pdf->MultiCell(70,4,$info2,$bd,'C');
        
        
        
        //numero
        $pdf->setFont('Arial','B',18);
        $pdf->SetXY(146,8);
        $pdf->Cell(13,6,utf8_decode("Nº ") . $payment->operation->fullNumber,$bd);
        
        //fecha
        $pdf->SetXY(115,17);
        $pdf->Cell(38,6,"FECHA: ", $bd,0);
        $pdf->Cell(20,6,$payment->operation->date_of, $bd,0,'C');
        $pdf->Ln();
                
        //linea divisora
        $pdf->Line(5,47,205,47);
            
        /*
        * DATOS DEL CLIENTE
        */
        $pdf->SetXY(6,48);
        //cliente
        $pdf->setFont('Times','',13);
        $pdf->Cell(21,6,utf8_decode("Señor(es): ") , $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(153,6,$payment->customer->name,$bd);
        $pdf->Ln();
        $pdf->SetX(6);
        //direccion
        $pdf->setFont('Times','',13);
        $pdf->Cell(21,6,utf8_decode("Dirección: "), $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(177,6,$payment->customer->address .  ' - ' .' ('. $payment->customer->province->province .')', $bd);
        $pdf->Ln();
        $pdf->SetX(6);
        //CUIT
        $pdf->setFont('Times','',13);
        $pdf->Cell(15,6,utf8_decode("CUIT: "), $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(183,6,$payment->customer->cuit, $bd);
        $pdf->Ln();
        $pdf->SetX(6);
        $pdf->setFont('Times','',13);
        $pdf->Cell(15,6,utf8_decode("Observ: "), $bd);
        $pdf->setFont('Times','B',13);
        $pdf->Cell(183,6,$payment->operation->observation, $bd);
        
            
        //detalles
        $pdf->setXY(5,75);
        $pdf->SetFont('Times','B',13);
        $pdf->Cell(200,8,"DETALLE DEL RECIBO", 1,0,'C');
        $pdf->Ln();

        //facturas
        $pdf->SetFont('Times','B',13);
        $pdf->setX(5);
        $pdf->Cell(200,8,'FACTURAS',1,0,'C');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(40,5,'Numero',1,0,'C');
        $pdf->Cell(40,5,'Fecha',1,0,'C');
        $pdf->Cell(40,5,'Importe',1,0,'C');
        $pdf->Cell(40,5,'Pendiente',1,0,'C');
        $pdf->Cell(40,5,'Entrega',1,0,'C');
        $pdf->SetFont('Times','',12);

        foreach($payment->sales as $sale)
        {
            $pdf->Ln();
            $pdf->SetX(5);
            $pdf->Cell(40,5,$sale->operation->operationtype->letter . $sale->operation->fullNumber,0,0,'C');
            $date=date_create($sale->created_at);
            $pdf->Cell(40,5,date_format($date,"d/m/Y"),0,0,'C');
            $pdf->Cell(40,5,"$".$sale->operation->amount,0,0,'C');
            $pdf->Cell(40,5,"$".$sale->pivot->residue,0,0,'C');
            $pdf->Cell(40,5,"$".$sale->pivot->canceled,0,0,'C');
        }
        
        $pdf->Line(45,92,45,178);
        $pdf->Line(85,92,85,178);
        $pdf->Line(125,92,125,178);
        $pdf->Line(165,92,165,178);

        //totales
        $pdf->SetXY(5,173);
        $pdf->SetFont('Times','',12);
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->SetFont('Times','B',13);
        $pdf->Cell(160,7,"TOTAL",1,0,'R');
        $pdf->Cell(40,7, "$" . $payment->operation->amount, 1,0,'C');

        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->SetFont('Times','B',13);
        $pdf->Cell(200,8,'FORMAS DE PAGO',1,0,'C');
        $pdf->SetFont('Times','',13);

        //Cheques
        $pdf->SetFont('Times','B',13);
        $pdf->setXY(5,193);
        $pdf->Cell(140,5,'CHEQUES',1,0,'C');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(25,5,'Numero',1,0,'C');
        $pdf->Cell(65,5,'Banco',1,0,'C');
        $pdf->Cell(25,5,'Fecha',1,0,'C');
        $pdf->Cell(25,5,'Importe',1,0,'C');
        $pdf->SetFont('Times','',12);

        
        $total_cheque = 0;
        foreach($payment->operation->paychecks as $paycheck)
        {
            $pdf->Ln();
            $pdf->SetX(5);
            $pdf->Cell(25,5,$paycheck->number,0,0,'C');
            $pdf->Cell(65,5,isset($paycheck->bank->bank)?substr($paycheck->bank->bank,0,25):'',0,0,'C');
            $pdf->Cell(25,5,$paycheck->paymentdate,0,0,'C');
            $pdf->Cell(25,5,"$".$paycheck->amount,0,0,'C');
            $total_cheque = $total_cheque + $paycheck->amount;
        }

        $pdf->Line(30,198,30,250);
        $pdf->Line(95,198,95,250);
        $pdf->Line(120,198,120,250);
        $pdf->Line(145,198,145,250);

        $pdf->Ln();
        $pdf->SetXY(5,250);
        $pdf->SetFont('Times','B',13);
        $pdf->Cell(115,5,"TOTAL",1,0,'R');
        $pdf->Cell(25,5, "$" . $total_cheque, 1,0,'C');
            
        //transferencias
        $pdf->SetFont('Times','B',13);
        $pdf->setXY(145,193);
        $pdf->Cell(60,5,'TRANSFERENCIAS',1,0,'C');
        $pdf->Ln();
        $pdf->SetX(145);
        $pdf->Cell(35,5,'Numero',1,0,'C');
        $pdf->Cell(25,5,'Importe',1,0,'C');
        $pdf->SetFont('Times','',12);
        $total_trans = 0;

        foreach($payment->operation->transfers as $transfer)
        {
            $pdf->Ln();
            $pdf->SetX(145);
            $pdf->Cell(35,5,$transfer->number,0,0,'C');
            $pdf->Cell(25,5,"$".$transfer->amount,0,0,'C');
            $total_trans = $total_trans + $transfer->amount;
        }

        $pdf->Line(180,198,180,250);
        
        $pdf->Ln();
        $pdf->SetXY(145,250);
        $pdf->SetFont('Times','B',13);
        $pdf->Cell(35,5,"TOTAL",1,0,'R');
        $pdf->Cell(25,5, "$" . $total_trans, 1,0,'C');


        $pdf->Ln();
        $pdf->SetFont('Times','B',13);
        $pdf->setX(5);
        $pdf->Cell(200,10,'TOTALES',1,0,'C');

        $pdf->ln();
        $pdf->SetX(5);
        $pdf->Cell(40,10,'CHEQUES',1,0,'C');
        $pdf->Cell(40,10,'TRANSFERENCIA',1,0,'C');
        $pdf->Cell(40,10,'EFECTIVO',1,0,'C');
        $pdf->Cell(40,10,'DEBITO/CRED',1,0,'C');
        $pdf->Cell(40,10,'TOTAL RECIBO',1,0,'C');
        $pdf->ln();
        $pdf->SetX(5);
        $pdf->Cell(40,10,"$".$total_cheque,1,0,'C');
        $pdf->Cell(40,10,"$".$total_trans,1,0,'C');
        $pdf->Cell(40,10,"$".$payment->cash,1,0,'C');
        $pdf->Cell(40,10,"$".$payment->debit,1,0,'C');
        $pdf->Cell(40,10,"$".$payment->operation->amount,1,0,'C');
        

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
