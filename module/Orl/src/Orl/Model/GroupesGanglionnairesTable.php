<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Facturation\View\Helper\DateHelper;

class GroupesGanglionnairesTable {

	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getGroupesGanglionnaires($id_cons){
		$rowset = $this->tableGateway->select ( array (
				'id_cons' => $id_cons
		) );
	    $rowset  =	$rowset->current();
		if (! $rowset) {
			return null;
		}
		return get_object_vars($rowset);
	}
	
	public function addGroupesGanglionnaires($data, $id_cons, $id_employe_e){
		$today = new \DateTime ();
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		$donnees = array(
				'id_cons' => $id_cons,
				'groupeI' => $data->groupeI,
				'groupeIIa' => $data->groupeIIa,
				'groupeIIb' => $data->groupeIIb,
				'groupeIII' => $data->groupeIII,
				'groupeVI' => $data->groupeVI,
				'groupeV' => $data->groupeV,
				'groupeIV' => $data->groupeIV,
				'libre' => $data->libre,
				'atteinte' => $data->atteinte,
				
				'date_enregistrement' => $date_enregistrement,
				'id_employe_e' => $id_employe_e,
		);
		$this->tableGateway->insert( $donnees );	
	}
	public function deleteGroupesGanglionnaires($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}
	
}