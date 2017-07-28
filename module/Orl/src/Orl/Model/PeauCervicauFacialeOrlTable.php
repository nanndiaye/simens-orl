<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Facturation\View\Helper\DateHelper;


class PeauCervicauFacialeOrlTable {

	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getPeauCervicauFaciale($id_cons){
		$rowset = $this->tableGateway->select ( array (
				'id_cons' => $id_cons
		) );
		
		if (! $rowset->current()) {
			return null;
		}
		return get_object_vars($rowset->current());
	}
	
	public function addPeauCervicauFacialeOrl($data, $id_cons, $id_employe_e){	
		$today = new \DateTime ();
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		$donnees = array(
				'id_cons' => $id_cons,
				'depigmentation_artificielle' => $data->depigmentation_artificielle,
				'cicatrices_taches_fistules' => $data->cicatrices_taches_fistules,
				'date_enregistrement' => $date_enregistrement,
				'id_employe_e' => $id_employe_e,
		);
		//var_dump($donnees);exit();
		$this->tableGateway->insert( $donnees );
	}
	public function deletePeauCervicauFaciale($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}
}