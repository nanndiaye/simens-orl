<?php
namespace Orl\Model;


class Tyroide {
	public $id_tyroide;
	public $id_cons;
	public $hypertrophie_globale;
	public $hypertrophie_localise;
	public $hypertrophie_nodulaire;
	public $hypertrophie_sensibilite;
	public $consistance;
	public $mobilite_transversale;
	public $taille_tyroide;
	public $aires_ganglionnaires;
	public $laryngoscopie_indirecte;
	public $examens_autres_appareils;
	public $date_enregistrement;
	public $date_modification;
	public $id_employe_e;
	public $id_employe_m;

	
	public function exchangeArray($data) {
		$this->id_tyroide = (! empty ( $data ['id_tyroide'] )) ? $data ['id_tyroide'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->hypertrophie_globale = (! empty ( $data ['hypertrophie_globale'] )) ? $data ['hypertrophie_globale'] : null;
		$this->hypertrophie_localise = (! empty ( $data ['hypertrophie_localise'] )) ? $data ['hypertrophie_localise'] : null;
		$this->hypertrophie_nodulaire = (! empty ( $data ['hypertrophie_nodulaire'] )) ? $data ['hypertrophie_nodulaire'] : null;
		$this->hypertrophie_sensibilite = (! empty ( $data ['hypertrophie_sensibilite'] )) ? $data ['hypertrophie_sensibilite'] : null;
		$this->consistance = (! empty ( $data ['consistance'] )) ? $data ['consistance'] : null;
		$this->mobilite_transversale = (! empty ( $data ['mobilite_transversale'] )) ? $data ['mobilite_transversale'] : null;
		$this->taille_tyroide = (! empty ( $data ['taille_tyroide'] )) ? $data ['taille_tyroide'] : null;
		$this->aires_ganglionnaires = (! empty ( $data ['aires_ganglionnaires'] )) ? $data ['aires_ganglionnaires'] : null;
		$this->laryngoscopie_indirecte = (! empty ( $data ['laryngoscopie_indirecte'] )) ? $data ['laryngoscopie_indirecte'] : null;
		$this->examens_autres_appareils = (! empty ( $data ['examens_autres_appareils'] )) ? $data ['examens_autres_appareils'] : null;
		$this->date_modification = (! empty ( $data ['date_modification'] )) ? $data ['date_modification'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->id_employe_e = (! empty ( $data ['id_employe_e'] )) ? $data ['id_employe_e'] : null;
		$this->id_employe_m = (! empty ( $data ['id_employe_m'] )) ? $data ['id_employe_m'] : null;
	}
}