<?php
namespace Orl\Model;


class CompteRenduOperatoireOrl {
	public $id_compte_rendu;
	public $id_cons;
	public $anesthesie;
	public $incision;
	public $exploitation;
	public $geste_sur_nerf;
	public $loboithmectomie;
	public $ithmectomie;
	public $thyroidectomie_subtotale;
	public $thyroidectomie_totale;
	public $glande_parathyroide;
	public $fermeture;
	public $description_piece;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_compte_rendu = (! empty ( $data ['id_compte_rendu'] )) ? $data ['id_compte_rendu'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->anesthesie = (! empty ( $data ['anesthesie'] )) ? $data ['anesthesie'] : null;
		$this->incision = (! empty ( $data ['incision'] )) ? $data ['incision'] : null;
		$this->exploitation= (! empty ( $data ['exploitation'] )) ? $data ['exploitation'] : null;
		$this->geste_sur_nerf = (! empty ( $data ['geste_sur_nerf'] )) ? $data ['geste_sur_nerf'] : null;
		$this->loboithmectomie = (! empty ( $data ['loboithmectomie'] )) ? $data ['loboithmectomie'] : null;
		$this->ithmectomie = (! empty ( $data ['ithmectomie'] )) ? $data ['ithmectomie'] : null;
		$this->thyroidectomie_subtotale = (! empty ( $data ['thyroidectomie_subtotale'] )) ? $data ['thyroidectomie_subtotale'] : null;
		$this->thyroidectomie_totale = (! empty ( $data ['thyroidectomie_totale'] )) ? $data ['thyroidectomie_totale'] : null;
		$this->glande_parathyroide = (! empty ( $data ['glande_parathyroide'] )) ? $data ['glande_parathyroide'] : null;
		$this->fermeture = (! empty ( $data ['fermeture'] )) ? $data ['fermeture'] : null;
		$this->description_piece = (! empty ( $data ['description_piece'] )) ? $data ['description_piece'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}