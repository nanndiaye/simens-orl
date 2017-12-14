<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;


class DonneesExamenCliniqueTable {
	protected $tableGateway;

	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	
	public function getDonneesExamenClinique($id_cons){
		$rowset = $this->tableGateway->select ( array (
				'id_cons' => $id_cons
		) );
		$rowset = $rowset->current();
		if (! $rowset) {
			return null;
		}
		return get_object_vars($rowset);
	}
	
	
	public function addDonneesExamenClinique($id_cons, $data){ //var_dump($data); exit();
		$today = new \DateTime ();
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		$donnees = array(
				'id_cons' => $id_cons,
				'examen_clinique' => $data->examen_clinique,
				'reste_examen_clinique' => $data->reste_examen_clinique,
				'examen_para_clinique' => $data->examen_para_clinique,
				);
				$this->tableGateway->insert( $donnees );
	}
	
	
	public function deleteDonneesExamenClinique($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}
	
	
}