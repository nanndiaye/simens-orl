<?php
return array(
    'acl' => array(
    		
        'roles' => array(
        		'guest'   => null,
        		'infirmier' => 'guest',
        		'laborantin' => 'guest',
        		'admin' => 'guest',
        		'radiologie' => 'guest',
        		'anesthesie' => 'guest',
        		'major' => 'guest',
        		'facturation' => 'guest',
        		'etat_civil' => 'guest',
        		'archivage' => 'guest',
        		
        		//***Polyclinique
        		//***Polyclinique
        		'cardiologue' => 'guest',
        		'gynecologue' => 'guest',
        		'pediatre' => 'guest',
        		'psychiatre' => 'guest',
        		'pneumologue' => 'guest',
        		//'orl' => 'guest',
        		'kinesiterapeute' => 'guest',
        		'sage_femme' => 'guest',
        		//***************
        		//***************

        		
        		'surveillant' => 'guest',
        		'medecin'     => 'surveillant',
        		'superAdmin'  => 'medecin',
        		'secretaire' => 'guest',
        		
        		
        ),
    		

    		'resources' => array(
    		
    				'allow' => array(
    						
    						/***
    						 * AdminController
    						 */
    						
    						'Admin\Controller\Admin' => array(
    								'login' => 'guest',
    								'logout' => 'guest',
    								'bienvenue' => 'guest',
    								'modifier-password' => 'guest',
    								'verifier-password' => 'guest',
    								'mise-a-jour-user-password' => 'guest',
    								
    								'utilisateurs' => array('admin','superAdmin'),
    								'liste-utilisateurs-ajax' => array('admin','superAdmin'),
    								'modifier-utilisateur' => array('admin','superAdmin'),
    								'liste-agent-personnel-ajax' => array('admin','superAdmin'),
    								'visualisation' => array('admin','superAdmin'),
    								'nouvel-utilisateur' => array('admin','superAdmin'),
    								'verifier-username' => array('admin','superAdmin'),

    								'parametrages' => array('admin','superAdmin'),
    								'gestion-des-hopitaux' => array('admin','superAdmin'),
    								'liste-hopitaux-ajax' => array('admin','superAdmin'),
    								'get-departements' => array('admin','superAdmin'),
    								'ajouter-hopital' => array('admin','superAdmin'),
    								'get-infos-hopital' => array('admin','superAdmin'),
    								'get-infos-modification-hopital' => array('admin','superAdmin'),
    								
    								'gestion-des-batiments' => array('admin','superAdmin'),
    								'gestion-des-services' => array('admin','superAdmin'),
    								'liste-services-ajax' => array('admin','superAdmin'),
    								'get-infos-service' => array('admin','superAdmin'),
    								'get-infos-modification-service' => array('admin','superAdmin'),
    								'ajouter-service' => array('admin','superAdmin'),
    								'supprimer-service' => array('admin','superAdmin'),
    								
    								'gestion-des-actes' => array('admin','superAdmin'),
    								'liste-actes-ajax' => array('admin','superAdmin'),
    								'get-infos-acte' => array('admin','superAdmin'),
    								'get-infos-modification-acte' => array('admin','superAdmin'),
    								'ajouter-acte' => array('admin','superAdmin'),
    								'supprimer-acte'  => array('admin','superAdmin'),
    								
    						),
    						
    						
    						/***
    						 * FacturationController
    						 */
    						
    						'Facturation\Controller\Facturation' => array(
    								/*Menu Dosssier*/
    								'ajouter' => array('facturation','etat_civil','major','medecin'),
    								'info-patient' => array('facturation','etat_civil','major','medecin'),
    								'modifier' => array('facturation','etat_civil','major','medecin'),
    								'enregistrement-modification' => array('facturation','etat_civil','major','medecin'),
    								'enregistrement' => array('facturation','etat_civil','major','medecin'),
    								
    								'liste-patient' => array('facturation','etat_civil','major','medecin'),
    								'liste-patient-ajax' => array('facturation','etat_civil','major','medecin'),
    								
    								/*Menu Naissance*/
    								'ajouter-naissance' => 'etat_civil',
    								'lepatient' => 'etat_civil',
    								'enregistrer-bebe' => 'etat_civil',
    								'ajouter-naissance-ajax' => 'etat_civil',
    								
    								'liste-naissance' => 'etat_civil',
    								'liste-naissance-ajax' => 'etat_civil',
    								'vue-naissance' => 'etat_civil',
    								'vue-info-maman' => 'etat_civil',
    								'modifier-naissance' => 'etat_civil',
    								
    								'ajouter-maman' => 'etat_civil',
    								'enregistrement-maman' => 'etat_civil',
    								'ajouter-patient' => 'etat_civil',
    								'enregistrement-patient' => 'etat_civil',
    								
    								/*MENU DECES*/
    								'declarer-deces' => 'guest',
    								'liste-patient-declaration-deces-ajax' => 'etat_civil',
    								'le-patient' => 'etat_civil',
    								
    								'liste-patients-decedes' => 'etat_civil',
    								'liste-patient-deces-ajax' => 'etat_civil',
    								'vue-patient-decede' => 'etat_civil',
    								'modifier-deces' => 'etat_civil',
    								'supprimer-deces' => 'etat_civil',
    								
    								/*MENU ADMISSION*/
    								'admission' => array('major', 'medecin','facturation'),
    								'liste-admission-ajax' => array('major', 'medecin','facturation'),
    								'montant' => 'facturation',
    								'enregistrer-admission' => 'facturation',
    								
    								'liste-patients-admis' => 'facturation',
    								'vue-patient-admis' => 'facturation',
    								'supprimer-admission' => 'facturation',
    								'enregistrer-deces' => 'facturation',
    								
    								'impression-pdf' => 'facturation',
    								'impression-facture' => 'facturation',
    								
    								'liste-actes' => 'facturation',
    								'liste-actes-impayes-ajax' => 'facturation',
    								'liste-actes-payes-ajax' => 'facturation',
    								
    								'vue-patient' => 'facturation',
    								'liste-actes-impayes' => 'facturation',
    								'acte-paye' => 'facturation',
    								'impression-facture-acte' => 'facturation',
    								
    								'liste-admission-bloc-ajax' =>  array('major', 'medecin', 'facturation'),
    								
    								
    								
    								/*MENU ADMISSION BLOC - major*/
    								/*MENU ADMISSION BLOC - major*/
    								'admission-bloc' => array('major', 'medecin', 'facturation'),
    								'enregistrer-admission-bloc' =>  array('major', 'medecin', 'facturation'),
    								'liste-patients-admis-bloc' =>  array('major', 'medecin', 'facturation'),
    								'liste-patient-admis-bloc-ajax' =>  array('major', 'medecin', 'facturation'),
    								'vue-patient-admis-bloc' => array('major', 'medecin', 'facturation'),
    								'modification-admission-bloc' =>  array('major', 'medecin', 'facturation'),
    								'get-service' => array('major', 'medecin', 'facturation', 'facturation'),
    								'supprimer-admission-bloc' => array('major', 'medecin', 'facturation'),
    								'supprimer-patient' => array('major', 'medecin', 'facturation'),
    						),
    						
    						
    						/***
    						 * ConsultationController
    						 */

    						'Consultation\Controller\Consultation' => array(
    								//============  SURVEILLANT  ===================
    								'recherche' => 'surveillant',
    								'espace-recherche-surv' => 'surveillant',
    								'maj-consultation' => 'surveillant',
    								'ajout-constantes' => 'surveillant',
    								'ajout-donnees-constantes' => 'surveillant',
    								'maj-cons-donnees' => 'surveillant',
    								
    								//============ MEDECIN =========================
    								'consultation-medecin' => 'medecin',
    								'liste-consultation' => 'medecin',
    								'espace-recherche-med' => 'medecin',
    								'complement-consultation' => 'medecin',
    								'services' => 'medecin',
    								'update-complement-consultation' => 'medecin',
    								'maj-complement-consultation' => 'medecin',
    								'visualisation-consultation' => 'medecin',
    								'visualisation-hospitalisation' => 'medecin',
    								'liste-soins-visualisation-hosp' => 'medecin', 
    								
    								'imagesExamensMorphologiques' => 'medecin',
    								'supprimerImage' => 'medecin', 
    								'demande-examen' => 'medecin',
    								'demande-examen-biologique' => 'medecin',
    								
    								'en-cours' => 'medecin',
    								'liste-patient-encours-ajax' => 'medecin',
    								'info-patient' => 'medecin',
    								'detail-info-liberation-patient' => 'medecin',
    								'info-patient-hospi' => 'medecin',
    								'liste-soin' => 'medecin',
    								'supprimer-soin' => 'medecin',
    								'modifier-soin' => 'medecin',
    								'vue-soin-appliquer' => 'medecin',
    								'liberer-patient' => 'medecin',
    								'liste-soins-prescrits' => 'medecin',
    								'recherche-visualisation-consultation' => 'medecin',
    								'enregistrer-examen-du-jour' => 'medecin',
    								'liste-examen-du-jour' => 'medecin',
    								'supprimer-examen-jour' => 'medecin',
    								'vue-examen-jour' => 'medecin',
    								
    								'supprimer-image-morpho' => 'guest', //radiologie et archivage
    								'images-examens-morphologiques' => 'guest', //radiologie et archivage
    								
    								
    								'test-mp3' => 'medecin',
    								'ajouter-mp3' => 'medecin',
    								'afficher-mp3' => 'medecin',
    								'supprimer-mp3' => 'medecin',
    								'inserer-bd-mp3' => 'medecin',
    								
    								'afficher-video' => 'medecin',
    								'ajouter-video' => 'medecin',
    								'inserer-bd-video' => 'medecin',
    								'supprimer-video' => 'medecin',
    								/**PDF**/
    								'impression-Pdf' => 'medecin',
    								'tarifacte' => 'medecin',
    								'demande-acte' => 'medecin',
    								
    								
    								
    								//POUR LE BLOC OPERATOIRE
    								//POUR LE BLOC OPERATOIRE
    								'protocole-operatoire' => 'medecin',
    								'liste-patient-admis-bloc-ajax' => 'medecin',
    								'vue-patient-admis-bloc' => 'medecin',
    								'imprimer-protocole-operatoire' => 'medecin',
    								'enregistrer-protocole-operatoire' => 'medecin',
    								'liste-protocole-operatoire' => 'medecin',
    								'liste-patients-operes-bloc-ajax' => 'medecin',
    								'vue-patient-opere-bloc' => 'medecin',
    								'modifier-protocole-operatoire' => 'medecin',
    						        'image-protocole-operatoire' => 'medecin',
         						    'supprimer-image-protocole-operatoire' => 'medecin',
    						        'supprimer-images-sans-protocole' => 'medecin',
    						        'afficher-mp3-protocole' => 'medecin',
    						        'ajouter-mp3-protocole' => 'medecin',
    						        'inserer-bd-mp3-protocole' => 'medecin',
    						        'supprimer-mp3-protocole' => 'medecin',
    								
    								
    								//PARTIE ORL
    								'complement-consultation-orl' => 'medecin',
    								'complement-consultationl' => 'medecin',
    								'update-complement-consultation' => 'medecin',
    								'liste-consultation' => 'medecin',
    						),
    						
    						
    						/***
    						 * PersonnelController
    						 */
    						
    						'Personnel\Controller\Personnel' => array(
    								'liste-personnel' => array('admin','superAdmin'),
    								'liste-personnel-ajax' => array('admin','superAdmin'),
    								'info-personnel' => array('admin','superAdmin'),
    								'supprimer' => array('admin','superAdmin'),
    								'modifier-dossier' => array('admin','superAdmin'),
    								'dossier-personnel' => array('admin','superAdmin'),
    								
    								'transfert' => array('admin','superAdmin'),
    								'liste-personnel-transfert-ajax' => array('admin','superAdmin'),
    								'popup-agent-personnel' => array('admin','superAdmin'),
    								'vue-agent-personnel' => array('admin','superAdmin'),
    								'services' => array('admin','superAdmin'),
    								
    								'liste-transfert' => array('admin','superAdmin'),
    								'liste-transfert-ajax' => array('admin','superAdmin'),
    								'supprimer-transfert' => array('admin','superAdmin'),
    								
    								'intervention' => array('admin','superAdmin'),
    								'liste-personnel-intervention-ajax' => array('admin','superAdmin'),
    								'liste-intervention' => array('admin','superAdmin'),
    								'liste-intervention-ajax' => array('admin','superAdmin'),
    								'supprimer-transfert' => array('admin','superAdmin'),
    								'info-personnel-intervention' => array('admin','superAdmin'),
    								'vue-intervention-agent' => array('admin','superAdmin'),
    								'supprimer-intervention' => array('admin','superAdmin'),
    								'supprimer-une-intervention' => array('admin','superAdmin'),
    								'save-intervention' => array('admin','superAdmin'),
    								'modifier-intervention-agent' => array('admin','superAdmin'),
    						),
    						
    						/***
    						 * HospitalisationController
    						 */
    						
    						'Hospitalisation\Controller\Hospitalisation' => array(
    								
    								'suivi-patient' => 'infirmier',
    								'liste-patient-suivi-ajax' => 'infirmier',
    								'vue-soin-appliquer' => 'infirmier',
    								'administrer-soin-patient' => 'infirmier',
    								'application-soin' => 'infirmier',
    								'raffraichir-liste' => 'infirmier',
    								
    								'en-cours' => 'infirmier',
    								'liste-patient-encours-ajax' => 'infirmier',
    								'liste-soin' => 'infirmier',
    								'supprimer-soin' => 'infirmier',
    								'modifier-soin' => 'infirmier',
    								'detail-info-liberation-patient' => 'infirmier',
    								'liberer-patient' => 'infirmier',
    								'heure-suivante' => 'infirmier',
    								'heure-passee' => 'infirmier',
    								'liste-soins-du-jour-a-appliquer' => 'infirmier',
    								'details-infos-soin-a-appliquer' => 'infirmier',
    								'heure-du-soin' => 'infirmier',
    								
    								
    								'liste-demandes-examens' => 'laborantin',
    								'liste-demandes-examens-ajax' => 'laborantin',
    								'liste-examens-demander' => 'laborantin', 
    								'vue-examen-appliquer' => 'laborantin',
    								'raffraichir-liste-examens-bio' => 'laborantin',
    								'envoyer-examen-bio' => 'laborantin',
    								
    								'verifier-si-resultat-existe' => 'guest',
    								'modifier-examen' => 'guest',
    								'envoyer-examen' => 'guest',
    								'appliquer-examen' => 'guest',
    								'raffraichir-liste-examens' => 'guest',
    								
    								'liste-examens-effectues' => 'laborantin',
    								'liste-recherche-examens-effectues-ajax' => 'laborantin',

    								
    								'liste-demandes-examens-morpho' => 'radiologie',
    								'liste-demandes-examens-morpho-ajax' => 'radiologie',
    								'liste-examens-demander-morpho' => 'radiologie',
    								'vue-examen-appliquer-morpho' => 'radiologie',
    								'liste-examens-effectues-morpho' => 'radiologie',
    								'liste-recherche-examens-effectues-morpho-ajax' => 'radiologie',
    								'ajouter-examen' => 'radiologie',
    								'afficher-video' => 'radiologie',
    								'ajouter-video' => 'radiologie',
    								'inserer-bd-video' => 'radiologie',
    								'supprimer-video' => 'radiologie',
    								
    								
    								
    								'liste-demandes-vpa' =>      'anesthesie',
    								'liste-demandes-vpa-ajax' => 'anesthesie',
    								'details-demande-visite' =>  'anesthesie',
    								'save-result-vpa' => 'anesthesie',
    								'liste-recherche-vpa' => 'anesthesie',
    								'liste-recherche-vpa-ajax' => 'anesthesie',
    								'details-recherche-visite' => 'anesthesie',
    								
    								
    								
    								'demande-hospitalisation' => 'major',
    								'liste-liberer-patients' => 'major',
    								'liste-liberer-patient-ajax' => 'major',
    								'liberation-patient' => 'major',
    								'liberer-patient_major' => 'major',
    								'info-patient-liberer' => 'major',
    								
    								'liste-patient-ajax' => 'major',
    								'salles' => 'major',
    								'lits' => 'major',
    								'liste' => 'major',
    								'info-patient' => 'guest',
    								'info-patient-hospi' => 'major',
    								
    								'gestion-des-lits' => 'major',
    								'liste-lits-ajax' => 'major',
    								'occuper-lit' => 'major',
    								'liberer-lit' => 'major',
    								'etat-lit' => 'major',
    								'information-patient' => 'major',
    								'info-lit-salle-batiment' => 'major',
    								
    								
     						),
    						
    						
    						/***
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						*/
    						
    						'Archivage\Controller\Archivage' => array(
    								/*Consultation */
    								'index' => array('archivage','medecin'),
    								'consulter' => array('archivage','medecin'),
    								'liste-consultation' => array('archivage','medecin'),
    								'hospitaliser' => array('archivage','medecin'),
    								'consultation' => array('archivage','medecin'), 
    								'update-complement-consultation' => array('archivage','medecin'), 
    								'visualisation-consultation' => array('archivage','medecin'),
    						        'visualisation-consultation-vue' => array('archivage','medecin'),
    								'visualiser-consultation' => array('archivage','medecin'),
    								'ajouter-mp3' => array('archivage','medecin'),
    								'afficher-mp3' => array('archivage','medecin'),
    								'supprimer-mp3' => array('archivage','medecin'),
    								'inserer-bd-mp3' => array('archivage','medecin'),
    								'afficher-video' => array('archivage','medecin'),
    								'ajouter-video' => array('archivage','medecin'),
    								'inserer-bd-video' => array('archivage','medecin'),
    								'supprimer-video' => array('archivage','medecin'),
    						        'demande-examen-biologique'=> array('archivage','medecin'),
    						        'demande-examen' => array('archivage','medecin'),
    						        'images-examens-morphologiques' => array('archivage','medecin'),
    						        'supprimer-image' => array('archivage','medecin'),
    								
    								/*Facturation*/
    								'ajouter' => array('archivage','medecin'),
    								'enregistrement' => array('archivage','medecin'),
    								'liste-dossiers-patients' => array('archivage','medecin'),
    								'liste-patient-ajax' => array('archivage','medecin'),
    								'info-dossier-patient' => array('archivage','medecin'),
    								'modifier' => array('archivage','medecin'),
    								'enregistrement-modification' => array('archivage','medecin'),
    								'admission' => array('archivage','medecin'),
    								'liste-admission-ajax' => array('archivage','medecin'),
    								'popup-visualisation' => array('archivage','medecin'),
    								'montant' => array('archivage','medecin'),
    								'enregistrer-admission' => array('archivage','medecin'),
    								'liste-admission' => array('archivage','medecin'),
    								'vue-patient-admis' => array('archivage','medecin'),
    								'supprimer-admission'  => array('archivage','medecin'),
    								
    								/*Hospitalisation*/
    								'info-patient' => array('archivage','medecin'),
    								'info-patient-hospi' => array('archivage','medecin'),
    								'liste-patient-encours-ajax' => array('archivage','medecin'),
    								'liste-demande-hospitalisation' => array('archivage','medecin'),
    								'salles' => array('archivage','medecin'),
    								'lits' => array('archivage','medecin'),
    								'services' => array('archivage','medecin'),
    								'administrer-soin' => array('archivage','medecin'),
    								'liste-soins-prescrits' => array('archivage','medecin'),
    								'appliquer-soin' => array('archivage','medecin'),
    								'liste-patient-suivi-ajax' => array('archivage','medecin'),
    								'info-patient-suivi' => array('archivage','medecin'),
    								'administrer-soin-patient' => array('archivage','medecin'),
    								'vue-soin-appliquer' => array('archivage','medecin'),
    								'heure-suivante' => array('archivage','medecin'),
    								'application-soin' => array('archivage','medecin'),
    								'raffraichir-liste' => array('archivage','medecin'),
    								'detail-info-liberation-patient' => array('archivage','medecin'),
    								'liste-demande-hospi-ajax' => array('archivage','medecin'),
    								'liberer-patient' => array('archivage','medecin'),
    								'liste-examen-du-jour' => array('archivage','medecin'),
    								'modifier-soin' => array('archivage','medecin'),
    								'supprimer-soin' => array('archivage','medecin'),
    								'information-patient' => array('archivage','medecin'),
    								
    								/*Radiologie*/
    								'liste-resultats-radiologie' => array('archivage','medecin'),
    								'liste-recherche-examens-effectues-morpho-ajax' => array('archivage','medecin'),
    								'liste-examens-demander-morpho' => array('archivage','medecin'),
    								'verifier-si-resultat-existe' => array('archivage','medecin'),
    								'vue-examen-appliquer-morpho' => array('archivage','medecin'),
    								
    								/*Biologie*/
    								'ajouter-resultat-biologique' => array('archivage','medecin'),
    								'liste-demandes-examens-ajax' => array('archivage','medecin'),
    								'liste-examens-demander' => array('archivage','medecin'),
    								'verifier-si-resultat-existe' => array('archivage','medecin'),
    								'vue-examen-appliquer' => array('archivage','medecin'),
    								'appliquer-examen' => array('archivage','medecin'),
    								'raffraichir-liste-examens-bio' => array('archivage','medecin'),
    								'modifier-examen' => array('archivage','medecin'),
    								'envoyer-examen-bio' => array('archivage','medecin'),
    								'liste-resultats-biologie' => array('archivage','medecin'),
    								'liste-recherche-examens-effectues-ajax' => array('archivage','medecin'),
    								
    								/*Anesthésie*/
    								'ajouter-resultat-vpa' => array('archivage','medecin'),
    								'liste-demandes-vpa-ajax' => array('archivage','medecin'),
    								'details-demande-visite' => array('archivage','medecin'),
    								'liste-resultats-vpa' => array('archivage','medecin'),
    								'liste-recherche-vpa-ajax' => array('archivage','medecin'),
    								'save-result-vpa' => array('archivage','medecin'),
    								'details-recherche-visite' => array('archivage','medecin'),
    								
    						),
    						
    						'Orl\Controller\Orl' => array(
    								
    								'ajout-constantes' => 'medecin',
    								'ajout-donnees-constantes' => 'medecin',
    								'complement-consultation-orl' => 'medecin',
    								'complement-consultation' => 'medecin',
    								'en-cours' => 'medecin',
    								'liste-consultation' => 'medecin',
    								'liste-consultation-ajax' => 'medecin',
    								
    								'espace-recherche-med' => 'medecin',
    								'espace-recherche-surv' => 'medecin',
    								'liste-consultation' => 'medecin',
    								'liste-protocole-operatoire'=> 'medecin',
    								'maj-complement-consultation' => 'medecin',
    								'maj-consultation'=> 'medecin',
    								'update-complement-consultation'=> 'medecin',
    								'recherche' => 'medecin',
    								'recherche-visualisation-consultation' => 'medecin',
    								'visualisation-consultation' => 'medecin',
    								'visualisation-hospitalisation' => 'medecin',
    								'vue-examen-jour' => 'medecin',
    								'enregistrer-protocole-operatoire' => 'medecin',
    								'recherche-dossier-patient' => 'medecin',
    								'demande-operation' => 'medecin',
    								//'visualisation-fiche-observation-clinique'=> 'medecin',
    								
    								//POUR LE BLOC OPERATOIRE
    								//POUR LE BLOC OPERATOIRE
    								'protocole-operatoire' => 'medecin',
    								'liste-patient-admis-bloc-ajax' => 'medecin',
    								'vue-patient-admis-bloc' => 'medecin',
    								'imprimer-protocole-operatoire' => 'medecin',
    								'enregistrer-protocole-operatoire' => 'medecin',
    								'liste-protocole-operatoire' => 'medecin',
    								'liste-patients-operes-bloc-ajax' => 'medecin',
    								'vue-patient-opere-bloc' => 'medecin',
    								'modifier-protocole-operatoire' => 'medecin',
    								'image-protocole-operatoire' => 'medecin',
    								'supprimer-image-protocole-operatoire' => 'medecin',
    								'supprimer-images-sans-protocole' => 'medecin',
    								'afficher-mp3-protocole' => 'medecin',
    								'ajouter-mp3-protocole' => 'medecin',
    								'inserer-bd-mp3-protocole' => 'medecin',
    								'supprimer-mp3-protocole' => 'medecin',
    								'image-protocole-operatoire' => 'medecin',
    								'impression-Pdf' => 'medecin',
    								
    								
    								
    								
    								
    								'consultation-orl' => 'medecin',
    								'choix-dossier' => 'medecin',
    								'fiche-observation-clinique' => 'medecin',
    								'thyroide' => 'medecin',
    								'liste-consultation-precedente-ajax' => 'medecin',
    								'liste-notes-medicales-precedente-ajax' => 'medecin',
    								'maj-fiche-observation-clinique' => 'medecin',
    							
    								
    						),
    						//secretariat
    						
    						
    						'Orl\Controller\Secretariat' => array(
    								
    								'ajouter-patient' => array('secretaire', 'medecin'),
    								'enregistrement-patient' => array('secretaire', 'medecin'),
    								'liste-patient' => array('secretaire', 'medecin'),
    								'liste-patient-ajax' => array('secretaire', 'medecin'),
    								'info-patient' => array('secretaire', 'medecin'),
    								'modifier' => array('secretaire', 'medecin'),
    								'enregistrement-modification' => array('secretaire', 'medecin'),
    								'admission' => array('secretaire','medecin'),
    								'liste-admission-ajax' => array('secretaire','medecin'),
    								'enregistrer-admission'=> array('secretaire','medecin'),
    								'liste-patients-admis'=> array('secretaire','medecin'),
    								'enregistrer-admission'=> array('secretaire','medecin'),
    								'declarer-deces'=> array('secretaire','medecin'),
    								'liste-actes'=> array('secretaire','medecin'),
    								'liste-actes-impayes-ajax' =>array('secretaire','medecin'),
    								'liste-actes-payes-ajax'=>array('secretaire','medecin'),
    								'vue-patient' =>array('secretaire','medecin'),
   								    'liste-actes-impayes' => array('secretaire','medecin'),
     								'acte-paye' => array('secretaire','medecin'),
  								    'impression-facture-acte' => array('secretaire','medecin'),
    								'vue-patient-admis' => array('secretaire','medecin'),
    								'liste-rendez-vous' => array('secretaire','medecin'),
    								'liste-rendez-vous-ajax' => array('secretaire','medecin'),
    								'info-patient-rv' => array('secretaire','medecin'),
    								'modifier-infos-patient-rv' => array('secretaire','medecin'),
    								'fixer-rendez-vous' => array('secretaire','medecin'),
    								'fixer-rendez-vous-ajax' => array('secretaire','medecin'),
    								'programmer-rendez-vous' => array('secretaire','medecin'),
    								'programmer-rendez-vous-ajax' => array('secretaire','medecin'),
    								'info-programmer-rendez-vous' => array('secretaire','medecin'),
    								'enregistrer-rendervous-programmer' => array('secretaire','medecin'),
    								
    						),
    						
    				),
    		),
    )
);