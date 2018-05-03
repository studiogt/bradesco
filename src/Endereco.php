<?php

namespace Bradesco;

class Endereco {
	private $cep;
	private $logradouro;
	private $numero;
	private $complemento;
	private $bairro;
	private $cidade;
	private $uf;

	public function __construct() {
		$this->setCEP('');
		$this->setLogradouro('');
		$this->setNumero('');
		$this->setComplemento('');
		$this->setBairro('');
		$this->setCidade('');
		$this->setUF('');
	}

	public function setCEP($cep = '') {
		$cep = preg_replace('/\D/','',$cep);
		$this->cep = $cep;
		return $this;
	}
	public function getCEP() {
		return $this->cep;
	}

	public function setLogradouro($logradouro = '') {
		$this->logradouro = $logradouro;
		return $this;
	}
	public function getLogradouro() {
		return $this->logradouro;
	}

	public function setNumero($numero = '') {
		$this->numero = $numero;
		return $this;
	}
	public function getNumero() {
		return $this->numero;
	}

	public function setComplemento($complemento = '') {
		$this->complemento = $complemento;
		return $this;
	}
	public function getComplemento() {
		return $this->complemento;
	}

	public function setBairro($bairro = '') {
		$this->bairro = $bairro;
		return $this;
	}
	public function getBairro() {
		return $this->bairro;
	}

	public function setCidade($cidade = '') {
		$this->cidade = $cidade;
		return $this;
	}
	public function getCidade() {
		return $this->cidade;
	}

	public function setUF($uf = '') {
		$this->uf = $uf;
		return $this;
	}
	public function getUF() {
		return $this->uf;
	}


}