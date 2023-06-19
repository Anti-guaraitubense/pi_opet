<?php 

    function check_cpf($cpf_num){
        
        #transformando em array
        $cpf_array = array_map('intval', str_split($cpf_num));

        if(count($cpf_array) == 11){
            $lastdig1 = $cpf_array[9];
            $lastdig2 = $cpf_array[10];

            $soma1 = $cpf_array[0] * 10 + $cpf_array[1] * 9 + $cpf_array[2] * 8 + $cpf_array[3] * 7 + $cpf_array[4] * 6 + $cpf_array[5] * 5 + $cpf_array[6] * 4 + $cpf_array[7] * 3 + $cpf_array[8] * 2;
            $soma1 *= 10;
            $soma1 %= 11;

            if($soma1 == $lastdig1){
                $soma2 = $cpf_array[0] * 11 + $cpf_array[1] * 10 + $cpf_array[2] * 9 + $cpf_array[3] * 8 + $cpf_array[4] * 7 + $cpf_array[5] * 6 + $cpf_array[6] * 5 + $cpf_array[7] * 4 + $cpf_array[8] * 3 + $cpf_array[9] * 2;
                $soma2 *= 10;
                $soma2 %= 11;

                if($soma2 == $lastdig2){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        else{          
            return false;
        }
    }
?>