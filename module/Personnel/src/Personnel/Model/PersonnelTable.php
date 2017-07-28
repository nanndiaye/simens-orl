<?php

namespace Personnel\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;
use Zend\Db\Sql\Sql;

class PersonnelTable {
	protected $tableGateway;
	protected $conversionDate;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getConversionDate(){
		$this->conversionDate = new DateHelper();
	
		return $this->conversionDate;
	}
	
	public function getPersonne($id_personne)
	{
		$id_personne  = (int) $id_personne;
		$rowset = $this->tableGateway->select(array('id_personne' => $id_personne));
		$row = $rowset->current();
		if (!$row) { return null; }
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('p' => 'personne'))->columns(array('*'))
		->join(array('e' => 'employe'), 'p.ID_PERSONNE = e.id_personne' , array('*'))
		->join(array('te' => 'type_employe'), 'e.id_type_employe = te.id' , array('NOM_TYPE' => 'nom'))
		->where(array('p.ID_PERSONNE' => $id_personne));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
	
	public function getPhoto($id_personne) {
		$donneesPersonne =  $this->getPersonne($id_personne);
	
		$nom = $donneesPersonne['PHOTO'];
		if ($nom) {
			return $nom . '.jpg';
		} else {
			return 'identite.jpg';
		}
	}
	
	public function deletePersonne($id_personne){
		$id_personne = (int) $id_personne;
		
		if ($this->getPersonne($id_personne)) {
			$this->tableGateway->delete( array('id_personne' => $id_personne));
		} else {
			throw new \Exception('Cette personne n existe pas');
		}
	}
	
	public function updateEmploye($id_employe, $type_personnel){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		
		$donnees = array('id_type_employe' => $type_personnel);
		
		$sQuery = $sql->update()
		->table('employe')
		->set( $donnees )->where(array('id_personne' => $id_employe ));
		$sql->prepareStatementForSqlObject($sQuery)->execute();
		
	}
	
	public function saveEmploye($id_personne, $type_personnel, $date_enregistrement){
		
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		
		$donnees = array(
				'id_personne' => $id_personne,
				'id_type_employe' => $type_personnel,
				'date_enregistrement' => $date_enregistrement,
				'etat' => 1
		);
		
		$sQuery = $sql->insert() ->into('employe') ->values( $donnees );
		
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	
	}
	
	public function savePersonnel(Personnel $personnel, $nomphoto = null)
	{
		$this->getConversionDate();
		
		$date = $personnel->date_naissance;
		if($date){ $date = $this->conversionDate->convertDateInAnglais($personnel->date_naissance); } else { $date = null; }
		
		$data = array(
				'NOM'  => $personnel->nom,
				'PRENOM'  => $personnel->prenom,
				'DATE_NAISSANCE'  => $date,
				'LIEU_NAISSANCE'  => $personnel->lieu_naissance,
				'NATIONALITE_ACTUELLE'  => $personnel->nationalite,
				'SITUATION_MATRIMONIALE' => $personnel->situation_matrimoniale,
				'ADRESSE'  => $personnel->adresse,
				'TELEPHONE'  => $personnel->telephone,
				'EMAIL'  => $personnel->email,
				'SEXE'  => $personnel->sexe,
				'PROFESSION'  => $personnel->profession,
				'PHOTO'  => $nomphoto,
		);
		
		$id_personne = (int)$personnel->id_personne;
		
		if($id_personne == 0) {
			$id_personne_inserer = $this->tableGateway->getLastInsertValue($this->tableGateway->insert($data));
			$this->saveEmploye($id_personne_inserer, $personnel->type_personnel, $personnel->date_enregistrement);
			return($id_personne_inserer);
 		} else {
			if ($this->getPersonne($id_personne)) {
				$this->tableGateway->update($data, array('id_personne' => $id_personne));
				$this->updateEmploye($id_personne, $personnel->type_personnel);
			} 
		}
	
	}
	
	//Réduire la chaine addresse
	function adresseText($Text){
		$chaine = $Text;
		if(strlen($Text)>30){
			$chaine = substr($Text, 0, 30);
			$nb = strrpos($chaine, ' ');
			$chaine = substr($chaine, 0, $nb);
			$chaine .=' ...';
		}
		return $chaine;
	}
	
	//Réduire la chaine nationalit�
	function nationaliteText($Text){
		$chaine = $Text;
		if(strlen($Text)>20){
			$chaine = substr($Text, 0, 20);
			$nb = strrpos($chaine, ' ');
			$chaine = substr($chaine, 0, $nb);
			$chaine .=' ...';
		}
		return $chaine;
	}
	
