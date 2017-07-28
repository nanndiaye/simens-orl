<?php
namespace Consultation\Form;

use Zend\Form\Form;

class ProtocoleOperatoireForm extends Form{

	public function __construct() {
		parent::__construct ();

		$this->add ( array (
				'name' => 'id_admission',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_admission'
				)
		) );
		
		$this->add ( array (
				'name' => 'id_patient',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_patient'
				)
		) );
		
		$this->add ( array (
				'name' => 'id_protocole',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_protocole'
				)
		) );


		$this->add ( array (
				'name' => 'anesthesiste',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Anesth�siste')
				),
				'attributes' => array (
						'id' => 'anesthesiste',
						'required' => true,
				        'tabindex' => 1,
				)
		) );
		
		
		$this->add ( array (
				'name' => 'indication',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Indication')
				),
				'attributes' => array (
						'id' => 'indication',
						'required' => true,
    				    'tabindex' => 2,
				)
		) );
		
		$this->add ( array (
				'name' => 'type_anesthesie',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type d\'anesth�sie')
				),
				'attributes' => array (
						'id' => 'type_anesthesie',
						'required' => true,
				        'tabindex' => 3,
				)
		) );
		
		$this->add ( array (
				'name' => 'protocole_operatoire',
				'type' => 'TextArea',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Protocole op�ratoire')
				),
				'attributes' => array (
						'id' => 'protocole_operatoire',
						'required' => true,
						'maxlength' => 1500,
    				    'tabindex' => 4,
				)
		) );
		
		$this->add ( array (
				'name' => 'soins_post_operatoire',
				'type' => 'TextArea',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Soins post Op�ratoire')
				),
				'attributes' => array (
						'id' => 'soins_post_operatoire',
						'maxlength' => 400,
						'required' => true,
    				    'tabindex' => 5,
				)
		) );
		
		
		//******************************************************************************
		//******************************************************************************
		//******************************************************************************
		$this->add ( array (
		    'name' => 'check_list_securite',
		    'type' => 'Hidden',
		    'attributes' => array (
		        'id' => 'check_list_securite',
		    )
		) );
		
		
		//La liste des participants � l'op�ration
		//La liste des participants � l'op�ration
		$this->add ( array (
		    'name' => 'aides_operateurs',
		    'type' => 'TextArea',
		    'options' => array (
		        'label' => iconv('ISO-8859-1', 'UTF-8','Aides op�rateurs')
		    ),
		    'attributes' => array (
		        'id' => 'aides_operateurs',
		        'tabindex' => 6,
		    )
		) );
		
		//Les complications de l'op�ration
		//Les complications de l'op�ration
		$this->add ( array (
		    'name' => 'complications',
		    'type' => 'TextArea',
		    'options' => array (
		        'label' => iconv('ISO-8859-1', 'UTF-8','Les complications')
		    ),
		    'attributes' => array (
		        'id' => 'complications',
		        'maxlength' => 350,
		        'tabindex' => 7,
		    )
		) );
		
		//Note relative au protocole op�ratoire
		//Note relative au protocole op�ratoire
		$this->add ( array (
		    'name' => 'note_audio_cro',
		    'type' => 'TextArea',
		    'options' => array (
		        'label' => iconv('ISO-8859-1', 'UTF-8','Note')
		    ),
		    'attributes' => array (
		        'id' => 'note_audio_cro',
		        'maxlength' => 200,
		        'tabindex' => 8,
		    )
		) );
		
	}
}