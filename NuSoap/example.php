<?php


require('NuSoap_library.php');

    
    
    $api_url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx'; // ex. http://www.example.com/index.php/soapserver
    $api_username = '';
    $api_password = '';
    $service = "CalcPrecoPrazo"; // from my POST <a href="http://www.php-guru.in/2013/soap-server-in-codeigniter-using-nusoap-library/" target="_blank">SOAP Server In CodeIgniter using NuSOAP PHP Toolkit</a>
    
      
    $params['nCdEmpresa'] = '';
    $params['sDsSenha'] = '';
    $params['sCepOrigem'] = '99010690';
    $params['sCepDestino'] = '99500000';
    $params['nVlPeso'] = '1';
    $params['nCdFormato'] = '1';
        //1 - Formato caixa/pacote
        //2 – Formato rolo/prisma
        //3 -Envelope
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
