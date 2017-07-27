<?php
namespace Orl\Model;


class DonneesExamenClinique {
	public $id_cons;
	public $examen_clinique;
	
	public function exchangeArray($data) {
		$this->id_examen_clinique = (! empty ( $data ['id_examen_clinique'] )) ? $data ['id_examen_clinique'] : null;
		 $this->examen_clinique = (! empty ( $data ['examen_clinique'] )) ? $data ['examen_clinique'] : null;
}
}