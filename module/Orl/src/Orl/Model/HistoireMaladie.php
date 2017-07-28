<?php
namespace Orl\Model;


class HistoireMaladie {
	public $id_histoire_maladie;
	public $id_cons;
	public $histoire_maladie;
	public $date_enregistrement;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_histoire_maladie = (! empty ( $data ['id_histoire_maladie'] )) ? $data ['id_histoire_maladie'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->histoire_maladie = (! empty ( $data ['histoire_maladie'] )) ? $data ['histoire_maladie'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}