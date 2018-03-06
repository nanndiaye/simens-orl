<?php
namespace Facturation\Form;

use Zend\Form\Form;

class StatistiqueForm extends Form{

	public function __construct() {
		parent::__construct ();

		$today = new \DateTime ();
		$dateAujourdhui = $today->format( 'Y-m-d' );
		
		$this->add ( array (
				'name' => 'id_sous_dossier',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du sous dossier'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getInformationsSousDossier(this.value)',
						'id' => 'id_sous_dossier',
						'class' => 'select-element',
				)
		) );
		
		
		$this->add ( array (
				'name' => 'sous_dossier',
				'type' => 'select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type Sous-Dossier'),
				),
				'attributes' => array (
						'id' =>'sous_dossier',
						'required' => true
		
				)
		) );
		
		$this->add ( array (
				'name' => 'id_medecin',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du m�decin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getInformationsMedecin(this.value)',
						'id' =>'id_medecin',
				)
		) );
		
		$this->add ( array (
				'name' => 'age_min',
				'type' => 'number',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Age min(1)'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeAgeMin(this.value)',
						'id' =>'age_min',
						'min' => 1,
						'max' => 150,
						
				)
		) );
		
		$this->add ( array (
				'name' => 'age_max',
				'type' => 'number',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Age max(150)'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeAgeMax(this.value)',
						'id' =>'age_max',
						'min' => 1,
						'max' => 150,
				)
		) );
		
		$this->add ( array (
				'name' => 'date_debut',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date d�but'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDateDebut(this.value)',
						'id' =>'date_debut',
						'min'  => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		
		$this->add ( array (
				'name' => 'date_fin',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						//'registerInArrrayValidator' => true,
						'onchange' => 'getListeDateFin(this.value)',
						'id' =>'date_fin',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'diagnostic',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du diagnostic'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDiagnostic(this.value)',
						'id' =>'diagnostic',
						'class' => 'diagnostic',
				)
		) );
		
		
		
		
		
		
		
		
		//POUR LA TROISIEME PARTIE ----- STAT 3
		//POUR LA TROISIEME PARTIE ----- STAT 3
		//POUR LA TROISIEME PARTIE ----- STAT 3
		//POUR LA TROISIEME PARTIE ----- STAT 3
		$this->add ( array (
				'name' => 'id_service_rapport',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du service'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getInformationsServiceRapport(this.value)',
						'id' => 'id_service_rapport',
						'class' => 'select-element',
				)
		) );
		
		$this->add ( array (
				'name' => 'date_debut_rapport',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date d�but'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDateDebutRapport(this.value)',
						'id' =>'date_debut_rapport',
						'min'  => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'date_fin_rapport',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDateFinRapport(this.value)',
						'id' =>'date_fin_rapport',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'diagnostic_rapport',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du diagnostic'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDiagnosticRapport(this.value)',
						'id' =>'diagnostic_rapport',
						'class' => 'diagnostic_rapport',
				)
		) );
		
		
		
		$this->add ( array (
				'name' => 'SEXE',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Sexe',
						'value_options' => array (
								'' => '',
								'Masculin' => 'Masculin',
								iconv ( 'ISO-8859-1', 'UTF-8','F�minin') => iconv ( 'ISO-8859-1', 'UTF-8','F�minin')
						)
				),
				'attributes' => array (
						'id' => 'SEXE',
						//'required' => true,
						//'tabindex' => 1,
				)
		) );		
		
	}
}