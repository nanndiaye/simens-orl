<?php
namespace Consultation\View\Helpers;

use ZendPdf;
use ZendPdf\Page;
use ZendPdf\Font;
use Consultation\Model\Consultation;
use Facturation\View\Helper\DateHelper; 


class TraitementChirurgicalPdf
{
	protected $_page;
	protected $_yPosition;
	protected $_leftMargin;
	protected $_pageWidth;
	protected $_pageHeight;
	protected $_normalFont;
	protected $_boldFont;
	protected $_newTime;
	protected $_newTimeGras;
	protected $_year;
	protected $_headTitle;
	protected $_introText;
	protected $_graphData;
	protected $_patient;
	protected $_id_cons;
	protected $_date;
	protected $_note;
	protected $_idPersonne;
	protected $_Medicaments;
	protected $_DonneesPatient;
	protected $_DonneesMedecin;
	protected $_DonneesDemande;
	protected $_policeContenu;
	protected $_newPolice;
	protected $_Service;
	
	public function __construct()
	{
		$this->_page = new Page(650,700);
		
 		$this->_yPosition = 610;
 		$this->_leftMargin = 50;
 		$this->_pageHeight = $this->_page->getHeight();
 		$this->_pageWidth = $this->_page->getWidth();
 		/**
 		 * Pas encore utilis�
 		 */
 		$this->_normalFont = Font::fontWithName( ZendPdf\Font::FONT_HELVETICA);
 		$this->_boldFont = Font::fontWithName( ZendPdf\Font::FONT_HELVETICA_BOLD);
 		/**
 		 ***************** 
 		 */
 		$this->_newTime = Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
 		$this->_newTimeGras = Font::fontWithName(ZendPdf\Font::FONT_TIMES_BOLD);
 		$this->_policeContenu = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_COURIER);
 		$this->_newPolice = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES);
	}
	
	public function getPage(){
		return $this->_page;
	}
	
	public function addNoteTC(){
		$this->_page->saveGS();
		
		$this->setEnTete();
		$this->getNoteTC();
		$this->getPiedPage();
		
		$this->_page->restoreGS();
	}
	
	public function setEnTete(){
		$imageHeader = ZendPdf\Image::imageWithPath('C:\wamp\www\simens\public\img\polycliniquelogo.png');
		$this->_page->drawImage($imageHeader, 505, //-x
				$this->_pageHeight - 130, //-y
				600, //+x
				650); //+y
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('R�publique du S�n�gal',
				$this->_leftMargin,
				$this->_pageHeight - 50);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Minist�re de la sant� et de l\'action sociale',
				$this->_leftMargin,
				$this->_pageHeight - 65);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Polyclinique de l\'UGB de Saint-Louis',
				$this->_leftMargin,
				$this->_pageHeight - 80);
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Service: '.iconv ('UTF-8' ,'ISO-8859-1' ,$this->_Service),
				$this->_leftMargin,
				$this->_pageHeight - 95);
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
		$this->_page->setFont($font, 8);
		$today = new \DateTime ();
		$dateNow = $today->format ( 'd/m/Y' );
		$this->_page->drawText('Saint-Louis le, ' . $dateNow, 510,
				$this->_pageHeight - 50);
		
		$this->_yPosition -= 35;
		$this->_page->setFont($this->_newTime, 15);
		$this->_page->setFillColor(new ZendPdf\Color\Html('green'));
		$this->_page->drawText('Demande de visite pr�-anesth�sique',
				$this->_leftMargin+170,
				$this->_yPosition);
		$this->_yPosition -= 5;
		$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
		$this->_page->setLineWidth(1);
		$this->_page->drawLine($this->_leftMargin,
				$this->_yPosition,
				$this->_pageWidth -
				$this->_leftMargin,
				$this->_yPosition);
		$this->_yPosition -= 15;
	}
	
	public function setDonneesPatientTC($donneesPatient){
		$this->_DonneesPatient = $donneesPatient;
	}
	
	public function setDonneesMedecinTC($donneesMedecin){
		$this->_DonneesMedecin = $donneesMedecin;
	}
	
	public function setDonneesDemandeTC($donneesDemande){
		$this->_DonneesDemande = $donneesDemande;
	}

	public function setService($service){
		$this->_Service = $service;
	}
	
	public function setIdConsTC($id_cons){
		$this->_id_cons = $id_cons;
	}
	
	public function getNewItalique(){
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_HELVETICA_OBLIQUE);
		$this->_page->setFont($font, 12);
	}
	
	public function getNewTime(){
		$font = ZendPdf\Font::fontWithName(ZendPdf\Font::FONT_TIMES_ROMAN);
		$this->_page->setFont($font, 12);
	}
	
	protected function scinderText($Text){
		$tab = array();
		$tab[1] = substr($Text, 0, 50);
		$tab[2] = substr($Text, 50, 60);
		$tab[3] = substr($Text, 110, 60);
		return $tab;
	}
	
	protected function nbAnnees($debut, $fin) {
		//60 secondes X 60 minutes X 24 heures dans une journee
		$nbSecondes = 60*60*24*365;
	
		$debut_ts = strtotime($debut);
		$fin_ts = strtotime($fin);
		$diff = $fin_ts - $debut_ts;
		return (int)($diff / $nbSecondes);
	}
	
	protected  function getNoteTC(){
		//\Zend\Debug\Debug::dump($this->_DonneesPatient); exit();
		$Control = new DateHelper();
		$noteLineHeight = 30;
		$this->_page->setFillColor(new ZendPdf\Color\Html('black')); //Pour le text
		
		$this->_page->setLineColor(new ZendPdf\Color\Html('#999999')); //Pour les ligne
		$this->_page->setLineWidth(0.2);
		$this->_page->setLineDashingPattern(array(0, 0));
		
		$today = new \DateTime();
		$date_actu = $today->format('Y-m-d');

			//-----------------------------------------------
			$this->_page->setFont($this->_newTimeGras, 9);
			$this->_page->drawText('PRENOM & NOM :',
					$this->_leftMargin+155,
					$this->_yPosition);
			$this->_page->setFont($this->_newTime, 11);
			$this->_page->drawText($this->_DonneesPatient['PRENOM'].' '.$this->_DonneesPatient['NOM'],
					$this->_leftMargin+240,
					$this->_yPosition);
			//-----------------------------------------------
			$this->_yPosition -= 15;// allez a ligne suivante
			//----- -----------------------------------------
			$this->_page->setFont($this->_newTimeGras, 9);
			$this->_page->drawText('SEXE :',
					$this->_leftMargin+205,
					$this->_yPosition);
			$this->_page->setFont($this->_newTime, 11);
			$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' ,$this->_DonneesPatient['SEXE']),
					$this->_leftMargin+240,
					$this->_yPosition);
			
 			//-----------------------------------------------
			$this->_yPosition -= 15;// allez a ligne suivante
			//----- -----------------------------------------
			$this->_page->setFont($this->_newTimeGras, 9);
			$this->_page->drawText('DATE DE NAISSANCE :',
					$this->_leftMargin+135,
					$this->_yPosition);
			$this->_page->setFont($this->_newTime, 11);
			$this->_page->drawText($Control->convertDate($this->_DonneesPatient['DATE_NAISSANCE'])."  (".$this->nbAnnees($this->_DonneesPatient['DATE_NAISSANCE'],$date_actu)." ans)",
					$this->_leftMargin+240,
					$this->_yPosition);
			
			//-----------------------------------------------
			$this->_yPosition -= 15;// allez a ligne suivante
			//----- -----------------------------------------
			$this->_page->setFont($this->_newTimeGras, 9);
			$this->_page->drawText('ADRESSE :',
					$this->_leftMargin+187,
					$this->_yPosition);
			$this->_page->setFont($this->_newTime, 11);
			$this->_page->drawText(iconv ('UTF-8' ,'ISO-8859-1' ,$this->_DonneesPatient['ADRESSE']),
					$this->_leftMargin+240,
					$this->_yPosition);
			
			
			$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
			$this->_page->setLineWidth(1);
			$this->_page->setLineDashingPattern(array(0, 0));
			$this->_page->drawLine($this->_leftMargin,
					$this->_yPosition-10,
					$this->_pageWidth -
					$this->_leftMargin,
					$this->_yPosition-10);
			
		$this->_yPosition -= $noteLineHeight+10;//aller a la ligne suivante
		
		$l = 1;
		$i = 0;
		$d = 1;
		//PREPARATION DU TEXT Diagnostic
		$tab = $this->scinderText($this->_DonneesDemande['diagnostic']);
		//PREPARATION DU TEXT Observation
		$tab2 = $this->scinderText($this->_DonneesDemande['observation']);
		
		while($this->_yPosition > 70 ) {
			if($i==0){
				$this->_page->setFont($this->_newTimeGras, 13);
				$this->_page->drawText('Diagnostic :   ',
						$this->_leftMargin,
						$this->_yPosition);
				$this->_page->setFont($this->_policeContenu, 14);
				$this->_page->drawText($tab[1],
						$this->_leftMargin+80,
						$this->_yPosition);
			}
			if($i==1){
				$this->_page->setFont($this->_policeContenu, 14);
				$this->_page->drawText($tab[2],
						$this->_leftMargin,
						$this->_yPosition);
			}
			if($i==2){
				$this->_page->setFont($this->_policeContenu, 14);
				$this->_page->drawText($tab[3],
						$this->_leftMargin,
						$this->_yPosition);
			}
			if($i==3){
				$this->_page->setFont($this->_newTimeGras, 13);
				$this->_page->drawText('Intervention pr�vue :   ',
						$this->_leftMargin,
						$this->_yPosition);
				$this->_page->setFont($this->_policeContenu, 14);
				$this->_page->drawText($this->_DonneesDemande['intervention_prevue'],
						$this->_leftMargin+125,
						$this->_yPosition);
			}
			if($i==4){
				$this->_page->setFont($this->_newTimeGras, 13);
				$this->_page->drawText('Type d\'anesth�sie :   ',
						$this->_leftMargin,
						$this->_yPosition);
				$this->_page->setFont($this->_policeContenu, 14);
				$this->_page->drawText("",
						$this->_leftMargin+120,
						$this->_yPosition);
			}
			if($i==5){
				$this->_page->setFont($this->_newTimeGras, 13);
				$this->_page->drawText('VPA N� :  ',
						$this->_leftMargin,
						$this->_yPosition);
				$this->_page->setFont($this->_policeContenu, 14);
				$this->_page->drawText("",
						$this->_leftMargin+60,
						$this->_yPosition);
			}
			if($i==6){
				$this->_page->setFont($this->_newTimeGras, 13);
				$this->_page->drawText('Observation :  ',
						$this->_leftMargin,
						$this->_yPosition);
				$this->_page->setFont($this->_policeContenu, 14);
				$this->_page->drawText($tab2[1],
						$this->_leftMargin+90,
						$this->_yPosition);
			}
			if($i==7){
				$this->_page->setFont($this->_policeContenu, 14);
				$this->_page->drawText($tab2[2],
						$this->_leftMargin,
						$this->_yPosition);
			}
			if($i==8){
				$this->_page->setFont($this->_policeContenu, 14);
				$this->_page->drawText($tab2[3],
						$this->_leftMargin,
						$this->_yPosition);
			}
			$i++;
				$this->_page->setlineColor(new ZendPdf\Color\Html('gray'));
				$this->_page->setLineWidth(0.7);
				$this->_page->setLineDashingPattern(array(1, 2));
				$this->_page->drawLine($this->_leftMargin,
						$this->_yPosition,
						$this->_pageWidth -
						$this->_leftMargin,
						$this->_yPosition);
			$this->_yPosition -= $noteLineHeight;
		}
		
		$this->_page->setFont($this->_policeContenu, 14);
		$this->_page->drawText($this->_DonneesMedecin['prenomMedecin'] .' '. $this->_DonneesMedecin['nomMedecin'],
				$this->_leftMargin+370,
				$this->_yPosition+90);
