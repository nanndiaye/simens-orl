<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class AdmissionTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getPatientsAdmis() {
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->from ( array (
				'p' => 'patient'
		) );
		$select->columns ( array () );
		$select->join(array('pers' => 'personne'), 'pers.ID_PERSONNE = p.ID_PERSONNE', array(
				'Nom' => 'NOM',
				'Prenom' => 'PRENOM',
				'Datenaissance' => 'DATE_NAISSANCE',
				'Sexe' => 'SEXE',
				'Adresse' => 'ADRESSE',
				'Nationalite' => 'NATIONALITE_ACTUELLE',
				'Id' => 'ID_PERSONNE'
		));
		$select->join ( array (
				'a' => 'admission'
		), 'p.ID_PERSONNE = a.id_patient', array (
				'Id_admission' => 'id_admission'
		) );
		$select->join ( array (
				's' => 'service'
		), 's.ID_SERVICE = a.id_service', array (
				'Id_Service' => 'ID_SERVICE',
				'Nomservice' => 'NOM'
		) );
				$select->where ( array (
				'a.date_cons' => $date
		) );
			
		
		$select->order ( 'id_admission DESC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		return $result;
	}
	
	public function nbAdmission() {
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'admission' );
		$select->columns ( array (
				'id_admission'
		) );
		$select->where ( array (
				'date_cons' => $date
		) );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$nb = $stat->execute ()->count ();
		return $nb;
	}
	
	public function addAdmission($donnees){
		$this->tableGateway->insert($donnees);
	}
	
	
	//ENREGISTREMENT D'UNE ADMISSION BLOC A LA BASE DE DONNEES
	//ENREGISTREMENT D'UNE ADMISSION BLOC A LA BASE DE DONNEES
	public function addAdmissionBloc($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('admission_bloc')
			->values($donnees);
			$requete = $sql->prepareStatementForSqlObject($sQuery);
			$requete->execute();
	}
	
	public function updateAdmissionBloc( $donneesAdmission , $id_admission){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update()
		->table('admission_bloc')
		->set( $donneesAdmission )
		->where(array('id_admission' => $id_admission ));
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	public function updateDemandeOperationBloc( $donneesDemandeOperation , $id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update()
		->table('demande_operation')
		->set( $donneesDemandeOperation )
		->where(array('id_cons' => $id_cons ));
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	/*
	 * Recup�rer la liste des patients admis et d�j� consult�s pour aujourd'hui
	 */
	public function getPatientAdmisCons(){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'consultation' );
		$select->columns ( array (
				'ID_PATIENT'
		) );
		$select->where ( array (
				'DATEONLY' => $date,
		) );
		
		$result = $sql->prepareStatementForSqlObject ( $select )->execute ();
		$tab = array();
		foreach ($result as $res) {
			$tab[] = $res['ID_PATIENT'];
		}
		
		return $tab;
	}
	
	/*
	 * Fonction qui v�rifie est ce que le patient n'est pas d�ja consult�
	 */
	public function verifierPatientConsulter($idPatient, $idService){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'consultation' );
		$select->columns ( array (
				'ID_PATIENT'
		) );
		$select->where ( array (
				'DATEONLY' => $date,
				'ID_SERVICE' => $idService,
				'ID_PATIENT' => $idPatient,
		) );
		
		return $sql->prepareStatementForSqlObject ( $select )->execute ()->current();
	}
	
	public function deleteAdmissionPatient($id, $idPatient, $idService){
		if($this->verifierPatientConsulter($idPatient, $idService)){
		    return 1;
		} else {
			$this->tableGateway->delete(array('id_admission'=> $id));
			return 0;
		}

	}
	
	public function getPatientAdmis($id){
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'id_admission' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	
	public function getPatientAdmisBloc($idAdmission){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('admission_bloc')
		->where(array('id_admission' => $idAdmission));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getInfosDemandeOperationBloc($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('demande_operation')
		->where(array('id_cons' => $id_cons));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getProtocoleOperatoireBloc($idAdmission){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('protocole_operatoire_bloc')
		->where(array('id_admission_bloc' => $idAdmission));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getListeProtocoleOperatoireBloc(){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_bloc')
	    ->group("protocole_operatoire");
	    $requete = $sql->prepareStatementForSqlObject($sQuery);
	    return $requete->execute();
	}
	
	public function getListeSoinsPostOperatoireBloc(){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_bloc')
	    ->group("soins_post_operatoire");
	     
	    $requete = $sql->prepareStatementForSqlObject($sQuery);
	    return $requete->execute();
	}
	
	public function getLastAdmission() {
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('admission')
		->order('id_admission DESC');
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	//Ajouter la consultation dans la table << consultation >> pour permettre au medecin de pouvoir lui m�me ajouter les constantes
	//Ajouter la consultation dans la table << consultation >> pour permettre au medecin de pouvoir lui m�me ajouter les constantes
	public function addConsultation($values , $IdDuService){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
		$dateOnly = $today->format ( 'Y-m-d' );
		
		$db = $this->tableGateway->getAdapter();
		$this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
		try {
	
			$dataconsultation = array(
					'ID_CONS'=> $values->get ( "id_cons" )->getValue (),
					'ID_PATIENT'=> $values->get ( "id_patient" )->getValue (),
					'DATE'=> $date,
 					'DATEONLY' => $dateOnly,
					'HEURECONS' => $values->get ( "heure_cons" )->getValue (),
					'ID_SERVICE' => $IdDuService
			);
			
			$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('consultation')
			->values($dataconsultation);
			$sql->prepareStatementForSqlObject($sQuery)->execute();
	
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();
		} catch (\Exception $e) {
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();
		}
	}
	
	public function addConsultationOrl($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('consultation_orl')
		->values(array('ID_CONS' => $id_cons));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		$requete->execute();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	//CONCERVE LA PARTIE POUR LE BLOC OPERATOIRE
	//CONCERVE LA PARTIE POUR LE BLOC OPERATOIRE
	//CONCERVE LA PARTIE POUR LE BLOC OPERATOIRE
	
	public function addProtocoleOperatoire($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('protocole_operatoire_bloc')
		->values($donnees);
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		$requete->execute();
	}

	public function updateProtocoleOperatoire($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update()
		->table('protocole_operatoire_bloc')
		->set( $donnees )
		->where(array('id_protocole' => $donnees['id_protocole'] ));
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function addImagesProtocole($nomImage, $id_admission, $id_employe){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->insert()
	    ->into('protocole_operatoire_image')
	    ->columns(array('nomImage', 'dateEnregistrement', 'idResultat'))
	    ->values(array('nomImage' => $nomImage,  'id_admission' => $id_admission , 'id_employe' => $id_employe));
	    $stat = $sql->prepareStatementForSqlObject($sQuery);
	    $result = $stat->execute();
	    return $result;
	}
	
	public function getImagesProtocoles($id_admission) {
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_image')
	    ->order('idImage DESC')
	    ->where(array('id_admission' => $id_admission));
	    
	    return $sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function recupererImageProtocole($id, $idAdmission)
	{
	        
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	     $sQuery = $sql->select('protocole_operatoire_image')
	    ->order('idImage DESC')
	    ->where(array('id_admission' => $idAdmission));

	    $Result = $sql->prepareStatementForSqlObject($sQuery)->execute();
	        
	    $i = 1;
	    $tabIdImage = array();
	    $tabNomImage = array();
	    
	    foreach ($Result as $resultat){
	         $tabIdImage[$i] = $resultat['idImage'];
	         $tabNomImage[$i] = $resultat['nomImage'];
	         $i++;
	    }
	        	
	    return  array('idImage' => $tabIdImage[$id], 'nomImage'=> $tabNomImage[$id]);
	
	}
	
	
	public function supprimerImageProtocole($idImage)
	{
	    $idImage = (int) $idImage;
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->delete('protocole_operatoire_image')
	    ->where(array('idImage' => $idImage));
	    return $sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	
	public function getProtocoleOperatoire($id_admission) 
	{
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_bloc')
	    ->where(array('id_admission_bloc' => $id_admission));
	     
	    return $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
	
	public function cheminBaseUrl(){
	    $baseUrl = $_SERVER['SCRIPT_FILENAME'];
	    $tabURI  = explode('public', $baseUrl);
	    return $tabURI[0];
	}
	
	public function supprimerImagesSansProtocole($id_admission)
	{
	    if(!$this->getProtocoleOperatoire($id_admission)){
	        
	        //On supprime les images sur le disque
	        //On supprime les images sur le disque
	        $db = $this->tableGateway->getAdapter();
	        $sql = new Sql($db);
	        $sQuery = $sql->select('protocole_operatoire_image')
	        ->order('idImage DESC')
	        ->where(array('id_admission' => $id_admission));
	        
	        $Result = $sql->prepareStatementForSqlObject($sQuery)->execute();
	         
	        foreach ($Result as $resultat){
	            unlink ( $this->cheminBaseUrl().'public/images/protocoles/' . $resultat['nomImage'] . '.jpg' );
	        }
	        
	        
	        //On supprime les images dans la base de donn�es
	        //On supprime les images dans la base de donn�es
	        $db = $this->tableGateway->getAdapter();
	        $sql = new Sql($db);
	        $sQuery = $sql->delete('protocole_operatoire_image')
	        ->where(array('id_admission' => $id_admission));
	        return $sql->prepareStatementForSqlObject($sQuery)->execute();
	    }
	}
	
	//GESTION DES FICHIER MP3 DES PROTOCOLES
	//GESTION DES FICHIER MP3 DES PROTOCOLES
	//GESTION DES FICHIER MP3 DES PROTOCOLES
	public function insererProtocoleMp3($titre , $nom, $id_admission, $id_employe){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->insert()
	    ->into('fichier_mp3_protocole')
	    ->columns(array('titre', 'nom', 'id_admission'))
	    ->values(array('titre' => $titre , 'nom' => $nom, 'id_admission'=>$id_admission, 'id_employe'=>$id_employe));
	
	    return $sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function getProtocoleMp3($id_admission){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select()
	    ->from(array('f' => 'fichier_mp3_protocole'))->columns(array('*'))
	    ->where(array('id_admission' => $id_admission))
	    ->order('id DESC');
	
	    $stat = $sql->prepareStatementForSqlObject($sQuery);
	    $result = $stat->execute();
	    return $result;
	}
	
	public function supprimerProtocoleMp3($id, $id_admission){
	    $liste = $this->getProtocoleMp3($id_admission);
	
	    $i=1;
	    foreach ($liste as $list){
	        if($i == $id){
	            unlink($this->cheminBaseUrl().'public/audios/protocoles/'.$list['nom']);
	
	            $db = $this->tableGateway->getAdapter();
	            $sql = new Sql($db);
	            $sQuery = $sql->delete()
	            ->from('fichier_mp3_protocole')
	            ->where(array('id' => $list['id']));
	
	            $sql->prepareStatementForSqlObject($sQuery)->execute();
	
	            return true;
	        }
	        $i++;
	    }
	    return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
	
	

	// GESTION DES ADMISSION PATIENTS SUR LE BLOB OPERATOIRE
	// GESTION DES ADMISSION PATIENTS SUR LE BLOB OPERATOIRE
	// GESTION DES ADMISSION PATIENTS SUR LE BLOB OPERATOIRE
	public function getDemandeOperation($id_demande){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('demop' => 'demande_operation'))->columns(array('*'))
		->where(array('id_demande_operation' => $id_demande));
		return  $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
}