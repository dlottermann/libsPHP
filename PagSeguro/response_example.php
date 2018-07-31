<?php
if (isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction') {
    //Todo resto do código iremos inserir aqui.
    # Email e Token para autenticação
    $email = 'XXXXX';
    $token = 'XXXXXX'; 
    /* $url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token; */

    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction = curl_exec($curl);
    curl_close($curl);

    if ($transaction == 'Unauthorized') {
        #tratar erro

        exit;
    }
    $transaction = simplexml_load_string($transaction);
    $transaction->code;

    #Salvamos os dados completos da notificação
    # URL de consulta: https://ws.pagseguro.uol.com.br/v2/transactions/notifications/$codigo_recebido?email=$email&token=$token
    $name = 'completo.txt';
    $text = var_export($_POST, true);
    $file = fopen($name, 'a');
    fwrite($file, $text);
    #Salvamos os dados completos da transação
    # URL de consulta: https://ws.pagseguro.uol.com.br/v2/transactions/$codigo_recebido?email=$email&token=$token
    fwrite($file, "\n--------------Abaixo o ID da Transação -------------------\n");
    fwrite($file, $transaction->code);
    fwrite($file, "\n-------------------------------------\n");
    #Salvamos o status do pagamento
    # Status
    /*     * ********************************** */
    /* 	
      Cód: 1 - Aguardando pagamento.
      Cód: 2 - Em análise - Cartão de Crédito
      Cód: 3 - Paga
      Cód: 4 - Disponível
      Cód: 5 - Em disputa
      Cód: 6 - Devolvida
      Cód: 7 - Cancelada
      Cód: 8 - Debitado
      Cód: 9 - Retenção temporária
     */
    /*     * ********************************* */
    fwrite($file, "\n--------------ID do Status -----------------------\n");
    fwrite($file, $transaction->status);
    fwrite($file, "\n-------------------------------------\n");

    fwrite($file, "\n--------------Data transação -----------------------\n");
    fwrite($file, $transaction->date);
    fwrite($file, "\n-------------------------------------\n");


    fwrite($file, "\n--------------Data ultima atualização -----------------------\n");
    fwrite($file, $transaction->lastEventDate);
    fwrite($file, "\n-------------------------------------\n");


    fwrite($file, "\n--------------Tipo de pagamento -----------------------\n");
    fwrite($file, $transaction->paymentMethod->type);
    /*
      1 -Cartão de crédito;
      2 -Boleto;
      3 -Débito online (TEF);
      4 -Saldo PagSeguro;
      5 -Oi Paggo *;
      7 -Depósito em conta;
     */
    fwrite($file, "\n-------------------------------------\n");


    fwrite($file, "\n--------------Meio de pagamento -----------------------\n");
    fwrite($file, $transaction->paymentMethod->code);
    /*
      101 -Cartão de crédito Visa.
      102 -Cartão de crédito MasterCard.
      103 -Cartão de crédito American Express.
      104 -Cartão de crédito Diners.
      105 -Cartão de crédito Hipercard.
      106 -Cartão de crédito Aura.
      107 -Cartão de crédito Elo.
      108 -Cartão de crédito PLENOCard. *
      109 -Cartão de crédito PersonalCard.
      110 -Cartão de crédito JCB.
      111 -Cartão de crédito Discover.
      112 -Cartão de crédito BrasilCard.
      113 -Cartão de crédito FORTBRASIL.
      114 -Cartão de crédito CARDBAN. *
      115 -Cartão de crédito VALECARD.
      116 -Cartão de crédito Cabal.
      117 -Cartão de crédito Mais!.
      118 -Cartão de crédito Avista.
      119 -Cartão de crédito GRANDCARD.
      120 -Cartão de crédito Sorocred.
      201 -Boleto Bradesco. *
      202 -Boleto Santander.
      301 -Débito online Bradesco.
      302 -Débito online Itaú.
      303 -Débito online Unibanco. *
      304 -Débito online Banco do Brasil.
      305 -Débito online Banco Real. *
      306 -Débito online Banrisul.
      307 -Débito online HSBC.
      401 -Saldo PagSeguro.
      501 -Oi Paggo. *
      701 -Depósito em conta - Banco do Brasil
      702 -Depósito em conta - HSBC
     */

    fwrite($file, "\n-------------------------------------\n");



    fwrite($file, "\n--------------Referência interna -----------------------\n");
    fwrite($file, $transaction->reference);
    fwrite($file, "\n-------------------------------------\n");


    fwrite($file, "\n--------------ID item -----------------------\n");
    fwrite($file, $transaction->items->item->id);
    fwrite($file, "\n-------------------------------------\n");


    fwrite($file, "\n--------------Descrição item -----------------------\n");
    fwrite($file, $transaction->items->item->description);
    fwrite($file, "\n-------------------------------------\n");


    fwrite($file, "\n--------------Valor  item -----------------------\n");
    fwrite($file, $transaction->items->item->amount);
    fwrite($file, "\n-------------------------------------\n");


    fwrite($file, "\n--------------Tipo de Frete -----------------------\n");
    fwrite($file, $transaction->shipping->type);

    /*          Tipo de Frete
      1 Encomenda normal (PAC).
      2 SEDEX.
      3  Tipo de frete não especificado.
     */

    fwrite($file, "\n-------------------------------------\n");
    
     fwrite($file, "\n--------------Valor de Frete -----------------------\n");
    fwrite($file, $transaction->shipping->cost);
    fwrite($file, "\n-------------------------------------\n");




    fclose($file);
}
?>


<h3>Obrigado por efetuar a compra.</h3>
