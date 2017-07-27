<?php
namespace Orl\Model;


class IndicationsOperatoireOrl {
	public $id_indication;
	public $id_cons;
	public $indication_preoperatoire;
	public $indication_peroperatoire;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_indication = (! empty ( $data ['id_indication'] )) ? $data ['id_indication'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->indication_preoperatoire = (! empty ( $data ['indication_preoperatoire'] )) ? $data ['indication_preoperatoire'] : null;
		$this->indication_peroperatoire = (! empty ( $data ['indication_peroperatoire'] )) ? $data ['indication_peroperatoire'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}