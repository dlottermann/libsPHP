<?php


require('NuSoap_library.php');

    
    
    $api_url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx';
    $api_username = '';
    $api_password = '';
    $service = "CalcPrecoPrazo"; 
    
      
    $params['nCdEmpresa'] = '';
    $params['sDsSenha'] = '';
    $params['sCepOrigem'] = '99010690';
    $params['sCepDestino'] = '99500000';
    $params['nVlPeso'] = '1';
    $params['nCdFormato'] = '1';
    $params['nVlComprimento'] = '16';
    $params['nVlAltura'] = '9';
    $params['nVlLargura'] = '18';
    $params['nVlDiametro'] = '0';
    $params['sCdMaoPropria'] = 'n';
    $params['nVlValorDeclarado'] = '200';
    $params['sCdAvisoRecebimento'] = 'n';
    $params['StrRetorno'] = 'xml';
    $params['nCdServico'] = '04014,04510';


    $client = new NuSoap_library();

    echo '<pre>';
    print_r($client->soaprequest($api_url,$service,$params));
