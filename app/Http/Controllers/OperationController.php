<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Operation;
use app\Models\Sale;
use app\Models\Operationtype;


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

            $nextNumber = $ot->letter . '0002-' . str_pad($number,9,'0',STR_PAD_LEFT);
        }
        else
        {
            $nextNumber = 'X0000-000000000';
        }

        return response()->json([
            'number'            => $nextNumber,
            'operationtype_id'  => $ot->id
        ]);

    }

}