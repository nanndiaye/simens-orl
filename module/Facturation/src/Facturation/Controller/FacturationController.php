<?php

//Ligne voir 264 - 280 pour la gestion des activit�s du serveillant de service


namespace Facturation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
// use Zend\View\Helper\Json;
use Zend\Json\Json;
use Facturation\Model\Patient;
use Facturation\Model\Deces;
use Facturation\Model\Naissance;
use Personnel\Model\Service;
use Facturation\Model\TarifConsultation;
use Facturation\Form\PatientForm;
use Facturation\Form\AjoutNaissanceForm;
use Facturation\Form\AdmissionForm;
use Zend\Json\Expr;
use Facturation\Form\AjoutDecesForm;
use Zend\Stdlib\DateTime;
use Zend\Mvc\Service\ViewJsonRendererFactory;
use Zend\Ldap\Converter\Converter;
use Zend\Form\View\Helper\FormRow;
use Zend\Form\View\Helper\FormInput;
use Facturation\View\Helper\DateHelper;
use Zend\Debug\Debug;
use Zend\Mail\Header\Sender;
use Zend\Form\View\Helper\FormLabel;
use Zend\Form\Form;
use Zend\Form\View\Helper\FormSelect;
use Zend\Form\View\Helper\FormText;
use Zend\Form\View\Helper\FormCollection;
use Zend\Form\View\Helper\FormElement;
use Zend\Form\View\Helper\FormTextarea;
use Zend\Crypt\PublicKey\Rsa\PublicKey;
use Zend\Form\View\Helper\FormHidden;
use Consultation\Form\ConsultationForm;
use Facturation\View\Helper\DocumentPdf;
use Facturation\View\Helper\FacturePdf;
use Facturation\View\Helper\FactureActePdf;
use Facturation\Form\AdmissionBlocForm;
use Facturation\Form\StatistiqueForm;

class FacturationController extends AbstractActionController {
	protected $dateHelper;
	protected $patientTable;
	protected $decesTable;
	protected $formPatient;
	protected $serviceTable;
	protected $admissionTable;
	protected $naissanceTable;
	protected $tarifConsultationTable;
	protected $consultationTable;
	protected $demandeActeTable;
	
	public function getPatientTable() {
		if (! $this->patientTable) {
			
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Facturation\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getDecesTable() {
		if (! $this->decesTable) {
			$sm = $this->getServiceLocator ();
			$this->decesTable = $sm->get ( 'Facturation\Model\DecesTable' );
		}
		return $this->decesTable;
	}
	public function getServiceTable() {
		if (! $this->serviceTable) {
			$sm = $this->getServiceLocator ();
			$this->serviceTable = $sm->get ( 'Facturation\Model\ServiceTable' );
		}
		return $this->serviceTable;
	}
	public function getAdmissionTable() {
		if (! $this->admissionTable) {
			$sm = $this->getServiceLocator ();
			$this->admissionTable = $sm->get ( 'Facturation\Model\AdmissionTable' );
		}
		return $this->admissionTable;
	}
	public function getNaissanceTable() {
		if (! $this->naissanceTable) {
			$sm = $this->getServiceLocator ();
			$this->naissanceTable = $sm->get ( 'Facturation\Model\NaissanceTable' );
		}
		return $this->naissanceTable;
	}
	public function getTarifConsultationTable() {
		if (! $this->tarifConsultationTable) {
			$sm = $this->getServiceLocator ();
			$this->tarifConsultationTable = $sm->get ( 'Facturation\Model\TarifConsultationTable' );
		}
		return $this->tarifConsultationTable;
	}
	
	public function getConsultationTable() {
		if (! $this->consultationTable) {
			$sm = $this->getServiceLocator ();
			$this->consultationTable = $sm->get ( 'Consultation\Model\ConsultationTable' );
		}
		return $this->consultationTable;
	}
	
	public function getDemandeActe() {
		if (! $this->demandeActeTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeActeTable = $sm->get ( 'Consultation\Model\DemandeActeTable' );
		}
		return $this->demandeActeTable;
	}
	
/*****************************************************************************************************************************/
/*****************************************************************************************************************************/
/*****************************************************************************************************************************/
	Public function getDateHelper() {
		$this->dateHelper = new DateHelper();
	}
	
	public function baseUrl(){
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
		return $tabURI[0];
	}
	
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm ();
		}
		return $this->formPatient;
	}
	
	public function listePatientAction() {
// 		listePatientAjaxAction();
// 		var_dump($donnees);exit();
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/facturation' );
		$view = new ViewModel ();
		return $view;
	}
	
	public function listeAdmissionAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->laListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeAdmissionBlocAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->laListePatientsBlocAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	

	public function listeActesImpayesAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->listeDesActesImpayesDesPatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeActesPayesAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->listeDesActesPayesDesPatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
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
	
	public function numeroFacture() {
		$lastAdmission = $this->getAdmissionTable()->getLastAdmission();
		return $this->creerNumeroFacturation($lastAdmission['numero']+1);
	}
	
	public function admissionAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/facturation' );
		$patient = $this->getPatientTable ();
		$output = $patient->laListePatientsAjax();
		
		$numero = $this->numeroFacture();
		//INSTANCIATION DU FORMULAIRE D'ADMISSION
		$formAdmission = new AdmissionForm ();
		
		$service = $this->getTarifConsultationTable()->listeService();
		
		$listeService = $this->getServiceTable ()->listeService ();
		$afficheTous = array ("" => 'Tous');
		
		$tab_service = array_merge ( $afficheTous, $listeService );
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$formAdmission->get ( 'liste_service' )->setValueOptions ( $tab_service );
		
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
			
			//Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
			$RendezVOUS = $pat->verifierRV($id, $dateAujourdhui);
			
			$unPatient = $pat->getInfoPatient( $id );

			$photo = $pat->getPhoto ( $id );

			
			$date = $unPatient['DATE_NAISSANCE'];
			if($date){ $date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}

			$html  = "<div style='width:100%;'>";
			
			$html .= "<div style='width: 18%; height: 190px; float:left;'>";
			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
			$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
			$html .= "</div>";
			
			$html .= "<div id='vuePatientAdmission' style='width: 70%; height: 190px; float:left;'>";
			$html .= "<table style='margin-top:0px; float:left; width: 100%;'>";
			
			$html .= "<tr style='width: 100%;'>";
			$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></div></td>";
			$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
			$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
			$html .= "<td style='width: 29%; '></td>";
			
			$html .= "</tr><tr style='width: 100%;'>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
			
			$html .= "</tr><tr style='width: 100%;'>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
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
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:10px; margin-left:5px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
			
			$html .= "</div>";
			
