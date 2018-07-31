<?php 
	
	require('PagSeguro_library.php');

	$pagamento = new pgSeguro();

	for($i =0;$i<=9;$i++){
		$itens[]['nome'] = 'Item 0'.$i;
	}

	$retorno = $pagamento->envia_pgSeguro($itens);

    	$retorno;

	header('location:https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $retorno);

?>
