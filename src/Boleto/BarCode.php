<?php

namespace Bradesco\Boleto;
use Bradesco\Util;
use Bradesco\Pessoa;
use DateTime;

class BarCode {
	private static $encoding = array(
						'NNWWN',
						'WNNNW',
						'NWNNW',
						'WWNNN',
						'NNWNW',
						'WNWNN',
						'NWWNN',
						'NNNWW',
						'WNNWN',
						'NWNWN'
					);
	public static function sizeFix($str) {
		if (strlen($str) % 2 != 0) {
			$str = '0'.$str;
		}
		return $str;
	}

	public static function getPairs($str) {
		$str = static::sizeFix($str);

		$pairs = array();
		for($i = 0; $i < strlen($str); $i+=2) {
			$pairs[] = $str[$i].$str[$i+1];
		}
		return $pairs;
	}

	public static function getEncoding($digit) {
		return static::$encoding[(int)$digit];
	}

	public static function encodePair($pair) {
		$digit1 = static::getEncoding($pair[0]);
		$digit2 = static::getEncoding($pair[1]);

		$str = '';
		for($i = 0; $i < strlen($digit1); $i++) {
			$str .= $digit1[$i].$digit2[$i];
		}

		return $str;
	}

	public static function encode($str) {
		$start = '1010';
		$end = '1101';
		$result = '';

		$pairs = static::getPairs($str);
		for($i = 0; $i < count($pairs); $i++) {
			$pairs[$i] = static::encodePair($pairs[$i]);
		}

		$res = join('', $pairs);

		for($i = 0; $i < strlen($res); $i++) {
			$d = ($i + 1) % 2;
			$char = $res[$i];
			$result .= $d;
			if ($char == 'W') {
				$result .= $d;
				$result .= $d;
			}			
		}

		return $start.$result.$end;
	}

	public static function renderFromString($str, $height = 100, $line_width = 5) {
		$str = preg_replace('/\D/','',$str);
		$encoded = static::encode($str);

		$width = strlen($encoded);

		$img = \imagecreatetruecolor($width*$line_width, $height);
		$white = \imagecolorallocate($img, 255, 255, 255);
		$black = \imagecolorallocate($img, 0, 0, 0);

		$x = 0;
		for($i = 0; $i < $width; $i++) {
			$d = $encoded[$i];
			$color = $d == '1' ? $black : $white;			

			for ($j = 0; $j < $line_width; $j++) {
				\imageline($img, $x, 0, $x, $height, $color);
				$x++;
			}

		}

		ob_start();
			\imagepng($img, null);
			$data = "data:image/png;base64,".base64_encode(ob_get_contents());
		ob_end_clean();
		\imagedestroy($img);
		return $data;
	}

	public function render($height = 100, $line_width = 5) {
		return $this->renderFromString($this->getString(), $height, $line_width);
	}

	private $vencimento;
	public function setVencimento($vencimento) {
		$this->vencimento = $vencimento;
		return $this;
	}
	public function getVencimento() {
		return $this->vencimento;
	}
	public function getFatorVencimento() {
		$vencimento = new DateTime($this->getVencimento());
		$inicio = new DAteTime('1997-10-07');
		$fator = (int)$vencimento->diff($inicio)->format('%a');

		if ($fator > 9999) {
			$fator = $fator - 9000;
		}

		return $fator;
	}

	private $beneficiario;
	public function setBeneficiario(Pessoa $beneficiario) {
		$this->beneficiario = $beneficiario;
		return $this;
	}
	public function getBeneficiario() {
		return $this->beneficiario;
	}
	
	public function setIdentificacaoBanco($identificacao_banco = 33) {
		$this->getBeneficiario()->getDadosBancarios()->getBanco()
				->setCodigo($identificacao_banco);
		return $this;
	}
	public function getIdentificacaoBanco() {
		return $this->getBeneficiario()->getDadosBancarios()->getBanco()->getCodigo();
	}

	private $valor_nominal;
	public function setValorNominal($valor_nominal) {
		$this->valor_nominal = $valor_nominal;
		return $this;
	}
	public function getValorNominal() {
		return $this->valor_nominal;
	}

	private $codigo_beneficiario;
	public function setCodigoBeneficiario($codigo_beneficiario) {
		$this->codigo_beneficiario = $codigo_beneficiario;
		return $this;
	}
	public function getCodigoBeneficiario() {
		return $this->codigo_beneficiario;
	}

	private $nosso_numero;
	public function setNossoNumero($nosso_numero) {
		$this->nosso_numero = $nosso_numero;
		return $this;
	}
	public function getNossoNumero() {
		return $this->nosso_numero;
	}

	private $tipo_modalidade_carteira;
	public function setTipoModalidadeCarteira($tipo_modalidade_carteira = 101) {
		$this->tipo_modalidade_carteira = $tipo_modalidade_carteira;
		return $this;
	}
	public function getTipoModalidadeCarteira() {
		return $this->tipo_modalidade_carteira;
	}

	public function getDV() {
		$str = $this->getString(true);
		return Util::modulo11($str, true);
	}

	public function getCampoLivre() {
		$data = array();
		$data[] = Util::format('9(04)', $this->getBeneficiario()->getDadosBancarios()->getAgencia());
		$data[] = Util::format('9(02)', $this->getBeneficiario()->getDadosBancarios()->getCarteira());
		$data[] = Util::format('9(11)', $this->getNossoNumero());
		$data[] = Util::format('9(07)', $this->getBeneficiario()->getDadosBancarios()->getConta());
		$data[] = Util::format('9(01)', 0);
		return join('', $data);
	}

	public function getString($dv = false) {
		$data = array();
		$data[] = Util::format('9(03)', $this->getIdentificacaoBanco());
		$data[] = Util::format('9(01)', 9);
		if (!$dv) {
			$data[] = Util::format('9(01)', $this->getDV());
		}
		$data[] = Util::format('9(04)', $this->getFatorVencimento());
		$data[] = Util::format('9(08)v9(2)', $this->getValorNominal());

		
		$data[] = $this->getCampoLivre();

		return join('', $data);
	}
	public function __toString() {
		return $this->getString();
	}

	public function __construct() {
		$this->setBeneficiario(new Pessoa());
		$this->getBeneficiario()->getDadosBancarios()->getBanco()->setCodigo(33);
		$this->setVencimento(date('Y-m-d'));
		$this->setValorNominal(0.00);
		$this->setCodigoBeneficiario(0);
		$this->setNossoNumero(0);
		$this->setTipoModalidadeCarteira(101);
	}
}