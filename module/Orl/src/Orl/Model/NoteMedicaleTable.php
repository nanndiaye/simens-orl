<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;


class NoteMedicaleTable {
	protected $tableGateway;

	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	
	public function getNoteMedicale($id_cons){
		$rowset = $this->tableGateway->select ( array (
				'id_cons' => $id_cons
		) );
		$rowset = $rowset->current();
		if (! $rowset) {
			return null;
		}
		return get_object_vars($rowset);
	}
	
	
	public function addNoteMedicale($id_cons, $data){ //var_dump($data); exit();
		$today = new \DateTime ();
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		$donnees = array(
				'id_cons' => $id_cons,
				'nouvelle_note_medicale' => $data->nouvelle_note_medicale,
				
				);
				$this->tableGateway->insert( $donnees );
	}
	
	
	public function deleteNoteMedicale($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}
	
	
}