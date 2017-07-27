<?php
namespace Orl\Model;


class PeauCervicauFacialeOrl {
	public $id_peau;
	public $id_cons;
	public $depigmentation_artificielle;
	public $cicatrices_taches_fistules;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e; 
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_peau = (! empty ( $data ['id_peau'] )) ? $data ['id_peau'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->depigmentation_artificielle = (! empty ( $data ['depigmentation_artificielle'] )) ? $data ['depigmentation_artificielle'] : null;
		$this->cicatrices_taches_fistules = (! empty ( $data ['cicatrices_taches_fistules'] )) ? $data ['cicatrices_taches_fistules'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}
