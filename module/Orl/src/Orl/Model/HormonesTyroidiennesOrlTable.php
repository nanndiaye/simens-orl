<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;

class HormonesTyroidiennesOrlTable {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getHormonesTyroidiennes($id_cons){
		$rowset = $this->tableGateway->select ( array (
				'id_cons' => $id_cons
		) );
		$rowset = $rowset->current();
		if (! $rowset) {
			return null;
		}
		return get_object_vars($rowset);
	}
	public function addHormonesTyroidiennesOrl($data, $id_cons, $id_employe_e){
		$today = new \DateTime ();
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		$donnees = array(
				'id_cons' => $id_cons,
				't4' => $data->t4,
				'tsh' => $data->tsh,
				'groupeIIIa' => $data->groupeIIIa,
				'groupeIIIb' => $data->groupeIIIb,
				'groupeIIIc' => $data->groupeIIIc,
				'cytologie' => $data->cytologie,
				'autres' => $data->autres,	
				'echographie_cervicale' => $data->echographie_cervicale,
				'date_enregistrement' => $date_enregistrement,
				'id_employe_e' => $id_employe_e,
		);
		$this->tableGateway->insert( $donnees );
	}
	public function deleteHormonesTyroidiennes($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}
}