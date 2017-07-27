<?php
namespace Orl\Model;
class ExamensComplementairesOrl{
	public $id_examen_complementaireOrl;
	public $id_cons;
	public $examen_complementaire;
	public $date_enregistrement;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_examen_complementaireOrl = (! empty ( $data ['id_examen_complementaireOrl'] )) ? $data ['id_examen_complementaireOrl'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->examen_complementaire = (! empty ( $data ['examen_complementaire'] )) ? $data ['examen_complementaire'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}




}