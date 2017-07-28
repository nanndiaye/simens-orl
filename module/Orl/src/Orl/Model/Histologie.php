<?php
namespace Orl\Model;


class Histologie {
	public $id_histologie;
	public $id_cons;
	public $histologie;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_histologie = (! empty ( $data ['id_histologie'] )) ? $data ['id_histologie'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->histologie = (! empty ( $data ['histologie'] )) ? $data ['histologie'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}