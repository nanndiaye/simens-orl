<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;
class ExamensComplementairesOrlTable {

	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getExamensComplementairesOrl($id_cons){

		
		$rowset = $this->tableGateway->select ( array (
				'id_cons' => $id_cons
		) );
		
		//var_dump("ssss");exit();
		$rowset  = $rowset->current();
		if (! $rowset) {
			return null;
		}
		return get_object_vars($rowset);
	}

	public function addExamensComplementairesOrl($data, $id_cons, $id_employe_e){
		$today = new \DateTime ();
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		$donnees = array(
				'id_cons' => $id_cons,
				'examen_complementaire' => $data->examen_complementaire,
				'date_enregistrement' => $date_enregistrement,
				'id_employe_e' => $id_employe_e,
		);
	
		$this->tableGateway->insert( $donnees );
	}	

	public function deleteExamensComplementairesOrl($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}	

}