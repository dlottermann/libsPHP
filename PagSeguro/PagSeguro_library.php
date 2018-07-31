<?php

/*

  https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/B33F4EF9040847EAA365693A5D54F139?email=diegolottermann@gmail.com&token=0BB294A0A9FF4444BBCE686EA4E829C7


  https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/833994-4AC21DC21DAD-6774D13FBDD7-CF7009?email=diegolottermann@gmail.com&token=0BB294A0A9FF4444BBCE686EA4E829C7




 */

class pgSeguro {

    private $con;
    private $res;
    #URL utilizada pelo pagseguro na data de 09.01.2013
    private $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/';

    # Email e Token para autenticação
    private $emailAutenticacao = 'diegolottermann@gmail.com';
    private $token = '0BB294A0A9FF4444BBCE686EA4E829C7'; //token 

    public function pgSeguro() {
        
    }

    # Função para envio de dados ao pagSeguro

    public function envia_pgSeguro($itens,$valorBol = 0.05) {


        

        $data['email'] = $this->emailAutenticacao; #Email de autenticação no pagseguro
        $data['token'] = $this->token; #Token de autenticação no pagseguro
        $data['currency'] = 'BRL'; #Moeda corrente utilizada

        /* Inicio da seção de items/serviços */
        $ind =1;
        foreach($itens as $item){

        $data['itemId'.$ind] = '0000'.$ind; #Código do item/serviço
        $data['itemDescription'.$ind] = $item['nome']; #Descrição do item/serviço 
        $data['itemAmount'.$ind] = $valorBol;
        $data['itemQuantity'.$ind] = '1';       
        //$data['itemWeight1'] = '0'; #Peso do item
        $data['itemShippingCost'] = 10.00;

            //incrementa total no indice do item
            $ind++;
        }

        

        /* Fim da seção */


        /* Inicio da seção de dados do cliente */

        //$data['reference'] = ''; #Referencia interna Ex: venda_codigo, 00001
        $data['senderName'] = 'João da Silva'; #Nome do cliente Ex: João da Silva
        $data['senderAreaCode'] = '54'; #DDD do cliente Ex: 55,54,11 (Máx: 2 digitos) - Opcional
        $data['senderPhone'] = '99335579'; #Numero de Telefone do cliente Ex: 987654321 (Máx: 9 digitos) - Opcional
        $data['senderEmail'] = 'c76521939531339033807@sandbox.pagseguro.com.br'; #Email do cliente Ex: joao.silva@metasig.com.br
//Password -> cvjDlbT4pdkX8Ne1
        /*  Fim da seção de dados do cliente */

        /* Inicio da seção de dados de endereço */


        $data['shippingType'] = 3; #Tipo de Frente a ser utilizado Ex: (1: PAC,2: Sedex,3: Não Especificado) - Opcional
        $data['shippingAddressStreet'] = 'Avenida Brasil'; #Nome de endereço de envio  Ex: Avenida Brasil (Máx: 80 digitos)
        $data['shippingAddressNumber'] = '22'; #Numero de endereco de envio Ex: 22, 145B  (Máx: 20 digitos)
        $data['shippingAddressComplement'] = 'Apto 202'; #Complemento de endereço de envio  Ex: Apto 202, Chacará (Máx: 40 digitos) -Opcional
        $data['shippingAddressDistrict'] = 'Centro'; #Bairro de endereço de envio Ex: Centro, Jaboticabal, Nenê Graeff (Máx: 60 digitos)
        $data['shippingAddressPostalCode'] = '99500000'; #CEP de endereço de envio Ex: 99500000 (Máx: 8 digitos)
        $data['shippingAddressCity'] = 'Carazinho'; #Cidade do endereço de envio Ex: Passo Fundo, Carazinho (Máx: 60 digitos)
        $data['shippingAddressState'] = 'SP'; #Estado de endereço de envio Ex: RS,SC - Opcional
        $data['shippingAddressCountry'] = 'BRA'; #Pais de endereço de envio Ex: BRA

      
        /* Fim da seção de endereço */

        #URL redirecionamento	
        //$data['redirectURL'] = 'http://www.tudoem.com.br/';
        #Transformando o array em formato de URL, para ser interpretado pelo pagseguro  
        $data = http_build_query($data);

        $curl = curl_init($this->url); #inicializando o cURL

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); #Informar que a operação não possui certificado de segurança
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); #Informar que operação possui um retorno 
        curl_setopt($curl, CURLOPT_POST, true); #Informar o tipo de retorno da operação é por POST
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); #Informa a versão aceita pelo pagSeguro	
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); #Informar os dados transportados pelo cURL

        $xml = curl_exec($curl); #Execução do cURL

        curl_close($curl); #limpa memória
        #Transformação do retorno XML em objeto
        $xml = simplexml_load_string('' . $xml);

        //print_r($xml);

        if (count($xml->error) > 0) {

            return 0;
            exit;
        } else {
            return $xml->code;
        }
    }

}

?>