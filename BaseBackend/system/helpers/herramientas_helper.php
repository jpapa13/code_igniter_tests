<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');
 
if (! function_exists('modificacionFecha')) {
    function modificacionFecha($fecha_actual,$cantidad = '1',$tipo = 'days',$operacion = '+')
    {
        $nueva_fecha = strtotime ( $operacion.$cantidad.' '.$tipo, strtotime ( $fecha_actual ) ) ;
        $nueva_fecha = date ( 'Y-m-d H:i:s' , $nueva_fecha );
        return $nueva_fecha;
    }
}
if (! function_exists('sumar')) {
    function sumar($cantidades = [])
    {
        $total = 0;
        foreach($cantidades as $val){
            $total = bcadd($total,$val,2);
        }
        return $total;
    }
}
if (! function_exists('min')) {
    function min($cantidades = [])
    {
        $minimo = 0;
        foreach($cantidades as $val){
            if($val<$minimo || $minimo==0){
                $minimo = $val;
            }
        }
        return $minimo;
    }
}
if (! function_exists('max')) {
    function max($cantidades = [])
    {
        $maximo = 0;
        foreach($cantidades as $val){
            if($maximo<$val){
                $maximo = $val;
            }
        }
        return $maximo;
    }
}
if (! function_exists('pago_max')) {
    function pago_max($capacidad,$fim,$ffm,$sueldo,$periodo_mes,$pond_antig,$maxm,$plazo_max)
	{
        $cantidades = [$fim*$sueldo*$periodo_mes*$pond_antig*$ffm,$maxm];
        return min($capacidad,pmt($tasa,$plazo_max,-min($cantidades)));
    }
}
if (! function_exists('plazo_max')) {
	function plazo_max($plazo,$maxp)
	{
        return min([$plazo,$maxp]);
    }
}
if (! function_exists('cred_max')) {
	function cred_max()
	{
        return pv($tasa,$plazo_max,-$pago_maximo*$plazo_max);
    }
}
if (! function_exists('pmt')) {
	function pmt($rate_per_period, $number_of_payments, $present_value, $future_value, $type)
	{
        if($rate_per_period != 0.0){
            $q = pow(1 + $rate_per_period, $number_of_payments);
            return -($rate_per_period * ($future_value + ($q * $present_value))) / ((-1 + $q) * (1 + $rate_per_period * ($type)));

        } else if($number_of_payments != 0.0){
            return -($future_value + $present_value) / $number_of_payments;
        }
        return 0;
    }
}
if (! function_exists('pv')) {
    function pv($rate, $nper, $pmt, $fv=1) {
        $rate = floatval($rate);
        $nper = floatval($nper);
        $pmt = floatval($pmt);
        $fv = floatval($fv);
        if ( $nper == 0 ) {
            echo "Why do you want to test me with zeros? - PV";
            return(0);       
        }
        if ( $rate == 0 ) { // Interest rate is 0
            $pv_value = -($fv + ($pmt * $nper));
        } else {
            $x = pow(1 + $rate, -$nper); 
            $y = pow(1 + $rate, $nper);
            $pv_value = - ( $x * ( $fv * $rate - $pmt + $y * $pmt )) / $rate;
        }
        return $pv_value;
    }
}
if (! function_exists('anios')) {
    function anios($fecha1 = '',$fecha2 = '') {
        $temp1 = new DateTime($fecha1);
        $temp2 = new DateTime($fecha2);
        $diff = $temp1->diff($temp2);
        $anios = bcdiv($diff->days,365,0);
        return $anios;
    }
}
if (! function_exists('dias')) {
    function dias($fecha1 = '',$fecha2 = '') {
        $temp1 = new DateTime($fecha1);
        $temp2 = new DateTime($fecha2);
        $diff = $temp1->diff($temp2);
        return $diff->days;
    }
}


