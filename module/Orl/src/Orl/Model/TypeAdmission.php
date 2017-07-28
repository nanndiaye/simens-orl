<?php

namespace Orl\Model;

class TypeAdmission {
	public  $id_type_admission;
	Public  $nom;
	

	public function exchangeArray($data) {
		$this->id_type_admission = (! empty ( $data ['id_type_admission'] )) ? $data ['id_type_admission'] : null;
		$this->nom = (! empty ( $data ['nom'] )) ? $data ['nom'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}