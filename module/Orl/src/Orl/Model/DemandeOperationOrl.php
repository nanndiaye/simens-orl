<?php
namespace Orl\Model;


class HormonesTyroidiennesOrl {
	public $id_hormones_tyrodiennes; 
	public $id_cons;
	public $t3;
	public $t4;
	public $tsh;
	public $hyperthyroidie;
	public $euthyroidie;
	public $hypothyroide;
	public $cytologie;
	public $autres;
	public $vpa;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_hormones_tyrodiennes = (! empty ( $data ['id_hormones_tyrodiennes'] )) ? $data ['id_hormones_tyrodiennes'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->t3 = (! empty ( $data ['t3'] )) ? $data ['t3'] : null;
		$this->t4 = (! empty ( $data ['t4'] )) ? $data ['t4'] : null;
		$this->tsh = (! empty ( $data ['tsh'] )) ? $data ['tsh'] : null;
		$this->hyperthyroidie = (! empty ( $data ['hyperthyroidie'] )) ? $data ['hyperthyroidie'] : null;
		$this->euthyroidie = (! empty ( $data ['euthyroidie'] )) ? $data ['euthyroidie'] : null;
		$this->hypothyroide = (! empty ( $data ['hypothyroide'] )) ? $data ['hypothyroide'] : null;
		$this->cytologie = (! empty ( $data ['cytologie'] )) ? $data ['cytologie'] : null;
		$this->autres = (! empty ( $data ['autres'] )) ? $data ['autres'] : null;
		$this->vpa = (! empty ( $data ['vpa'] )) ? $data ['vpa'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}