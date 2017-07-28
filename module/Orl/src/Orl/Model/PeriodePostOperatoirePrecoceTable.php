<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;


class PeriodePostOperatoirePrecoceTable {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getPeriodePostOperatoirePrecoce($id_cons){
		$rowset = $this->tableGateway->select ( array (
				'id_cons' => $id_cons
		) );
		$rowset = $rowset->current();
		if (! $rowset) {
			return null;
		}
		return get_object_vars($rowset);
	}
	public function addPeriodePostOperatoirePrecoce($data, $id_cons, $id_employe_e){
		$today = new \DateTime ();
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		
		$donnees = array(
				'id_cons' => $data->id_cons,
				'calcemie' => $data->calcemie,
				'laryngectomie_indirecte' => $data->laryngectomie_indirecte,
				'ablation_drain' => $data->ablation_drain,
				'ablation_fil' => $data->ablation_fil,
				'accident_hemoragie' => $data->accident_hemoragie,
				'accident_infectieux' => $data->accident_infectieux,
				'autresAccident' => $data->autresAccident,				
				'date_enregistrement' => $date_enregistrement,
				'id_employe_e' => $id_employe_e,
		);
		//var_dump($donnees);exit();
		$this->tableGateway->insert( $donnees );
	}
	
	public function deletePeriodePostOperatoirePrecoce($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}
}