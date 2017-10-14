<?php

namespace Orl;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Orl\Model\PatientTable;
use Orl\Model\Patient;
use Orl\Model\Consultation;
use Orl\Model\ConsultationTable;
use Zend\Db\TableGateway\TableGateway;
use Orl\Model\DemandeTable;
use Orl\Model\Demande;
use Orl\Model\MotifAdmissionTable;
use Orl\Model\MotifAdmission;
use Orl\Model\RvPatientConsTable;
use Orl\Model\RvPatientCons;
use Orl\Model\TransfererPatientServiceTable;
use Orl\Model\TransfererPatientService;
use Orl\Model\DonneesExamensPhysiquesTable;
use Orl\Model\DonneesExamensPhysiques;
use Orl\Model\DonneesExamenCliniqueTable;
use Orl\Model\DonneesExamenClinique;
use Orl\Model\DiagnosticsTable;
use Orl\Model\Diagnostics;
use Orl\Model\OrdonnanceTable;
use Orl\Model\Ordonnance;
use Orl\Model\DemandeVisitePreanesthesiqueTable;
use Orl\Model\DemandeVisitePreanesthesique;
use Orl\Model\NotesExamensMorphologiquesTable;
use Orl\Model\NotesExamensMorphologiques;
use Orl\Model\NotesExamensBiologiquesTable;
use Orl\Model\NotesExamensBiologiques;
use Orl\Model\OrdonConsommableTable;
use Orl\Model\OrdonConsommable;
use Orl\Model\AntecedentPersonnelTable;
use Orl\Model\AntecedentPersonnel;
use Orl\Model\AntecedentsFamiliauxTable;
use Orl\Model\AntecedentsFamiliaux;
use Orl\Model\DemandehospitalisationTable;
use Orl\Model\Demandehospitalisation;
use Orl\Model\SoinhospitalisationTable;
use Orl\Model\Soinhospitalisation;
use Orl\Model\SoinsTable;
use Orl\Model\Soins;
use Orl\Model\HospitalisationTable;
use Orl\Model\Hospitalisation;
use Orl\Model\HospitalisationlitTable;
use Orl\Model\Hospitalisationlit;
use Orl\Model\LitTable;
use Orl\Model\SalleTable;
use Orl\Model\Lit;
use Orl\Model\Salle;
use Orl\Model\BatimentTable;
use Orl\Model\Batiment;
use Orl\Model\ResultatVisitePreanesthesiqueTable;
use Orl\Model\DemandeActeTable;
use Orl\Model\DemandeActe;
use Orl\Model\AntecedentOrlTable;
use Orl\Model\AntecedentOrl;
use Orl\Model\MotifHospitalisationOrlTable;
use Orl\Model\MotifHospitalisationOrl;
use Orl\Model\HistoireMaladieTable;
use Orl\Model\HistoireMaladie;
use Orl\Model\ExamensComplementairesOrlTable;
use Orl\Model\ExamensComplementairesOrl;
use Orl\Model\PeauCervicauFacialeOrlTable;
use Orl\Model\PeauCervicauFacialeOrl;
use Orl\Model\TyroideTable;
use Orl\Model\Tyroide;
use Orl\Model\HormonesTyroidiennesOrlTable;
use Orl\Model\HormonesTyroidiennesOrl;
use Orl\Model\SousDossierTable;
use Orl\Model\SousDossier;
use Orl\Model\IndicationsOperatoireOrlTable;
use Orl\Model\IndicationsOperatoireOrl;
use Orl\Model\CompteRenduOperatoireOrlTable;
use Orl\Model\CompteRenduOperatoireOrl;
use Orl\Model\PeriodePostOperatoirePrecoceTable;
use Orl\Model\PeriodePostOperatoirePrecoce;
use Orl\Model\HistologieTable;
use Orl\Model\Histologie;
use Orl\Model\SurveillanceTardiveTable;
use Orl\Model\SurveillanceTardive;
use Orl\Model\GroupesGanglionnairesTable;
use Orl\Model\GroupesGanglionnaires;
use Orl\Model\IncidentAccidentPerOperatoireOrlTable;
use Orl\Model\IncidentAccidentPerOperatoireOrl;
use Orl\Model\ResultatVisitePreanesthesique;
use Orl\Model\TarifConsultationTable;
use Orl\Model\TarifConsultation;
use Orl\Model\Admission;
use Orl\Model\AdmissionTable;
use Orl\Model\ServiceTable;
use Orl\Model\Service;
use Orl\Model\TypeAdmissionTable;
use Orl\Model\TypeAdmission;


