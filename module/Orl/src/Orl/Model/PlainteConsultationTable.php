<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;


class PlainteConsultationTable {
	protected $tableGateway;

	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	
	public function getPlainteConsultation($id_cons){
		$rowset = $this->tableGateway->select ( array (
				'id_cons' => $id_cons
		) );
		$rowset = $rowset->current();
		if (! $rowset) {
			return null;
		}
		return get_object_vars($rowset);
	}
	
	
	public function addPlainteConsultation($id_cons, $data){ //var_dump($data); exit();
		$today = new \DateTime ();
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		$donnees = array(
				'id_cons' => $id_cons,
				'plainte_motif' => $data->plainte_motif,
				
				);
				$this->tableGateway->insert( $donnees );
	}
	
	
	public function deletePlainteConsultation($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}
	
	
}