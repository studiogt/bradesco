<?php

namespace Bradesco;

use Bradesco\Pessoa\Documento;
use Bradesco\Pessoa\DadosBancarios;


class Pessoa {
	private $nome;
	private $documento;
	private $endereco;
	private $dados_bancarios;

	public function __construct($nome = '') {
		$this->setNome($nome);
		$this->documento = new Documento();
		$this->endereco = new Endereco();
		$this->dados_bancarios = new DadosBancarios();
	}

	public function setNome($nome = '') {
		$this->nome = $nome;
		return $this;
	}
	public function getNome() {
		return $this->nome;
	}

	public function setDocumento(Documento $documento) {
		$this->documento = $documento;
		return $this;
	}
	public function getDocumento() {
		return $this->documento;
	}

	public function setEndereco(Endereco $endereco) {
		$this->endereco = $endereco;
		return $this;
	}
	public function getEndereco() {
		return $this->endereco;
	}

	public function setDadosBancarios(DadosBancarios $dados_bancarios) {
		$this->dados_bancarios = $dados_bancarios;
		return $this;
	}
	public function getDadosBancarios() {
		return $this->dados_bancarios;
	}
}