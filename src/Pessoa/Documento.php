<?php

namespace Bradesco\Pessoa;

class Documento {
	const OUTRO = 0;
	const CPF = 1;
	const CNPJ = 2;

	private $tipo;
	private $numero;

	public function __construct($numero = '') {		
		$this->setNumero($numero);
	}

	public function setTipo($tipo = 0) {
		$this->tipo == (int)$tipo;
		return $this;
	}
	public function getTipo() {
		return $this->tipo;
	}

	public function setNumero($numero = '') {
		$numero = preg_replace('/[^\d\.\-]/','', $numero);
		$this->numero = $numero;

		$len = strlen($numero);
		switch ($len) {
			case 11:
				$this->setTipo(Documento::CPF);
				break;
			case 14:
				$this->setTipo(Documento::CNPJ);
				break;
			default:
				$this->setTipo(Documento::OUTRO);
				break;
		}
		return $this;
	}
	public function getNumero() {
		return $this->numero;
	}
}