<?php

namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;


class TypeAdmissionTable{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getTypeAdmissionAffectation($id){
		$id = ( int ) $id;
		$select = $this->tableGateway->select(array('id_type_admission' => $id));
		$type_admissionRow = $select->current();
		if (! $type_admissionRow) {
			return null;
		}
		return $type_admissionRow;
	}

	public function listeTypeAdmission(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('t'=>'type_admission'));
		$select->columns(array('type'));
	    //$select->where(array('DOMAINE' => 'MEDECINE'));
		//$select->where(array('type'=>'Normale'));
		$select->order('id_type_admission ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['type']] = $data['type'];
		}
		return $options;
	}

	public function fetchTypeAdmission()
	{
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql($adapter);
		$select = $sql->select('type_admission');
		$select->columns(array('id_type_admission', 'NOM'));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['id_type_admission']] = $data['NOM'];
		}
		return $options;
	}	
	

}