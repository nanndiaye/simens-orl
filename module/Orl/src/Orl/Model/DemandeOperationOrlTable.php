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
				't3' => $data->t3,
				't4' => $data->t4,
				'tsh' => $data->tsh,
				'hyperthyroidie' => $data->hyperthyroidie,
				'euthyroidie' => $data->euthyroidie,
				'hypothyroide' => $data->hypothyroide,
				'cytologie' => $data->cytologie,
				'autres' => $data->autres,	
				'vpa' => $data->vpa,
				'date_enregistrement' => $date_enregistrement,
				'id_employe_e' => $id_employe_e,
		);
		$this->tableGateway->insert( $donnees );
	}
	public function deleteHormonesTyroidiennes($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}
}