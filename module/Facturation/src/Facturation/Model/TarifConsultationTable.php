<?php
namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class TarifConsultationTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getActe($id) {
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'ID_TARIF_CONSULTATION' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	
	public function fetchService()
	{
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql($adapter);
		$select = $sql->select('tarif_consultation');
		$select->columns(array('ID_TARIF_CONSULTATION', 'LIBELLE'));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['ID_TARIF_CONSULTATION']] = $data['LIBELLE'];
		}
		return $options;
	}

	public function listeService(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'service'));
		$select->columns(array('ID_SERVICE','NOM'));
		$select->where(array('DOMAINE' => 'MEDECINE'));
		$select->order('ID_SERVICE ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['ID_SERVICE']] = $data['NOM'];
		}
		return $options;
	}
	
	public function listeMedecins(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('e'=>'employe'));
		$select->columns(array('Id_personne','id_personne'));
		$select->join(array('p' => 'personne') , 'p.ID_PERSONNE = e.id_personne' , array('Nom' => 'NOM', 'Prenom' => 'PRENOM'));
		$select->join(array('t' => 'type_employe') , 't.id = e.id_type_employe' , array('*'));
		$select->where(array('t.id' => 1));
		$select->order('e.id_personne ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['Id_personne']] = $data['Prenom'].' '.$data['Nom'];
		}
		return $options;
	}
	
	public function getServiceMedecin($id_medecin){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('e'=>'employe'));
		$select->columns(array('id_personne'));
		$select->join(array('s' => 'service_employe') , 's.id_employe = e.id_personne' , array('Id_service' => 'id_service'));
		$select->where(array('e.id_personne' => $id_medecin));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
		return $result;
	}
	
	
	public function TarifDuService($id_service){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('s'=>'service'));
		$select->columns(array('*'));
		$select->where(array('ID_SERVICE' => $id_service));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
		return $result;
	}
	
}