// 		$this->_page->setFont($this->_policeContenu, 14);
// 		$this->_page->drawText($this->_DonneesMedecin['nomMedecin'],
// 				$this->_leftMargin+490,
// 				$this->_yPosition+90);
	} 
	
	public function getPiedPage(){
		$this->_yPosition -= -30;
		$this->_page->setlineColor(new ZendPdf\Color\Html('green'));
		$this->_page->setLineWidth(1.5);
		$this->_page->setLineDashingPattern(array(0, 0));		
		$this->_page->drawLine($this->_leftMargin,
						$this->_yPosition,
						$this->_pageWidth -
						$this->_leftMargin,
						$this->_yPosition);
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('T�l�phone: 33 726 25 36   BP: 24000',
				$this->_leftMargin,
				$this->_pageWidth - ( $this->_yPosition + 503));
		
		$this->_page->setFont($this->_newTime, 10);
		$this->_page->drawText('Consultation num�ro: ',
				$this->_leftMargin + 370,
				$this->_pageWidth - ( $this->_yPosition + 503));
		$this->_page->setFont($this->_newTimeGras, 11);
		$this->_page->drawText($this->_id_cons,
				$this->_leftMargin + 465,
				$this->_pageWidth - ( $this->_yPosition + 503));
	}
	
}