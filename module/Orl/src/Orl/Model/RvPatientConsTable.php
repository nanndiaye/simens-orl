<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\XmlRpc\Value\String;
use Doctrine\Tests\Common\Annotations\Null;
use Orl\View\Helpers\DateHelper;

class RvPatientConsTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getRendezVous($id){
		$rowset = $this->tableGateway->select ( array (
				'ID_CONS' => $id
		) );
		
		$row =  $rowset->current ();
		if (! $row) { 
 			//throw new \Exception ( "Could not find row $id" );
 			return $row;
 		}
		return $row;
	}
	
	public function getTousRendezVous(){
		$rowset = $this->tableGateway->select ();
	
		$row =  $rowset->current ();
		if (! $row) {
			//throw new \Exception ( "Could not find row $id" );
			return null;
		}
		return $rowset;
	}
	
	
	public function updateRendezVous($infos_rv){
		$this->tableGateway->delete(array('ID_CONS'=>$infos_rv['ID_CONS']));
		
		//if($infos_rv['DATE'] && $infos_rv['HEURE']){
			$this->tableGateway->insert($infos_rv);
		//}
	}
	
	
	public function addRendezVous($infos_rv){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('rendezvous')
		->values( $infos_rv );
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
	}
	
	public function addRendezVousProgrammer($rv_programmer){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('rv_programmer')
		->values( $rv_programmer );
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function addRendezVousFixer($rv_consultation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('rv_consultation')
		->values( $rv_consultation );
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function getRendezVousProgrammer($id_rv){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('rv' => 'rendezvous'))->columns(array('*'))
		->where(array('ID_RV' => $id_rv));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
	
	public function updateRendezVousProgrammer($infos_rv, $id_rv){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update()
		->table('rendezvous')->set( $infos_rv )
		->where(array('ID_RV' => $id_rv ));
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	
	
	
	
	
	public function getFixerRV(){
		
		
		
		//$today = new \DateTime ( 'now' );
		//mettre la variable qui permet de r�cup�rer la date d'aujourd'hui et de le mettre dans la clause where $today = new \DateTime ( 'now' );
		//$comp_date=$this->controlDate->convertDate($leRendezVous->date);
		$db = $this->tableGateway->getAdapter();
		$aColumns = array('NUMERO_DOSSIER', 'Nom','Prenom','Age','Sexe', 'Adresse', 'Nationalite', 'id', 'id2');
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
		->from(array('pat' => 'patient'))->columns(array('*'))
		//->from(array('a' => 'admission'))->columns(array('*'))
		->join(array('p' => 'personne'), 'pat.id_personne = p.id_personne' , array('Nom'=>'NOM','Prenom'=>'PRENOM','Datenaissance'=>'DATE_NAISSANCE','Sexe'=>'SEXE','Adresse'=>'ADRESSE','Nationalite'=>'NATIONALITE_ACTUELLE','Taille'=>'TAILLE','id'=>'ID_PERSONNE', 'id2'=>'ID_PERSONNE', 'Age'=>'AGE'))
		//->join(array('a' => 'admission'), 'p.ID_PERSONNE = a.id_patient', array('Id_admission' => 'id_admission'))
		->join(array('cons' => 'consultation'), 'p.ID_PERSONNE = cons.ID_PATIENT', array('Id_cons' => 'ID_CONS'))
		->join(array('rv' => 'rendezvous_consultation') , 'rv.ID_CONS = cons.ID_CONS', array('delai' => 'DELAI'))
		->order('rv.HEURE_ENR ASC')
		->where(array( 'rv.DATE' => null));
		//->where(array( 'rv.$comp_date' => '00/00/0000'));
		
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
		
						$date_naissance = $aRow[ $aColumns[$i] ];
						if($date_naissance){ $row[] = $Control->convertDate($aRow[ $aColumns[$i] ]); }else{ $row[] = null;}
					}
					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $aRow[ $aColumns[$i] ];
					}
					else if ($aColumns[$i] == 'id') {
		
						$html ="<infoBulleVue> <a href='".$tabURI[0]."public/secretariat/info-patient-rv?id_cons=".$aRow[ 'Id_cons' ]."&id_patient=".$aRow[ $aColumns[$i] ]."'>";
						$html .="<img style='display: inline; margin-right: 10%;' src='".$tabURI[0]."public/images_icons/voir2.png' title='d&eacute;tails'></a></infoBulleVue>";
		
						//$html .= "<infoBulleVue> <a href='".$tabURI[0]."public/secretariat/modifier/id_patient/".$aRow[ $aColumns[$i] ]."'>";
						//$html .="<img style='display: inline; margin-right: 10%;' src='".$tabURI[0]."public/images_icons/pencil_16.png' title='Modifier'></a></infoBulleVue>";
		
						// 						if(!$this->verifierExisteAdmission($aRow[ $aColumns[$i] ])){
						// 							$html .= "<infoBulleVue> <a id='".$aRow[ $aColumns[$i] ]."' href='javascript:supprimer(".$aRow[ $aColumns[$i] ].");'>";
						// 							$html .="<img style='display: inline;' src='".$tabURI[0]."public/images_icons/symbol_supprimer.png' title='Supprimer'></a></infoBulleVue>";
						// 						}
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
	
	
	
	
	
	
	
	public function getRvProgrammer($id_rv){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('rvp' => 'rv_programmer'))->columns( array( '*' ))
		->where(array('ID_RV'  => $id_rv));
	
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
	
	

	public function getRvConsultation($id_rv){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('rvc' => 'rv_consultation'))->columns( array( '*' ))
		->where(array('ID_RV'  => $id_rv));
	
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
	
	
	
	
	public function getTousRV(){
		$db = $this->tableGateway->getAdapter();
		$aColumns = array('NUMERO_DOSSIER', 'Nom','Prenom','Age','Sexe', 'Adresse', 'date', 'id', 'id2');
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
		$sql2 = new Sql($db);
		$sQuery2 = $sql2->select()
		->from(array('pat' => 'patient'))->columns(array('*'))
		->join(array('p' => 'personne'), 'pat.id_personne = p.id_personne' , array('Nom'=>'NOM','Prenom'=>'PRENOM','Datenaissance'=>'DATE_NAISSANCE','Sexe'=>'SEXE','Adresse'=>'ADRESSE','Nationalite'=>'NATIONALITE_ACTUELLE','Taille'=>'TAILLE','id'=>'ID_PERSONNE', 'id2'=>'ID_PERSONNE', 'Age'=>'AGE'))
		->join(array('rv' => 'rendezvous') , 'rv.ID_PATIENT = p.id_personne', array('id_rv' => 'ID_RV', 'delai' => 'DELAI', 'date' => 'DATE'))
		->order('rv.HEURE_ENREG ASC')
		->where(array( 'date != ?' => ''));
		
		/* Data set length after filtering */
		$stat = $sql2->prepareStatementForSqlObject($sQuery2);
		$rResultFt = $stat->execute();
		
		$rResult = $rResultFt;
		
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
		
					else if ($aColumns[$i] == 'date') {
		
						$date_rv = $aRow[ $aColumns[$i] ];
						if($date_rv){ $row[] = $Control->convertDate($aRow[ $aColumns[$i] ]); }else{ $row[] = null;}
					}
					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $aRow[ $aColumns[$i] ];
					}
					else if ($aColumns[$i] == 'id') {
		
						$html ="<infoBulleVue> <a href='".$tabURI[0]."public/secretariat/modifier-infos-patient-rv?id_rv=".$aRow[ 'id_rv' ]."&id_patient=".$aRow[ $aColumns[$i] ]."'>";
						$html .="<img style='display: inline; margin-left: 10%; margin-right: 20%;' src='".$tabURI[0]."public/images_icons/pencil_16.png' title='modifier'></a></infoBulleVue>";
		
						if($this->getRvProgrammer($aRow[ 'id_rv' ])){
							$html .= "<infoBulleVue>";
							$html .="<span style='display: inline; margin-right: 10%; font-family: Bradley Hand ITC; font-weight: bold; color: green;' title='Rv Programmer' > RP </span></infoBulleVue>";
						}else{
							$html .= "<infoBulleVue>";
							$html .="<span style='display: inline; margin-right: 10%; font-family: Bradley Hand ITC; font-weight: bold; color: green;' title='Rv Programmer' > RC </span></infoBulleVue>";
						}
						
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
	
	
	//NOUVEAUX CODES AJOUTES
	//NOUVEAUX CODES AJOUTES
	//NOUVEAUX CODES AJOUTES
	
	public function addInfosRendezVousConsultation($infos_rv, $id_cons){
		if(!$this->getRendezVousConsultation($id_cons)){
			if($infos_rv['DELAI']){
				$db = $this->tableGateway->getAdapter();
				$sql = new Sql($db);
				$sQuery = $sql->insert()
				->into('rendezvous')
				->values( $infos_rv );
				return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
			}
		}else{
			$rvcons = $this->getRendezVousConsultation($id_cons);
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->delete()->from('rendezvous')->where(array('ID_RV' => $rvcons['ID_RV']));
			$sql->prepareStatementForSqlObject($sQuery)->execute();
			if($infos_rv['DELAI']){
				$db = $this->tableGateway->getAdapter();
				$sql = new Sql($db);
				$sQuery = $sql->insert()
				->into('rendezvous')
				->values( $infos_rv );
				return $sql->prepareStatementForSqlObject($sQuery)->execute()->getGeneratedValue();
			}
		}
	}
	
	public function addRendezVousConsultation($rv_consultation, $id_rv){
		if(!$this->getRendezVousConsultation($rv_consultation['ID_CONS']) && $this->getInfosRendezVousConsultation($id_rv)){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('rv_consultation')
			->values( $rv_consultation );
			$sql->prepareStatementForSqlObject($sQuery)->execute();
		}
	}
	
	public function getRendezVousConsultation($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('rvc' => 'rv_consultation'))->columns(array('*'))
		->where(array('ID_CONS' => $id_cons));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
	
	public function getInfosRendezVousConsultation($id_rv){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('rvc' => 'rendezvous'))->columns(array('*'))
		->where(array('ID_RV' => $id_rv ));
		return $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
	
	
	
	public function fixerRendezVousConsultation(){
	
		$db = $this->tableGateway->getAdapter();
		$aColumns = array('NUMERO_DOSSIER', 'Nom','Prenom','Age','Sexe', 'Adresse', 'Nationalite', 'id', 'id2');
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
		->from(array('pat' => 'patient'))->columns(array('*'))
		->join(array('p' => 'personne'), 'pat.id_personne = p.id_personne' , array('Nom'=>'NOM','Prenom'=>'PRENOM','Datenaissance'=>'DATE_NAISSANCE','Sexe'=>'SEXE','Adresse'=>'ADRESSE','Nationalite'=>'NATIONALITE_ACTUELLE','Taille'=>'TAILLE','id'=>'ID_PERSONNE', 'id2'=>'ID_PERSONNE', 'Age'=>'AGE'))
		->join(array('cons' => 'consultation'), 'p.ID_PERSONNE = cons.ID_PATIENT', array('Id_cons' => 'ID_CONS'))
		->join(array('rvc' => 'rv_consultation') , 'rvc.ID_CONS = cons.ID_CONS', array('*'))
		->join(array('rv'  => 'rendezvous') , 'rv.ID_RV = rvc.ID_RV', array('Id_rv'=>'ID_RV'))
		->order('rv.HEURE_ENREG ASC')
		->where(array( 'rv.DATE' => null));
	
	
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
	
						$date_naissance = $aRow[ $aColumns[$i] ];
						if($date_naissance){ $row[] = $Control->convertDate($aRow[ $aColumns[$i] ]); }else{ $row[] = null;}
					}
					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $aRow[ $aColumns[$i] ];
					}
					else if ($aColumns[$i] == 'id') {
	
						$html ="<infoBulleVue> <a href='".$tabURI[0]."public/secretariat/info-patient-rv?id_cons=".$aRow[ 'Id_cons' ]."&id_patient=".$aRow[ $aColumns[$i] ]."'>";
						$html .="<img style='display: inline; margin-right: 10%;' src='".$tabURI[0]."public/images_icons/voir2.png' title='d&eacute;tails'></a></infoBulleVue>";
	
						//$html .= "<infoBulleVue> <a href='".$tabURI[0]."public/secretariat/modifier/id_patient/".$aRow[ $aColumns[$i] ]."'>";
						//$html .="<img style='display: inline; margin-right: 10%;' src='".$tabURI[0]."public/images_icons/pencil_16.png' title='Modifier'></a></infoBulleVue>";
	
						// 						if(!$this->verifierExisteAdmission($aRow[ $aColumns[$i] ])){
						// 							$html .= "<infoBulleVue> <a id='".$aRow[ $aColumns[$i] ]."' href='javascript:supprimer(".$aRow[ $aColumns[$i] ].");'>";
						// 							$html .="<img style='display: inline;' src='".$tabURI[0]."public/images_icons/symbol_supprimer.png' title='Supprimer'></a></infoBulleVue>";
						// 						}
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
	
}