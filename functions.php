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

    function check_num($num){

        $num_array = array_map('intval', str_split($num));

        if(count($num_array) == 11){
            return true;
        }else{
            return false;
        }
    }

    function get_address($cep){

        $ch = curl_init();
        $link = "viacep.com.br/ws/$cep/json/";

        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);

        $texto = json_decode($data);

        return $texto->logradouro;
    }
    function get_uf($cep){

        $ch = curl_init();
        $link = "viacep.com.br/ws/$cep/json/";

        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);

        $texto = json_decode($data);

        return $texto->uf;
    }
    function get_district($cep){

        $ch = curl_init();
        $link = "viacep.com.br/ws/$cep/json/";

        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);

        $texto = json_decode($data);

        return $texto->bairro;
    }

    function check_card($cartao_num, $cartao_nome, $cartao_cvv, $cartao_mes){

        if(strlen($cartao_num) == 16 && strlen($cartao_cvv) == 3){
            $check_card_num = is_numeric($cartao_num);
            $check_card_name = is_numeric($cartao_nome);
            $check_card_cvv = is_numeric($cartao_cvv);
                
            $mes_atual = date("m");
            
            $check_card_val = ($mes_atual > $cartao_mes) ? 0 : 1;
            if($check_card_num == 1 && $check_card_name == 0 && $check_card_cvv == 1 && $check_card_val == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

?>