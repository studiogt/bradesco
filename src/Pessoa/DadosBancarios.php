<?php

namespace Bradesco\Pessoa;

use Bradesco\Banco;

class DadosBancarios {
	private $banco;
	private $agencia;
	private $conta;
	private $carteira;

	public function __construct() {
		$this->setBanco(new Banco());
		$this->setAgencia('');
		$this->setConta('');
		$this->setCarteira(0);
	}

	public function setBanco(Banco $banco) {
		$this->banco = $banco;
		return $this;
	}
	public function getBanco() {
		return $this->banco;
	}

	public function setAgencia($agencia = '') {
		$agencia = preg_replace('/\D/','', $agencia);
		$this->agencia = $agencia;
		return $this;
	}
	public function getAgencia() {
		return $this->agencia;
	}

	public function setConta($conta = '') {
		$conta = preg_replace('/\D/','',$conta);
		$this->conta = $conta;
		return $this;
	}
	public function getConta() {
		return $this->conta;
	}

	public function setCarteira($carteira = 0) {
		$this->carteira = (int)$carteira;
		return $this;
	}
	public function getCarteira() {
		return $this->carteira;
	}
}