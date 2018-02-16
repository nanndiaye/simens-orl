<?php
namespace Orl\Model;


class PlainteConsultation {
	public $id_plainte;
	public $id_cons;
	public $plainte_motif;
	
	
	public function exchangeArray($data) {
		$this->id_plainte = (! empty ( $data ['id_plainte'] )) ? $data ['id_plainte'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		 $this->plainte_motif = (! empty ( $data ['plainte_motif'] )) ? $data ['plainte_motif'] : null;

}
}