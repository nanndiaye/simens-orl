<?php

namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;


class SousDossierTable{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function getSousDossierAffectation($id){
		$id = ( int ) $id;
		$select = $this->tableGateway->select(array('id_sous_dossier' => $id));
		$sous_dossierRow = $select->current();
		if (! $sous_dossierRow) {
			return null;
		}
		return $sous_dossierRow;
	}
	
	public function listeSousDossier(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'sous_dossier'));
		$select->columns(array('type_dossier'));
		//$select->where(array('DOMAINE' => 'MEDECINE'));
		$select->order('id_sous_dossier ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['type_dossier']] = $data['type_dossier'];
		}
		return $options;
	}
	
	public function fetchSousDossier()
	{
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql($adapter);
		$select = $sql->select('sous_dossier');
		$select->columns(array('id_sous_dossier', 'type_dossier'));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		
		$options = array(null => 'Choisir un sous dossier');
		foreach ($result as $data) {
			$options[$data['id_sous_dossier']] = $data['type_dossier'];
		}
		return $options;
	}
	
	public function addSousDossier($data, $id_cons, $id_employe_e){
		$today = new \DateTime ();
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		$donnees = array(
				'id_cons' => $id_cons,
				
		);
		$this->tableGateway->insert( $donnees );
	}
	
	public function deleteSousDossier($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}



}