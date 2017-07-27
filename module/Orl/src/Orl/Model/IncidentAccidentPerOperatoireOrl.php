<?php
namespace Orl\Model;


class IncidentAccidentPerOperatoireOrl {
	public $id_incident;
	public $id_cons;
	public $incident_anesthesique;
	public $groupeIVb;
	public $groupeIVa;
	public $incident_chirurgicaux;
	public $incident_glandulaire;
	public $incident_tracheotomie;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe; 
	
	public function exchangeArray($data) {
		$this->id_incident = (! empty ( $data ['id_incident'] )) ? $data ['id_incident'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->incident_anesthesique = (! empty ( $data ['incident_anesthesique'] )) ? $data ['incident_anesthesique'] : null;
		$this->groupeIVb = (! empty ( $data ['groupeIVb'] )) ? $data ['groupeIVb'] : null;
		$this->groupeIVa = (! empty ( $data ['groupeIVa'] )) ? $data ['groupeIVa'] : null;
		$this->incident_chirurgicaux = (! empty ( $data ['incident_chirurgicaux'] )) ? $data ['incident_chirurgicaux'] : null;
		$this->incident_glandulaire = (! empty ( $data ['incident_glandulaire'] )) ? $data ['incident_glandulaire'] : null;
		$this->incident_tracheotomie = (! empty ( $data ['incident_tracheotomie'] )) ? $data ['incident_tracheotomie'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->id_employe = (! empty ( $data ['id_employe'] )) ? $data ['id_employe'] : null;
		
	}
}