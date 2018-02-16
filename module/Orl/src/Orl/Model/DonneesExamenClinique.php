<?php
namespace Orl\Model;


class DonneesExamenClinique {
	public $id_cons;
	public $examen_clinique;
	public $reste_examen_clinique;
	public $examen_para_clinique;
	
	public function exchangeArray($data) {
		$this->id_examen_clinique = (! empty ( $data ['id_examen_clinique'] )) ? $data ['id_examen_clinique'] : null;
		 $this->examen_clinique = (! empty ( $data ['examen_clinique'] )) ? $data ['examen_clinique'] : null;
		 $this->reste_examen_clinique = (! empty ( $data ['reste_examen_clinique'] )) ? $data ['reste_examen_clinique'] : null;
		 $this->examen_para_clinique = (! empty ( $data ['examen_para_clinique'] )) ? $data ['examen_para_clinique'] : null;
}
}