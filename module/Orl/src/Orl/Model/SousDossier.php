<?php

namespace Orl\Model;

class SousDossier {
	public  $id_sous_dossier;
	Public  $type_dossier;
	

	public function exchangeArray($data) {
		$this->id_sous_dossier = (! empty ( $data ['id_sous_dossier'] )) ? $data ['id_sous_dossier'] : null;
		$this->type_dossier = (! empty ( $data ['type_dossier'] )) ? $data ['type_dossier'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}