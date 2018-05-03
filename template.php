<?php
	$logo = base64_encode(file_get_contents(__DIR__.'/img/logo.png'));
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<style type="text/css">
			body {
				margin: 0;
				padding: 10mm;
				box-sizing: border-box;
			}
			* {
				font-family: sans-serif;
			}
			.recibo-pagador, .boleto {
				width: 190mm;				
			}

				.header {
						display: grid;
						border-bottom: 0.8mm solid black;
						grid-template-columns: 30mm 20mm 1fr;
						height: 6mm;
				}
				.header .logo,
				.header .codigo-banco {
							border-right: 0.8mm solid black;

				}
				.header .codigo-banco {
							font-size: 5mm;
							font-weight: bold;
							text-align: center;					
							
				}
				.header .logo img {
					height: 5.5mm;
				}
				.header .text-right {
					text-align: right;
					font-size: 3.5mm;
					font-weight: bold;
					align-self: center;
				}
				.text-right {
					text-align: right;
					display: block;
				}
				.content .row {
					display: grid;
					grid-template-columns: repeat(12, 1fr);
					border-bottom: 1px solid black;
				}
					.content .row .columns {
						border-right: 1px solid black;
						font-size: 2.5mm;
						padding: 1mm;
					}
					.content .row .columns strong {
						font-size: 2.7mm;
					}
					.content .row .columns {
						align-self: center;
						box-sizing: border-box;
						height: 100%;
						align-self: center;
					}
					.content .row .columns:last-child {
						border-right: none;
					}
					.content .row .columns.large-1-12 {
						grid-column: span 1;
					}
					.content .row .columns.large-2-12 {
						grid-column: span 2;
					}
					.content .row .columns.large-3-12 {
						grid-column: span 3;
					}
					.content .row .columns.large-4-12 {
						grid-column: span 4;
					}
					.content .row .columns.large-5-12 {
						grid-column: span 5;
					}
					.content .row .columns.large-6-12 {
						grid-column: span 6;
					}
					.content .row .columns.large-7-12 {
						grid-column: span 7;
					}
					.content .row .columns.large-8-12 {
						grid-column: span 8;
					}
					.content .row .columns.large-9-12 {
						grid-column: span 9;
					}
					.content .row .columns.large-10-12 {
						grid-column: span 10;
					}
					.content .row .columns.large-11-12 {
						grid-column: span 11;
					}
					.content .row .columns.large-12-12 {
						grid-column: span 12;
					}
					.content .row .columns.no-padding {
						padding: 0;
					}
					.grid-5 {
						display: grid;
						grid-template-columns: repeat(5, 1fr);
					}
						.grid-5 .cell-1 {
							padding: 1mm;
							grid-column: span 1;
							border-right: 1px solid black;
						}
						.grid-5 .cell-1:last-child {
							border: none;
						}
					.content .row .columns.no-border {
						border: none;
					}
					.content .row.no-border {
						border: none;
					}
					.recibo-pagador .content .row:last-child {
						border-bottom: none;
						border-top: 2px solid black;
					}
			.linha-pontilhada {
				border-bottom: 1px dashed black;
				text-align: right;
				padding-top: 7mm;
				padding-right: 5mm;
				box-sizing: border-box;
				width: 190mm;
				font-size: 2.7mm;
				margin-bottom: 4mm;
			}

			.boleto .border-bottom {
				border-bottom: 1px solid black;
				padding: 1mm;
			}
			.boleto .padding {
				padding: 1mm;
			}
			.boleto .content .row.border-top {
				border-top: 2px solid black;
			}
			.boleto .content .row:last-child {
				border-top: 2px solid black;
				border-bottom: none;
			}
			.boleto .content .row:last-child img {
				height: 13mm
			}
			.boleto .content .row:last-child .columns:first-child {
				padding-left: 0;
			}
		</style>
	</head>
	<body>
		<div class="recibo-pagador">
			<div class="header">
				<div class="logo">
					<img src="data:image/png;base64,<?php echo $logo;?>">
				</div>
				<div class="codigo-banco"><?php echo $beneficiario->getDadosBancarios()->getBanco()->getCodigo()?>-<?php echo $beneficiario->getDadosBancarios()->getBanco()->getDV()?></div>
				<div class="text-right">
					RECIBO DO PAGADOR

				</div>
			</div>
			<div class="content">
				<div class="row">
					<div class="columns large-9-12">
						Local de Pagamento <br />
						<center><strong>Pagável Preferencialmente no Bradesco</strong></center>
					</div>
					<div class="columns large-3-12">
						Vencimento<br />
						<strong class="text-right"><?php echo date('d/m/Y',strtotime($boleto->getVencimento()))?></strong>
					</div>
				</div>
				<div class="row">
					<div class="columns large-9-12">
						Beneficiário <br />
						<strong>
							<?php echo $beneficiario->getNome();?> - <?php echo $beneficiario->getDocumento()->getNumero();?>
							<br />
							<?php echo $beneficiario->getEndereco()->getLogradouro()?>, 
							<?php echo $beneficiario->getEndereco()->getNumero()?> 
							<?php echo $beneficiario->getEndereco()->getComplemento()?> -
							<?php echo $beneficiario->getEndereco()->getBairro()?> -
							<?php echo $beneficiario->getEndereco()->getCEP()?> -
							<?php echo $beneficiario->getEndereco()->getCidade()?> -
							<?php echo $beneficiario->getEndereco()->getUF()?>
						</strong>

					</div>
					<div class="columns large-3-12">
						Agência / Cod. Beneficiário <br />
						<strong class="text-right">
							<?php echo \Bradesco\Util::format('9(07)',$beneficiario->getDadosBancarios()->getAgencia());?>
							<?php echo \Bradesco\Util::format('9(09)',$boleto->getCodigoBeneficiario());?>

						</strong>
					</div>

				</div>
				<div class="row">
					<div class="columns large-9-12 no-padding">
						<div class="grid-5">
							<div class="cell-1">
								Data do documento<br />
								<center><strong><?php echo date('d/m/Y',strtotime($boleto->getDataDocumento()))?></strong></center>
							</div>
							<div class="cell-1">
								No. do documento<br />
								<center><strong><?php echo $boleto->getNossoNumero()?></strong></center>
							</div>
							<div class="cell-1">
								Espécie doc.<br />
								<center><strong>DM</strong></center>
							</div>
							<div class="cell-1">
								Aceite<br />
								<center><strong>NAO ACEITO</strong></center>
							</div>
							<div class="cell-1">
								Data Processamento<br />
								<center><strong><?php echo date('d/m/Y',strtotime($boleto->getDataProcessamento()))?></strong></center>
							</div>							
						</div>
					</div>
					<div class="columns large-3-12">
						Nosso Número<br />
						<strong class="text-right"><?php echo \Bradesco\Util::format('9(013)',$boleto->getNossoNumero());?></strong>
					</div>

				</div>
				<div class="row">
					<div class="columns large-9-12 no-padding">
						<div class="grid-5">
							<div class="cell-1">
								Uso do Banco<br />
								&nbsp;
							</div>
							<div class="cell-1">
								Carteira<br />
								<center><strong>RAPIDA C/REG</strong></center>
							</div>
							<div class="cell-1">
								Espécie Moeda.<br />
								<center><strong>REAL</strong></center>
							</div>
							<div class="cell-1">
								Quantidade<br />
								&nbsp;
							</div>
							<div class="cell-1">
								(x) Valor<br />
								&nbsp;
							</div>							
						</div>
					</div>
					<div class="columns large-3-12">
						(=) Valor do Documento<br />					
						<strong class="text-right"><?php echo number_format($boleto->getValor(),2,',','.');?></strong>
					</div>
				</div>
				<div class="row">
					<div class="columns large-12-12">
						Instruções (Texto de Responsabilidade do Beneficiário)<br />
						<strong>
							<center>BOLETO DE PROPOSTA</center>
							ESTE BOLETO SE REFERE A UMA PROPOSTA JÁ FEITA A VOCÊ E O SEU PAGAMENTO
							NÃO É OBRIGATÓRIO.<br />
							Deixar de pagá-lo não dará causa a protesto, a cobrança judicial ou extrajudicial, nem a
							inserção de seu nome em cadastro de restrição ao crédito.<br />
							Pagar até a data de vencimento significa aceitar a proposta.<br />
							Informações adicionais sobre a proposta e sobre o respectivo contrato poderão ser solicitadas
							a qualquer momento ao beneficiário, por meio de seus canais de atendimento.
						</strong>
					</div>
				</div>
				<div class="row no-border">
					<div class="columns large-2-12 no-border">
						Pagador:
					</div>
					<div class="columns large-5-12 no-border">
						<?php echo $pagador->getNome()?><br />
						<?php echo $pagador->getEndereco()->getLogradouro()?>,
						<?php echo $pagador->getEndereco()->getNumero()?>
						<?php echo $pagador->getEndereco()->getComplemento()?>,
						<?php echo $pagador->getEndereco()->getBairro()?><br />
						<?php echo $pagador->getEndereco()->getCEP()?> - 
						<?php echo $pagador->getEndereco()->getCidade()?> - 
						<?php echo $pagador->getEndereco()->getUF()?>


						<br />
					</div>					
					<div class="columns large-2-12 no-border">
						<?php echo $pagador->getDocumento()->getNumero();?>
					</div>
					<div class="columns large-3-12 no-border"></div>
				</div>
				<div class="row">
					<div class="columns large-1-12 no-border">
						Sacador/Avalista:
					</div>
					<div class="columns large-7-12 no-border">
						&nbsp;
					</div>					
					<div class="columns large-1-12 no-border">
						&nbsp;
					</div>
					<div class="columns large-3-12 no-border">
						Código de Baixa
					</div>

				</div>
				<div class="row">
					<div class="columns large-9-12 no-border"></div>
					<div class="columns large-3-12">
						<center>Autenticação Mecânica</center>
					</div>
				</div>
			</div>
		</div>
		<div class="linha-pontilhada">			
			Corte na Linha Pontilhada
		</div>
		<div class="boleto">
			<div class="header">
				<div class="logo">
					<img src="data:image/png;base64,<?php echo $logo;?>">
				</div>
				<div class="codigo-banco"><?php echo $beneficiario->getDadosBancarios()->getBanco()->getCodigo()?>-<?php echo $beneficiario->getDadosBancarios()->getBanco()->getDV()?></div>
				<div class="text-right">
					<?php echo $boleto->getLinhaDigitavel()?>
				</div>
			</div>
			<div class="content">
				<div class="row">
					<div class="columns large-9-12">
						Local de Pagamento <br />
						<center><strong>Pagável Preferencialmente no Bradesco</strong></center>
					</div>
					<div class="columns large-3-12">
						Vencimento<br />
						<strong class="text-right"><?php echo date('d/m/Y',strtotime($boleto->getVencimento()))?></strong>
					</div>
				</div>
				<div class="row">
					<div class="columns large-9-12">
						Beneficiário <br />
						<strong>
							<?php echo $beneficiario->getNome();?> - <?php echo $beneficiario->getDocumento()->getNumero();?>
							<br />
							<?php echo $beneficiario->getEndereco()->getLogradouro()?>, 
							<?php echo $beneficiario->getEndereco()->getNumero()?> 
							<?php echo $beneficiario->getEndereco()->getComplemento()?> -
							<?php echo $beneficiario->getEndereco()->getBairro()?> -
							<?php echo $beneficiario->getEndereco()->getCEP()?> -
							<?php echo $beneficiario->getEndereco()->getCidade()?> -
							<?php echo $beneficiario->getEndereco()->getUF()?>
						</strong>

					</div>
					<div class="columns large-3-12">
						Agência / Cod. Beneficiário <br />
						<strong class="text-right">
							<?php echo \Bradesco\Util::format('9(07)',$beneficiario->getDadosBancarios()->getAgencia());?>
							<?php echo \Bradesco\Util::format('9(09)',$boleto->getCodigoBeneficiario());?>

						</strong>
					</div>
				</div>
				<div class="row">
					<div class="columns large-9-12 no-padding">
						<div class="grid-5">
							<div class="cell-1">
								Data do documento<br />
								<center><strong><?php echo date('d/m/Y',strtotime($boleto->getDataDocumento()))?></strong></center>
							</div>
							<div class="cell-1">
								No. do documento<br />
								<center><strong><?php echo $boleto->getNossoNumero()?></strong></center>
							</div>
							<div class="cell-1">
								Espécie doc.<br />
								<center><strong>DM</strong></center>
							</div>
							<div class="cell-1">
								Aceite<br />
								<center><strong>NAO ACEITO</strong></center>
							</div>
							<div class="cell-1">
								Data Processamento<br />
								<center><strong><?php echo date('d/m/Y',strtotime($boleto->getDataProcessamento()))?></strong></center>
							</div>							
						</div>
					</div>
					<div class="columns large-3-12">
						Nosso Número<br />
						<strong class="text-right"><?php echo \Bradesco\Util::format('9(013)',$boleto->getNossoNumero());?></strong>
					</div>
				</div>
				<div class="row">
					<div class="columns large-9-12 no-padding">
						<div class="grid-5">
							<div class="cell-1">
								Uso do Banco<br />
								&nbsp;
							</div>
							<div class="cell-1">
								Carteira<br />
								<center><strong>RAPIDA C/REG</strong></center>
							</div>
							<div class="cell-1">
								Espécie Moeda.<br />
								<center><strong>REAL</strong></center>
							</div>
							<div class="cell-1">
								Quantidade<br />
								&nbsp;
							</div>
							<div class="cell-1">
								(x) Valor<br />
								&nbsp;
							</div>							
						</div>
					</div>
					<div class="columns large-3-12">
						(=) Valor do Documento<br />					
						<strong class="text-right"><?php echo number_format($boleto->getValor(),2,',','.');?></strong>
					</div>
				</div>
				<div class="row">
					<div class="columns large-9-12">
						Instruções (Texto de Responsabilidade do Beneficiário)
						<br /><br />
						<strong>
							BANCO AUTORIZADO A RECEBER ATÉ <?php echo date('d/m/Y',strtotime($boleto->getVencimento()))?>.<br />
						</strong>
						
					</div>
					<div class="columns large-3-12 no-padding">
						<div class="border-bottom">
							(-) Descontos/Abatimento<br />
							&nbsp;
						</div>
						<div class="border-bottom">
							&nbsp;<br />
							&nbsp;
						</div>
						<div class="border-bottom">
							(+) Moras/Multa<br />
							&nbsp;
						</div>
						<div class="border-bottom">
							&nbsp;<br />
							&nbsp;
						</div>
						<div class="padding">
							(=) Valor Cobrado<br />
							&nbsp;
						</div>
					</div>
				</div>
				<div class="row no-border border-top">
					<div class="columns large-2-12 no-border">
						Pagador:
					</div>
					<div class="columns large-5-12 no-border">
						<?php echo $pagador->getNome()?><br />
						<?php echo $pagador->getEndereco()->getLogradouro()?>,
						<?php echo $pagador->getEndereco()->getNumero()?>
						<?php echo $pagador->getEndereco()->getComplemento()?>,
						<?php echo $pagador->getEndereco()->getBairro()?><br />
						<?php echo $pagador->getEndereco()->getCEP()?> - 
						<?php echo $pagador->getEndereco()->getCidade()?> - 
						<?php echo $pagador->getEndereco()->getUF()?>


						<br />
					</div>					
					<div class="columns large-2-12 no-border">
						<?php echo $pagador->getDocumento()->getNumero();?>
					</div>
					<div class="columns large-3-12 no-border">
						<center><strong>Ficha de Compensação</strong></center>
					</div>
				</div>
				<div class="row">
					<div class="columns large-1-12 no-border">
						Sacador/Avalista:
					</div>
					<div class="columns large-7-12 no-border">
						&nbsp;
					</div>					
					<div class="columns large-1-12 no-border">
						&nbsp;
					</div>
					<div class="columns large-3-12 no-border">
						Código de Baixa
					</div>

				</div>
				<div class="row">
					<div class="columns large-9-12 no-border">
						<img src="<?php echo $boleto->getBarCode()->render(600, 15);?>">
					</div>
					<div class="columns large-3-12">
						<center>Autenticação Mecânica</center>
					</div>
				</div>
			</div>
		</div>
		<div class="linha-pontilhada">
			Corte na Linha Pontilhada
		</div>
	</body>
</html>