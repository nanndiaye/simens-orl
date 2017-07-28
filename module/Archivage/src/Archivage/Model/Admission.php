<?php
namespace Archivage\Model;

class Admission {
	public $id_admission;
	public $id_patient;
	public $id_service;
	public $date_cons;
	public $montant;
	public $numero;
	public $note;
	public $id_employe;
	public $date_enregistrement;
	public $date_archivage;
	public $heure_archivage;
	public $cons_archive_applique;
	public $archivage;

	public function exchangeArray($data) {
		$this->id_admission = (! empty ( $data ['id_admission'] )) ? $data ['id_admission'] : null;
		$this->id_patient = (! empty ( $data ['id_patient'] )) ? $data ['id_patient'] : null;
		$this->id_service = (! empty ( $data ['id_service'] )) ? $data ['id_service'] : null;
		$this->date_cons = (! empty ( $data ['date_cons'] )) ? $data ['date_cons'] : null;
		$this->montant = (! empty ( $data ['montant'] )) ? $data ['montant'] : null;
		$this->numero = (! empty ( $data ['numero'] )) ? $data ['numero'] : null;
		$this->id_employe = (! empty ( $data ['id_employe'] )) ? $data ['id_employe'] : null; 	
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->note = (! empty ( $data ['note'] )) ? $data ['note'] : null;
		$this->date_archivage = (! empty ( $data ['date_archivage'] )) ? $data ['date_archivage'] : null;
		$this->heure_archivage = (! empty ( $data ['heure_archivage'] )) ? $data ['heure_archivage'] : null;
		$this->cons_archive_applique = (! empty ( $data ['cons_archive_applique'] )) ? $data ['cons_archive_applique'] : null;
		$this->archivage = (! empty ( $data ['archivage'] )) ? $data ['archivage'] : null;
		
	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
}