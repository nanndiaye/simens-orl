<?php
namespace Orl\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class NotesExamensBiologiquesTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getNotesExamensBiologiques($id_cons){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->columns(array('*'));
		$select->from(array('nemb'=>'note_examen_biologique'));
		$select->where(array('nemb.id_cons' => $id_cons));
		$select->order('nemb.code_bio ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();

		$tab = array('groupe_sanguin'=>'','hemogramme_sanguin'=>'','bilan_hepatique'=>'','bilan_renal'=>'','bilan_hemolyse'=>'','bilan_inflammatoire'=>'');

		foreach ($result as $donnes){
			if($donnes['id_examen'] == 1 ){ $tab['groupe_sanguin']       = $donnes['note_bio'];}
			if($donnes['id_examen'] == 2 ){ $tab['hemogramme_sanguin']  = $donnes['note_bio'];}
			if($donnes['id_examen'] == 3){ $tab['bilan_hepatique'] = $donnes['note_bio'];}
			if($donnes['id_examen'] == 4){ $tab['bilan_renal']     = $donnes['note_bio'];}
			if($donnes['id_examen'] == 5){ $tab['bilan_hemolyse']         = $donnes['note_bio'];}
			if($donnes['id_examen'] == 6){ $tab['bilan_inflammatoire']         = $donnes['note_bio'];}

		}
		return $tab;
	}
	public function updateNotesExamensBiologiques($donnees)
	{
		$this->tableGateway->delete(array('id_cons' => $donnees['id_cons']));

		for($i=1; $i<7; $i++){
			if($donnees[$i]){
				$dataNotesExamensBio	 = array(
						'id_cons'    => $donnees['id_cons'],
						'id_examen' => $i,
						'note_bio'      => $donnees[$i],
				);
				$this->tableGateway->insert($dataNotesExamensBio);
			}
		}
	}
}
