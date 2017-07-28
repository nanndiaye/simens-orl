<?php

namespace Personnel\Form;

use Zend\Form\Form;

class PersonnelForm extends Form {
	
	public function __construct($name = null) {
		parent::__construct ();

		$this->add ( array (
				'name' => 'id_personne',
				'type' => 'Hidden',
				'attributes' => array (
						'id' => 'id_personne'
				)
		) );
		
// 		<!--**************************************-->
		
// 		<!--========== PREMIER DEPLIANT ========-->
		
// 		<!--**************************************-->
		$this->add ( array (
				'name' => 'date_enregistrement',
				'type' => 'Hidden',
				'attributes' => array (
						'id' => 'date_enregistrement'
				)
		) );
		
		$this->add ( array (
				'name' => 'civilite',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Civilite',
						'value_options' => array (
								''=>'',
								'Mme' => 'Mme',
								'Mlle' => 'Mlle',
								'M' => 'M'
						)
				),
				'attributes' => array (
						'id' => 'civilite',
						'classe' => 'civilite',
				)
		) );
		$this->add ( array (
				'name' => 'nom',
				'type' => 'Text',
				'options' => array (
						'label' => 'Nom'
				),
				'attributes' => array (
						'class' => 'only_Char',
						'id' => 'nom',
						'required' => true,
						'tabindex' => 2,
				)
		) );
		$this->add ( array (
				'name' => 'prenom',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Pr�nom' )
				),
				'attributes' => array (
						'id' => 'prenom',
						'class' => 'only_Char',
						'required' => true,
						'tabindex' => 3,
				)
		) );


		$this->add ( array (
				'name' => 'sexe',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Sexe',
						'value_options' => array (
								''=>'',
								'Masculin' => 'Masculin',
								iconv ( 'ISO-8859-1', 'UTF-8','F�minin') => iconv ( 'ISO-8859-1', 'UTF-8','F�minin')
						)
				),
				'attributes' => array (
						'id' => 'sexe',
						'required' => true,
						'tabindex' => 1,
				)
				) );


		$this->add ( array (
				'name' => 'date_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date de naissance'
				),
				'attributes' => array (
						'id' => 'date_naissance',
						'tabindex' => 4,
				)
				) );


		$this->add ( array (
				'name' => 'lieu_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Lieu de naissance'
				),
				'attributes' => array (
						'id' => 'lieu_naissance',
						'tabindex' => 5,
				)
				) );


		$this->add ( array (
				'name' => 'situation_matrimoniale',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8','Situation matrimoniale'),
						'value_options' => array (
								''=>'',
								iconv ( 'ISO-8859-1', 'UTF-8','Mari�') => iconv ( 'ISO-8859-1', 'UTF-8','Mari�'),
								iconv ( 'ISO-8859-1', 'UTF-8','C�libataire') => iconv ( 'ISO-8859-1', 'UTF-8','C�libataire')
						)
				),
				'attributes' => array (
						'id' => 'situation_matrimoniale',
						'tabindex' => 10,
				)
				) );
		$this->add ( array (
				'name' => 'nationalite',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8','Nationalit�'),
				),
				'attributes' => array (
						'id' => 'nationalite',
						'tabindex' => 11,
				)
				) );
		$this->add ( array (
				'name' => 'adresse',
				'type' => 'Text',
				'options' => array (
						'label' => 'Adresse'
				),
				'attributes' => array (
						'id' => 'adresse',
						'tabindex' => 8,
				)
		) );
		$this->add ( array (
				'name' => 'telephone',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'T�l�phone' )
				),
				'attributes' => array (
						'id' => 'telephone',
						'tabindex' => 6,
				)
		) );
		$this->add ( array (
				'type' => 'Zend\Form\Element\Email',
				'name' => 'email',
				'options' => array (
						'label' => 'Email'
				),
				'attributes' => array (
						'placeholder' => 'votre@domain.com',
						'id' => 'email',
						'tabindex' => 9,
				)
		) );
		$this->add ( array (
				'name' => 'profession',
				'type' => 'Text',
				'options' => array (
						'label' => 'Profession'
				),
				'attributes' => array (
						'id' => 'profession',
						'tabindex' => 7,
				)
		) );
		
