<?php
namespace Orl\Model;

class NotesExamensBiologiques{
	public $code_bio;
	public $id_cons;
	public $id_examen;
	public $note_bio;

	public function exchangeArray($data) {
		$this->code_bio = (! empty ( $data ['code_bio'] )) ? $data ['code_bio'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->id_examen = (! empty ( $data ['id_examen'] )) ? $data ['id_examen'] : null;
		$this->note_bio = (! empty ( $data ['note_bio'] )) ? $data ['note_bio'] : null;
	}
}