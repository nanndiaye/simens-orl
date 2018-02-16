<?php

namespace Orl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Orl\Form\PatientForm;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Zend\Form\View\Helper\FormRow;
use Zend\Form\View\Helper\FormInput;
use Orl\View\Helpers\DateHelper;
use Zend\Json\Json;
use Zend\Db\Sql\Sql;
use Orl\Form\AdmissionForm;
use Orl\Form\ConsultationForm;
use Facturation\View\Helper\FactureActePdf;

class MajorController extends AbstractActionController {
	
	protected $patientTable;
	protected $formPatient;
	protected $dateHelper;
	protected $admissionTable;
	protected $serviceTable;
	protected $tarifConsultationTable;
	protected $consultationTable;
	protected $rvPatientConsTable;
	protected $ConsultationTable;
	protected $typeAdmissionTable;

	public function testAction(){
		
	}
}