<?php

namespace App\Validation;

class RutValidation
{
    public function validate_rut($rut){
        $rut = str_replace('.', '', strtoupper($rut));
        if (strlen($rut) < 9 || strlen($rut) > 10) {
          return false;
        }else {
          if (substr($rut, -2, 1) != '-') {
            return false;
          }else {
            if (!ctype_digit(substr($rut, 0, strlen($rut)-2))) {
              return false;
            }else{
              $k          = [2, 3, 4, 5, 6, 7, 2, 3];
              $dv         = substr($rut, -1);
              $rut        = substr($rut, 0, strlen($rut)-2);
              $rut_array  = array_reverse(str_split($rut));
      
              $result     = [];
              for ($j=0; $j < count($rut_array); $j++) {
                $result[]   = $rut_array[$j] * $k[$j];
              }
              $suma           = array_sum($result);
              $resto          = $suma % 11;
              $verificador    = 11 - $resto;
              switch ($verificador) {
                case 11:
                  $verificador = 0;
                  break;
                case 10:
                  $verificador = 'K';
                  break;
                default:
                  $verificador = $verificador;
                  break;
              }
              return ($verificador == $dv) ? true : false ;
            }
          }
        }
      }
      
}
