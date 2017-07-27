<?php
namespace Orl\Model;
class SurveillanceTardive {
	public $id_st;
	public $id_cons;
	public $plainte;
	public $qualite_voix_parlee;
	public $qualite_voix_chantee;
	public $qualite_cicatrice;
	public $laryngoscopie_indirecte;
	public $palpation_cou;
	public $radiographie_pulmonaire;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_st = (! empty ( $data ['id_st'] )) ? $data ['id_st'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->plainte = (! empty ( $data ['plainte'] )) ? $data ['plainte'] : null;
		$this->qualite_voix_parlee = (! empty ( $data ['qualite_voix_parlee'] )) ? $data ['qualite_voix_parlee'] : null;
		$this->qualite_voix_chantee = (! empty ( $data ['qualite_voix_chantee'] )) ? $data ['qualite_voix_chantee'] : null;
		$this->qualite_cicatrice = (! empty ( $data ['qualite_cicatrice'] )) ? $data ['qualite_cicatrice'] : null;
		$this->laryngoscopie_indirecte = (! empty ( $data ['laryngoscopie_indirecte'] )) ? $data ['laryngoscopie_indirecte'] : null;
		$this->palpation_cou = (! empty ( $data ['palpation_cou'] )) ? $data ['palpation_cou'] : null;
		$this->radiographie_pulmonaire = (! empty ( $data ['radiographie_pulmonaire'] )) ? $data ['radiographie_pulmonaire'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}