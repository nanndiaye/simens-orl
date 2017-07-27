<?php
namespace Orl\Model;


class HormonesTyroidiennesOrl {
	public $id_hormones_tyrodiennes; 
	public $id_cons;
	public $t3;
	public $t4;
	public $tsh;
	public $groupeIIIa;
	public $groupeIIIb;
	public $groupeIIIc;
	public $cytologie;
	public $autres;
	public $echographie_cervicale;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_hormones_tyrodiennes = (! empty ( $data ['id_hormones_tyrodiennes'] )) ? $data ['id_hormones_tyrodiennes'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		//$this->t3 = (! empty ( $data ['t3'] )) ? $data ['t3'] : null;
		$this->t4 = (! empty ( $data ['t4'] )) ? $data ['t4'] : null;
		$this->tsh = (! empty ( $data ['tsh'] )) ? $data ['tsh'] : null;
		$this->groupeIIIa = (! empty ( $data ['groupeIIIa'] )) ? $data ['groupeIIIa'] : null;
		$this->groupeIIIb = (! empty ( $data ['groupeIIIb'] )) ? $data ['groupeIIIb'] : null;
		$this->groupeIIIc = (! empty ( $data ['groupeIIIc'] )) ? $data ['groupeIIIc'] : null;
		$this->cytologie = (! empty ( $data ['cytologie'] )) ? $data ['cytologie'] : null;
		$this->autres = (! empty ( $data ['autres'] )) ? $data ['autres'] : null;
		$this->echographie_cervicale = (! empty ( $data ['echographie_cervicale'] )) ? $data ['echographie_cervicale'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}