// 		<!--**************************************-->
		
// 		<!--========== DEUXIEME DEPLIANT ========-->
		
// 		<!--**************************************-->
		$this->add ( array (
				'name' => 'type_personnel',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Type Personnel',
				),
				'attributes' => array (
						'id' => 'type_personnel',
						'onchange' => 'getChamps(this.value)',
						'required' =>true,
				)
		) );
		$this->add ( array (
				'name' => 'matricule',
				'type' => 'Text',
				'options' => array (
						'label' => 'Matricule'
				),
				'attributes' => array (
						//'class' => 'only_Char',
						'id' => 'matricule',
				)
		) );
		$this->add ( array (
				'name' => 'grade',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Grade' )
				),
				'attributes' => array (
						'id' => 'grade',
						//'class' => 'only_Char',
				)
		) );
		
		
		$this->add ( array (
				'name' => 'specialite',
				'type' => 'Text',
				'options' => array (
						'label' => 'Specialite',
				),
				'attributes' => array (
						'id' => 'specialite',
				)
		) );
		
		
		$this->add ( array (
				'name' => 'fonction',
				'type' => 'Text',
				'options' => array (
						'label' => 'Fonction'
				),
				'attributes' => array (
						'id' => 'fonction',
				)
		) );
		
		$this->add ( array (
				'name' => 'matricule_medico',
				'type' => 'Text',
				'options' => array (
						'label' => 'Matricule'
				),
				'attributes' => array (
						'id' => 'matricule_medico',
				)
		) );
		
		$this->add ( array (
				'name' => 'grade_medico',
				'type' => 'Text',
				'options' => array (
						'label' => 'Grade'
				),
				'attributes' => array (
						'id' => 'grade_medico',
				)
		) );
		
		$this->add ( array (
				'name' => 'domaine_medico',
				'type' => 'Text',
				'options' => array (
						'label' => 'Domaine'
				),
				'attributes' => array (
						'id' => 'domaine_medico',
				)
		) );
		
		$this->add ( array (
				'name' => 'autres',
				'type' => 'Text',
				'options' => array (
						'label' => 'Autres'
				),
				'attributes' => array (
						'id' => 'autres',
				)
		) );
		
		$this->add ( array (
				'name' => 'matricule_logistique',
				'type' => 'Text',
				'options' => array (
						'label' => 'Matricule'
				),
				'attributes' => array (
						'id' => 'matricule_logistique',
				)
		) );
		
		$this->add ( array (
				'name' => 'grade_logistique',
				'type' => 'Text',
				'options' => array (
						'label' => 'Grade'
				),
				'attributes' => array (
						'id' => 'grade_logistique',
				)
		) );
		
		$this->add ( array (
				'name' => 'domaine_logistique',
				'type' => 'Text',
				'options' => array (
						'label' => 'Domaine'
				),
				'attributes' => array (
						'id' => 'domaine_logistique',
				)
		) );
		
		$this->add ( array (
				'name' => 'autres_logistique',
				'type' => 'Text',
				'options' => array (
						'label' => 'Autres'
				),
				'attributes' => array (
						'id' => 'autres_logistique',
				)
		) );
// 		<!--**************************************-->
		
// 		<!--========== TROISIEME DEPLIANT ========-->
		
// 		<!--**************************************-->

		$this->add ( array (
				'name' => 'service_accueil',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Service'
				),
				'attributes' => array (
						'id' => 'service_accueil',
					    'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'date_debut',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date debut'
				),
				'attributes' => array (
						'id' => 'date_debut',
				)
		) );
		
		$this->add ( array (
				'name' => 'date_fin',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date fin'
				),
				'attributes' => array (
						'id' => 'date_fin',
				)
		) );
		
		$this->add ( array (
				'name' => 'numero_os',
				'type' => 'Text',
				'options' => array (
						'label' => 'Numero'
				),
				'attributes' => array (
						'id' => 'numero_os',
				)
		) );
		
		//FICHIER TAMPON DU FORMULAIRE
		$this->add ( array (
				'name' => 'fichier_tmp',
				'type' => 'hidden',
				'attributes' => array (
						'id' => 'fichier_tmp',
				)
		) );
		
	}
}