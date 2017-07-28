<?php
namespace Orl\Model;


class PeriodePostOperatoirePrecoce {
	public $id_ppop;
	public $id_cons;
	public $calcemie;
	public $laryngectomie_indirecte;
	public $ablation_drain;
	public $ablation_fil;
	public $accident_hemoragie;
	public $accident_infectieux;
	public $autresAccident;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;
	
	public function exchangeArray($data) {
		$this->id_ppop = (! empty ( $data ['id_ppop'] )) ? $data ['id_ppop'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->calcemie = (! empty ( $data ['calcemie'] )) ? $data ['calcemie'] : null;
		$this->laryngectomie_indirecte = (! empty ( $data ['laryngectomie_indirecte'] )) ? $data ['laryngectomie_indirecte'] : null;
		$this->ablation_drain= (! empty ( $data ['ablation_drain'] )) ? $data ['ablation_drain'] : null;
		$this->ablation_fil = (! empty ( $data ['ablation_fil'] )) ? $data ['ablation_fil'] : null;
		$this->accident_hemoragie = (! empty ( $data ['accident_hemoragie'] )) ? $data ['accident_hemoragie'] : null;
		$this->accident_infectieux = (! empty ( $data ['accident_infectieux'] )) ? $data ['accident_infectieux'] : null;
		$this->autresAccident = (! empty ( $data ['autresAccident'] )) ? $data ['autresAccident'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}