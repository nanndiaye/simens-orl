<?php

namespace Orl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Orl\Form\PatientForm;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Zend\Form\View\Helper\FormRow;
use Zend\Form\View\Helper\FormInput;
use Orl\View\Helpers\DateHelper;
use Zend\Json\Json;
use Zend\Db\Sql\Sql;
use Orl\Form\AdmissionForm;
use Orl\Form\ConsultationForm;
use Facturation\View\Helper\FactureActePdf;

class SecretariatController extends AbstractActionController {
	
	protected $patientTable;
	protected $formPatient;
	protected $dateHelper;
	protected $admissionTable;
	protected $serviceTable;
	protected $tarifConsultationTable;
	protected $consultationTable;
	protected $rvPatientConsTable;
	protected $ConsultationTable;
	protected $typeAdmissionTable;

	public function testAction(){
		
	}
	public function getPatientTable() {
		if (! $this->patientTable) {
						$sm = $this->getServiceLocator ();
						
			$this->patientTable = $sm->get ( 'Orl\Model\PatientTable' );
			
		}
		return $this->patientTable;
	}
	public function getTypeAdmissionTable() {
		if (! $this->typeAdmissionTable) {
			$sm = $this->getServiceLocator ();
	
			$this->typeAdmissionTable = $sm->get ( 'Orl\Model\TypeAdmissionTable' );
				
		}
		return $this->typeAdmissionTable;
	}
	Public function getDateHelper() {
		$this->dateHelper = new DateHelper();
	}
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm();
		}
		return $this->formPatient;
	}
	public function getRvPatientConsTable() {
		if (! $this->rvPatientConsTable) {
			$sm = $this->getServiceLocator ();
			$this->rvPatientConsTable = $sm->get ( 'Orl\Model\RvPatientConsTable' );
		}
		return $this->rvPatientConsTable;
	}
	
	public function getConsultationTable() {
		if (! $this->ConsultationTable) {
			$sm = $this->getServiceLocator ();
			$this->ConsultationTable = $sm->get ( 'Orl\Model\ConsultationTable' );
		}
		return $this->ConsultationTable;
	}
	
	public function listePatientAction() {
		
		$layout = $this->layout ();
		
		$layout->setTemplate ( 'layout/orl' );
		//var_dump('ddd');exit();
		$view = new ViewModel ();
		return $view;
		
	}
	
	
	public function ajouterPatientAction() {
		$this->layout ()->setTemplate ( 'layout/orl' );
		$form = $this->getForm ();
		$patientTable = $this->getPatientTable();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('NATIONALITE_ORIGINE' => 'Sénégal', 'NATIONALITE_ACTUELLE' => 'Sénégal');
	
		$form->populateValues($data);
	
		return new ViewModel ( array (
				'form' => $form
		) );
	}
