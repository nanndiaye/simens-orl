<?php
namespace Orl\Model;


class GroupesGanglionnaires {
	public $id_groupesGC;
	public $id_cons;
	public $groupeI;
	public $groupeIIa;
	public $groupeIIb;
	public $groupeIII;
	public $groupeIV;
	public $groupeV;
	public $groupeVI;
	public $libre;
	public $atteinte;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_tyroide = (! empty ( $data ['id_groupesGC'] )) ? $data ['id_groupesGC'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->groupeI = (! empty ( $data ['groupeI'] )) ? $data ['groupeI'] : null;
		$this->groupeIIa = (! empty ( $data ['groupeIIa'] )) ? $data ['groupeIIa'] : null;
		$this->groupeIIb = (! empty ( $data ['groupeIIb'] )) ? $data ['groupeIIb'] : null;
		$this->groupeIII = (! empty ( $data ['groupeIII'] )) ? $data ['groupeIII'] : null;
		$this->groupeIV = (! empty ( $data ['groupeIV'] )) ? $data ['groupeIV'] : null;
		$this->groupeV = (! empty ( $data ['groupeV'] )) ? $data ['groupeV'] : null;
		$this->groupeVI = (! empty ( $data ['groupeVI'] )) ? $data ['groupeVI'] : null;
		$this->libre = (! empty ( $data ['libre'] )) ? $data ['libre'] : null;
		$this->atteinte = (! empty ( $data ['atteinte'] )) ? $data ['atteinte'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}