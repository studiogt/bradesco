<?php

namespace Bradesco;

use Bradesco\Util;

class Banco {

	private $codigo;
	private $nome;

	public function __construct($codigo = '', $nome = '') {
		$this->setCodigo($codigo);
		$this->setNome($nome);
	}

	public function setCodigo($codigo = '') {
		$this->codigo = $codigo;
		return $this;
	}
	public function getCodigo() {
		return $this->codigo;
	}

	public function getDV() {
		return Util::modulo11(Util::format('9(03)',$this->getCodigo()));
	}

	public function setNome($nome = '') {
		$this->nome = $nome;
		return $this;
	}
	public function getNome() {
		return $this->nome;
	}
}