<?php
namespace Orl\Model;


class MotifHospitalisationOrl {
	public $id_motif;
	public $id_cons;
	public $tumefaction_cervical_anterieur;
	public $signes_thyroxicose;
	public $signe_compression;
	public $groupeIa;
	public $groupeIb;
	public $groupeIc;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_motif = (! empty ( $data ['id_motif'] )) ? $data ['id_motif'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->tumefaction_cervical_anterieur = (! empty ( $data ['tumefaction_cervical_anterieur'] )) ? $data ['tumefaction_cervical_anterieur'] : null;
		$this->signes_thyroxicose = (! empty ( $data ['signes_thyroxicose'] )) ? $data ['signes_thyroxicose'] : null;
		$this->signe_compression = (! empty ( $data ['signe_compression'] )) ? $data ['signe_compression'] : null;
		$this->groupeIa = (! empty ( $data ['groupeIa'] )) ? $data ['groupeIa'] : null;
		$this->groupeIb = (! empty ( $data ['groupeIb'] )) ? $data ['groupeIb'] : null;
		$this->groupeIc = (! empty ( $data ['groupeIc'] )) ? $data ['groupeIc'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
		
	}
}