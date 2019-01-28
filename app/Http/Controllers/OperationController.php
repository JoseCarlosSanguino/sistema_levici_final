<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Operation;
use app\Models\Sale;
use app\Models\Operationtype;

use app\Libs\My_afip;

class OperationController extends Controller
{


	/**
     * Show operation's next number
     *
     * @return \Illuminate\Http\Response
     */
    public function nextNumber(Request $request)
    {

        $lastId = Operation::whereIn('operationtype_id',explode(',',$request->input('operationtype_id')))
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

    public function nextSaleNumber(Request $request)
    {
        $ivacondition_id = $request->input('ivacondition_id');
        $group_id        = $request->input('group_id');

        $ot = Operationtype::WhereHas("ivaconditions", function($q) use ($ivacondition_id){
                        $q->where('ivacondition_id', $ivacondition_id);
                    })
                ->where('groupoperationtype_id', $group_id)
                ->first();

        if(!is_null($ot))
        {

            $myafip = NEW My_afip();
            $number =$myafip->getNextNumber($ot->pointofsale, $ot->afip_id);

            if(is_null($number))
            {
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
            }

            $nextNumber = $ot->letter . str_pad($ot->pointofsale,4,'0',STR_PAD_LEFT) . '-' . str_pad($number,9,'0',STR_PAD_LEFT);
            $operationtype_id = $ot->id;
        }
        else
        {
            $nextNumber = 'X0000-000000000';
            $operationtype_id = null;
        }

        return response()->json([
            'number'            => $nextNumber,
            'operationtype_id'  => $operationtype_id
        ]);

    }

}