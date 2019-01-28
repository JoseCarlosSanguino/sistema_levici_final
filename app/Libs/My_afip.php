<?php

namespace app\Libs;

use AFIP;

Class My_afip
{
	var $afip;


	function __construct()
	{

		$this->afip = New Afip([
            'CUIT'      => env('AFIP_CUIT'),
            'res_folder'=> config_path('afip/'),
            'ta_folder' => config_path('afip/'),
            'produccion'=> env('AFIP_PROD')
        ]);
	}


	/**
	 * @param $tc tipo de comprobante 
	 * @param $pv punto de venta
	 * 
	 * @return number
	 */
	public function getNextNumber($pv = null, $tc = null)
	{

		if($tc != null && $pv != null)
		{
			return $this->afip->ElectronicBilling->GetLastVoucher($pv, $tc)+1;
		}
		else
		{
			return null;
		}
		
	}

	public function generateVoucher($oper = null)
	{

		if(!is_null($oper))
		{

			$docTipo = 80;
			$docNum = $oper->sale->customer->cuit;
			if($oper->sale->customer->ivacondition_id == 4)
			{
				$docTipo = 99;
				$docNum = 0;
			}

			//IVA
			$iva_arr = [];
			$iva = 0;$debug=[];
			foreach($oper->products as $prod)
			{
				$base_imp = round($prod->pivot->price * $prod->pivot->quantity,2);
				$importe  = round($base_imp / 100 * $prod->ivatype->percent,2);

				$iva_arr[$prod->ivatype_id]['Id'] 		= $prod->ivatype->afip_id;
				$iva_arr[$prod->ivatype_id]['BaseImp']  = isset($iva_arr[$prod->ivatype_id]['BaseImp'])?$iva_arr[$prod->ivatype_id]['BaseImp'] + $base_imp: $base_imp;
				$iva_arr[$prod->ivatype_id]['Importe']  = isset($iva_arr[$prod->ivatype_id]['Importe'])?$iva_arr[$prod->ivatype_id]['Importe']+$importe : $importe;
				$iva = $iva + $importe;
			}

			$arr_iva = [];
			foreach($iva_arr as $i)
			{
				array_push($arr_iva, $i);
			}

			$data = [
				'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
				'PtoVta' 	=> $oper->operationtype->pointofsale,  // Punto de venta
				'CbteTipo' 	=> $oper->operationtype->afip_id,  // Tipo de comprobante (ver tipos disponibles) 
				'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
				'DocTipo' 	=> $docTipo, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
				'DocNro' 	=> $docNum,  // Número de documento del comprador (0 consumidor final)
				//'CbteDesde' 	=> 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
				//'CbteHasta' 	=> 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
				'CbteFch' 	=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
				'ImpTotal' 	=> round($oper->amount,2), // Importe total del comprobante
				'ImpTotConc'=> 0,   // Importe neto no gravado
				'ImpNeto' 	=> round($oper->amount - $iva,2), // Importe neto gravado
				'ImpOpEx' 	=> 0,   // Importe exento de IVA
				'ImpIVA' 	=> round($iva,2),  //Importe total de IVA
				'ImpTrib' 	=> 0,   //Importe total de tributos
				'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
				'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
				'Iva' 		=> $arr_iva
			];

			$res = $this->afip->ElectronicBilling->CreateNextVoucher($data,true);
		}
		else
		{
			$res = null;
		}
		return $res;
	}
}