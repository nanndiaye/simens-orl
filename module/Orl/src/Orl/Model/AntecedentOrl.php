<?php
namespace Orl\Model;


class AntecedentOrl {
	public $id_antecedent;
	public $id_cons;
	public $irradiation_cervical_anterieur;
	public $goitre_atcd;
	public $ant_chirurgicaux;
	public $antecedents_specifiques;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe; 
	
	public function exchangeArray($data) {
		$this->id_antecedent = (! empty ( $data ['id_antecedent'] )) ? $data ['id_antecedent'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->irradiation_cervical_anterieur = (! empty ( $data ['irradiation_cervical_anterieur'] )) ? $data ['irradiation_cervical_anterieur'] : null;
		$this->goitre_atcd = (! empty ( $data ['goitre_atcd'] )) ? $data ['goitre_atcd'] : null;
		$this->ant_chirurgicaux = (! empty ( $data ['ant_chirurgicaux'] )) ? $data ['ant_chirurgicaux'] : null;
		$this->antecedents_specifiques = (! empty ( $data ['antecedents_specifiques'] )) ? $data ['antecedents_specifiques'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->id_employe = (! empty ( $data ['id_employe'] )) ? $data ['id_employe'] : null;
		
	}
}