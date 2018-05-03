<?php

namespace Bradesco;

use Bradesco\Boleto\BarCode;
use Bradesco\Boleto\LinhaDigitavel;


class Boleto {

	public function __construct() {
		$this->setLinhaDigitavel(new LinhaDigitavel());
		$this->setBeneficiario(new Pessoa());
		$this->setPagador(new Pessoa());
		$this->setDataProcessamento(date('Y-m-d'));
		$this->setDataDocumento(date('Y-m-d'));
	}

	private $linha_digitavel;
	public function setLinhaDigitavel(LinhaDigitavel $linha_digitavel) {
		$this->linha_digitavel = new LinhaDigitavel();
		return $this;
	}
	public function getLinhaDigitavel() {
		return $this->linha_digitavel;
	}

	public function setBarCode(BarCode $bar_code) {
		$this->getLinhaDigitavel()->setBarCode($bar_code);		
		return $this;
	}
	public function getBarCode() {
		return $this->getLinhaDigitavel()->getBarCode();
	}

	
	public function setBeneficiario(Pessoa $beneficiario) {
		$this->getBarCode()->setBeneficiario($beneficiario);
		return $this;
	}
	public function getBeneficiario() {
		return $this->getBarCode()->getBeneficiario();
	}

	private $pagador;
	public function setPagador(Pessoa $pagador) {
		$this->pagador = $pagador;
		return $this;
	}
	public function getPagador() {
		return $this->pagador;
	}

	public function setVencimento($vencimento) {
		$this->getBarCode()->setVencimento($vencimento);
		return $this;
	}
	public function getVencimento() {
		return $this->getBarCode()->getVencimento();
	}

	public function setValor($valor) {
		$this->getBarCode()->setValorNominal($valor);
		return $this;
	}
	public function getValor() {
		return $this->getBarCode()->getValorNominal();
	}

	public function setCodigoBeneficiario($codigo_beneficiario) {
		$this->getBarCode()->setCodigoBeneficiario($codigo_beneficiario);
		return $this;
	}
	public function getCodigoBeneficiario() {
		return $this->getBarCode()->getCodigoBeneficiario();
	}

	public function setNossoNumero($nosso_numero) {
		$this->getBarCode()->setNossoNumero($nosso_numero);
		return $this;
	}
	public function getNossoNumero() {
		return $this->getBarCode()->getNossoNumero();
	}

	public function setTipoModalidadeCarteira($tipo_modalidade_carteira) {
		$this->getBarCode()->setTipoModalidadeCarteira($tipo_modalidade_carteira);
		return $this;
	}
	public function getTipoModalidadeCarteira() {
		return $this->getBarCode()->getTipoModalidadeCarteira();
	}

	private $data_processamento;
	public function setDataProcessamento($data_processamento) {
		$this->data_processamento = $data_processamento;
	}
	public function getDataProcessamento() {
		return $this->data_processamento;
	}

	private $data_documento;
	public function setDataDocumento($data_documento) {
		$this->data_documento = $data_documento;
	}
	public function getDataDocumento() {
		return $this->data_documento;
	}
	public function renderHTML() {
		$boleto = $this;
		$beneficiario = $boleto->getBeneficiario();
		$pagador = $boleto->getPagador();
		$barcode = $boleto->getBarCode();
		$linhaDigitavel = $boleto->getLinhaDigitavel();
		
		ob_start();
		include dirname(__DIR__).'/template.php';
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	public function renderPDF() {
		$ch = curl_init("https://studiogt.herokuapp.com/pdf");
		//$ch = curl_init("http://studiogt:8080/pdf");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
			'content' => $this->renderHTML()
		)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$pdf = curl_exec($ch);
		curl_close($ch);
		return $pdf;
	}
}