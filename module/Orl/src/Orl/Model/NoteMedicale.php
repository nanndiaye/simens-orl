<?php
namespace Orl\Model;


class NoteMedicale {
	public $id_note_medicale;
	public $id_cons;
	public $nouvelle_note_medicale;
	
	
	public function exchangeArray($data) {
		$this->id_note_medicale = (! empty ( $data ['id_note_medicale'] )) ? $data ['id_note_medicale'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		 $this->nouvelle_note_medicale = (! empty ( $data ['nouvelle_note_medicale'] )) ? $data ['nouvelle_note_medicale'] : null;

}
}