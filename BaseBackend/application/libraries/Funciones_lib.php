<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funciones_lib {
    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
            // Assign the CodeIgniter super-object
            $this->CI =& get_instance();
    }

    public function multiplicar($arreglo = [],$key = '')
    {
        $mul = 0;
        if(empty($key)){
            foreach($arreglo as $val){
                if(empty($mul)){
                    $mul = $val;
                }else{
                    $mul = $mul*$val;
                }
            }
        }else{
            foreach($arreglo as $val){
                if(empty($mul)){
                    $mul = $val;
                }else{
                    $mul = $val[$key]*$mul;
                }
            }
        }
        return $mul;
    }
    public function sumar($arreglo = [],$key = '')
    {
        $suma = 0;
        if(empty($key)){
            foreach($arreglo as $val){
                $suma = $val+$suma;
            }
        }else{
            foreach($arreglo as $val){
                $suma = $val[$key]+$suma;
            }
        }
        return $suma;
    }
    public function restar($arreglo = [],$key = '')
    {
        $resta = 0;
        if(empty($key)){
            $i=0;
            foreach($arreglo as $val){
                if($resta==0){
                    $resta = $val;
                }else{
                    $resta = $resta-$val;
                }
                $i++;
            }
        }else{
            $i=0;
            foreach($arreglo as $val){
                if($resta==0){
                    $resta = $val[$key];
                }else{
                    $resta = $resta-$val[$key];
                }
                $i++;
            }
        }
        return $resta;
    }
    public function maximo($arreglo = [],$key = '')
    {
        $maximo = 0;
        if(empty($key)){
            $maximo = max($arreglo);
        }else{
            $temp = [];
            foreach($arreglo as $val){
                $temp[] = $val[$key];
            }
            $maximo = max($temp);
        }
        return $maximo;
    }
    public function minimo($arreglo = [],$key = '')
    {
        $minimo = 0;
        if(empty($key) && !empty($arreglo)){
            $minimo = min($arreglo);
        }else{
            $temp = [];
            foreach($arreglo as $val){
                $temp[] = $val[$key];
            }
            if(!empty($temp)){
                $minimo = min($temp);
            }
        }
        return $minimo;
    }
    public function tir($arreglo = [],$taza = 0){
        $taza_ant=0;
        $taza_ult=0;
        $vpn = $this->vpn($arreglo,$taza);
        
        if ($vpn>0){
            echo "entro";
            for ($x=$taza;$vpn>0; $x+=.0001){
                $vpn = $this->vpn($arreglo,$x);
                $taza_ant=$x-0.0001;
                $taza_ult=$x;
                if($x>1){
                    $taza_ult="NA";
                    return $taza_ult;
                }
            }
            return $taza_ult*100;
        }
        else
        {
            for ($x=$taza;$vpn<0; $x-=.0001){
                $vpn=$this->vpn($arreglo,$x);
                $taza_ant=$x+0.0001;
                $taza_ult=$x;
        
                if($x<-1){
                    $taza_ult="NA";
                    return $taza_ult;
                }
            }
            return $taza_ult*100;
        }
    }
    public function vpn($arreglo,$taza = 0)
    {
        $vpn = 0;
        foreach($arreglo as $key=>$val){
            if($key==0){
                $vpn = $val+$vpn;
            }else{
                $pow = pow((1+$taza),$key+1);
                $div = $val/$pow;
                $vpn = $vpn+$div;
            }
        }
        return $vpn;
    }
    public function pmt($rate, $nper, $pv, $fv, $type = 0)
    {
        $rate = floatval($rate);
        $nper = floatval($nper);
        $pv = floatval($pv);
        $fv = floatval($fv);
        $resultado = 0;
        if($rate != 0.0){
            // Interest rate exists
            $q = pow(1 + $rate, $nper);
            $resultado = -($rate * ($fv + ($q * $pv))) / ((-1 + $q) * (1 + $rate * ($type)));

        } else if($nper != 0.0){
            // No interest rate, but number of payments exists
            $resultado = -($fv + $pv) / $nper;
        }
        return $resultado;
    }
    public function pv($rate, $nper, $pmt, $fv=1) {
        $rate = floatval($rate);
        $nper = floatval($nper);
        $pmt = floatval($pmt);
        $fv = floatval($fv);
        if ( $nper == 0 ) {
            return(0);       
        }
        if ( $rate == 0 ) { // Interest rate is 0
            $pv_value = -($fv + ($pmt * $nper));
        } else {
            $x = pow(1 + $rate, -$nper); 
            $y = pow(1 + $rate, $nper);
            $uno = - ( $x * ( $fv * $rate - $pmt + $y * $pmt ));
            if($uno == 0 || $rate == 0){
                $pv_value = 0;
            }else{
                $pv_value = $uno / $rate;
            }
        }
        return $pv_value;
    }
}