	/**
	 * POUR LA LISTE DES AGENTS DU SERVICE
	 */
	public function getListePersonnel() 
	{

		$db = $this->tableGateway->getAdapter();
		
		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'Adresse', 'Nationalite', 'id');
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
		
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
		
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
		
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('e' => 'employe'))->columns(array('*'))
		->join(array('pers' => 'personne'), 'pers.ID_PERSONNE = e.id_personne', array('Nom'=>'NOM','Prenom'=>'PRENOM','Datenaissance'=>'DATE_NAISSANCE','Sexe'=>'SEXE','Adresse'=>'ADRESSE','Nationalite'=>'NATIONALITE_ACTUELLE','id'=>'ID_PERSONNE'))
		->join(array('te' => 'type_employe'), 'te.id = e.id_type_employe', array('Typepersonnel'=>'nom'))
		->where(array('etat' => 1));
		
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
		
		$rResult = $rResultFt;
		//var_dump($rResultFt); exit();
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
		
		/*
		 * $Control pour convertir la date en fran�ais
		*/
		$Control = new DateHelper();
		
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
		
		/*
		 * Pr�parer la liste
		*/
		foreach ( $rResult as $aRow )
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Nom'){
						$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
					}
		
					else if ($aColumns[$i] == 'Datenaissance') {
						$date = $aRow[ $aColumns[$i] ];
						if($date){ $row[] = $Control->convertDate($aRow[ $aColumns[$i] ]); } else { $row[] = ""; }
					}
		
					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
					}
		
					else if($aColumns[$i] == 'Nationalite') {
						$row[] = $this->nationaliteText($aRow[ $aColumns[$i] ]);
					}
					
					else if ($aColumns[$i] == 'id') {
						$html  ="<a href='javascript:affichervue(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 15%;' src='".$tabURI[0]."public/images_icons/voir2.png' title='détails'></a>";
		
						$html .="<a href='".$tabURI[0]."public/personnel/modifier-dossier/id_personne/".$aRow[ $aColumns[$i] ]."'>";
						$html .="<img style='display: inline; margin-right: 15%;' src='".$tabURI[0]."public/images_icons/pencil_16.png' title='Modifier'></a>";
		
						//$html .="<a id='".$aRow[ $aColumns[$i] ]."' href='javascript:supprimer(".$aRow[ $aColumns[$i] ].")'>";
						//$html .="<img style='display: inline;' src='".$tabURI[0]."public/images_icons/trash_16.PNG' title='Supprimer'></a>";
						
						$html .="<input type='hidden' value='".$aRow[ 'Typepersonnel' ]."'>";
						
						$row[] = $html;
					}
					
					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}
		
				}
			}
			
			$output['aaData'][] = $row;
		}
		
		return $output;
	}

	/**
	 * POUR LA RECHERCHE DES AGENTS A TRANSFERE
	 * @return Ambigous <multitype:multitype: number , multitype:string Ambigous <string, unknown> unknown >
	 */
	public function getListeRechercheTransfertPersonnel()
	{
	
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Codepersonne','Nom','Prenom','Datenaissance','Adresse', 'id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pers' => 'personnel2'))->columns(array('Codepersonne'=>'id_personne','Nom'=>'nom','Prenom'=>'prenom','Datenaissance'=>'date_naissance','Sexe'=>'sexe','Adresse'=>'adresse','Nationalite'=>'nationalite','Typepersonnel'=>'type_personnel','id'=>'id_personne'))
		->where(array('etat' => 1));
	
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en fran�ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Pr�parer la liste
		*/
		foreach ( $rResult as $aRow )
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Nom'){
						$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
					}
	
					else if ($aColumns[$i] == 'Datenaissance') {
						$row[] = $Control->convertDate($aRow[ $aColumns[$i] ]);
					}
	
					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
					}
	
					else if ($aColumns[$i] == 'id') {
						$html  ="<a href='javascript:affichervue(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 25%;' src='".$tabURI[0]."public/images_icons/vue.png' title='détails'></a>";
	
						$html .="<a href='javascript:transferer(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 5%;' src='".$tabURI[0]."public/images_icons/suivant.png' title='transféré'></a>";
						
						$html .="<input type='hidden' value='".$aRow[ 'Typepersonnel' ]."'>";
	
						$row[] = $html;
					}
						
					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}
	
				}
			}
				
			$output['aaData'][] = $row;
		}
	
		return $output;
	}
	
	/**
	 * POUR LA LISTE DES AGENTS TRANSFERES
	 * @param unknown $id_personne
	 */
	public function getListeTransfertPersonnel()
	{
	
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'Adresse', 'Nationalite', 'id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pers' => 'personnel2'))->columns(array('Nom'=>'nom','Prenom'=>'prenom','Datenaissance'=>'date_naissance','Sexe'=>'sexe','Adresse'=>'adresse','Nationalite'=>'nationalite','Typepersonnel'=>'type_personnel','id'=>'id_personne'))
		->where(array('etat' => 0));
	
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en fran�ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Pr�parer la liste
		*/
		foreach ( $rResult as $aRow )
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Nom'){
						$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
					}
	
					else if ($aColumns[$i] == 'Datenaissance') {
						$row[] = $Control->convertDate($aRow[ $aColumns[$i] ]);
					}
	
					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
					}
					
	
					else if ($aColumns[$i] == 'id') {
						$html  ="<a href='javascript:affichervue(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 15%;' src='".$tabURI[0]."public/images_icons/vue.png' title='détails'></a>";
	
						$html  .="<a href='javascript:modifiertransfert(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 15%;' src='".$tabURI[0]."public/images_icons/modifier.png' title='modifier'></a>";
	
						$html .="<a id='".$aRow[ $aColumns[$i] ]."' href='javascript:supprimer(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline;' src='".$tabURI[0]."public/images_icons/trash_16.PNG' title='Supprimer'></a>";
	
						$html .="<input type='hidden' value='".$aRow[ 'Typepersonnel' ]."'>";
	
						$row[] = $html;
					}
						
					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}
	
				}
			}
				
			$output['aaData'][] = $row;
		}
	
		return $output;
	}
	
	public function updateEtatForTransfert($id_personne) {
		$this->tableGateway->update(array('etat' => 0), array('id_personne' => $id_personne));
	}
	
	public function updateEtatForDeleteTransfert($id_personne) {
		$this->tableGateway->update(array('etat' => 1), array('id_personne' => $id_personne));
	}
	
	/**************************************
	 *======= PARTIE INTERVENTION =========
	 **************************************
	 **************************************
	 */
	/**
	 * POUR LA RECHERCHE D'UN AGENT AFIN D'ENREGISTRER SON INTERVENTION 
	 * @return Ambigous <multitype:multitype: number , multitype:string Ambigous <string, unknown> unknown >
	 */
	public function getListeRechercheInterventionPersonnel()
	{
	
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Codepersonne','Nom','Prenom','Datenaissance','Adresse', 'id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pers' => 'personnel2'))->columns(array('Codepersonne'=>'id_personne','Nom'=>'nom','Prenom'=>'prenom','Datenaissance'=>'date_naissance','Sexe'=>'sexe','Adresse'=>'adresse','Nationalite'=>'nationalite','Typepersonnel'=>'type_personnel','id'=>'id_personne'))
		->where(array('etat' => 1));
	
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en fran�ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Pr�parer la liste
		*/
		foreach ( $rResult as $aRow )
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Nom'){
						$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
					}
	
					else if ($aColumns[$i] == 'Datenaissance') {
						$row[] = $Control->convertDate($aRow[ $aColumns[$i] ]);
					}
	
					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
					}
	
					else if ($aColumns[$i] == 'id') {
						$html  ="<a href='javascript:affichervue(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 25%;' src='".$tabURI[0]."public/images_icons/vue.png' title='détails'></a>";
	
						$html .="<a href='javascript:intervention(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 5%;' src='".$tabURI[0]."public/images_icons/suivant.png' title='intervention'></a>";
	
						$html .="<input type='hidden' value='".$aRow[ 'Typepersonnel' ]."'>";
	
						$row[] = $html;
					}
	
					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}
	
				}
			}
	
			$output['aaData'][] = $row;
		}
	
		return $output;
	}
	
	/**
	 * POUR LA LISTE DES AGENTS AYANT EFFECTUEE AU MOINS UNE INTERVENTION 
	 */
	public function getListeInterventionPersonnel()
	{
	
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'Adresse', 'Nationalite', 'id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pers' => 'personnel2'))->columns(array('Nom'=>'nom','Prenom'=>'prenom','Datenaissance'=>'date_naissance','Sexe'=>'sexe','Adresse'=>'adresse','Nationalite'=>'nationalite','Typepersonnel'=>'type_personnel','id'=>'id_personne'))
		->where(array('etat' => 1));
		$sQuery->join ( array (
				'i' => 'intervention'
		), 'pers.id_personne = i.id_personne', array ('*') );
		$sQuery->group('i.id_personne');
	
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en fran�ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Pr�parer la liste
		*/
		foreach ( $rResult as $aRow )
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Nom'){
						$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
					}
	
					else if ($aColumns[$i] == 'Datenaissance') {
						$row[] = $Control->convertDate($aRow[ $aColumns[$i] ]);
					}
	
					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
					}
						
	
					else if ($aColumns[$i] == 'id') {
						$html  ="<a href='javascript:affichervue(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 25%;' src='".$tabURI[0]."public/images_icons/vue.png' title='détails'></a>";
	
						$html .="<a id='".$aRow[ $aColumns[$i] ]."' href='javascript:supprimerintervention(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline;' src='".$tabURI[0]."public/images_icons/trash_16.PNG' title='Supprimer'></a>";
	
						$html .="<input type='hidden' value='".$aRow[ 'Typepersonnel' ]."'>";
	
						$row[] = $html;
					}
	
					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}
	
				}
			}
	
			$output['aaData'][] = $row;
		}
	
		return $output;
	}
	
	public function getListeInterventions($id_personne){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$sQuery = $sql->select('intervention');
		$sQuery->columns(array('*'));
		$sQuery->where(array('id_personne' => $id_personne));
		//$sQuery->order('numero_intervention DESC');
		
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
		
		return $result;
	}
	
}