			$html .= "<script>
					         $('#numero').val('" . $numero . "');
					         $('#numero').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'18px'});
					         $('#numero').attr('readonly',true);

					         $('#service').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'16px'});

					         $('#taux').css({'font-weight':'bold','color':'#065d10','padding-left':'10px','font-family': 'Times  New Roman','font-size':'24px'});
					         		
					         $('#montant_avec_majoration').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'green','font-family': 'Time  New Romans','font-size':'24px'});
					         $('#montant_avec_majoration').attr('readonly',true);
					
					         function FaireClignoterImage (){
                                $('#image-neon').fadeOut(900).delay(300).fadeIn(800);
                             }
                             setInterval('FaireClignoterImage()',2200);
					 </script>"; // Uniquement pour la facturation

			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array (
				'form' => $formAdmission
		);
	}
	
	public function admissionBlocAction(){
		
		$patient = $this->getPatientTable ();
		$output = $patient->laListePatientsBlocAjax();
		
		//var_dump($output);exit();
		
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/facturation' );
		$numero = $this->numeroFacture();
		//INSTANCIATION DU FORMULAIRE D'ADMISSION
		$formAdmission = new AdmissionBlocForm();
		$service = $this->getTarifConsultationTable()->listeService();
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$medecin = $this->getTarifConsultationTable()->listeMedecins();
		$formAdmission->get ( 'operateur' )->setValueOptions ( $medecin );
		$id_cons = $this->params()->fromPost ('id_cons');
		if ($this->getRequest ()->isPost ()) {
			$today = new \DateTime ();
			$dateAujourdhui = $today->format( 'Y-m-d' );
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			$iddemande = ( int ) $this->params ()->fromPost ( 'iddemande', 0 );
			$demande = $this->getAdmissionTable()->getDemandeOperation($iddemande);
			$numeroVPA = $demande['numeroVPA']; //met la valeur de numeroVPA dans son champ sur la vue
			$typeIntervention = $demande['type_intervention'];
			$diagnostic = $demande['diagnostic'];
			
			//MISE A JOUR DE L'AGE DU PATIENT
			$personne = $this->getPatientTable()->miseAJourAgePatient($id);
			//*******************************
				
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getInfoPatient( $id );
			$photo = $pat->getPhoto ( $id );
			$date = $unPatient['DATE_NAISSANCE'];
			if($date){ $date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}
		
			$html  = "<div style='width:100%;'>";
				
			$html .= "<div style='width: 18%; height: 190px; float:left;'>";
			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
			$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
			$html .= "</div>";
				
			$html .= "<div id='vuePatientAdmission' style='width: 70%; height: 190px; float:left;'>";
			$html .= "<table style='margin-top:0px; float:left; width: 100%;'>";
				
			$html .= "<tr style='width: 100%;'>";
			$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></div></td>";
			$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
			$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
			$html .= "<td style='width: 29%; '></td>";
				
			$html .= "</tr><tr style='width: 100%;'>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
				
			$html .= "</tr><tr style='width: 100%;'>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></div></td>";
				
			$html .= "<td style='width: 30%; height: 50px;'>";
			$html .= "</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
				
			$html .= "<div style='width: 12%; height: 190px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:10px; margin-left:5px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
				
			$html .= "</div>";
				
			$html .= "<script>
					   $('#service').css({'color':'black', 'font-family': 'Times  New Roman','font-size':'17px'});
					   $('#vpa').val('".$numeroVPA."').attr('disabled', true);
					   $('#intervention_prevue').val('".$typeIntervention."').attr('readonly',true);
					   $('#diagnostic').val('".$diagnostic."').attr('disabled',true);
					   $('#idDemandeOperation').val($iddemande);
					 </script>"; 
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array ( 'form' => $formAdmission );
	}
	
	public function getServiceAction() {
		$id_medecin = ( int ) $this->params ()->fromPost ( 'id_medecin', 0 );
		
		$medecin = $this->getTarifConsultationTable()->getServiceMedecin($id_medecin);
		
		$id_service = $medecin['Id_service'];
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $id_service ) );
	}
	
	public function enregistrerAdmissionAction() {
		$user = $this->layout()->user;
		$id_employe = $user['id_personne'];
		
		$today = new \DateTime ( "now" );
		$date_cons = $today->format ( 'Y-m-d' );
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		
		$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient', 0 );
		$numero = $this->params ()->fromPost ( 'numero' );
		$id_service = $this->params ()->fromPost ( 'service' );
		$montant = $this->params ()->fromPost ( 'montant' );
		$type_facturation = $this->params ()->fromPost ( 'type_facturation' );
		
		$donnees = array (
				'id_patient' => $id_patient,
				'id_service' => $id_service,
				'date_cons' => $date_cons,
				'montant' => $montant,
				'numero' => $numero,
				'date_enregistrement' => $date_enregistrement,
				'id_employe' => $id_employe,
		);
		if($type_facturation == 2){
			$organisme = $this->params ()->fromPost ( 'organisme' );
			$taux = $this->params ()->fromPost ( 'taux' );
			$montant_avec_majoration = $this->params ()->fromPost ( 'montant_avec_majoration' );
			
			$donnees['id_type_facturation'] = 2;
			$donnees['organisme'] = $organisme;
			$donnees['taux_majoration'] = $taux;
			$donnees['montant_avec_majoration'] = $montant_avec_majoration;
		} else 
		    if($type_facturation == 1){
		    	$donnees['id_type_facturation'] = 1;
		    }
		$this->getAdmissionTable ()->addAdmission ( $donnees );
			
			
		//NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT SANS LE PASSAGE DE CELUI CI AU NIVEAU DU SURVEILLANT DE SERVICE
		//NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT SANS LE PASSAGE DE CELUI CI AU NIVEAU DU SURVEILLANT DE SERVICE
		//NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT SANS LE PASSAGE DE CELUI CI AU NIVEAU DU SURVEILLANT DE SERVICE
		/* CODE A SUPPRIMER POUR FAIRE INTERVENIR LE SURVEILLANT DE SERVICE*/
		/* CODE A SUPPRIMER POUR FAIRE INTERVENIR LE SURVEILLANT DE SERVICE*/
		/* CODE A SUPPRIMER POUR FAIRE INTERVENIR LE SURVEILLANT DE SERVICE*/
		$form = new ConsultationForm ();
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
			
		$this->getAdmissionTable ()-> addConsultation ( $form, $id_service );
		$id_cons = $form->get ( "id_cons" )->getValue ();
		$this->getAdmissionTable ()->addConsultationOrl($id_cons);
			
		//FIN FIN NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT
		//FIN FIN NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT
		//FIN FIN NOUVEAU CODE AJOUTER POUR QUE LE MEDECIN PUISSE AJOUTER DIRECTEMENT LES CONSTANTES DU PATIENT
 		return $this->redirect()->toRoute('facturation', array( 'action' =>'liste-patients-admis' ));
	}
	
	public function enregistrerAdmissionBlocAction(){
		$user = $this->layout()->user;
		$id_employe = $user['id_personne'];
		$today = new \DateTime ( "now" );
		$date_cons = $today->format ( 'Y-m-d' );
		$date = $today->format ( 'Y-m-d' );
		$heure = $today->format ( 'H:i:s' );
		$salle = $this->params ()->fromPost ( 'salle' );
		$operateur = $this->params ()->fromPost ( 'operateur' );
		
		$idDemandeOperation = ( int ) $this->params ()->fromPost ( 'idDemandeOperation' );
		$demandeOperation = $this->getAdmissionTable()->getDemandeOperation($idDemandeOperation);
		$id_cons = $demandeOperation['id_cons'];
		$donnees = array (
				'id_cons' =>$id_cons,
				'salle' => $salle,
				'operateur' => $operateur,
				'date' => $date,
				'heure' => $heure,
				'id_employe' => $id_employe,
		);
		$this->getAdmissionTable ()->addAdmissionBloc ( $donnees );
		return $this->redirect()->toRoute('facturation', array('action' =>'liste-patients-admis-bloc'));
	}
	
	public function modificationAdmissionBlocAction(){
		$user = $this->layout()->user;
		$id_employe = $user['id_personne'];
		
		$today = new \DateTime ( "now" );
		$date_cons = $today->format ( 'Y-m-d' );
		$date_modification = $today->format ( 'Y-m-d H:i:s' );
		
		$id_admission = ( int ) $this->params ()->fromPost ( 'id_admission', 0 );
		$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient', 0 );
		$diagnostic = $this->params ()->fromPost ( 'diagnostic' );
		$intervention_prevue = $this->params ()->fromPost ( 'intervention_prevue' );
		$vpa = $this->params ()->fromPost ( 'vpa' );
		$salle = $this->params ()->fromPost ( 'salle' );
		$operateur = $this->params ()->fromPost ( 'operateur' );
		
		$donneesAdmission = array (
				'salle' => $salle,
				'operateur' => $operateur,
				'date_modification' => $date_modification,
				'id_employe' => $id_employe,
		);
		$this->getAdmissionTable ()->updateAdmissionBloc( $donneesAdmission , $id_admission);
		
		$InfoAdmis = $this->getAdmissionTable()->getPatientAdmisBloc($id_admission);
		$id_cons = $InfoAdmis['id_cons'];
		$donneesDemandeOperation= array (
				'diagnostic' => $diagnostic,
				'type_intervention' => $intervention_prevue,
				'numeroVPA' => $vpa,
				'id_employe' => $id_employe,
		);
		//var_dump($id_cons);exit();
		$this->getAdmissionTable ()->updateDemandeOperationBloc( $donneesDemandeOperation , $id_cons);
		
		
		return $this->redirect()->toRoute('facturation', array(
				'action' =>'liste-patients-admis-bloc'));
	}
	
	public function impressionPdfAction(){
		
		$id_patient = $this->params()->fromPost( 'id_patient' );
		$user = $this->layout()->user;
		$service = $user['NomService'];
 		//******************************************************
 		//******************************************************
 		//*********** DONNEES COMMUNES A TOUS LES PDF **********
 		//******************************************************
 		//******************************************************
		$lePatient = $this->getPatientTable()->getInfoPatient( $id_patient );

		$infos = array(
				'numero' => $this->params ()->fromPost ( 'numero' ),
				'service' => $this->getPatientTable()->getServiceParId( $this->params ()->fromPost ( 'service' ) )['NOM'],
				'montant' => $this->params ()->fromPost ( 'montant' ),
				'montant_avec_majoration' => $this->params ()->fromPost ( 'montant_avec_majoration' ),
				'type_facturation' => $this->params ()->fromPost ( 'type_facturation' ),
				'organisme' => $this->params ()->fromPost ( 'organisme' ),
				'taux' => $this->params ()->fromPost ( 'taux' ),
		);
 		
		//******************************************************
		//******************************************************
		//*************** Cr�ation du fichier pdf **************
		//******************************************************
		//******************************************************
		//Cr�er le document
		$DocPdf = new DocumentPdf();
		//Cr�er la page
		$page = new FacturePdf();
	
		//Envoyer les donn�es sur le partient
		$page->setDonneesPatient($lePatient);
		$page->setService($service);
		$page->setInformations($infos);
		//Ajouter une note � la page
		$page->addNote();
		//Ajouter la page au document
		$DocPdf->addPage($page->getPage());
  	    //Afficher le document contenant la page
 			
		$DocPdf->getDocument();

	}
	
	public function prixMill($prix) {
		$str="";
		$long =strlen($prix)-1;
		for($i = $long ; $i>=0; $i--)
		{
		$j=$long -$i;
		if( ($j%3 == 0) && $j!=0)
		{ $str= " ".$str;   }
		$p= $prix[$i];
	
		$str = $p.$str;
		}
		if(!$str){ $str = $prix; }
		return($str);
	}
	
	public function montantAction() {
		if ($this->getRequest ()->isPost ()) {
			$id_service = ( int ) $this->params ()->fromPost ( 'id', 0 ); // id du service
			$tarif = $this->getTarifConsultationTable ()->TarifDuService ( $id_service );
			if ($tarif) {
				$montant = $tarif['TARIF'];
			} else {
				$montant = '';
			}
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $montant ) );
		}
	}
	
	public function listePatientsAdmisAction() {
		
		$this->layout ()->setTemplate ( 'layout/facturation' );
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
	
	public function listePatientAdmisBlocAjaxAction() {
		$output = $this->getPatientTable ()->getListePatientsAdmisBloc();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function supprimerAdmissionBlocAction(){
		
		$id_admission = (int)$this->params()->fromPost ('id_admission');
		$protocole = $this->getPatientTable ()->getProtocoleOperatoire($id_admission);
		$existeResult = 1;
		if(!$protocole){ $this->getPatientTable ()->deleteAdmission($id_admission); $existeResult = 0;}
		
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($existeResult));
	}
	
	public function listePatientsAdmisBlocAction() {
		$output = $this->getPatientTable ()->getListePatientsAdmisBlocOperatoire(1);
		//var_dump($output);exit();
		//INSTANCIATION DU FORMULAIRE D'ADMISSION
		$formAdmission = new AdmissionBlocForm();
		
		$this->layout ()->setTemplate ( 'layout/facturation' );
		//INSTANCIATION DU FORMULAIRE
		$service = $this->getServiceTable ()->fetchService ();
		$listeService = $this->getServiceTable ()->listeService ();
		$afficheTous = array (
				"" => 'Tous'
		);
	
		$tab_service = array_merge ( $afficheTous, $listeService );
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$formAdmission->get ( 'liste_service' )->setValueOptions ( $tab_service );
		
		$medecin = $this->getTarifConsultationTable()->listeMedecins();
		$formAdmission->get ( 'operateur' )->setValueOptions ( $medecin );
		
		return new ViewModel ( array (
				'form' => $formAdmission,
		) );
	}
	
	public function vuePatientAdmisBlocAction() {

		$this->getDateHelper();
		
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$idPatient = (int)$this->params()->fromPost ('idPatient');
		$idAdmission = (int)$this->params()->fromPost ('idAdmission');
		
		$unPatient = $this->getPatientTable()->get
		($idPatient);
		$photo = $this->getPatientTable()->getPhoto($idPatient);
		
		//Informations sur l'admission
		$InfoAdmis = $this->getAdmissionTable()->getPatientAdmisBloc($idAdmission);
		$id_cons = $InfoAdmis['id_cons'];
		$InfoDemandeOperation = $this->getAdmissionTable()->getInfosDemandeOperationBloc($id_cons);
		
		$medecin = $this->getTarifConsultationTable()->getServiceMedecin($InfoAdmis['operateur']);
		$id_service = $medecin['Id_service'];
		
		//Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
		$today = new \DateTime ();
		$dateAujourdhui = $today->format( 'Y-m-d' );
		
		$date = $unPatient['DATE_NAISSANCE'];
		if($date){ $date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 210px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
		$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 70%; height: 210px; float:left;'>";
		$html .= "<table id='vuePatientAdmission' style='margin-top:10px; float:left'>";
		
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></div></td>";
		$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
		$html .= "<td style='width: 29%; '></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . " </p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></div></td>";
		
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 12%; height: 210px; float:left; '>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:0px; margin-left:0px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		$datetime = $this->convertDate ($InfoAdmis['date']).' - '.$InfoAdmis['heure'];
		
 		$html .= "<script>";
		$html .= " $('#diagnostic').val('".str_replace("'", "\'",$InfoDemandeOperation['
		    
		 
		'])."');";
		$html .= "$('#id_admission').val('".str_replace("'", "\'",$InfoAdmis['id_admission'])."');";
		$html .= "$('#intervention_prevue').val('".str_replace("'", "\'",$InfoDemandeOperation['type_intervention'])."');";
		$html .= "$('#vpa').val('".str_replace("'", "\'",$InfoDemandeOperation['numeroVPA'])."');";
		$html .= "$('#salle').val('".str_replace("'", "\'",$InfoAdmis['salle'])."');";
		$html .= "$('#operateur').val('".(int)$InfoAdmis['operateur']."');";
		$html .= "$('#service').val('".(int)$id_service."'); ";
		$html .= "$('.dateEnregistrementBloc').html('enregistr&eacute; le, ".$datetime."');";
 		$html .= "</script>";
 		$html .= "<script> setTimeout(function(){ desactiverChamps(); desactiverChampsInit(); },500); </script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($html));
	}
	
	public function supprimerPatientAction() {
		$id_patient = (int)$this->params()->fromPost ('id_patient');
		
		$this->getPatientTable() -> deletePersonne($id_patient);
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($id_patient));
	}
	
	public function listeNaissanceAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
		
		return new ViewModel ( array ( ) );
	}
	
	
	//Ajouter un patient pour l'agent de la facturation
	//Ajouter un patient pour l'agent de la facturation
	public function ajouterAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
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
	
	//Ajouter un patient pour l'agent qui ajoute une naissance ou un dec�s
	//Ajouter un patient pour l'agent qui ajoute une naissance ou un dec�s
	public function ajouterMamanAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
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
	
	//Ajouter un patient d�c�d�
	//Ajouter un patient d�c�d�
	public function ajouterPatientAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
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
	
	
	//Enregistrement du patient ajout� par l'agent de la facturation
	public function enregistrementAction() {
	
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connect�
		
		// CHARGEMENT DE LA PHOTO ET ENREGISTREMENT DES DONNEES
		if (isset ( $_POST ['terminer'] ))  // si formulaire soumis
		{
			$Control = new DateHelper();
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
					'DATE_MODIFICATION' => $today->format ( 'Y-m-d' ),
			);
				//var_dump($date_naissance); exit();
			if ($img != false) {
	
				$donnees['PHOTO'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
					
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'liste-patient'
				) );
			} else {
				// On enregistre sans la photo
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'liste-patient'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'facturation', array (
				'action' => 'liste-patient'
		) );
	}
	
	//Enregistrement de la maman par l'agent qui enregistre les naissances
	public function enregistrementMamanAction() {
		//var_dump('test reussi'); exit();
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connect�
		
		// CHARGEMENT DE LA PHOTO ET ENREGISTREMENT DES DONNEES
		if (isset ( $_POST ['terminer'] ))  // si formulaire soumis
		{
			$Control = new DateHelper();
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
					'SEXE' => 'Féminin',
					'AGE' => $this->params ()->fromPost ( 'AGE' ),
			);
			
			if ($img != false) {
		
				$donnees['PHOTO'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
					
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'ajouter-naissance'
				) );
			} else {
				// On enregistre sans la photo
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'ajouter-naissance'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'facturation', array (
				'action' => 'ajouter-naissance'
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
			);
	
			if ($img != false) {
	
				$donnees['PHOTO'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
					
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'declarer-deces'
				) );
			} else {
				// On enregistre sans la photo
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'declarer-deces'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'facturation', array (
				'action' => 'declarer-deces'
		) );
	}
	
	public function 
	 Action() {
		$control = new DateHelper();
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$id_patient = $this->params ()->fromRoute ( 'val', 0 ); 
	
		$infoPatient = $this->getPatientTable ();
		try {
			$info = $infoPatient->getInfoPatient( $id_patient );
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'facturation', array (
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
				
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'liste-patient'
				) );
			} else {
				$Patient->updatePatient($donnees, $id_patient, $date_modification, $id_employe);
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'liste-patient'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'facturation', array (
				'action' => 'liste-patient'
		) );
	}
	
	public function listePatientDecesAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->getListePatientsDecedesAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listePatientDeclarationDecesAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->getListeDeclarationDecesAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function declarerDecesAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
		
		//INSTANCIATION DU FORMULAIRE DE DECES
		$ajoutDecesForm = new AjoutDecesForm ();

		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			//MISE A JOUR DE L'AGE DU PATIENT
			//MISE A JOUR DE L'AGE DU PATIENT
			//MISE A JOUR DE L'AGE DU PATIENT
			//$personne = $this->getPatientTable()->miseAJourAgePatient($id);
			//*******************************
			//*******************************
			//*******************************
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getInfoPatient ( $id );
			$photo = $pat->getPhoto ( $id );
			
			$date = $unPatient['DATE_NAISSANCE'];
			if($date){ $date = $this->convertDate ($date); }else{ $date = null;}

			$html = "<div style='float:left;' ><div id='photo' style='float:left; margin-right:20px; margin-bottom: 10px;'> <img  src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'  style='width:105px; height:105px;'></div>";
			$html .= "<div style='margin-left:6px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div></div>";
			
			
			$html .= "<table>";

			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
			$html .= "</tr>";

			$html .= "</table>";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array (
				'form' => $ajoutDecesForm
		);
	}
	
	public function listePatientAjaxAction() {
		$output = $this->getPatientTable ()->getListePatient ();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function convertDate($date) {
		$nouv_date = substr ( $date, 8, 2 ) . '/' . substr ( $date, 5, 2 ) . '/' . substr ( $date, 0, 4 );
		return $nouv_date;
	}
	
	public function listeNaissanceAjaxAction() {
		$output = $this->getPatientTable ()->getListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function ajouterNaissanceAjaxAction() {
		$output = $this->getPatientTable ()->getListeAjouterNaissanceAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function ajouterNaissanceAction() {
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$this->layout ()->setTemplate ( 'layout/facturation' );
		
		$ajoutNaissForm = new AjoutNaissanceForm ();

		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			
			$unPatient = $this->getPatientTable ()->getInfoPatient ( $id );
			$photo = $this->getPatientTable ()->getPhoto ( $id );

			$date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] );

			$html = "<div id='photo' style='float:left; margin-right:20px;' > <img  style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/" . $photo . "'></div>";

			$html .= "<table>";

			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
			$html .= "</tr>";

			$html .= "</table>";

			$this->getResponse ()->setMetadata ( 'Content-Type', 'application/html' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array (
				'form' => $ajoutNaissForm
		);
	}
	public function enregistrerBebeAction() {

		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connect�
		
		if ($this->getRequest ()->isPost ()) {
			$this->getDateHelper();
			$today = new \DateTime ( 'now' );
			$date_enregistrement = $today->format ( 'Y-m-d H:i:s' ); 
			$patient = $this->getPatientTable ();
			$naissance = $this->getNaissanceTable();

			$id_maman = ( int ) $this->params ()->fromPost ( 'ID_PERSONNE' ); 
 			$info_maman = $patient->getInfoPatient ( $id_maman );

 			$donnees = array(
 					'NOM'             => $this->params ()->fromPost ( 'NOM' ),
 					'PRENOM'          => $this->params ()->fromPost ( 'PRENOM' ),
 					'DATE_NAISSANCE'  => $this->dateHelper->convertDateInAnglais($this->params ()->fromPost ( 'DATE_NAISSANCE' )),
 					'LIEU_NAISSANCE'  => $this->params ()->fromPost ( 'LIEU_NAISSANCE' ),
 					'GROUPE_SANGUIN'  => $this->params ()->fromPost ( 'GROUPE_SANGUIN' ),
 					'SEXE'            => $this->params ()->fromPost ( 'SEXE' ),
 					'TAILLE'          => $this->params ()->fromPost ( 'TAILLE' ),
 					'POIDS'           => $this->params ()->fromPost ( 'POIDS' ),
 					'TELEPHONE'       => $info_maman['TELEPHONE'],
 					'EMAIL'           => $info_maman['EMAIL'],
 					'ADRESSE'         => $info_maman['ADRESSE'],
 					'NATIONALITE_ACTUELLE' => $info_maman['NATIONALITE_ACTUELLE'],
 					'NATIONALITE_ORIGINE'  => $info_maman['NATIONALITE_ORIGINE'],
 			);
		
			//Enegistrement dans la table PERSONNE
			$id_bebe = $patient->addPersonneNaissance($donnees, $date_enregistrement, $id_employe); /* id_bebe = ID_PERSONNE dans la table patient*/
			$donneesNaissance = array (
					'ID_MAMAN' => $id_maman,
					'ID_BEBE' => $id_bebe,
					'TAILLE' => $donnees['TAILLE'],
					'POIDS' => $donnees['POIDS'],
					'DATE_NAISSANCE' => $donnees['DATE_NAISSANCE'],
					'HEURE_NAISSANCE' => $this->params ()->fromPost ( 'HEURE_NAISSANCE' ),
					'DATE_ENREGISTREMENT'  => $date_enregistrement,
					'ID_EMPLOYE' => $id_employe,
			);
			//Enregistrement de la naissance
			$naissance->addNaissance($donneesNaissance);
			
			return $this->redirect ()->toRoute ( 'facturation', array (
					'action' => 'liste-naissance'
			) );
		}
	}
	
	
	public function birthday2Age($value) {
		$date = new \DateTime("now");
		$date2 = new \DateTime($value);
		$resultatTab = get_object_vars($date->diff($date2));
		$nbJours = $resultatTab['days'];
		$nbAnnees = floor($nbJours / 365);
		
		if($nbAnnees == 0){ 
			return $nbJours.' jours';
		}
		else if($nbAnnees == 1){ 
			return $nbAnnees.' an';
		}
		else return $nbAnnees.' ans';
	}
	public function lePatientAction() {
		if ($this->getRequest ()->isPost ()) {

			$id = $this->params ()->fromPost ( 'id', 0 );
			$unPatient = $this->getPatientTable ()->getInfoPatient ( $id );
			$photo = $this->getPatientTable ()->getPhoto ( $id );

			$date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] );
			
			$html  = "<div>";
			
			$html .= "<div style='width: 18%; height: 180px; float:left;'>";
			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
			$html .= "</div>";
			
			$html .= "<div style='width: 65%; height: 180px; float:left;'>";
			$html .= "<table style='margin-top:10px; float:left'>";
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PROFESSION'] . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .="</div>";
			
			$html .= "<div style='width: 17%; height: 180px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
			
			$html .= "</div>";
			
			$html .= "<script>$('#age_deces').val('" . $this->birthday2Age ( $unPatient['DATE_NAISSANCE'] ) . "');
					         $('#age_deces').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					         $('#age_deces').attr('readonly',true);
					 </script>"; // Uniquement pour la d�claration du d�c�s

			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
	}
	public function enregistrerDecesAction() {
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connect�
		
		$this->getDateHelper();
		if ($this->getRequest ()->isPost ()) {
			$today = new \DateTime ();
			$date_enregistrement = $today->format('Y-m-d H:i:s');

			$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient' ); 
			
			$date_deces = $this->dateHelper->convertDateInAnglais($this->params ()->fromPost ( 'date_deces' ));
			$heure_deces = $this->params ()->fromPost ( 'heure_deces' );
			$age_deces = $this->params ()->fromPost ( 'age_deces' );
			$lieu_deces = $this->params ()->fromPost ( 'lieu_deces' );
			$circonstances_deces = $this->params ()->fromPost ( 'circonstances_deces' );
			$note_importante = $this->params ()->fromPost ( 'note' );

			$donnees = array (
					'id_patient' => $id_patient,
					'date_deces' => $date_deces,
					'heure_deces' => $heure_deces,
					'age_deces' => $age_deces,
					'lieu_deces' => $lieu_deces,
					'circonstances_deces' => $circonstances_deces,
					'note' => $note_importante,
					'date_enregistrement' => $date_enregistrement,
					'id_employe' => $id_employe,
			);

			$this->getDecesTable()->addDeces ( $donnees );

			return $this->redirect()->toRoute('facturation', array(
					'action' => 'liste-patients-decedes'));
		}
	}
	
	public function listePatientsDecedesAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$Patientsdeces = $this->getDecesTable ();
		$listePatientsDecedes = $Patientsdeces->getPatientsDecedes ();
		$nbPatientsDecedes = $Patientsdeces->nbPatientDecedes ();
		return array (
				'listePatients' => $listePatientsDecedes,
				'nbPatients' => $nbPatientsDecedes
		);
	}
	
	public function supprimerNaissanceAction() {
		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id' );
			$list = $this->getNaissanceTable ();
			$list->deleteNaissance ( $id );

			$nb = $list->nbPatientNaissance ();

			$html = "$nb au total";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($html));
		}
	}
	public function vueNaissanceAction() {
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInfoPatient ( $id );
		$photo = $patient->getPhoto ( $id );

		$date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] );

		// Informations sur la naissance
		$InfoNaiss = $this->getNaissanceTable ()->getPatientNaissance ( $id );

		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left'>";
		$html .= "<tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></td>";
		$html .= "<td></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PROFESSION'] . "</p></td>";
		$html .= "<td></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
			
		$html .= "<div id='titre_info_deces'>Informations sur la naissance</div>";
		$html .= "<div id='barre_separateur'></div>";

		$html .= "<table style='margin-top:10px; margin-left:170px;'>";
		$html .= "<tr>";
		$html .= "<td style='width:150px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Heure:</a><div id='inform' style='width:100px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss->HEURE_NAISSANCE . "</div></td>";
		$html .= "<td style='width:120px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Poids:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss->POIDS . " kg</div></td>";
		$html .= "<td style='width:120px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Taille:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss->TAILLE . " cm</div></td>";
		$html .= "<td style='width:250px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Groupe Sanguin :</a><div id='inform' style='width:100px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss->GROUPE_SANGUIN . "</div></td>";
		$html .= "<td style='width:250px'><a href='javascript:infomaman(" . $InfoNaiss->ID_MAMAN . ")' style='float:right; margin-right: 10px; font-size:27px; font-family: Edwardian Script ITC; color:green; font-weight:bold;'><img style='margin-right:5px;' src='".$chemin."/images_icons/vuemaman.png' >Info maman</a></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "<table style='margin-top:10px; margin-left:170px;'>";
		$html .= "<tr>";
		$html .= "<td style='padding-top: 10px;'><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>" . $InfoNaiss->NOTE . "</p></td>";
		$html .= "<td class='block' id='thoughtbot' style='display: inline-block;  vertical-align: bottom; padding-left:300px; padding-bottom: 15px;'><button type='submit' id='terminer'>Terminer</button></td>";
		$html .= "</tr>";
		$html .= "</table>";

		$html .= "<div style='color: white; opacity: 1; margin-top: -100px; margin-right:20px; width:95px; height:40px; float:right'>
                          <img  src='".$chemin."/images_icons/fleur1.jpg' />
                     </div>";

		$html .= "<script>listepatient();</script>";

		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent(Json::encode($html));
	}
	public function vueInfoMamanAction() {
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInfoPatient ( $id );
		$photo = $patient->getPhoto ( $id );

		$date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] );

		$html = "<div id='photo' style='float:left; margin-right:20px;' > <img  style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/" . $photo . "'></div>";

		$html .= "<table>";

		$html .= "<tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient['PROFESSION'] . "</p></td>";
		$html .= "</tr><tr>";

		$html .= "</tr>";

		$html .= "</table>";

		 $this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent(Json::encode($html));
	}
	public function modifierNaissanceAction() {
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connect�
		
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		if ($this->getRequest ()->isGet ()) {

			$id = ( int ) $this->params ()->fromQuery ( 'id', 0 ); // CODE DU BEBE

			// RECUPERONS LE CODE DE LA MAMAN
			$naiss = $this->getNaissanceTable ();
			$enreg = $naiss->getPatientNaissance ( $id );
			$id_maman = $enreg->ID_MAMAN;

			// RECUPERONS LES DONNEES DE LA MAMAN
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getInfoPatient ( $id_maman );
			$photo = $pat->getPhoto ( $id_maman );

			$date_naiss_maman = $this->convertDate ( $unPatient['DATE_NAISSANCE'] );

			// RECUPERONS LES INFOS DU BEBE
			$DonneesBebe = $pat->getInfoPatient ( $id );

			$formRow = new FormRow();
			$formSelect = new FormSelect();
			$formText = new FormText();
			$formHidden = new FormHidden();
			
			$form = new AjoutNaissanceForm ();
			// PEUPLER LE FORMULAIRE
			$donnees = array (
					'ID_PERSONNE'=>$id,
					'NOM' => $DonneesBebe['NOM'],
					'PRENOM' => $DonneesBebe['PRENOM'],
					'SEXE' => $DonneesBebe['SEXE'],
					'DATE_NAISSANCE' => $this->convertDate ( $DonneesBebe['DATE_NAISSANCE'] ),
					'HEURE_NAISSANCE' => $enreg->HEURE_NAISSANCE,
					'LIEU_NAISSANCE' => $DonneesBebe['LIEU_NAISSANCE'],
					'POIDS' => $enreg->POIDS,
					'TAILLE' => $enreg->TAILLE,
					'GROUPE_SANGUIN' => $DonneesBebe['GROUPE_SANGUIN']
			);

			$form->populateValues ( $donnees ); 
			
			$html = "<a href='' id='precedent' style='font-family: police2; width:50px; margin-left:30px; margin-top:5px;'>
	                 <img style='' src='".$chemin."/images_icons/left_16.PNG' title='Retour'>
				     Retour
		             </a>

		    <div id='info_maman'  style=''> ";
				
			$html .= "<div style='width: 18%; height: 200px; float:left;'>";
			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/" . $photo . "' ></div>";
			$html .= "</div>";
			
			$html .= "<div style='width: 65%; height: 200px; float:left;'>";
			$html .= "<table style='margin-top:10px; float:left'>";
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE']. "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date_naiss_maman . "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PROFESSION'] . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
			
			$html .= "<div style='width: 17%; height: 200px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
			
			$html .= "</div>
			
		    <div id='barre_separateur_modifier'>
		    </div>
            
			<form  method='post' action='".$chemin."/facturation/modifier-naissance'>
					
		    <div id='info_bebe' style=''>
               <div  style='float:left; margin-left:40px; margin-top:25px; margin-right:35px; width:11%; height:105px;'>
		       <img style='display: inline;' src='".$this->baseUrl()."public/images_icons/bebe.jpg' alt='Photo bebe'>
		       </div>".$formHidden($form->get( 'ID_PERSONNE' ))."
		       		
			   <div style='width: 75%; float:left;'>
		       <table id='form_patient' style='width: 100%;'>
		             <tr>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'NOM' )) . $formText($form->get ( 'NOM' )) . "</td>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'DATE_NAISSANCE' )) . $formText($form->get ( 'DATE_NAISSANCE' )) . "</td>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'POIDS' )) . $formText($form->get ( 'POIDS' )) . "</td>

		             </tr>

		             <tr>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'PRENOM' )) . $formText($form->get ( 'PRENOM')) . "</td>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'HEURE_NAISSANCE' )) . $formText($form->get ( 'HEURE_NAISSANCE')) . "</td>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'TAILLE' )) . $formText($form->get ( 'TAILLE')) . "</td>

		             </tr>

		             <tr>
		                 <td class='comment-form-patient'>" .$formRow($form->get ( 'SEXE' )) . $formSelect($form->get ( 'SEXE' )). "</td>
		                 <td class='comment-form-patient'>" .$formRow($form->get ( 'LIEU_NAISSANCE' )) . $formText($form->get ( 'LIEU_NAISSANCE' )) . "</td>
		                 <td class='comment-form-patient'>" .$formRow($form->get ( 'GROUPE_SANGUIN' )) . $formText($form->get ( 'GROUPE_SANGUIN' )) . "</td>

		             </tr>
		       </table>
		       </div>

		       <div style='width: 5%; float:left;'>
		       <div id='barre_vertical'></div>

		       <div id='menu'>
		           <div class='vider_formulaire' id='vider_champ'>
                     <hass> <input title='Vider tout' name='vider' id='vider'> </hass>
                   </div>

                   <div class='modifer_donnees' id='div_modifier_donnees'>
                     <hass> <input alt='modifer_donnees' title='modifer les donnees' name='modifer_donnees' id='modifer_donnees'></hass>
                   </div>

                   <div class='supprimer_photo' id='div_supprimer_photo'>
                     <hass> <input name='supprimer_photo'> </hass> <!-- balise sans importance pour le moment -->
                   </div>

                   <div class='ajouter_photo' id='div_ajouter_photo'>
                     <hass> <input type='submit' alt='ajouter_photo' title='Ajouter une photo' name='ajouter_photo' id='ajouter_photo'> </hass>
                   </div>
               </div>
               </div>
               
		       </div>

		        <div id='terminer_annuler' >
                    <div class='block' id='thoughtbot'>
                       <button type='submit' style='height:35px; margin-right:10px;'>Terminer</button>
                    </div>

                    <div class='block' id='thoughtbot'>
                       <button id='annuler_modif' style='height:35px;'>Annuler</button>
                    </div>
                </div>
			   </form>";
			
			$this->getResponse ()->getHeaders ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($html));
		} else if ($this->getRequest ()->isPost ()) {

			$today = new \DateTime ();
			$dateModification = $today->format( 'Y-m-d h:i:s' );
			
			$modif_naiss = $this->getNaissanceTable ();
			$modif_pat = $this->getPatientTable ();

			$id_bebe = ( int ) $this->params ()->fromPost ( 'ID_PERSONNE' );
			
			$donnees = array(
					'NOM'             => $this->params ()->fromPost ( 'NOM' ),
					'PRENOM'          => $this->params ()->fromPost ( 'PRENOM' ),
					'DATE_NAISSANCE'  => $this->convertDateInAnglais($this->params ()->fromPost ( 'DATE_NAISSANCE' )),
					'LIEU_NAISSANCE'  => $this->params ()->fromPost ( 'LIEU_NAISSANCE' ),
					'GROUPE_SANGUIN'  => $this->params ()->fromPost ( 'GROUPE_SANGUIN' ),
					'SEXE'            => $this->params ()->fromPost ( 'SEXE' ),
					'TAILLE'          => $this->params ()->fromPost ( 'TAILLE' ),
					'POIDS'           => $this->params ()->fromPost ( 'POIDS' ),
			);
			
			$modif_pat->updatePatient($donnees, $id_bebe, $dateModification, $id_employe);
			
			$donneesNaissance = array (
					'TAILLE' => $donnees['TAILLE'],
					'POIDS' => $donnees['POIDS'],
					'DATE_NAISSANCE' => $donnees['DATE_NAISSANCE'],
					'HEURE_NAISSANCE' => $this->params ()->fromPost ( 'HEURE_NAISSANCE' ),
					'DATE_MODIFICATION'  => $dateModification,
					'ID_EMPLOYE' => $id_employe,
			);
			$modif_naiss->updateBebe($donneesNaissance, $id_bebe);

			return $this->redirect ()->toRoute ( 'facturation', array (
					'action' => 'liste-naissance'
			) );
		}
	}
	public function convertDateInAnglais($date) {
		$nouv_date = substr ( $date, 6, 4 ) . '-' . substr ( $date, 3, 2 ) . '-' . substr ( $date, 0, 2 );
		return $nouv_date;
	}
	public function infoPatientAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
		
		$id_pat = $this->params ()->fromRoute ( 'val', 0 );
		
		$patient = $this->getPatientTable ();
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
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$id_patient = $this->params ()->fromRoute ( 'val', 0 );
	
		$infoPatient = $this->getPatientTable ();
		try {
			$info = $infoPatient->getInfoPatient( $id_patient );
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'facturation', array (
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
	
	public function supprimerDecesAction(){
		if ($this->getRequest()->isPost()){
			$id = (int)$this->params()->fromPost ('id');
			$list = $this->getDecesTable();
			$list->deletePatient($id);

			$nb = $list->nbPatientDecedes();

			$html ="$nb au total";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($html));
		}
	}
	public function vuePatientDecedeAction(){

		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id = (int)$this->params()->fromPost ('id');

		$infoPatient = $this->getPatientTable()->getInfoPatient($id);
		$photo = $this->getPatientTable()->getPhoto($id);

		$date = $this->convertDate($infoPatient['DATE_NAISSANCE']);

		//Informations sur le deces
		$InfoDeces = $this->getDecesTable()->getPatientDecede($id);

		$html ="<div id='photo' style='float:left; margin-left:20px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/".$photo."' ></div>";

		$html .="<table style='margin-top:10px; float:left'>";

		$html .="<tr>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>".$infoPatient['NOM']."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient['LIEU_NAISSANCE']."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>".$infoPatient['NATIONALITE_ORIGINE']."</p></td>";
		$html .="</tr><tr>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient['PRENOM']."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient['TELEPHONE']."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient['NATIONALITE_ACTUELLE']."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>".$infoPatient['EMAIL']."</p></td>";
		$html .="</tr><tr>";
		$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:13px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>".$date."</p></td>";
		$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:13px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>".$infoPatient['ADRESSE']."</p></td>";
		$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:13px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient['PROFESSION']."</p></td>";
		$html .="</tr>";

		$html .="</table>";

		$html .="<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/".$photo."'></div>";
		$html .="<div id='titre_info_deces'>Informations sur le d&eacute;c&egrave;s</div>";
		$html .="<div id='barre_separateur'></div>";

		$html .="<table style='margin-top:10px; margin-left:170px;'>";
		$html .="<tr>";
		$html .="<td style='width:150px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date:</a><div id='inform' style='width:100px; float:left; font-weight:bold; font-size:17px;'>".$this->convertDate($InfoDeces->date_deces)."</div></td>";
		$html .="<td style='width:120px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Heure:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>".$InfoDeces->heure_deces."</div></td>";
		$html .="<td style='width:100px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Age:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>".$InfoDeces->age_deces." ans</div></td>";
		$html .="<td style='width:350px;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Lieu:</a><div id='inform' style='width:300px; float:left; font-weight:bold; font-size:17px;'>".$InfoDeces->lieu_deces."</div></td>";
		$html .="</tr>";
		$html .="</table>";
		$html .="<table style='margin-top:10px; margin-left:170px;'>";
		$html .="<tr>";
		$html .="<td style='padding-top: 10px;'><a style='text-decoration:underline; font-size:13px;'>Circonstances:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$InfoDeces->circonstances_deces."</p></td>";
		$html .="<td style='padding-top: 10px; padding-left: 20px;'><a style='text-decoration:underline; font-size:13px;'>Note importante:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$InfoDeces->note."</p></td>";
		$html .="<td class='block' id='thoughtbot' style='display: inline-block;  vertical-align: bottom; padding-left:100px; padding-bottom: 15px;'><button type='submit' id='terminer'>Terminer</button></td>";
		$html .="</tr>";
		$html .="</table>";

		$html .="<div style='color: white; opacity: 1; margin-top: -100px; margin-right:20px; width:95px; height:40px; float:right'>
                          <img  src='".$chemin."/images_icons/fleur1.jpg' />
                     </div>";

		$html .="<script>listepatient();</script>";

		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($html));

	}
	public function modifierDecesAction(){
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		if ($this->getRequest()->isGet()){

			$id = (int)$this->params()->fromQuery ('id'); //CODE DU DECES

			//RECUPERONS LE CODE DU PATIENT et l'enregistrement sur le deces
			$deces = $this->getDecesTable();
			$enregDeces = $deces->getLePatientDecede($id);
			$id_patient = $enregDeces->id_patient;

			//RECUPERONS LES DONNEES DU PATIENT
			$list = $this->getPatientTable();
			$unPatient = $list->getInfoPatient($id_patient);
			$photo = $list->getPhoto($id_patient);

			$date = $this->convertDate($unPatient['DATE_NAISSANCE']);
			
			$formRow = new FormRow();
			$formText = new FormText();
			$formTextarea = new FormTextarea();
			$formHidden = new FormHidden();
			
			$form = new AjoutDecesForm();
			//PEUPLER LE FORMULAIRE
			$donnees = array(
					'id_deces' => $id,
					'date_deces'   =>$this->convertDate($enregDeces->date_deces),
					'heure_deces'  =>$enregDeces->heure_deces,
					'age_deces'    =>$enregDeces->age_deces.' ans',
					'lieu_deces'   =>$enregDeces->lieu_deces,
					'circonstances_deces' =>$enregDeces->circonstances_deces,
					'note'  =>$enregDeces->note,
			);

			$form->populateValues($donnees);


			$html ="<a id='precedent' style='cursor: pointer; text-decoration: none; font-family: police2; width:50px; margin-left:30px;'>
					 <img style='display: inline;' src='".$chemin."/images_icons/left_16.png' />
		             Retour
		           </a>";

			$html .="<div id='info_patient' style='width:100%;'>";
			
			$html .= "<div style='width: 18%; height: 180px; float:left;'>";
			$html .="<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/".$photo."' ></div>";
			$html .= "</div>";
			
			$html .= "<div style='width: 65%; height: 180px; float:left;'>";
			$html .="<table style='margin-top:10px; float:left'>";
			$html .="<tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>".$unPatient['NOM']."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient['LIEU_NAISSANCE']."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>".$unPatient['NATIONALITE_ORIGINE']."</p></td>";
			$html .="</tr><tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient['PRENOM']."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient['TELEPHONE']."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient['NATIONALITE_ACTUELLE']."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>".$unPatient['EMAIL']."</p></td>";
			$html .="</tr><tr>";
			$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>".$date."</p></td>";
			$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>".$unPatient['ADRESSE']."</p></td>";
			$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient['PROFESSION']."</p></td>";
			$html .="</tr>";
			$html .="</table>";
			$html .="</div>";

			$html .= "<div style='width: 17%; height: 180px; float:left;'>";
			$html .="<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/".$photo."'></div>";
			$html .="</div>";
			
			$html .="</div>

		            <div id='titre_info_deces_modif'>Informations sur le d&eacute;c&egrave;s</div>
		            <div id='barre_separateur_modif'></div>";

			$html .="<form  method='post' action='".$chemin."/facturation/modifier-deces'>";
		    $html .="<div id='info_bebe' style='width: 100%; margin-top:0px;'>
                         <div style='float:left; width:18%; height:105px;'>
		                 </div>";
			
            $html .="<div style='width: 77%; float:left;'>";
			$html .="<table id='form_patient' style='float:left; margin-top:15px;'>
		               <tr>".$formHidden($form->get('id_deces')) ."
		                   <td style='width: 33%;' class='comment-form-patient'>".$formRow($form->get('date_deces')) . $formText($form->get('date_deces')) ."</td>
		                   <td style='width: 33%;' class='comment-form-patient'>".$formRow($form->get('heure_deces')) . $formText($form->get('heure_deces')) ."</td>
		                   <td style='width: 33%;' class='comment-form-patient'>".$formRow($form->get('age_deces')) . $formText($form->get('age_deces'))."</td>
     		           </tr>

		               <tr>
		                   <td class='comment-form-patient' style='display: inline-block; vertical-align: top;'>".$formRow($form->get('lieu_deces')) . $formText($form->get('lieu_deces')) ."</td>
		                   <td class='comment-form-patient'>".$formRow($form->get('circonstances_deces')) . $formTextarea($form->get('circonstances_deces')) ."</td>
		                   <td class='comment-form-patient'>".$formRow($form->get('note')) . $formTextarea($form->get('note'))."</td>
		               </tr>
		            </table>";
            $html .="</div>";
            
            //Rendre non modifiable la date du deces
            //Rendre non modifiable la date du deces
            $html .="<script> 
            		   $('#age_deces').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					   $('#age_deces').attr('readonly',true);
            		 </script>";
            
            
            $html .="<div style='float:left; width:5%;'>";
			$html .="<div id='barre_vertical'></div>
		             <div id='menu'>
		    		      <div class='vider_formulaire' id='vider_champ'>
                               <input title='Vider tout' name='vider' id='vider'>
                          </div>

                          <div class='modifer_donnees' id='div_modifier_donnees'>
                               <input alt='modifer_donnees' title='modifer les donnees' name='modifer_donnees' id='modifer_donnees'>
                          </div>

                          <div class='supprimer_photo' id='div_supprimer_photo'>
                               <input name='supprimer_photo'> <!-- balise sans importance pour le moment -->
                          </div>

                          <div class='ajouter_photo' id='div_ajouter_photo'>
                               <input type='submit' alt='ajouter_photo' title='Ajouter une photo' name='ajouter_photo' id='ajouter_photo'>
                          </div>
                     </div>
				 	 </div>
					 </div>";
			
            $html .="<div style='width:100%;'>
                      <div id='terminer_annuler'>
                          <div class='block' id='thoughtbot'>
                               <button type='submit' id='terminer_modif_dece' style='height:35px;'>Terminer</button>
                          </div>

                          <div class='block' id='thoughtbot'>
                               <button id='annuler_modif_deces' style='height:35px;'>Annuler</button>
                          </div>
                     </div>
		             </div>
            		</form>";
            
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($html));
		}
		else if ($this->getRequest()->isPost()){
			$user = $this->layout()->user;
			$id_employe = $user['id_personne']; //L'utilisateur connect�
			
			$today = new \DateTime ();
			$dateModification = $today->format( 'Y-m-d H:i:s' );
			
			$id_deces = (int)$this->params()->fromPost ('id_deces'); 
			$deces = $this->getDecesTable();

			$donnees = array(
					'date_deces' => $this->convertDateInAnglais($this->params()->fromPost('date_deces')),
					'heure_deces' => $this->params()->fromPost('heure_deces'),
					'age_deces' => $this->params()->fromPost('age_deces'),
					'lieu_deces' => $this->params()->fromPost('lieu_deces'),
					'circonstances_deces' =>$this->params()->fromPost('circonstances_deces'),
					'date_modification' => $dateModification,
					'note' => $this->params()->fromPost('note'),
					'id_employe' => $id_employe
			);
			
			$deces->updateDeces($donnees, $id_deces);

			return $this->redirect()->toRoute('facturation' , array(
					'action'=>'liste-patients-decedes') );
		}
	}
	
	public function supprimerAdmissionAction(){
		if ($this->getRequest()->isPost()){
			$id = (int)$this->params()->fromPost ('id');
			$idPatient = (int)$this->params()->fromPost ('idPatient');
			$idService = (int)$this->params()->fromPost ('idService');
			$resultat = $this->getAdmissionTable()->deleteAdmissionPatient($id, $idPatient, $idService);

			//$nb = $this->getAdmissionTable()->nbAdmission();
			//$html ="$nb au total";
			
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($resultat));
		}
	}
	
	public function vuePatientAdmisAction(){
		$this->getDateHelper();
		
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
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
		
		$date = $unPatient['DATE_NAISSANCE'];
		if($date){ $date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}

		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
		$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 70%; height: 180px; float:left;'>";
		$html .= "<table id='vuePatientAdmission' style='margin-top:10px; float:left'>";

		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></div></td>";
		$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
		$html .= "<td style='width: 29%; '></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
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
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:0px; margin-left:0px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		$html .="<div id='titre_info_admis'>Informations sur la facturation <img id='button_pdf' style='width:15px; height:15px; float: right; margin-right: 35px; cursor: pointer;' src='".$this->baseUrl()."public/images_icons/button_pdf.png' title='Imprimer la facture' ></div>";
		$html .="<div id='barre_separateur'></div>";

		$html .="<table style='margin-top:10px; margin-left:18%; width: 80%; margin-bottom: 60px;'>";

		$html .="<tr style='width: 80%; '>";
 		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Date d'admission </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $this->dateHelper->convertDateTime($InfoAdmis->date_enregistrement) ." </p></td>";
 		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Num&eacute;ro facture </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoAdmis->numero ." </p></td>";
 		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Service </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-size:15px;'> ". $InfoService->nom ." </p></td>";
 		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Tarif (frs) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-weight:bold; font-size:22px;'> ". $this->prixMill($InfoAdmis->montant)." </p></td>";
		$html .="</tr>";
		
		if($InfoAdmis->id_type_facturation == 2){
			$html .="<tr style='width: 80%; '>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Prise en charge par </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoAdmis->organisme ." </p></td>";
			if($InfoAdmis->taux_majoration){
				$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Taux (%) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-weight:bold; font-size:22px;'> ". $InfoAdmis->taux_majoration ." </p></td>";
			}else {
				$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Taux (%) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-weight:bold; font-size:22px;'> 0 </p></td>";
			}
			$majoration = ($InfoAdmis->montant * $InfoAdmis->taux_majoration)/100;
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Majoration (frs) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-weight:bold; font-size:22px;'> ". $this->prixMill("$majoration") ." </p></td>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Tarif major&eacute; (frs) </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-size:15px; font-weight:bold; font-size:22px;'> ". $this->prixMill( $InfoAdmis->montant_avec_majoration ) ."  </p></td>";
			$html .="</tr>";
		}
		
		

		$html .="</table>";
		$html .="<table style='margin-top:10px; margin-left:18%; width: 80%;'>";
		$html .="<tr style='width: 80%;'>";
		
		$html .="<td class='block' id='thoughtbot' style='width: 35%; display: inline-block;  vertical-align: bottom; padding-left:350px; padding-bottom: 15px; padding-right: 150px;'><button type='submit' id='terminer'>Terminer</button></td>";

		$html .="</tr>";
		$html .="</table>";

		$html .="<div style='color: white; opacity: 1; margin-top: -100px; margin-right:20px; width:95px; height:40px; float:right'>
                          <img  src='".$chemin."/images_icons/fleur1.jpg' />
                     </div>";

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
	
	public function impressionFactureAction(){
		$idAdmission = (int)$this->params()->fromPost ('idAdmission');

		//Informations sur l'admission
		$InfoAdmis = $this->getAdmissionTable()->getPatientAdmis($idAdmission);

		
		if($InfoAdmis){
			$id_patient = $InfoAdmis->id_patient;
			
			$user = $this->layout()->user;
			$service = $user['NomService'];
			//******************************************************
			//******************************************************
			//*********** DONNEES COMMUNES A TOUS LES PDF **********
			//******************************************************
			//******************************************************
			$lePatient = $this->getPatientTable()->getInfoPatient( $id_patient );
			
			$infos = array(
					'numero' => $InfoAdmis->numero,
 					'service' => $this->getPatientTable()->getServiceParId( $InfoAdmis->id_service )['NOM'],
 					'montant' => $InfoAdmis->montant,
					'montant_avec_majoration' => $InfoAdmis->montant_avec_majoration,
  					'type_facturation' => $InfoAdmis->id_type_facturation,
 					'organisme' => $InfoAdmis->organisme,
 					'taux' => $InfoAdmis->taux_majoration,
			);
				
			//******************************************************
			//******************************************************
			//*************** Cr�ation du fichier pdf **************
			//******************************************************
			//******************************************************
			//Cr�er le document
			$DocPdf = new DocumentPdf();
			//Cr�er la page
			$page = new FacturePdf();
			
			//Envoyer les donn�es sur le partient
			$page->setDonneesPatient($lePatient);
			$page->setService($service);
			$page->setInformations($infos);
			//Ajouter une note � la page
			$page->addNote();
			//Ajouter la page au document
			$DocPdf->addPage($page->getPage());
			//Afficher le document contenant la page
			
			$DocPdf->getDocument();
			
		} else {
			var_dump('c bon'); exit();
		}
		
	}
	
	public function listeActesAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/facturation' );

// 		$patient = $this->getPatientTable ();
// 		$output = $patient->verifierActesPayesEnTotalite("s-c-140516-120202");
// 		var_dump($output); exit();
		
		$numero = $this->numeroFacture();
		// INSTANCIATION DU FORMULAIRE d'ADMISSION
		$formAdmission = new AdmissionForm ();
		
		$service = $this->getTarifConsultationTable()->listeService();
		
		$listeService = $this->getServiceTable ()->listeService ();
		$afficheTous = array ("" => 'Tous');
		
		$tab_service = array_merge ( $afficheTous, $listeService );
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$formAdmission->get ( 'liste_service' )->setValueOptions ( $tab_service );
		
		return array (
				'form' => $formAdmission
		);
	}
	
	
	public function vuePatientAction($idPatient) {
		
		$unPatient = $this->getPatientTable()->getInfoPatient($idPatient);
		$photo = $this->getPatientTable()->getPhoto($idPatient);
		
		$date = $unPatient['DATE_NAISSANCE'];
		if($date){ $date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 200px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
		$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 70%; height: 200px; float:left;'>";
		$html .= "<table id='vuePatientAdmission' style='margin-top:10px; float:left'>";
		
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 150; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></div></td>";
		$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
		$html .= "<td style='width: 29%; '></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></div></td>";
		$html .= "<td></td>";
		
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 12%; height: 200px; float:left; '>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:0px; margin-left:0px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		return $html;
	}
	
	public function listeActesImpayesAction() {
		$this->getDateHelper();
		$idPatient = (int)$this->params()->fromPost ('id');
		$idDemande = (int)$this->params()->fromPost ('idDemande');
		$type = (int)$this->params()->fromPost ('type');
		
		//MISE A JOUR DE L'AGE DU PATIENT
		//MISE A JOUR DE L'AGE DU PATIENT
		//MISE A JOUR DE L'AGE DU PATIENT
		$personne = $this->getPatientTable()->miseAJourAgePatient($idPatient);
		//*******************************
		//*******************************
		//*******************************
		
		$html = $this->getListeDesActesDuPatient($idPatient, $idDemande, $type);
	    
	    
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($html));
	}
	
	public function getListeDesActesDuPatient($idPatient, $idDemande, $type){

		$this->getDateHelper();
		
		$listeDemande = $this->getDemandeActe()->getLaListeDesDemandesActesDuPatient($idDemande);
		$listeDemande2 = $this->getDemandeActe()->getLaListeDesDemandesActesDuPatient($idDemande);
		
		
		$unActePaye = $this->getDemandeActe()->getUnActePaye($idDemande);
		
		$montantTotaleActes = $this->getDemandeActe()->getMontantTotalActes($idDemande);
		$sommeActesImpayes = $this->getDemandeActe()->getSommeActesImpayes($idDemande);
		$sommeActesPayes = $this->getDemandeActe()->getSommeActesPayes($idDemande);
		
		
		$html = $this->vuePatientAction($idPatient);
		
		$html .="<div id='titre_info_acte'>Liste des actes <div style='float:right; margin-right:25px; font-size:14px;'> Date de la demande : ". $this->dateHelper->convertDateTime( $listeDemande2->current()['dateDemande'] ) ."</div></div>
				  <div id='barre_separateur'>
				  </div>
		
				  <div id='info_bebe' style='width: 100%; margin-top:0px; max-height:345px;'>
		               <div style='float:left; width:18%; height:5%;'>
				       </div>
				       <div id='listeDesActes' style='width: 80%; float:left;'>";
		
		$html .="<div style='width: 700px; height: 20px; float:right;'>";
		  
		  $html .="<div style='width: 90%; height: 20px; float:left;'>";
		     $html .="<div style='margin-right: 20px; float:right; font-size: 15px; margin-top:5px; font-family: Times New Roman; font-size: 15px; color: green;'>"; 

		     if($type == 1){
		     	$html .=" <i id='afficherMontantTotal'> Montant total :  </i><a style='text-decoration: none; font-family: Iskoola Pota; color: green; font-size: 17px;font-weight: bold;' > ".$this->prixMill("$montantTotaleActes")." frs </a>
		     		    <span style='font-weight: bold; font-size: 22px;'> | </span>
		     		    <i style='cursor:pointer;' id='afficherMontantImpayer'> Total impay&eacute;: </i> <a style='text-decoration: none; font-family: Iskoola Pota; color: green; font-size: 17px;font-weight: bold;' > ".$this->prixMill("$sommeActesImpayes")." frs</a>
		     		    <span style='font-weight: bold; font-size: 22px;'> | </span>";
		     }
		     		    
		     $html .=" <i style='cursor:pointer;' id='afficherMontantPayer'>    Total pay&eacute;:  </i> <a style='text-decoration: none; font-family: Iskoola Pota; color: green; font-size: 17px;font-weight: bold;' > ".$this->prixMill("$sommeActesPayes")."   frs</a> 
		     		  </div>";
		     
		  $html .="</div>";
		  
		  $html .="<div style='width: 10%; height: 20px; float:left;'>";
		     if($unActePaye == 1){ $html .="<div style='margin-right: 10px; float:right; font-size: 15px; margin-top:5px; font-family: Times New Roman; font-size: 15px; color: green;'> <a href='javascript:imprimerFactureActe(".$idDemande.")'> <img style='width: 22px; height: 22px; cursor: pointer;' src='/simens/public/images_icons/pdf.png' title='Facture' /> </a> </div>"; }
		  $html .="</div>";

		$html .="</div>";
		
		
		//TABLEAU DES ACTES ------ TABLEAU DES ACTES ------ TABLEAU DES ACTES ----- TABLEAU DES ACTES
		$html .='<table class="table table-bordered tab_list_mini"  style="margin-left: 0px; margin-top: 0px; margin-bottom: 5px; width:100%;" id="listeDesActesImpayesVue"> ';
		//EN TETE ---- EN TETE ---- EN TETE
		$html .='<thead style="width: 100%;">
		             <tr style="height:40px; width:100%; cursor:pointer;">
		               <th style="width: 40%;">Acte</th>
		               <th style="width: 20%;">Tarif (FRS) </th>
		               <th style="width: 28%;">R&egrave;glement</th>
		               <th style="width: 12%;">Options</th>
		             </tr>
				 </thead>';
		
		//COPRS ---- COPRS ---- COPRS ----
		$html .='<tbody id="listeActeStyle" style="width: 100%;">';
		
		foreach ($listeDemande as $liste){
			$html .='<tr>';
				
			$html .='<td style="width: 40%;">'.$liste['designation'].'</td>';
			$html .='<td class="tarifMill" style="width: 20%;">'.$this->prixMill($liste['tarif']).'</td>';
				
			if($liste['reglement'] == 1){
				$html .='<td class="dateStyle" style="width: 28%; color: green;">r&eacute;gl&eacute; le : '.$this->dateHelper->convertDateTime($liste['dateReglement']).'</td>';
				$html .='<td style="width: 12%; padding-left: 15px;"><a><img src="/simens/public/images_icons/tick_16.png" /></a></td>';
			}else {
				$html .='<td class="dateStyl" style="width: 28%; color: red; font-style: italic;">pas encore r&eacute;gl&eacute;</td>';
				$html .='<td style="width: 12%; padding-left: 15px;"><a href="javascript:reglement('.$liste['idDemande'].','.$idPatient.')" ><img id="regler_'.$liste['idDemande'].'"  src="/simens/public/images_icons/paiement-16.png" /></a></td>';
			}
				
			$html .='</tr>';
		}
		
		$html .='</tbody>';
		
		
		$html .='</table> ';
		
		 
		$html .="      </div>
	    		       <div style='float:left; width:2%;'></div>";
		
		 
		$html .='<table style="width: 100%; height: 50px; padding-top: -100px;">
                    <tr style="width: 100%; line-height: 50px;">
		
	    		       <td style="width: 50%; height: 10px;">
	    		       </td>
		
	    		       <td style="width: 10%; height: 10px; padding-bottom: 20px;">
	   
	    		           <div class="block terminerpaiement" id="thoughtbot">
                              <button id="terminerpaiement" style=" height:35px; ">Terminer</button>
                           </div>
		
	    		       </td>
	   
	    		       <td style="width: 40%; height: 10px;">
	    		       </td>
		
	    		    </tr>
	    		  </table>';
		 
		 
		$html .="</div>";
		
		
		$html .="<script>
	    		  listeDesActes();
	    		  $('#terminerpaiement').click(function(){
				    
				    if(".$type." == 1){
				    	if(".$unActePaye." == 1){ imprimerFactureActe(".$idDemande."); } 
				        setTimeout(function() { $(location).attr('href','/simens/public/facturation/liste-actes'); },500);
				    } else if (".$type." == 2){
				    		
				    		  $('#paiement_des_actes').fadeOut(function(){
				    		     $('#titre2').replaceWith('<div id=\'titre\' style=\'font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 35px;\'><iS style=\'font-size: 25px;\'>&curren;</iS> LISTE DES ACTES <span>PAYES</span> PAR PATIENT </div>');	
				    		     $('#LesDeuxListes').toggle(true);
				    		  });
				    		
				    	   }
				    		
	              });
	    		 
				  $('img').tooltip({
                   animation: true,
                   html: true,
                   placement: 'bottom',
                   show: {
                    effect: 'slideDown',
                    delay: 250
                   }
                  });
				
				</script>";
		 
		$html .="<style>
				  #listeDesActesImpayesVue tbody tr{
				    background: #fbfbfb;
				  }
		
				  #listeDesActesImpayesVue tbody tr:hover{
				    background: #fefefe;
				  }
	    		 </style>";
		 
		return $html;
	}
	
	public function actePayeAction() {
		
		$user = $this->layout()->user;
		$id_employe = $user[ 'id_personne' ];
		
		$today = new \DateTime( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
		
		$idPatient = (int)$this->params()->fromPost ( 'idPatient' );
		$idDemande = (int)$this->params()->fromPost ( 'idDemande' );
		
		$this->getDemandeActe()->addPaiement($id_employe, $date, $idDemande);
		
		$html = $this->getListeDesActesDuPatient($idPatient, $idDemande);
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode( $html ));
		
	}
	
	public function impressionFactureActeAction(){
		$idDemande = (int)$this->params()->fromPost ('idDemande');
		
		if($idDemande){
			
			$infosPatient = $this->getDemandeActe()->getInfoPatientPayantActe($idDemande);
			$listeDesActesPayes = $this->getDemandeActe()->getLaListeActesPayesParLePatient($idDemande);
			$montantTotalDesActesPayes = $this->getDemandeActe()->getmontantTotalActesPayesParLePatient($idDemande);
			
			$id_patient = $infosPatient['ID_PATIENT'];
			
			$user = $this->layout()->user;
			$service = $user['NomService'];
			//******************************************************
			//******************************************************
			//*********** DONNEES COMMUNES A TOUS LES PDF **********
			//******************************************************
			//******************************************************
			$lePatient = $this->getPatientTable()->getInfoPatient( $id_patient );
				
			//******************************************************
			//******************************************************
			//*************** Cr�ation du fichier pdf **************
			//******************************************************
			//******************************************************
			//Cr�er le document
			$DocPdf = new DocumentPdf();
			//Cr�er la page
			$page = new FactureActePdf();
				
			//Envoyer les donn�es sur le partient
			$page->setDonneesPatient($lePatient);
			$page->setService($service);
			$page->setInformations($listeDesActesPayes);
			$page->setMontantTotal($this->prixMill("$montantTotalDesActesPayes"));
			//Ajouter une note � la page
			$page->addNote();
			//Ajouter la page au document
			$DocPdf->addPage($page->getPage());
			//Afficher le document contenant la page
				
			$DocPdf->getDocument();
				
		} else {
			var_dump('Rien a imprimer'); exit();
		}
		
		
	}
	
	
	public function informationsStatistiquesAction() {

		$this->layout ()->setTemplate ( 'layout/facturation' );
		$patientTable = $this->getPatientTable();
		$infos = $this->getConsultationTable()->getInfosSousDossier();
		//var_dump($infos);exit();
		
		return new ViewModel ( array (
				'infos' => $infos
		) );
	

	}	
	
	
	public function informationsComplementairesAjaxAction() {
		$output = $this->getPatientTable ()->getListePatientNouvelle ();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	
	
	public function informationsComplementairesAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/facturation' );
		$view = new ViewModel ();
		return $view;
	}	
	
	
	
}