class Module implements AutoloaderProviderInterface {
	
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
						)
				)
		);
	}
	
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getServiceConfig() {
		return array (
				
				
				
				'factories' => array (
						'Orl\Model\PatientTable' => function ($sm) {
							$tableGateway = $sm->get ( 'PatientTable1Gateway' );
							$table = new PatientTable ( $tableGateway );
							return $table;
						},'PatientTable1Gateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Patient () );
							return new TableGateway ( 'patient', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Orl\Model\ConsultationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ConsultationTableConsGateway' );
							$table = new ConsultationTable ( $tableGateway );
							return $table;
						},
						'Orl\Model\AdmissionTable' => function ($sm) {
							$tableGateway = $sm->get( 'AdmissionTableGateway' );
							$table = new AdmissionTable( $tableGateway );
							return $table;
						},
						'ConsultationTableConsGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new Consultation());
							return new TableGateway ( 'consultation', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\TarifConsultationTable' => function ($sm) {
							$tableGateway = $sm->get( 'TarifConsultationTableGateway' );
							$table = new TarifConsultationTable( $tableGateway );
							return $table;
						},
						'TarifConsultationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype (new TarifConsultation());
							return new TableGateway ( 'tarif_consultation', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\ServiceTable' => function ($sm) {
							$tableGateway = $sm->get('ServiceTableFactGateway');
							$table = new ServiceTable($tableGateway);
							return $table;
						},
						
						'Orl\Model\TypeAdmissionTable' => function ($sm){
							$tablegateway = $sm->get('TypeAdmissionTableGateway');
							$table = new TypeAdmissionTable($tablegateway);
							return $table;
						},
						'TypeAdmissionTableGateway' =>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new TypeAdmission());
							return  new TableGateway('type_admission',$dbAdapter,null,$resultSetPrototype);
						},
						
						
						'Orl\Model\DemandeTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandeTableGateway' );
							$table = new DemandeTable($tableGateway);
							return $table;
						},
						'DemandeTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new Demande());
							return new TableGateway ( 'demande', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\MotifAdmissionTable' => function ($sm) {
							$tableGateway = $sm->get ( 'MotifAdmissionTableGateway' );
							$table = new MotifAdmissionTable($tableGateway);
							return $table;
						},
						'MotifAdmissionTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new MotifAdmission());
							return new TableGateway ( 'motif_admission', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\RvPatientConsTable' => function ($sm) {
							$tableGateway = $sm->get ( 'RvPatientConsTableGateway' );
							$table = new RvPatientConsTable( $tableGateway );
							return $table;
						},
						'RvPatientConsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new RvPatientCons());
							return new TableGateway ( 'rendezvous_Consultation', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\TransfererPatientServiceTable' => function ($sm) {
							$tableGateway = $sm->get ( 'TransfererPatientServiceTableGateway' );
							$table = new TransfererPatientServiceTable($tableGateway);
							return $table;
						},
						'TransfererPatientServiceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new TransfererPatientService());
							return new TableGateway ( 'transferer_patient_service', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\DonneesExamensPhysiquesTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DonneesExamensPhysiquesTableGateway' );
							$table = new DonneesExamensPhysiquesTable($tableGateway);
							return $table;
						},
						'DonneesExamensPhysiquesTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new DonneesExamensPhysiques());
							return new TableGateway ( 'Donnees_examen_physique', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\DonneesExamenCliniqueTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DonneesExamenCliniqueTableGateway' );
							$table = new DonneesExamenCliniqueTable($tableGateway);
							return $table;
						},
						'DonneesExamenCliniqueTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new DonneesExamenClinique());
							return new TableGateway ( 'Donnees_examen_clinique', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\DiagnosticsTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DiagnosticsTableGateway' );
							$table = new DiagnosticsTable($tableGateway);
							return $table;
						},
						'DiagnosticsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new Diagnostics());
							return new TableGateway ( 'diagnostic', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\OrdonnanceTable' => function ($sm) {
							$tableGateway = $sm->get ( 'OrdonnanceTableGateway' );
							$table = new OrdonnanceTable($tableGateway);
							return $table;
						},
						'OrdonnanceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new Ordonnance());
							return new TableGateway ( 'ordonnance', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\DemandeVisitePreanesthesiqueTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandeVisitePreanesthesiqueTableGateway' );
							$table = new DemandeVisitePreanesthesiqueTable($tableGateway);
							return $table;
						},
						'DemandeVisitePreanesthesiqueTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new DemandeVisitePreanesthesique());
							return new TableGateway ( 'demande_visite_preanesthesique', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\NotesExamensMorphologiquesTable' => function ($sm) {
							$tableGateway = $sm->get ( 'NotesExamensMorphologiquesTableGateway' );
							$table = new NotesExamensMorphologiquesTable($tableGateway);
							return $table;
						},
						'NotesExamensMorphologiquesTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new NotesExamensMorphologiques());
							return new TableGateway ( 'note_examen_morphologique', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\NotesExamensBiologiquesTable' => function ($sm) {
							$tableGateway = $sm->get ( 'NotesExamensBiologiquesTableGateway' );
							$table = new NotesExamensBiologiquesTable($tableGateway);
							return $table;
						},
						'NotesExamensBiologiquesTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new NotesExamensBiologiques());
							return new TableGateway ( 'note_examen_biologique', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Orl\Model\OrdonConsommableTable' => function ($sm) {
							$tableGateway = $sm->get ( 'OrdonConsommableTableGateway' );
							$table = new OrdonConsommableTable($tableGateway);
							return $table;
						},
						'OrdonConsommableTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new OrdonConsommable());
							return new TableGateway ( 'ordon_consommable', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\AntecedentPersonnelTable' => function ($sm) {
							$tableGateway = $sm->get ( 'AntecedentPersonnelPatientTableGateway' );
							$table = new AntecedentPersonnelTable($tableGateway);
							return $table;
						},
						'AntecedentPersonnelPatientTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentPersonnel());
							return new TableGateway ( 'ant_personnels_patient', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\AntecedentsFamiliauxTable' => function ($sm) {
							$tableGateway = $sm->get ( 'AntecedentsFamiliauxPatientTableGateway' );
							$table = new AntecedentsFamiliauxTable($tableGateway);
							return $table;
						},
						'AntecedentsFamiliauxPatientTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentsFamiliaux());
							return new TableGateway ( 'ant_familiaux_patient', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\DemandehospitalisationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandehospitalisationTableeGateway' );
							$table = new DemandehospitalisationTable ( $tableGateway );
							return $table;
						},
						'DemandehospitalisationTableeGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Demandehospitalisation () );
							return new TableGateway ( 'demande_hospitalisation', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\SoinhospitalisationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'SoinhospitalisationConsTableGateway' );
							$table = new SoinhospitalisationTable( $tableGateway );
							return $table;
						},
						'SoinhospitalisationConsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Soinhospitalisation() );
							return new TableGateway ( 'soins_hospitalisation', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\SoinsTable' => function ($sm) {
							$tableGateway = $sm->get ( 'SoinsTableGateway' );
							$table = new SoinsTable( $tableGateway );
							return $table;
						},
						'SoinsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Soins() );
							return new TableGateway ( 'soins', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\HospitalisationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'HospitalisationTableGateway' );
							$table = new HospitalisationTable ( $tableGateway );
							return $table;
						},
						'HospitalisationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Hospitalisation() );
							return new TableGateway ( 'hospitalisation', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\HospitalisationlitTable' => function ($sm) {
							$tableGateway = $sm->get ( 'HospitalisationlitTableGateway' );
							$table = new HospitalisationlitTable ( $tableGateway );
							return $table;
						},
						'HospitalisationlitTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Hospitalisationlit() );
							return new TableGateway ( 'hospitalisation_lit', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\LitTable' => function ($sm) {
							$tableGateway = $sm->get ( 'LitTableGateway' );
							$table = new LitTable ( $tableGateway );
							return $table;
						},
						'LitTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Lit() );
							return new TableGateway ( 'lit', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\SalleTable' => function ($sm) {
							$tableGateway = $sm->get ( 'SalleTableGateway' );
							$table = new SalleTable( $tableGateway );
							return $table;
						},
						'SalleTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Salle() );
							return new TableGateway ( 'salle', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\BatimentTable' => function ($sm) {
							$tableGateway = $sm->get ( 'BatimentTableGateway' );
							$table = new BatimentTable ( $tableGateway );
							return $table;
						},
						'BatimentTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Batiment () );
							return new TableGateway ( 'batiment', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\ResultatVisitePreanesthesiqueTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ResultatVisitePreanesthesiqueTableGateway' );
							$table = new ResultatVisitePreanesthesiqueTable( $tableGateway );
							return $table;
						},
						'ResultatVisitePreanesthesiqueTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new ResultatVisitePreanesthesique() );
							return new TableGateway ( 'resultat_vpa', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\DemandeActeTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandeActeTableGateway' );
							$table = new DemandeActeTable($tableGateway);
							return $table;
						},
						'DemandeActeTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new DemandeActe());
							return new TableGateway ( 'demande_acte', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\AntecedentOrlTable' => function ($sm) {
							$tableGateway = $sm->get ( 'AntecedentOrlTableGateway' );
							$table = new AntecedentOrlTable($tableGateway);
							return $table;
						},
						'AntecedentOrlTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentOrl());
							return new TableGateway ( 'antecedent_orl', $dbAdapter, null, $resultSetPrototype );
						},

						'Orl\Model\MotifHospitalisationOrlTable' => function ($sm) {
							$tableGateway = $sm->get ( 'MotifHospitalisationOrlTableGateway' );
							$table = new MotifHospitalisationOrlTable($tableGateway);
							return $table;
						},
						'MotifHospitalisationOrlTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new MotifHospitalisationOrl());
							return new TableGateway ( 'motif_hospitalisation_orl', $dbAdapter, null, $resultSetPrototype );
						},
						'Orl\Model\HistoireMaladieTable' => function ($sm) {
							$tableGateway = $sm->get ( 'HistoireMaladieTableGateway' );
							$table = new HistoireMaladieTable($tableGateway);
							return $table;
						},
						'HistoireMaladieTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new HistoireMaladie());
							return new TableGateway ( 'histoire_maladie',$dbAdapter, null, $resultSetPrototype );
						},
						
						'Orl\Model\ExamensComplementairesOrlTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ExamensComplementairesOrlTableGateway' );
							$table = new ExamensComplementairesOrlTable($tableGateway);
							return $table;
						},
						'ExamensComplementairesOrlTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new ExamensComplementairesOrl());
							return new TableGateway ( 'examens_complementaires_orl', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Orl\Model\PeauCervicauFacialeOrlTable' => function ($sm){
							$tablegateway = $sm->get('PeauCervicauFacialeOrlTableGateway');
							$table = new PeauCervicauFacialeOrlTable($tablegateway);
							return $table;
						},
						'PeauCervicauFacialeOrlTableGateway' => function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new PeauCervicauFacialeOrl());
							return new TableGateway('peau_cervicau_faciale_orl', $dbAdapter, null,$resultSetPrototype);
						},
						'Orl\Model\TyroideTable' => function ($sm){
							$tablegateway = $sm->get('TyroideTableGateway');
							$table = new TyroideTable($tablegateway);
							return $table;
						},
						'TyroideTableGateway' => function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new Tyroide());
							return  new TableGateway('tyroide',$dbAdapter,null,$resultSetPrototype);
						},
						'Orl\Model\GroupesGanglionnairesTable'=>function ($sm){
							$tablegateway = $sm->get('GroupesGanglionnairesTableGateway');
							$table = new GroupesGanglionnairesTable($tablegateway);
							return $table;
						},
						'GroupesGanglionnairesTableGateway'=>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new GroupesGanglionnaires());
							return new TableGateway('groupes_ganglionnaires_cervicaux',$dbAdapter,null,$resultSetPrototype);
						},
						'Orl\Model\IncidentAccidentPerOperatoireOrlTable' => function ($sm){
							$tablegateway = $sm->get('IncidentAccidentPerOperatoireOrlTableGateway');
							$table = new IncidentAccidentPerOperatoireOrlTable($tablegateway);
							return $table;
						},
						'IncidentAccidentPerOperatoireOrlTableGateway' =>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new IncidentAccidentPerOperatoireOrl());
							return  new TableGateway('incident_accident_peroperatoire', $dbAdapter,null,$resultSetPrototype);
						},
						'Orl\Model\HormonesTyroidiennesOrlTable' => function ($sm){
							$tablegateway = $sm->get('HormonesTyroidiennesOrlTableGateway');
							$table = new HormonesTyroidiennesOrlTable($tablegateway);
							return $table;
						},
						'HormonesTyroidiennesOrlTableGateway' =>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new HormonesTyroidiennesOrl());
							return  new TableGateway('hormones_tyroidiennes_orl',$dbAdapter,null,$resultSetPrototype);
						},
						
						'Orl\Model\SousDossierTable' => function ($sm){
							$tablegateway = $sm->get('SousDossierTableGateway');
							$table = new SousDossierTable($tablegateway);
							return $table;
						},
						'SousDossierTableGateway' =>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new SousDossier());
							return  new TableGateway('sous_dossier',$dbAdapter,null,$resultSetPrototype);
						},
						
						
						
						'Orl\Model\IndicationsOperatoireOrlTable' => function ($sm){
							$tablegateway = $sm->get('IndicationsOperatoireOrlTableGateway');
							$table = new IndicationsOperatoireOrlTable($tablegateway);
							return $table;
						},
						'IndicationsOperatoireOrlTableGateway' =>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new IndicationsOperatoireOrl());
							return  new TableGateway('indications_operatoire_orl', $dbAdapter,null,$resultSetPrototype);
						},
						'Orl\Model\CompteRenduOperatoireOrlTable' => function ($sm){
							$tablegateway = $sm->get('CompteRenduOperatoireOrlTableGateway');
							$table = new CompteRenduOperatoireOrlTable($tablegateway);
							return $table;
						},
						'CompteRenduOperatoireOrlTableGateway' =>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new CompteRenduOperatoireOrl() );
							return  new TableGateway('compte_rendu_operatoire_orl', $dbAdapter,null,$resultSetPrototype);
						},
						'Orl\Model\PeriodePostOperatoirePrecoceTable' => function ($sm){
							$tablegateway = $sm->get('PeriodePostOperatoirePrecoceTableGateway');
							$table = new PeriodePostOperatoirePrecoceTable($tablegateway);
							return $table;
						},
						'PeriodePostOperatoirePrecoceTableGateway' =>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new PeriodePostOperatoirePrecoce() );
							return  new TableGateway('periode_post_operatoire_precoce', $dbAdapter,null,$resultSetPrototype);
						},
						'Orl\Model\HistologieTable' => function ($sm){
							$tablegateway = $sm->get('HistologieTableGateway');
							$table = new HistologieTable($tablegateway);
							return $table;
						},
						'HistologieTableGateway' =>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new Histologie() );
							return  new TableGateway('histologie', $dbAdapter,null,$resultSetPrototype);
						},
						
						'Orl\Model\SurveillanceTardiveTable' => function ($sm){
							$tableGateway = $sm->get('SurveillanceTardiveTableGateway');
							$table = new SurveillanceTardiveTable($tableGateway);
							return $table;
						},
						'SurveillanceTardiveTableGateway' =>function ($sm){
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype ->setArrayObjectPrototype(new SurveillanceTardive() );
							return  new TableGateway('surveillance_tardive', $dbAdapter,null,$resultSetPrototype);
						},
				)		
		);
	}
}