//Enregistrement de la maman par l'agent qui enregistre les naissances
	public function enregistrementPatientAction() {
		
	
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connect�
	
		// CHARGEMENT DE LA PHOTO ET ENREGISTREMENT DES DONNEES
		if (isset ( $_POST ['terminer'] ))  // si formulaire soumis
		{
			$Control = new DateHelper();
			//var_dump('tet');exit();
			$form = new PatientForm ();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );
			$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			$fileBase64 = substr ( $fileBase64, 23 );
			
			if($fileBase64){
				$img = imagecreatefromstring(base64_decode($fileBase64));
			}else {
				$img = false;
			}
	
		
			$date_naissance = $this->params ()->fromPost ( 'DATE_NAISSANCE' );
			if($date_naissance){ $date_naissance = $Control->convertDateInAnglais($this->params ()->fromPost ( 'DATE_NAISSANCE' )); }else{ $date_naissance = null;}
			
			$donnees = array(
					
					//'NUMERO_DOSSIER' => $this->params ()->fromPost ( 'NUMERO_DOSSIER' ),
					'LIEU_NAISSANCE' => $this->params ()->fromPost ( 'LIEU_NAISSANCE' ),
					'EMAIL' => $this->params ()->fromPost ( 'EMAIL' ),
					'NOM' => $this->params ()->fromPost ( 'NOM' ),
					'TELEPHONE' => $this->params ()->fromPost ( 'TELEPHONE' ),
					'NATIONALITE_ORIGINE' => $this->params ()->fromPost ( 'NATIONALITE_ORIGINE' ),
					'PRENOM' => $this->params ()->fromPost ( 'PRENOM' ),
					'PROFESSION' => $this->params ()->fromPost ( 'PROFESSION' ),
					'NATIONALITE_ACTUELLE' => $this->params ()->fromPost ( 'NATIONALITE_ACTUELLE' ),
					'DATE_NAISSANCE' => $date_naissance,
					'ADRESSE' => $this->params ()->fromPost ( 'ADRESSE' ),
					'SEXE' => $this->params ()->fromPost ( 'SEXE' ),
					'AGE' => $this->params ()->fromPost ( 'AGE' ),
					//'NUMERO_DOSSIER' => $this->params ()->fromPost ( 'NUMERO_DOSSIER' ),
			);
	
			if ($img != false) {
	
				$donnees['PHOTO'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
					
				return $this->redirect ()->toRoute ( 'secretariat', array (
						'action' => 'liste-patient'
				) );
			} else {
				// On enregistre sans la photo
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				
				return $this->redirect ()->toRoute ( 'secretariat', array (
						'action' => 'liste-patient'
				) );
			}
		}
		
		
		
		
		else
			//**********Terminer et Admettre*****************
			//**********Terminer et Admettre*****************
			//**********Terminer et Admettre*****************	

			
			
			if (isset ( $_POST ['terminer_admettre'] ))  // si formulaire soumis
			{
				$Control = new DateHelper();
				//var_dump('tet');exit();
				$form = new PatientForm ();
				$Patient = $this->getPatientTable ();
				$today = new \DateTime ( 'now' );
				$nomfile = $today->format ( 'dmy_His' );
				$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
				$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
				$fileBase64 = substr ( $fileBase64, 23 );
					
				if($fileBase64){
					$img = imagecreatefromstring(base64_decode($fileBase64));
				}else {
					$img = false;
				}
			
			
				$date_naissance = $this->params ()->fromPost ( 'DATE_NAISSANCE' );
				if($date_naissance){ $date_naissance = $Control->convertDateInAnglais($this->params ()->fromPost ( 'DATE_NAISSANCE' )); }else{ $date_naissance = null;}
					
				$donnees = array(
							
						//'NUMERO_DOSSIER' => $this->params ()->fromPost ( 'NUMERO_DOSSIER' ),
						'LIEU_NAISSANCE' => $this->params ()->fromPost ( 'LIEU_NAISSANCE' ),
						'EMAIL' => $this->params ()->fromPost ( 'EMAIL' ),
						'NOM' => $this->params ()->fromPost ( 'NOM' ),
						'TELEPHONE' => $this->params ()->fromPost ( 'TELEPHONE' ),
						'NATIONALITE_ORIGINE' => $this->params ()->fromPost ( 'NATIONALITE_ORIGINE' ),
						'PRENOM' => $this->params ()->fromPost ( 'PRENOM' ),
						'PROFESSION' => $this->params ()->fromPost ( 'PROFESSION' ),
						'NATIONALITE_ACTUELLE' => $this->params ()->fromPost ( 'NATIONALITE_ACTUELLE' ),
						'DATE_NAISSANCE' => $date_naissance,
						'ADRESSE' => $this->params ()->fromPost ( 'ADRESSE' ),
						'SEXE' => $this->params ()->fromPost ( 'SEXE' ),
						'AGE' => $this->params ()->fromPost ( 'AGE' ),
						//'NUMERO_DOSSIER' => $this->params ()->fromPost ( 'NUMERO_DOSSIER' ),
				);
			
				if ($img != false) {
			
					$donnees['PHOTO'] = $nomfile;
					//ENREGISTREMENT DE LA PHOTO
					imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
					//ENREGISTREMENT DES DONNEES
					$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
						
					return $this->redirect ()->toRoute ( 'secretariat', array (
							'action' => 'admission'
					) );
				} else {
					// On enregistre sans la photo
					$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
			
					return $this->redirect ()->toRoute ( 'secretariat', array (
							'action' => 'admission'
					) );
				}
			}

			
			
			
			
			
			else
			//**********Terminer et Rendez-vous*****************
			//**********Terminer et Rendez-vous*****************
			//**********Terminer et Rendez-vous*****************
			
				
				
			if (isset ( $_POST ['terminer_rv'] ))  // si formulaire soumis
			{
				$Control = new DateHelper();
				//var_dump('tet');exit();
				$form = new PatientForm ();
				$Patient = $this->getPatientTable ();
				$today = new \DateTime ( 'now' );
				$nomfile = $today->format ( 'dmy_His' );
				$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
				$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
				$fileBase64 = substr ( $fileBase64, 23 );
					
				if($fileBase64){
					$img = imagecreatefromstring(base64_decode($fileBase64));
				}else {
					$img = false;
				}
					
					
				$date_naissance = $this->params ()->fromPost ( 'DATE_NAISSANCE' );
				if($date_naissance){ $date_naissance = $Control->convertDateInAnglais($this->params ()->fromPost ( 'DATE_NAISSANCE' )); }else{ $date_naissance = null;}
					
				$donnees = array(
							
						//'NUMERO_DOSSIER' => $this->params ()->fromPost ( 'NUMERO_DOSSIER' ),
						'LIEU_NAISSANCE' => $this->params ()->fromPost ( 'LIEU_NAISSANCE' ),
						'EMAIL' => $this->params ()->fromPost ( 'EMAIL' ),
						'NOM' => $this->params ()->fromPost ( 'NOM' ),
						'TELEPHONE' => $this->params ()->fromPost ( 'TELEPHONE' ),
						'NATIONALITE_ORIGINE' => $this->params ()->fromPost ( 'NATIONALITE_ORIGINE' ),
						'PRENOM' => $this->params ()->fromPost ( 'PRENOM' ),
						'PROFESSION' => $this->params ()->fromPost ( 'PROFESSION' ),
						'NATIONALITE_ACTUELLE' => $this->params ()->fromPost ( 'NATIONALITE_ACTUELLE' ),
						'DATE_NAISSANCE' => $date_naissance,
						'ADRESSE' => $this->params ()->fromPost ( 'ADRESSE' ),
						'SEXE' => $this->params ()->fromPost ( 'SEXE' ),
						'AGE' => $this->params ()->fromPost ( 'AGE' ),
						//'NUMERO_DOSSIER' => $this->params ()->fromPost ( 'NUMERO_DOSSIER' ),
				);
					
				if ($img != false) {
						
					$donnees['PHOTO'] = $nomfile;
					//ENREGISTREMENT DE LA PHOTO
					imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
					//ENREGISTREMENT DES DONNEES
					$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
			
					return $this->redirect ()->toRoute ( 'secretariat', array (
							'action' => 'programmer-rendez-vous'
					) );
				} else {
					// On enregistre sans la photo
					$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
						
					return $this->redirect ()->toRoute ( 'secretariat', array (
							'action' => 'programmer-rendez-vous'
					) );
				}
			}
		
		
		
// 		return $this->redirect ()->toRoute ( 'secretariat', array (
// 				'action' => 'liste-patient'
// 		) );
	}
	public function listePatientAjaxAction() {
		
		$output = $this->getPatientTable()->getListePatient();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	public function infoPatientAction() {
		//
		$id_pat = $this->params ()->fromRoute ( 'val', 0 );	
		$this->layout ()->setTemplate ( 'layout/orl' );
		
 		$patient = $this->getPatientTable ();
 		//var_dump( new \DateTime ( 'now' ));exit(); date d'aujourd'hui
 		
 		$unPatient = $patient->getInfoPatient( $id_pat );
 		
 		
 		return array (
 				'lesdetails' => $unPatient,
 				'image' => $patient->getPhoto ( $id_pat ),
 				'id_patient' => $unPatient['ID_PERSONNE'],
 				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
 		);
	}
	public function modifierAction() {
		$control = new DateHelper();
		$this->layout ()->setTemplate ( 'layout/orl' );
		$id_patient = $this->params ()->fromRoute ( 'val', 0 );
	
		$infoPatient = $this->getPatientTable ();
		try {
			$info = $infoPatient->getInfoPatient( $id_patient );
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'secretariat', array (
					'action' => 'liste-patient'
			) );
		}
		$form = new PatientForm ();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($infoPatient->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($infoPatient->listeDeTousLesPays());
	
		$date_naissance = $info['DATE_NAISSANCE'];
		if($date_naissance){ $info['DATE_NAISSANCE'] =  $control->convertDate($info['DATE_NAISSANCE']); }else{ $info['DATE_NAISSANCE'] = null;}
	
		$form->populateValues ( $info );
	
		if (! $info['PHOTO']) {
			$info['PHOTO'] = "identite";
		}
		return array (
				'form' => $form,
				'photo' => $info['PHOTO']
		);
	}
	public function enregistrementModificationAction() {
	
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connect�
	
		if (isset ( $_POST ['terminer'] ))
		{
			$Control = new DateHelper();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );
			$date_modification = $today->format ( 'Y-m-d H:i:s' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			$fileBase64 = substr ( $fileBase64, 23 );
	
			if($fileBase64){
				$img = imagecreatefromstring(base64_decode($fileBase64));
			}else {
				$img = false;
			}
	
			$date_naissance = $this->params ()->fromPost ( 'DATE_NAISSANCE' );
			if($date_naissance){ $date_naissance = $Control->convertDateInAnglais($this->params ()->fromPost ( 'DATE_NAISSANCE' )); }else{ $date_naissance = null;}
	
			$donnees = array(
					'LIEU_NAISSANCE' => $this->params ()->fromPost ( 'LIEU_NAISSANCE' ),
					'EMAIL' => $this->params ()->fromPost ( 'EMAIL' ),
					'NOM' => $this->params ()->fromPost ( 'NOM' ),
					'TELEPHONE' => $this->params ()->fromPost ( 'TELEPHONE' ),
					'NATIONALITE_ORIGINE' => $this->params ()->fromPost ( 'NATIONALITE_ORIGINE' ),
					'PRENOM' => $this->params ()->fromPost ( 'PRENOM' ),
					'PROFESSION' => $this->params ()->fromPost ( 'PROFESSION' ),
					'NATIONALITE_ACTUELLE' => $this->params ()->fromPost ( 'NATIONALITE_ACTUELLE' ),
					'DATE_NAISSANCE' => $date_naissance,
					'ADRESSE' => $this->params ()->fromPost ( 'ADRESSE' ),
					'SEXE' => $this->params ()->fromPost ( 'SEXE' ),
					'AGE' => $this->params ()->fromPost ( 'AGE' ),
					//'NUMERO_DOSSIER' => $this->params ()->fromPost ( 'NUMERO_DOSSIER' ),
			);
	
			$id_patient =  $this->params ()->fromPost ( 'ID_PERSONNE' );
			if ($img != false) {
	
				$lePatient = $Patient->getInfoPatient ( $id_patient );
				$ancienneImage = $lePatient['PHOTO'];
	
				if($ancienneImage) {
					unlink ( 'C:\wamp\www\simens\public\img\photos_patients\\' . $ancienneImage . '.jpg' );
				}
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
	
				$donnees['PHOTO'] = $nomfile;
				$Patient->updatePatient ( $donnees , $id_patient, $date_modification, $id_employe);
	
				return $this->redirect ()->toRoute ( 'secretariat', array (
						'action' => 'liste-patient'
				) );
			} else {
				$Patient->updatePatient($donnees, $id_patient, $date_modification, $id_employe);
				return $this->redirect ()->toRoute ( 'secretariat', array (
						'action' => 'liste-patient'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'secretariat', array (
				'action' => 'liste-patient'
		) );
	}
	
	
	
	public function getNaissanceTable() {
		if (! $this->naissanceTable) {
			$sm = $this->getServiceLocator ();
			$this->naissanceTable = $sm->get ( 'Orl\Model\NaissanceTable' );
		}
		return $this->naissanceTable;
	}
	public function supprimerAction() {
		
		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			$patientTable = $this->getPatientTable ();
			
			$patientTable->deletePatient ( $id );
	
			// Supprimer le patient s'il est dans la liste des naissances
			$naiss = $this->getNaissanceTable ();
			$naiss->deleteNaissance ( $id );
			// AFFICHAGE DE LA LISTE DES PATIENTS
			$liste = $patientTable->tousPatients ();
			$nb = $patientTable->nbPatientSUP900 ();
			$html = " $nb patients";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
	}
// 	

	public function numeroFacture() {
		
		$lastAdmission = $this->getAdmissionTable()->getLastAdmission();
		
		return $this->creerNumeroFacturation($lastAdmission['numero']+1);
	}

	public function creerNumeroFacturation($numero) {
		$nbCharNum = 10 - strlen($numero);
		$chaine ="";
		for ($i=1 ; $i <= $nbCharNum ; $i++){
			$chaine .= '0';
		}
		$chaine .= $numero;
		return $chaine;
	}
	public function getServiceTable() {
		if (! $this->serviceTable) {
			$sm = $this->getServiceLocator ();
			$this->serviceTable = $sm->get ( 'Orl\Model\ServiceTable' );
		}
		return $this->serviceTable;
	}
	
	
	public function getAdmissionTable() {
		
		if (! $this->admissionTable) {
			
			$sm = $this->getServiceLocator ();
			
			$this->admissionTable = $sm->get ( 'Orl\Model\AdmissionTable' );
			
		}
		
		return $this->admissionTable;
	}
	public function listeService(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'service'));
		$select->columns(array('ID_SERVICE','NOM'));
		$select->where(array('DOMAINE' => 'MEDECINE'));
		$select->order('ID_SERVICE ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['ID_SERVICE']] = $data['NOM'];
		}
		return $options;
	}
	

	public function listeTypeAdmission(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('t'=>'type_admission'));
		$select->columns(array('type'));
		//$select->where(array('DOMAINE' => 'MEDECINE'));
		$select->order('id_type_admission ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['type']] = $data['type'];
		}
		return $options;
	}
	
	
	public function getTarifConsultationTable() {
		if (! $this->tarifConsultationTable) {
			$sm = $this->getServiceLocator ();
			
			$this->tarifConsultationTable = $sm->get ( 'Orl\Model\TarifConsultationTable' );
		}
		
		return $this->tarifConsultationTable;
	}
	
	
	public function listeAdmissionAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->laListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function admissionAction() {
		
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/orl' );
		$patient = $this->getPatientTable ();
		
	//$numDossier=$patient['NUMERO_DOSSIER'];
	
		$numero = $this->numeroFacture();
		//INSTANCIATION DU FORMULAIRE D'ADMISSION
		$formAdmission = new AdmissionForm ();
		
		$service = $this->getTarifConsultationTable()->listeService();
		
		$listeService = $this->getServiceTable ()->listeService ();
		//var_dump($listeService);exit();
		$afficheTous = array ("" => 'Tous');
		$tab_service = array_merge ( $afficheTous, $listeService );
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$formAdmission->get ( 'liste_service' )->setValueOptions ( $tab_service );
		
		//Type Admission
		$listeTypeAdmission = $this->getTypeAdmissionTable ()->listeTypeAdmission ();
		//var_dump($listeTypeAdmission);exit();
		//$afficheTous = array ("" => 'Choisir un type d"admission');
		$tab_type_admission = array_merge ( $listeTypeAdmission );
		$formAdmission->get ( 'type_admission' )->setValueOptions ( $tab_type_admission );
		//$formAdmission->get ( 'liste_type_admission' )->setValueOptions ( $tab_type_admission );
		
	
 		if ($this->getRequest ()->isPost ()) {
				
 			$today = new \DateTime ();
 			$dateAujourdhui = $today->format( 'Y-m-d' );
				
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
				
			//MISE A JOUR DE L'AGE DU PATIENT
			//MISE A JOUR DE L'AGE DU PATIENT
			//MISE A JOUR DE L'AGE DU PATIENT
			$personne = $this->getPatientTable()->miseAJourAgePatient($id);
			//*******************************
			//*******************************
			//*******************************
				
			$pat = $this->getPatientTable ();
				//var_dump($pat);exit();
			//Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
			$RendezVOUS = $pat->verifierRV($id, $dateAujourdhui);
				
			$unPatient = $pat->getInfoPatient( $id );
			
				
			$photo = $pat->getPhoto ( $id );
	
			
 			$date = $unPatient['DATE_NAISSANCE'];
 			if($date){ $date = (new DateHelper())->convertDate( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}
	
 			$html  = "<div style='width:100%;'>";
				
 			$html .= "<div style='width: 18%; height: 190px; float:left;'>";
 			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='../img/photos_patients/" . $photo . "' ></div>";
 			$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
 			$html .= "</div>";
				
			$html .= "<div id='vuePatientAdmission' style='width: 70%; height: 190px; float:left;'>";
			$html .= "<table style='margin-top:0px; float:left; width: 100%;'>";
				
			$html .= "<tr style='width: 100%;'>";
			
			
			
			$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Numero dossier:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NUMERO_DOSSIER'] . "</p></div></td>";
			$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['DATE_NAISSANCE'] . "</p></div></td>";
			$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
			$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
			
			
				
			$html .= "<td style='width: 29%; '></td>";
				
			$html .= "</tr><tr style='width: 100%;'>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
			$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
			
				
			$html .= "</tr><tr style='width: 100%;'>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['NOM'] . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['SEXE'] . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></div></td>";
				
			
			$html .= "<td style='width: 30%; height: 50px;'>";
			if($RendezVOUS){
				$html .= "<span> <i style='color:green;'>
					        <span id='image-neon' style='color:red; font-weight:bold;'>Rendez-vous! </span> <br>
					        <span style='font-size: 16px;'>Service:</span> <span style='font-size: 16px; font-weight:bold;'> ". $pat->getServiceParId($RendezVOUS[ 'ID_SERVICE' ])[ 'NOM' ]." </span> <br>
					        <span style='font-size: 16px;'>Heure:</span>  <span style='font-size: 16px; font-weight:bold;'>". $RendezVOUS[ 'HEURE' ]." </span> </i>
			              </span>";
			}
			$html .= "</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
				
			$html .= "<div style='width: 12%; height: 190px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:10px; margin-left:5px; margin-top:5px;'> <img style='width:105px; height:105px;' src='../img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
				
			$html .= "</div>";
				

	
 			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
 		}
		return array (
				'form' => $formAdmission
		);
	}
	public function enregistrerAdmissionAction() {
		$user = $this->layout()->user;
		$id_employe = $user['id_personne'];
		$id_service = $user['id_service'];
		//var_dump($id_service);exit();
		
		$today = new \DateTime ( "now" );
		$date_admis = $today->format ( 'Y-m-d' );
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
	
		$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient', 0 );
		//$numero = $this->params ()->fromPost ( 'numero' );
		//$id_service = $this->params ()->fromPost ( 'service' );
		//$montant = $this->params ()->fromPost ( 'montant' );
		//$type_facturation = $this->params ()->fromPost ( 'type_facturation' );
		
		$donnees = array (
				'id_patient' => $id_patient,
				'id_service' => $id_service,
				'date_admis' => $date_admis,
				//'montant' => $montant,
				//'numero' => $numero,
				'date_enregistrement' => $date_enregistrement,
				'id_employe' => $id_employe,
		);
		
// 		if($type_facturation == 2){
// 			$organisme = $this->params ()->fromPost ( 'organisme' );
// 			$taux = $this->params ()->fromPost ( 'taux' );
// 			$montant_avec_majoration = $this->params ()->fromPost ( 'montant_avec_majoration' );
				
// 			$donnees['id_type_facturation'] = 2;
// 			$donnees['organisme'] = $organisme;
// 			$donnees['taux_majoration'] = $taux;
// 			$donnees['montant_avec_majoration'] = $montant_avec_majoration;
// 		} else
// 		if($type_facturation == 1){
// 			$donnees['id_type_facturation'] = 1;
// 		}
		$this->getAdmissionTable ()->addAdmission ( $donnees );
			
			
		//NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT SANS LE PASSAGE DE CELUI CI AU NIVEAU DU SURVEILLANT DE SERVICE
		//NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT SANS LE PASSAGE DE CELUI CI AU NIVEAU DU SURVEILLANT DE SERVICE
		//NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT SANS LE PASSAGE DE CELUI CI AU NIVEAU DU SURVEILLANT DE SERVICE
		/* CODE A SUPPRIMER POUR FAIRE INTERVENIR LE SURVEILLANT DE SERVICE*/
		/* CODE A SUPPRIMER POUR FAIRE INTERVENIR LE SURVEILLANT DE SERVICE*/
		/* CODE A SUPPRIMER POUR FAIRE INTERVENIR LE SURVEILLANT DE SERVICE*/
		$form = new ConsultationForm();
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
			
		//$this->getAdmissionTable ()-> addConsultation ( $form, $id_service );
		//$id_cons = $form->get ( "id_cons" )->getValue ();
		//$this->getAdmissionTable ()->addConsultationOrl($id_cons);
			
		//FIN FIN NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT
		//FIN FIN NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT
		//FIN FIN NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT
		return $this->redirect()->toRoute('secretariat', array( 'action' =>'liste-patients-admis' ));
	}
	public function listePatientsAdmisAction() {
		
		$this->layout ()->setTemplate ( 'layout/orl' );
		$patientsAdmis = $this->getAdmissionTable ();
		//INSTANCIATION DU FORMULAIRE
		
		$formAdmission = new AdmissionForm ();
		$service = $this->getServiceTable ()->fetchService ();
		$listeService = $this->getServiceTable ()->listeService ();
		
		$afficheTous = array ( "" => 'Tous' );
		$tab_service = array_merge ( $afficheTous, $listeService );
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$formAdmission->get ( 'liste_service' )->setValueOptions ( $tab_service );
		
		return new ViewModel ( array (
				'listePatientsAdmis' => $patientsAdmis->getPatientsAdmis (),
				'form' => $formAdmission,
				'listePatientsCons' => $patientsAdmis->getPatientAdmisCons(),
		) );

	}
	public function vuePatientAdmisAction(){
		$this->getDateHelper();
		
		//$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$idPatient = (int)$this->params()->fromPost ('idPatient');
		$idAdmission = (int)$this->params()->fromPost ('idAdmission');

		$unPatient = $this->getPatientTable()->getInfoPatient($idPatient);
		$photo = $this->getPatientTable()->getPhoto($idPatient);
	
		//Informations sur l'admission
		$InfoAdmis = $this->getAdmissionTable()->getPatientAdmis($idAdmission);
	
		//Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
		$today = new \DateTime ();
		$dateAujourdhui = $today->format( 'Y-m-d' );
		$RendezVOUS = $this->getPatientTable ()->verifierRV($idPatient, $dateAujourdhui);
	
		//Recuperer le service
		$InfoService = $this->getServiceTable()->getServiceAffectation($InfoAdmis->id_service);
		//Recuperer le type d'admission
		//$InfoTypeAdmission = $this->getTypeAdmissionTable()->getTypeAdmissionAffectation($InfoAdmis->id_type_admission);
		
		
	
		$date = $unPatient['DATE_NAISSANCE'];
		//if($date){ $date = (new DateHelper())->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}
	
		$html  = "<div style='width:100%;'>";
			
 		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='../img/photos_patients/". $photo ."' ></div>";
		$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 70%; height: 180px; float:left;'>";
		$html .= "<table id='vuePatientAdmission' style='margin-top:10px; float:left'>";
	
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nmero dossier:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NUMERO_DOSSIER'] . "</p></div></td>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['DATE_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
		$html .= "<td style='width: 29%; '></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom  :</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" .$unPatient['NOM']  . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['SEXE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['ADRESSE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></div></td>";
		if($RendezVOUS){
			$html .= "<span> <i style='color:green;'>
					        <span id='image-neon' style='color:red; font-weight:bold;'>Rendez-vous! </span> <br>
					        <span style='font-size: 16px;'>Service:</span> <span style='font-size: 16px; font-weight:bold;'> ". $RendezVOUS[ 'NOM' ]." </span> <br>
					        <span style='font-size: 16px;'>Heure:</span>  <span style='font-size: 16px; font-weight:bold;'>". $RendezVOUS[ 'HEURE' ]." </span> </i>
			              </span>";
		}
	
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 12%; height: 180px; float:left; '>";
		//$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:0px; margin-left:0px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->..()."public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		//$html .="<div id='titre_info_admis'>Informations sur la facturation <img id='button_pdf' style='width:15px; height:15px; float: right; margin-right: 35px; cursor: pointer;' src='".$this->baseUrl()."public/images_icons/button_pdf.png' title='Imprimer la facture' ></div>";
		$html .="<div id='barre_separateur'></div>";
	
		$html .="<table style='margin-top:10px; margin-left:18%; width: 80%; margin-bottom: 60px;'>";
	
 		$html .="<tr style='width: 80%; '>";
        $html .="<td style='width: 50%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Date d'admission </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $this->dateHelper->convertDateTime($InfoAdmis->date_enregistrement) ." </p></td>";
 		//$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Num&eacute;ro facture </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoAdmis->numero ." </p></td>";
 		$html .="<td style='width: 50%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Service </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-size:15px;'> ". $InfoService->nom ." </p></td>";
//	    $html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Tarif (frs) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-weight:bold; font-size:22px;'> ". $this->prixMill($InfoAdmis->montant)." </p></td>";
		$html .="</tr>";
	
// 		if($InfoAdmis->id_type_facturation == 2){
// 			$html .="<tr style='width: 80%; '>";
// 			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Prise en charge par </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoAdmis->organisme ." </p></td>";
// 			if($InfoAdmis->taux_majoration){
// 				$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Taux (%) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-weight:bold; font-size:22px;'> ". $InfoAdmis->taux_majoration ." </p></td>";
// 			}else {
// 				$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Taux (%) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-weight:bold; font-size:22px;'> 0 </p></td>";
// 			}
// 			$majoration = ($InfoAdmis->montant * $InfoAdmis->taux_majoration)/100;
// 			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Majoration (frs) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-weight:bold; font-size:22px;'> ". $this->prixMill("$majoration") ." </p></td>";
// 			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Tarif major&eacute; (frs) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-size:15px; font-weight:bold; font-size:22px;'> ". $this->prixMill( $InfoAdmis->montant_avec_majoration ) ."  </p></td>";
// 			$html .="</tr>";
// 		}
	
	
	
	    $html .="</table>";
    	$html .="<table style='margin-top:10px; margin-left:18%; width: 80%;'>";
        $html .="<tr style='width: 80%;'>";
	
 		$html .="<td class='block' id='thoughtbot' style='width: 35%; display: inline-block;  vertical-align: bottom; padding-left:350px; padding-bottom: 15px; padding-right: 150px;'><button type='submit' id='terminer'>Terminer</button></td>";
	
		$html .="</tr>";
 		$html .="</table>";
	
//     	$html .="<div style='color: white; opacity: 1; margin-top: -100px; margin-right:20px; width:95px; height:40px; float:right'>
//                           <img  src='".$chemin."/images_icons/fleur1.jpg' />
//                       </div>";
	
		$html .="<script>listepatient();
				  function FaireClignoterImage (){
                    $('#image-neon').fadeOut(900).delay(300).fadeIn(800);
                  }
                  setInterval('FaireClignoterImage()',2200);
	
				  $('#button_pdf').click(function(){
				     vart='/simens/public/facturation/impression-facture';
				     var formulaire = document.createElement('form');
			         formulaire.setAttribute('action', vart);
			         formulaire.setAttribute('method', 'POST');
			         formulaire.setAttribute('target', '_blank');
	
				     var champ = document.createElement('input');
				     champ.setAttribute('type', 'hidden');
				     champ.setAttribute('name', 'idAdmission');
				     champ.setAttribute('value', ".$idAdmission.");
				     formulaire.appendChild(champ);
				  
				     formulaire.submit();
	              });
	
				  $('a,img,hass').tooltip({
                  animation: true,
                  html: true,
                  placement: 'bottom',
                  show: {
                    effect: 'slideDown',
                      delay: 250
                    }
                  });
	
				 </script>";
	
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($html));
	
	}

	/*Gestion des rendez-vous --- Gestion des rendez-vous --- Gestion des rendez-vous*/
	/*Gestion des rendez-vous --- Gestion des rendez-vous --- Gestion des rendez-vous*/
	/*Gestion des rendez-vous --- Gestion des rendez-vous --- Gestion des rendez-vous*/
	
	public function programmerRendezVousAjaxAction() {
	
		$output = $this->getPatientTable()->getProgrammerRendezVous();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function programmerRendezVousAction() {
	
		$layout = $this->layout ();
	
		$layout->setTemplate ( 'layout/orl' );
		//var_dump('ddd');exit();
		$view = new ViewModel ();
		return $view;
	
	}
	
	public function infoProgrammerRendezVousAction() {
		$this->layout ()->setTemplate ( 'layout/orl' );
		$id_pat = $this->params()->fromRoute ( 'val', 0 );
	
		$user = $this->layout()->user;
		$IdDuService = $user['IdService'];
	
		$form = new ConsultationForm();
	
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInfoPatient( $id_pat );
	
		$form->get ( "id_patient" )->setValue($id_pat);
	
		return array (
				'form'=>$form,
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'id_patient' => $unPatient['ID_PERSONNE'],
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	}
	
	public function listeRendezVousAjaxAction() {
		$output = $this->getRvPatientConsTable()->getTousRV();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeRendezVousAction() {
		
 		$layout = $this->layout ();
 		$layout->setTemplate ( 'layout/orl' );
 		$user = $this->layout()->user;
 		$idService = $user['IdService'];
	}
	
	
	public function enregistrerRendervousProgrammerAction() {

		$formData = $this->getRequest ()->getPost ();
		$id_patient = $formData['id_patient'];
			
		$date_RV_Recu = $formData['date_rv'];
		$date_RV = "";
		if($date_RV_Recu){
			$date_RV = (new DateHelper())->convertDateInAnglais($formData['date_rv']);
		}
			
		$infos_rv = array(
				'ID_PATIENT' => $id_patient,
				'NOTE'    => $formData['motif_rv'],
				'HEURE'   => $formData['heure_rv'],
				'DATE'    => $date_RV,
				'DELAI'   => $formData['delai_rv'],
		);
		$idRV = $this->getRvPatientConsTable()->addRendezVous($infos_rv);
			
		$rv_programmer = array(
				'ID_RV' => $idRV,
				'ID_PATIENT' => $id_patient,
		);
			
		$this->getRvPatientConsTable()->addRendezVousProgrammer($rv_programmer);
			
		
		return $this->redirect ()->toRoute ( 'secretariat', array (
				'action' => 'liste-rendez-vous'
		) );
		
	}
	
	public function enregistrerRvConsultationAction(){
	
		$formData = $this->getRequest ()->getPost ();
		$infos_rv = array(
				'NOTE'    => $formData['motif_rv'],
				'HEURE'   => $formData['heure_rv'],
				'DATE'    => (new DateHelper())->convertDateInAnglais($formData['date_rv']),
				'DELAI'   => $formData['delai_rv'],
		);
		
		$id_rv = $formData['id_rv'];
		//var_dump($id_rv );exit();
		$this->getRvPatientConsTable()->updateRendezVousProgrammer($infos_rv, $id_rv);
	
		return $this->redirect ()->toRoute ( 'secretariat', array (
				'action' => 'liste-rendez-vous'
		) );
	
	}
	
	
	public function enregistrerRendervousFixerAction() {
	
		$formData = $this->getRequest ()->getPost ();
		$id_cons = $formData['id_cons']; 
		var_dump($id_cons);exit();
		
			
		$date_RV_Recu = $formData['date_rv'];
		$date_RV = "";
		if($date_RV_Recu){
			$date_RV = (new DateHelper())->convertDateInAnglais($formData['date_rv']);
		}
			
		$infos_rv = array(
				'ID_CONS' => $id_cons,
				'NOTE'    => $formData['motif_rv'],
				'HEURE'   => $formData['heure_rv'],
				'DATE'    => $date_RV,
				'DELAI'   => $formData['delai_rv'],
		);
		$idRV = $this->getRvPatientConsTable()->addRendezVous($infos_rv);
			
		$rv_consultation = array(
				'ID_RV' => $idRV,
				'ID_CONS' => $id_cons,
		);
			
		$this->getRvPatientConsTable()->addRendezVousFixer($rv_consultation);
			
	
		return $this->redirect ()->toRoute ( 'secretariat', array (
				'action' => 'liste-rendez-vous'
		) );
	
	}
	
	
	
	

	public function modifierInfosPatientRvAction() {
		$id_pat = $this->params()->fromQuery ( 'id_patient', 0 );
		$id_rv  = $this->params()->fromQuery ( 'id_rv' );
		
		
	
		$this->layout ()->setTemplate ( 'layout/orl' );
	
		if($this->getRequest ()->isPost ()){
			$formData = $this->getRequest ()->getPost ();
			
			$infos_rv = array(
					'NOTE'    => $formData['motif_rv'],
					'HEURE'   => $formData['heure_rv'],
					'DATE'    => (new DateHelper())->convertDateInAnglais($formData['date_rv']),
					'DELAI'   => $formData['delai_rv'],
			);
			$id_rv = $formData['id_rv'];
			$this->getRvPatientConsTable()->updateRendezVousProgrammer($infos_rv, $id_rv);
			
			return $this->redirect ()->toRoute ( 'secretariat', array (
					'action' => 'liste-rendez-vous'
			) );
				
		}else{

			
			$infosRv = $this->getRvPatientConsTable()->getRendezVousProgrammer($id_rv);
			
			$tabInfos = array(
					'id_rv'    => $id_rv,
					'motif_rv' => $infosRv['NOTE'],
					'date_rv'  => (new DateHelper())->convertDate($infosRv['DATE']),
					'delai_rv' => $infosRv['DELAI'],
					'heure_rv' => $infosRv['HEURE'],
			);
			
			$form = new ConsultationForm();
			$form->populateValues($tabInfos);
			
			$patient = $this->getPatientTable ();
			$unPatient = $patient->getInfoPatient( $id_pat );
			//var_dump(	$tabInfos);exit();
			return array (
					
					'form'=>$form,
					'lesdetails' => $unPatient,
					'image' => $patient->getPhoto ( $id_pat ),
					'id_patient' => $unPatient['ID_PERSONNE'],
					'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
			);
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function fixerRendezVousAjaxAction() {
		$output = $this->getRvPatientConsTable()->fixerRendezVousConsultation();
		// var_dump("$leRendezVous"); exit();
		//$patient = $this->getPatientTable ();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function fixerRendezVousAction() {
		//$formConsultation = new ConsultationForm();
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/orl' );
			
		$user = $this->layout()->user;
		$idService = $user['IdService'];
		$id_cons = $this->params()->fromPost('id_cons');
		$id_patient = $this->params()->fromPost('id_patient');
		$leRendezVous = $this->getRvPatientConsTable()->getFixerRV();
		//var_dump($leRendezVous); exit();
	
	
		//$lespatients = $this->getConsultationTable()->listePatientsConsParMedecin ( $idService );
		//
		//RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
	
		$tabPatientRV = $this->getConsultationTable ()->getPatientsRV($idService);
		//var_dump($tabPatientRV);exit();
		//   		if($leRendezVous) {
	
		//   		var_dump($leRendezVous); exit();
		//  		$data['heure_rv'] = $leRendezVous->heure;
		//   		//$data['date_rv']  = $this->controlDate->convertDate($leRendezVous->date);
		//   		$data['motif_rv'] = $leRendezVous->note;
		//   		$data['delai_rv'] = $leRendezVous->note;
		//   		}
	
	
		if (isset ( $_POST ['terminer'] ))  // si formulaire soumis
		{
			$id_patient = $this->params()->fromPost('id_patient');
			$date_RV_Recu = $this->params()->fromPost('date_rv');
	
			if($date_RV_Recu){
				$date_RV = (new DateHelper())->convertDateInAnglais($date_RV_Recu);
			}
				
			else{
				$date_RV = $date_RV_Recu;
			}
				
			$infos_rv = array(
					'ID_CONS' => $id_cons,
					'NOTE'    => $this->params()->fromPost('motif_rv'),
					'HEURE'   => $this->params()->fromPost('heure_rv'),
					'DATE'    => $date_RV,
					'DELAI'   => $this->params()->fromPost('delai_rv'),
			);
			//var_dump($infos_rv);exit();
				
			$this->getRvPatientConsTable()->updateRendezVous($infos_rv);
			//var_dump('ssssss');exit();
			if ($this->params()->fromPost ( 'terminer' ) == 'save') {
				//VALIDER EN METTANT '1' DANS CONSPRISE Signifiant que le medecin a consulter le patient
				//Ajouter l'id du medecin ayant consulter le patient
				$valide = array (
						'VALIDER' => 1,
						'ID_CONS' => $id_cons,
						'ID_MEDECIN' => $this->params()->fromPost('med_id_personne')
				);
				$this->getConsultationTable ()->validerConsultation ( $valide );
			}
			return $this->redirect ()->toRoute ( 'secretariat', array (
					'action' => 'fixer-rendez-vous'
			) );
		}
	
	
		return new ViewModel ( array (
				//'donnees' => $leRendezVous,
				'tabPatientRV' => $tabPatientRV,
				//  				'listeRendezVous' => $patientsRV->getPatientsRV (),
		//  				'form' => $formConsultation,
		) );
			
			
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function infoPatientRvAction() {
		$this->layout ()->setTemplate ( 'layout/orl' );
		$id_pat = $this->params()->fromQuery ( 'id_patient', 0 );
		$id_cons = $this->params()->fromQuery ( 'id_cons' );
	
		$form = new ConsultationForm();
		$form->populateValues(array('id_cons' => $id_cons));
	
		$user = $this->layout()->user;
		$IdDuService = $user['IdService'];
	
		$patient = $this->getPatientTable ();
			
		$unPatient = $patient->getInfoPatient( $id_pat );
	
		$data = array();
		$rv_consultation = $this->getRvPatientConsTable()->getRendezVousConsultation($id_cons);
		$leRendezVous = $this->getRvPatientConsTable()->getInfosRendezVousConsultation($rv_consultation['ID_RV']);
	
		if($leRendezVous) {
			$date_rv = "";
			if ($leRendezVous['DATE']){ $date_rv = (new DateHelper())->convertDate($leRendezVous['DATE']); }
	
			$data['heure_rv'] = $leRendezVous['HEURE'];
			$data['date_rv']  = $date_rv;
			$data['motif_rv'] = $leRendezVous['NOTE'];
			$data['delai_rv'] = $leRendezVous['DELAI'];
		}
		$data['id_rv'] = $rv_consultation['ID_RV'];
		$form->populateValues($data);
	
		return array (
				'form'=>$form,
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'id_patient' => $unPatient['ID_PERSONNE'],
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	}
	
	
	
	
	
}

