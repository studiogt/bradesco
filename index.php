<?php


require 'vendor/autoload.php';
	
$boleto = new \Bradesco\Boleto();

$beneficiario = $boleto->getBeneficiario();
$beneficiario->getDadosBancarios()
					->setAgencia('3381')		
					->setConta('633')		
					->setCarteira('26')		
				->getBanco()->setCodigo('237');
$beneficiario->getEndereco()
				->setLogradouro("Almirante Barroso")
				->setNumero('735 sala 402')
				->setBairro('Floresta')
				->setCidade('Porto Alegre')
				->setCEP('90220-021')
				->setUF('RS');
$beneficiario->setNome("Nu Pagamentos S.A.");
$beneficiario->getDocumento()
				->setNumero('26');					


$pagador = $boleto->getPagador();
$pagador->setNome("Fábio da Silva Dias")
		->getDocumento()
				->setNumero('007.550.710-26');
$pagador->getEndereco()
				->setLogradouro("José Pinto Menezes")
				->setNumero('207')
				->setBairro('Estalagem')
				->setCidade('Viamão')
				->setCEP('94425-340')
				->setUF('RS');

$boleto->setVencimento('2018-05-30');
$boleto->setValor(3.00);
$boleto->setCodigoBeneficiario('633');
$boleto->setNossoNumero('00069264504');

//header("Content-type: application/pdf");
echo $boleto->renderHTML();