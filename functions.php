<?php 

    function check_cpf($cpf_num){
            
        #transformando em array
        $cpf_array = array_map('intval', str_split($cpf_num));

        if(count($cpf_array) == 11){
            $lastdig1 = $cpf_array[9];
            $lastdig2 = $cpf_array[10];

            $soma1 = 0;
            
            for($i=0;$i<=8;$i++){
                $soma1+=$cpf_array[0+$i] * (10 - $i);
            }
            
            $soma1 *= 10;
            $soma1 %= 11;

            if($soma1 == $lastdig1){
                
                $soma2 = 0;
                for($i=0;$i<=9;$i++){
                    $soma2+=$cpf_array[0+$i] * (11-$i);
                }
                
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
    function get_city($cep){

        $ch = curl_init();
        $link = "viacep.com.br/ws/$cep/json/";

        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);

        $texto = json_decode($data);

        return $texto->localidade;
    }

    function check_card($cartao_num, $cartao_nome, $cartao_cvv, $cartao_mes, $cartao_ano){

        if(strlen($cartao_num) == 16 && strlen($cartao_cvv) == 3){
            $check_card_num = is_numeric($cartao_num);
            $check_card_name = is_numeric($cartao_nome);
            $check_card_cvv = is_numeric($cartao_cvv);
                
            $mes_atual = date("m");
            $ano_atual = date("Y");

            if($mes_atual < $cartao_mes){
                if($cartao_ano > $ano_atual){
                    $check_card_val = 1;
                }
            }else{
                $check_card_val = 1;
            }
            
            if($check_card_num == 1 && $check_card_name == 0 && $check_card_cvv == 1 && $check_card_val == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function goto_page($target){
        echo "<script type='text/javascript'>
                window.location.href = '$target';
                </script>";
    }

    function encode_image($tmp_name, $type){

        
        $filecontent = file_get_contents($tmp_name);

        $b64img = base64_encode($filecontent);
        return "data:$type;base64,$b64img";
    }

?>