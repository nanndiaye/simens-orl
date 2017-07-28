<?php
namespace Orl\Form;

use Zend\Form\Form;
// use Personnel\Model\Service;
// use Personnel\Model\ServiceTable;

class AdmissionForm extends Form{

	//protected $serviceTable;
	public function __construct() {
		//$this->serviceTable = $serviceTable;
		parent::__construct ();

		$this->add ( array (
				'name' => 'id_patient',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_patient'
				)
		) );

		$this->add ( array (
				'name' => 'service',
				'type' => 'select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Service'),
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getmontant(this.value)',
						'id' =>'service',
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'type_admission',
				'type' => 'select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type admission'),
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'id' =>'id_type_admission',
						
				)
		) );
		

		

		$this->add ( array (
				'name' => 'montant_avec_majoration',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Tarif (frs)')
				),
				'attributes' => array (
						'id' => 'montant_avec_majoration',
				)
		) );
		
		$this->add ( array (
				'name' => 'montant',
				'type' => 'Hidden',
				'attributes' => array (
						'id' => 'montant',
				)
		) );

		$this->add ( array (
				'name' => 'numero',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Num�ro facture')
				),
				'attributes' => array (
						'id' => 'numero'
				)
		) );
		$this->add ( array (
				'name' => 'liste_service',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'id' => 'liste_service',
				)
		) );
		
		$this->add(array(
				'name' => 'type_facturation',
				'type' => 'Zend\Form\Element\radio',
				'options' => array (
						'value_options' => array(
								1 => 'Normal',
								2 => iconv ( 'ISO-8859-1', 'UTF-8','Prise en charge') ,
						),
				),
				'attributes' => array(
						'id' => 'type_facturation',
						'required' => true,
				),
		));
		
		$this->add(array(
				'name' => 'organisme',
				'type' => 'textarea',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Organisme')
				),
				'attributes' => array(
						'id' => 'organisme',
				),
		));
		
		$this->add(array(
				'name' => 'taux',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Taux (%)'),
						'value_options' => array(
								'' => '00',
								5  => '05',
								10 => '10',
						),
				),
				'attributes' => array(
						'registerInArrrayValidator' => true,
						'onchange' => 'getTarif(this.value)',
						'id' => 'taux',
				),
		));
		
	}
}