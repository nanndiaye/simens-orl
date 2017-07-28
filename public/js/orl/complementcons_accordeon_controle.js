 var base_url = window.location.toString();
 var tabUrl = base_url.split("public");

 $(function(){
	$( "#accordionsssss").accordion();
	$( "#accordionsTyroide").accordion();
  });
  
  $(function(){
    $( "#accordionssss").accordion();
    $( "#accordionsss_exam_clinik").accordion();
    $( "#accordionsss_operation" ).accordion();
    
  });

  $(function() {
	$( "#accordions_resultat" ).accordion();
	$( "#accordions_demande" ).accordion();
	$( "#accordionsss" ).accordion();
  });

  $(function() {
		$( "#accordionsss_paraclinik" ).accordion();
	
	  });
  
  $(function() {
	$( "#accordionss" ).accordion();
  });

  $(function() {
    $( "#accordions" ).accordion();
  });
  
  
  function supprimer_dernier_caractere(elm) {
	  var val = $(elm).val();
	var cursorPos = elm.selectionStart;
	$(elm).val(
	   val.substr(0,cursorPos-1) + // before cursor - 1
	  val.substr(cursorPos,val.length) // after cursor
	);
	elm.selectionStart = cursorPos-1; // replace the cursor at the right place
	elm.selectionEnd = cursorPos-1;
 }

  $(function() {
  /***** Fonction Controle de saisie TEMPERATURE *****/
	 $('body').delegate('input.duree_traitement_ord','keyup',function(){
		    
		    if(!$(this).val().match(/^[0-9]{0,3}$/)) // 0-9 avec deux chiffres uniquement
		      supprimer_dernier_caractere(this);
    });
  });
  /*** FIN ***/
  
  
  
 
	  
	  function getThyroide(val){
			if(val==1){
				$("#thyroidet span span").html("<img src='../images_icons/tick-icon2.png' >");
			}else{
				$("#thyroidet span span").html("");
			}	
		}	 
	  
  

//********************* ANALYSE MORPHOLOGIQUE *****************************
//********************* ANALYSE MORPHOLOGIQUE *****************************
$(function(){
	var radio = $("#radio");
	var ecographie = $("#ecographie");
	var fibrocospie = $("#fibrocospie");
	var scanner = $("#scanner");
	var irm = $("#irm");
	
	//Au debut on affiche pas le bouton modifier
	$("#bouton_morpho_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_morpho_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	radio.attr( 'readonly', false);
	ecographie.attr( 'readonly', false);
	fibrocospie.attr( 'readonly', false);
	scanner.attr( 'readonly', false);
	irm.attr( 'readonly', false);
	
	$("#bouton_morpho_valider").click(function(){
		radio.attr( 'readonly', true).css({'background':'#f8f8f8'});
		ecographie.attr( 'readonly', true).css({'background':'#f8f8f8'});
		fibrocospie.attr( 'readonly', true).css({'background':'#f8f8f8'});
		scanner.attr( 'readonly', true).css({'background':'#f8f8f8'});
		irm.attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_morpho_modifier").toggle(true);
		$("#bouton_morpho_valider").toggle(false);
		return false;
	});
	
	$("#bouton_morpho_modifier").click(function(){
		radio.attr( 'readonly', false).css({'background':'#fff'});
		ecographie.attr( 'readonly', false).css({'background':'#fff'});
		fibrocospie.attr( 'readonly', false).css({'background':'#fff'});
		scanner.attr( 'readonly', false).css({'background':'#fff'});
		irm.attr( 'readonly', false).css({'background':'#fff'});
		
		$("#bouton_morpho_modifier").toggle(false);
		$("#bouton_morpho_valider").toggle(true);
		return false;
	});
	
});
  
  
//********************* TRAITEMENTS CHIRURGICAUX *****************************
//********************* TRAITEMENTS CHIRURGICAUX ***************************** 
//********************* TRAITEMENTS CHIRURGICAUX ***************************** 
$(function(){
	var diagnostic_traitement_chirurgical = $("#diagnostic_traitement_chirurgical");
	var intervention_prevue = $("#intervention_prevue");
	var observation = $("#observation");
	
	$("#chirurgical1").click(function(){
		diagnostic_traitement_chirurgical.attr( 'readonly', true).css({'background':'#f8f8f8'});
		intervention_prevue.attr( 'readonly', true).css({'background':'#f8f8f8'});
		observation.attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_chirurgical_modifier").toggle(true);
		$("#bouton_chirurgical_valider").toggle(false);	
	});
	
	//Au debut on affiche pas le bouton modifier, on l'affiche seulement apres impression
	$("#bouton_chirurgical_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_chirurgical_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	diagnostic_traitement_chirurgical.attr( 'readonly', false).css({'background':'#fff'});
	intervention_prevue.attr( 'readonly', false).css({'background':'#fff'});
	observation.attr( 'readonly', false).css({'background':'#fff'});
	
	$("#bouton_chirurgical_valider").click(function(){
		diagnostic_traitement_chirurgical.attr( 'readonly', true).css({'background':'#f8f8f8'});
		intervention_prevue.attr( 'readonly', true).css({'background':'#f8f8f8'});
		observation.attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_chirurgical_modifier").toggle(true);
		$("#bouton_chirurgical_valider").toggle(false);
		
		$("#annuler_traitement_chirurgical").attr('disabled', true);
		return false;
	});
	
	$("#bouton_chirurgical_modifier").click(function(){
		diagnostic_traitement_chirurgical.attr( 'readonly', false).css({'background':'#fff'});
		intervention_prevue.attr( 'readonly', false).css({'background':'#fff'});
		observation.attr( 'readonly', false).css({'background':'#fff'});
		
		$("#bouton_chirurgical_modifier").toggle(false);
		$("#bouton_chirurgical_valider").toggle(true);
		
		$("#annuler_traitement_chirurgical").attr('disabled', false);
		return false;
	});
	
});

//********************* TRAITEMENTS INSTRUMENTAUX *****************************
//********************* TRAITEMENTS INSTRUMENTAUX ***************************** 
//********************* TRAITEMENTS INSTRUMENTAUX ***************************** 
$(function(){
	var endoscopieInterventionnelle = $("#endoscopieInterventionnelle");
	var radiologieInterventionnelle = $("#radiologieInterventionnelle");
	var cardiologieInterventionnelle = $("#cardiologieInterventionnelle"); 
	var autresIntervention = $("#autresIntervention");
	
	$("#chirurgicalImpression").click(function(){
		endoscopieInterventionnelle.attr( 'readonly', true).css({'background':'#f8f8f8'});
		radiologieInterventionnelle.attr( 'readonly', true).css({'background':'#f8f8f8'});
		autresIntervention.attr( 'readonly', true).css({'background':'#f8f8f8'});
		cardiologieInterventionnelle.attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_chirurgical_modifier").toggle(true);
		$("#bouton_chirurgical_valider").toggle(false);	
	});
	
	$("#bouton_instrumental_modifier").toggle(false);
	$("#bouton_instrumental_valider").toggle(true);
	
	endoscopieInterventionnelle.attr( 'readonly', false).css({'background':'#fff'});
	radiologieInterventionnelle.attr( 'readonly', false).css({'background':'#fff'});
	autresIntervention.attr( 'readonly', false).css({'background':'#fff'});
	cardiologieInterventionnelle.attr( 'readonly', false).css({'background':'#fff'});
	
	$("#bouton_instrumental_valider").click(function(){
		endoscopieInterventionnelle.attr( 'readonly', true).css({'background':'#f8f8f8'});
		radiologieInterventionnelle.attr( 'readonly', true).css({'background':'#f8f8f8'});
		autresIntervention.attr( 'readonly', true).css({'background':'#f8f8f8'});
		cardiologieInterventionnelle.attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_instrumental_modifier").toggle(true);
		$("#bouton_instrumental_valider").toggle(false);
		
		$('#annuler_traitement_instrumental').attr('disabled', true);
		return false;
	});
	
	$("#bouton_instrumental_modifier").click(function(){
		endoscopieInterventionnelle.attr( 'readonly', false).css({'background':'#fff'});
		radiologieInterventionnelle.attr( 'readonly', false).css({'background':'#fff'});
		autresIntervention.attr( 'readonly', false).css({'background':'#fff'});
		cardiologieInterventionnelle.attr( 'readonly', false).css({'background':'#fff'});
		
		$("#bouton_instrumental_modifier").toggle(false);
		$("#bouton_instrumental_valider").toggle(true);
		
		$('#annuler_traitement_instrumental').attr('disabled', false);
		return false;
	});
	
	
	$('#annuler_traitement_instrumental').click(function(){
		endoscopieInterventionnelle.val('');
		radiologieInterventionnelle.val('');
		autresIntervention.val('');
		cardiologieInterventionnelle.val('');
		return false;
	});
	
	
	//COMPTE RENDU OPERATOIRE CHIRURGICAL
	//COMPTE RENDU OPERATOIRE CHIRURGICAL
	$("#bouton_compte_rendu_chirurgical_valider").toggle(true);
	$("#bouton_compte_rendu_chirurgical_modifier").toggle(false);
	
	$("#bouton_compte_rendu_chirurgical_valider").click(function(){
		$("#note_compte_rendu_operatoire").attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_compte_rendu_chirurgical_valider").toggle(false);
		$("#bouton_compte_rendu_chirurgical_modifier").toggle(true);
		
		return false;
	});
	
	$("#bouton_compte_rendu_chirurgical_modifier").click(function(){
		$("#note_compte_rendu_operatoire").attr( 'readonly', false).css({'background':'#fff'});
		
		$("#bouton_compte_rendu_chirurgical_valider").toggle(true);
		$("#bouton_compte_rendu_chirurgical_modifier").toggle(false);
		
		return false;
	});
	
	//COMPTE RENDU OPERATOIRE INSTRUMENTAL
	//COMPTE RENDU OPERATOIRE INSTRUMENTAL
	$("#bouton_compte_rendu_instrumental_valider").toggle(true);
	$("#bouton_compte_rendu_instrumental_modifier").toggle(false);
	
	
	$("#bouton_compte_rendu_instrumental_valider").click(function(){
		$("#note_compte_rendu_operatoire_instrumental").attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_compte_rendu_instrumental_valider").toggle(false);
		$("#bouton_compte_rendu_instrumental_modifier").toggle(true);
		
		return false;
	});
	
	$("#bouton_compte_rendu_instrumental_modifier").click(function(){
		$("#note_compte_rendu_operatoire_instrumental").attr( 'readonly', false).css({'background':'#fff'});
		
		$("#bouton_compte_rendu_instrumental_valider").toggle(true);
		$("#bouton_compte_rendu_instrumental_modifier").toggle(false);
		
		return false;
	});
	
});

// *************Autres(Transfert/Hospitalisation/ Rendez-Vous )***************
// *************Autres(Transfert/Hospitalisation/ Rendez-Vous )***************
// *************Autres(Transfert/Hospitalisation/ Rendez-Vous )***************

// ******************* Tranfert ******************************** 
// ******************* Tranfert ******************************** 
$(function(){
	var motif_transfert = $("#motif_transfert");
	var hopital_accueil = $("#hopital_accueil");
	var service_accueil = $("#service_accueil");
//	$("#transfert").click(function(){ 
//		motif_transfert.attr( 'readonly', true).css({'background':'#f8f8f8'});
//		$("#hopital_accueil_tampon").val(hopital_accueil.val());
//		//hopital_accueil.attr( 'disabled', true).css({'background':'#f8f8f8'});
//		$("#service_accueil_tampon").val(service_accueil.val());
//		//service_accueil.attr( 'disabled', true).css({'background':'#f8f8f8'});
//		$("#bouton_transfert_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
//	    $("#bouton_transfert_valider").toggle(false); //on cache le bouton permettant de valider les champs
//	});

	$( "bouton_valider_transfert" ).button();
	$( "bouton_modifier_transfert" ).button();

	//Au debut on cache le bouton modifier et on affiche le bouton valider
	$( "#bouton_transfert_valider" ).toggle(true);
	$( "#bouton_transfert_modifier" ).toggle(false);

	//Au debut on desactive tous les champs
	motif_transfert.attr( 'readonly', false ).css({'background':'#fff'});;
	hopital_accueil.attr( 'disabled', false ).css({'background':'#fff'});;
	service_accueil.attr( 'disabled', false ).css({'background':'#fff'});;

	//Valider(cach�) avec le bouton 'valider'
	$( "#bouton_transfert_valider" ).click(function(){
		motif_transfert.attr( 'readonly', true ).css({'background':'#f8f8f8'});     //d�sactiver le motif transfert
		$("#hopital_accueil_tampon").val(hopital_accueil.val());
		hopital_accueil.attr( 'disabled', true ).css({'background':'#f8f8f8'});     //d�sactiver hopital accueil
		$("#service_accueil_tampon").val(service_accueil.val());
		service_accueil.attr( 'disabled', true ).css({'background':'#f8f8f8'});   //d�sactiver service accueil
		$("#bouton_transfert_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
		$("#bouton_transfert_valider").toggle(false); //on cache le bouton permettant de valider les champs
		
		$("#annulertransfert").attr('disabled', true);
		return false; 
	});
	//Activer(d�cach�) avec le bouton 'modifier'
	$( "#bouton_transfert_modifier" ).click(function(){
		motif_transfert.attr( 'readonly', false ).css({'background':'#fff'});
		hopital_accueil.attr( 'disabled', false ).css({'background':'#fff'});
		service_accueil.attr( 'disabled', false ).css({'background':'#fff'});
	 	$("#bouton_transfert_modifier").toggle(false);   //on cache le bouton permettant de modifier les champs
	 	$("#bouton_transfert_valider").toggle(true);    //on affiche le bouton permettant de valider les champs
	 	
	 	$("#annulertransfert").attr('disabled', false);
	 	return  false;
	});
});

//********************* HOSPITALISATION *****************************
//********************* HOSPITALISATION *****************************
$(function(){
	var motif_hospitalisation = $("#motif_hospitalisation");
	var date_fin_hospitalisation = $("#date_fin_hospitalisation_prevue");
//	$("#hospitalisation").click(function(){
//		motif_hospitalisation.attr( 'disabled', true).css({'background':'#f8f8f8'});
//		date_fin_hospitalisation.attr( 'disabled', true).css({'background':'#f8f8f8'});
//		$("#bouton_hospi_modifier").toggle(true);
//		$("#bouton_hospi_valider").toggle(false);	
//	});
	
	$("#annulerhospitalisation").click(function(){
		motif_hospitalisation.val("");
		date_fin_hospitalisation.val("");
		return false;
	});
	//Au debut on affiche pas le bouton modifier
	$("#bouton_hospi_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_hospi_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	motif_hospitalisation.attr( 'disabled', false).css({'background':'#fff'});
	date_fin_hospitalisation.attr( 'disabled', false).css({'background':'#fff'});
	
	$("#bouton_hospi_valider").click(function(){
		motif_hospitalisation.attr( 'disabled', true).css({'background':'#f8f8f8'});
		date_fin_hospitalisation.attr( 'disabled', true).css({'background':'#f8f8f8'});
		$("#bouton_hospi_modifier").toggle(true);
		$("#bouton_hospi_valider").toggle(false);
		
	 	$("#annulerhospitalisation").attr('disabled', true);
		return false;
	});
	
	$("#bouton_hospi_modifier").click(function(){
		motif_hospitalisation.attr( 'disabled', false).css({'background':'#fff'});
		date_fin_hospitalisation.attr( 'disabled', false).css({'background':'#fff'});
		$("#bouton_hospi_modifier").toggle(false);
		$("#bouton_hospi_valider").toggle(true);
		
	 	$("#annulerhospitalisation").attr('disabled', false);
		return false;
	});
	
	
	
});

//********************* RENDEZ VOUS *****************************
//********************* RENDEZ VOUS *****************************
 $(function() {
 var motif_rv = $('#motif_rv');
 var date_rv = $( "#date_rv" );
 var heure_rv = $("#heure_rv");
   date_rv.attr('autocomplete', 'off');
   $( "#disable" ).click(function(){
	  motif_rv.attr( 'readonly', true ).css({'background':'#f8f8f8'});     //d�sactiver le motif
	  $("#date_rv_tampon").val(date_rv.val()); //Placer la date dans date_rv_tampon avant la desacivation
      date_rv.attr( 'disabled', true ).css({'background':'#f8f8f8'});     //d�sactiver la date
      $("#heure_rv_tampon").val(heure_rv.val()); //Placer l'heure dans heure_rv_tampon avant la desacivation
      heure_rv.attr( 'disabled', true ).css({'background':'#f8f8f8'});   //d�sactiver l'heure
      $("#disable_bouton").toggle(true);  //on affiche le bouton permettant de modifier les champs
      $("#enable_bouton").toggle(false); //on cache le bouton permettant de valider les champs
 
      date_rv.val(date);
   });
   
   $( "button" ).button();
   //$( "bouton_valider" ).button();

   //Au debut on affiche pas le bouton modifier, on l'affiche seulement apres impression
   $("#disable_bouton").toggle(false);
   //Au debut on affiche le bouton valider
   $("#enable_bouton").toggle(true);
   
   //Au debut on desactive tous les champs
   motif_rv.attr( 'readonly', false ).css({'background':'#fff'});
   date_rv.attr( 'disabled', false ).css({'background':'#fff'});
   heure_rv.attr( 'disabled', false ).css({'background':'#fff'});

   //Valider(cach�) avec le bouton 'valider'
   $( "#enable_bouton" ).click(function(){
	  motif_rv.attr( 'readonly', true ).css({'background':'#f8f8f8'});     //d�sactiver le motif
	  $("#date_rv_tampon").val(date_rv.val()); //Placer la date dans date_rv_tampon avant la desacivation
      date_rv.attr( 'disabled', true ).css({'background':'#f8f8f8'});     //d�sactiver la date
      $("#heure_rv_tampon").val(heure_rv.val()); //Placer l'heure dans heure_rv_tampon avant la desacivation
	  heure_rv.attr( 'disabled', true ).css({'background':'#f8f8f8'});   //d�sactiver l'heure
	  $("#disable_bouton").toggle(true);  //on affiche le bouton permettant de modifier les champs
	  $("#enable_bouton").toggle(false); //on cache le bouton permettant de valider les champs
	  
	  $("#annulerrendezvous").attr('disabled', true);
	  return false; 
   });
   //Activer(d�cach�) avec le bouton 'modifier'
   $( "#disable_bouton" ).click(function(){
	  motif_rv.attr( 'readonly', false ).css({'background':'#fff'});      //activer le motif
	  date_rv.attr( 'disabled', false ).css({'background':'#fff'});      //activer la date
	  heure_rv.attr( 'disabled', false ).css({'background':'#fff'});    //activer l'heure
 	  $("#disable_bouton").toggle(false);   //on cache le bouton permettant de modifier les champs
 	  $("#enable_bouton").toggle(true);    //on affiche le bouton permettant de valider les champs
 	  
	  $("#annulerrendezvous").attr('disabled', false);
 	  return  false;
   });
   
 });
 
//Boite de dialogue de confirmation d'annulation
//Boite de dialogue de confirmation d'annulation
//Boite de dialogue de confirmation d'annulation

/***BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION**/
/***BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION**/

	var theHREF = tabUrl[0]+"public/consultation/consultation-medecin";
	function confirmation(){
		
 		$( "#confirmation2" ).dialog({
 		    resizable: false,
 		    height:170,
 		    width:505,
 		    autoOpen: false,
 		    modal: true,
 		    buttons: {
 		        "Oui": function() {
 		            $( this ).dialog( "close" );
 		            window.location.href = theHREF;   
 		        },
 		        "Non": function() {
 		            $( this ).dialog( "close" );
 		        }
 		    }
 		});
    }	
	$("#annuler2").click(function() { 
       confirmation(); 
       $("#confirmation2").dialog('open');
       
       return false;
    });
	
	//******************* POPUP ENVOIE DEMANDE OPERATION VPA ********************************
    function confirmationDemandeOperation(){
    	$( "#popupVPA" ).dialog({
 		    resizable: false,
 		    height:170,
 		    width:505,
 		    autoOpen: false,
 		    modal: true,
 		    buttons: {
 		        "Oui": function() {
 		            $( this ).dialog( "close" );
 		            
 		            var id_cons = $('#id_cons').val();
 		            var resultatNumeroVPA = $('#resultatNumeroVPA').val();
 		            var resultatTypeIntervention = $('#resultatTypeIntervention').val();
 		            var valeurResEnvoie = $('#valeurResEnvoie').val();
 		            var diagnostic_traitement_chirurgical = $('#diagnostic_traitement_chirurgical').val();
 		            var theHREF = tabUrl[0]+"public/orl/demande-operation";
 		            $.ajax({
 		   			type:'POST', 
 		   			url: theHREF,
 		   			data: {'id_cons':id_cons, 'resultatNumeroVPA':resultatNumeroVPA, 
 		   				'resultatTypeIntervention':resultatTypeIntervention, 
 		   				'valeurResEnvoie':valeurResEnvoie, 
 		   				'diagnostic':diagnostic_traitement_chirurgical},
 		   			success: function(){
 		   				$('#temoinDemandeEnvoyer').html("Demande envoyee avec succes")
 		   			},
 		   			error: function(){alert('la requete n\'a pas abouti');}
 		   		    });
 		            //window.location.href = theHREF; 
 		        },
 		        "Non": function() {
 		            $( this ).dialog( "close" );
 		        }
 		    }
 		});
    }
	$("#testPopUpVpa").click(function() {		
		confirmationDemandeOperation(); 
		$("#popupVPA").dialog('open');
		return false;
	}); 
	 //---------------------------------------------------------------------

	var temoinTaille = 0;
	var temoinPoids = 0;
	var temoinTemperature = 0;
	var temoinPouls = 0;
	var temoinTensionMaximale = 0;
	var temoinTensionMinimale = 0;
		
	var valid = true;  // VARIABLE GLOBALE utilis�e dans 'VALIDER LES DONNEES DU TABLEAU DES CONSTANTES'
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	/****** MASK DE SAISIE ********/ 
   	/****** MASK DE SAISIE ********/ 
 	/****** MASK DE SAISIE ********/
	function maskSaisie() {
	    $(function(){
	    	$("#pressionarterielle").mask("299/299");
	    	$("#glycemie_capillaire").mask("9,99");
	    });
    
	    $("#poids").blur(function(){
	    	var valeur = $('#poids').val();
	    	if(isNaN(valeur/1) || valeur > 300 || valeur == ""){
				valeur = null;
				$("#poids").css("border-color","#FF0000");
				$("#erreur_poids").fadeIn().text("Max: 300kg").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
				temoinPoids = 2;
	    	} 
	    	else{
	    		$("#poids").css("border-color","");
				$("#erreur_poids").fadeOut();
				temoinPoids = 0;
	    	}
	    	return false;
	    });
	    
	    $("#temperature").blur(function(){
	    	var valeur = $('#temperature').val();
	    	if(isNaN(valeur/1) || valeur > 45 || valeur < 34  || valeur == ""){
				$("#temperature").css("border-color","#FF0000");
	    		$("#erreur_temperature").fadeIn().text("Min: 34°C, Max: 45°C").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
				temoinTemperature = 3;
	    	} 
	    	else{
	    		$("#temperature").css("border-color","");
				$("#erreur_temperature").fadeOut();
				temoinTemperature = 0;
	    	}
	    	return false;
	    });
	    
	    $("#tensionmaximale").blur(function(){
	    	var valeur = $('#tensionmaximale').val();
			if(isNaN(valeur/1) || valeur > 300 || valeur == ""){
				$("#tensionmaximale").css("border-color","#FF0000");
	    		$("#erreur_tensionmaximale").fadeIn().text("300mmHg").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
				temoinTensionMaximale = 5;
			}else{
				$("#tensionmaximale").css("border-color","");
				$("#erreur_tensionmaximale").fadeOut();
				temoinTensionMaximale = 0;
			}
	    });
	    
	    $("#tensionminimale").blur(function(){
	    	var valeur = $('#tensionminimale').val();
			if(isNaN(valeur/1) || valeur > 200 || valeur == ""){
				$("#tensionminimale").css("border-color","#FF0000");
	    		$("#erreur_tensionminimale").fadeIn().text("200mmHg").css({"color":"#ff5b5b","padding":" 0 10px 0 105px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
				temoinTensionMinimale = 6;
			}else{
				$("#tensionminimale").css("border-color","");
				$("#erreur_tensionminimale").fadeOut();
				temoinTensionMinimale = 0;
			}
	    });
	}
	
	/****** CONTROLE APRES VALIDATION ********/ 
	/****** CONTROLE APRES VALIDATION ********/ 

     $("#terminer,#bouton_constantes_valider, #terminer2, #terminer3").click(function(){
	     	 valid = true;	         
//	         if( $("#poids").val() == "" || temoinPoids == 2){
//	         	 $("#poids").css("border-color","#FF0000");
//	             $("#erreur_poids").fadeIn().text("Max: 300kg").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
//	             valid = false;
//	         }
//	         else{
	         	$("#poids").css("border-color", "");
	         	$("#erreur_poids").fadeOut();
	         //}
//	         if( $('#temperature').val() == "" || temoinTemperature == 3){
//	         	$("#temperature").css("border-color","#FF0000");
//	         	$("#erreur_temperature").fadeIn().text("Min: 34°C, Max: 45°C").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
//	             valid = false;
//	         }
//	         else{
	         	$("#temperature").css("border-color", "");
	         	$("#erreur_temperature").fadeOut();
	         //}
//	         if( $("#tensionmaximale").val() == "" || temoinTensionMaximale == 5){
//	         	 $("#tensionmaximale").css("border-color","#FF0000");
//		    	 $("#erreur_tensionmaximale").fadeIn().text("300mmHg").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
//	             valid = false;
//	         }
//	         else{
	         	 $("#tensionmaximale").css("border-color", "");
	             $("#erreur_tensionmaximale").fadeOut();
	         //}
	         
//	         if( $("#tensionminimale").val() == "" || temoinTensionMinimale == 6 ){
//	         	 $("#tensionminimale").css("border-color","#FF0000");
//		    	 $("#erreur_tensionminimale").fadeIn().text("200mmHg").css({"color":"#ff5b5b","padding":" 0 10px 0 105px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
//	             valid = false;
//	         }
//	         else{
	         	 $("#tensionminimale").css("border-color", "");
	             $("#erreur_tensionminimale").fadeOut();
	         //}
	         return false;
	 	}); 

//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--*-*-*-*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-**--*-**-*--**-*-*-*-*-*-*-*-*-*-*-*-*-*--**-*-*-*-*-	
	//Method envoi POST pour updatecomplementconsultation
	//Method envoi POST pour updatecomplementconsultation
	//Method envoi POST pour updatecomplementconsultation
    
	function updateexecuterRequetePost(donnees) {
		var vart =  tabUrl[0]+'public/orl/update-complement-consultation';
		var FormulaireUpdateComplementConsultation = document.getElementById("FormulaireUpdateComplementConsultation");
		FormulaireUpdateComplementConsultation.setAttribute("action", vart);
		FormulaireUpdateComplementConsultation.setAttribute("method", "POST");
	    for( donnee in donnees ){
		     // Ajout dynamique de champs dans le formulaire
		        var champ = document.createElement("input");
		        champ.setAttribute("type", "hidden");
		        champ.setAttribute("name", donnee);
		        champ.setAttribute("value", donnees[donnee]);
		        FormulaireUpdateComplementConsultation.appendChild(champ);
	    }	  
	    $("#UpdateComplementConsultation").trigger('click');
	}
	
    /***LORS DU CLICK SUR 'Terminer' ****/
	/***LORS DU CLICK SUR 'Terminer' ****/
	$("#terminer2, #terminer3").click(function() {
		if (valid == false){
			$('#motifsAdmissionConstanteClick').trigger('click');
			$('#constantesClick').trigger('click');
			return false;
		}
		$('#bouton_Acte_valider_demande button, #bouton_ExamenBio_valider_demande button, #bouton_morpho_valider_demande button').trigger('click');
	    var donnees = new Array();
	    donnees['id_cons']    = $("#id_cons").val();
	    donnees['terminer'] = 'save';
	    
	    // **********-- Donnees de l'examen physique --*******
        // **********-- Donnees de l'examen physique --*******
	    donnees['examen_donnee1'] = $("#examen_donnee1").val();
	    donnees['examen_donnee2'] = $("#examen_donnee2").val();
	    donnees['examen_donnee3'] = $("#examen_donnee3").val();
	    donnees['examen_donnee4'] = $("#examen_donnee4").val();
	    donnees['examen_donnee5'] = $("#examen_donnee5").val();
	    
	 // **********-- Donnees de l'examen clinique --*******
	    donnees['examen_clinique'] = $("#examen_clinique").val();
	    
	    //**********-- ANALYSE BIOLOGIQUE --************
        //**********-- ANALYSE BIOLOGIQUE --************
	    donnees['groupe_sanguin']      = $("#groupe_sanguin").val();
	    donnees['hemogramme_sanguin']  = $("#hemogramme_sanguin").val();
	    donnees['bilan_hemolyse']      = $("#bilan_hemolyse").val();
	    donnees['bilan_hepatique']     = $("#bilan_hepatique").val();
	    donnees['bilan_renal']         = $("#bilan_renal").val();
	    donnees['bilan_inflammatoire'] = $("#bilan_inflammatoire").val();
	    
	    //**********-- ANALYSE MORPHOLOGIQUE --************
        //**********-- ANALYSE MORPHOLOGIQUE --************
	    donnees['radio_']        = $("#radio").val();
	    donnees['ecographie_']   = $("#ecographie").val();
	    donnees['fibroscopie_']  = $("#fibrocospie").val();
	    donnees['scanner_']      = $("#scanner").val();
	    donnees['irm_']          = $("#irm").val();
	    
	    //*********** DIAGNOSTICS ************
	    //*********** DIAGNOSTICS ************
	    donnees['diagnostic1'] = $("#diagnostic1").val();
	    donnees['diagnostic2'] = $("#diagnostic2").val();
	    donnees['diagnostic3'] = $("#diagnostic3").val();
	    donnees['diagnostic4'] = $("#diagnostic4").val();
	    
	    //*********** ORDONNACE (M�dical) ************
	    //*********** ORDONNACE (M�dical) ************
	    donnees['duree_traitement_ord'] = $("#duree_traitement_ord").val();
	     
	    for(var i = 1 ; i < 10 ; i++ ){
	     	if($("#medicament_0"+i).val()){
	     		donnees['medicament_0'+i] = $("#medicament_0"+i).val();
	     		donnees['forme_'+i] = $("#forme_"+i).val();
	     		donnees['nb_medicament_'+i] = $("#nb_medicament_"+i).val();
	     		donnees['quantite_'+i] = $("#quantite_"+i).val();
	     	}
	     }
	    
	    //*********** TRAITEMENTS CHIRURGICAUX ************
		//*********** TRAITEMENTS CHIRURGICAUX ************
	    donnees['diagnostic_traitement_chirurgical'] = $("#diagnostic_traitement_chirurgical").val();
	    donnees['intervention_prevue'] = $("#intervention_prevue").val();
	    donnees['type_anesthesie_demande'] = $("#type_anesthesie_demande").val();
	    donnees['numero_vpa'] = $("#numero_vpa").val();
	    donnees['observation'] = $("#observation").val();
	    donnees['note_compte_rendu_operatoire'] = $("#note_compte_rendu_operatoire").val();
	    
	    
	    //*********** TRAITEMENTS INSTRUMENTAL ************
		//*********** TRAITEMENTS INSTRUMENTAL ************
	    donnees['endoscopieInterventionnelle'] = $("#endoscopieInterventionnelle").val();
	    donnees['radiologieInterventionnelle'] = $("#radiologieInterventionnelle").val();
	    donnees['cardiologieInterventionnelle'] = $("#cardiologieInterventionnelle").val();
	    donnees['autresIntervention'] = $("#autresIntervention").val();
	    donnees['note_compte_rendu_operatoire_instrumental'] = $("#note_compte_rendu_operatoire_instrumental").val();

	    
	    // **********-- Rendez Vous --*******
        // **********-- Rendez Vous --*******
		donnees['id_patient'] = $("#id_patient").val();
		//Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas d�sactiver
		   if($("#date_rv").val()){$("#date_rv_tampon").val($("#date_rv").val());}
		donnees['date_rv']    = $("#date_rv_tampon").val();
		donnees['motif_rv']   = $("#motif_rv").val();
		donnees['heure_rv']   = $("#heure_rv").val();
		donnees['delai_rv']   = $("#delai_rv").val();
		
		// **********-- Hospitalisation --*******
        // **********-- Hospitalisation --*******
		//Desactivation des champs pour la recuperation des donnees
		$("#motif_hospitalisation").attr( 'disabled', false);
		$("#date_fin_hospitalisation_prevue").attr( 'disabled', false);
		donnees['motif_hospitalisation'] = $("#motif_hospitalisation").val();
		donnees['date_fin_hospitalisation_prevue'] = $("#date_fin_hospitalisation_prevue").val();
		
		// **********-- Transfert --*******
        // **********-- Transfert --*******
		//Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas d�sactiver
		   if($("#service_accueil").val()){$("#service_accueil_tampon").val($("#service_accueil").val());};
		
		donnees['id_service']      = $("#service_accueil_tampon").val();
		donnees['med_id_personne'] = $("#id_medecin").val();
		donnees['date']            = $("#date_cons").val();
		donnees['motif_transfert'] = $("#motif_transfert").val();
	    
		//**********-- LES MOTIFS D'ADMISSION --********
		//**********-- LES MOTIFS D'ADMISSION --********
		//**********-- LES MOTIFS D'ADMISSION --********
		donnees['motif_admission1'] = $("#motif_admission1").val();
		donnees['motif_admission2'] = $("#motif_admission2").val();
		donnees['motif_admission3'] = $("#motif_admission3").val();
		donnees['motif_admission4'] = $("#motif_admission4").val();
		donnees['motif_admission5'] = $("#motif_admission5").val();
		
		//**********-- LES CONSTANTES CONSTANTES CONSTANTES --********
		//**********-- LES CONSTANTES CONSTANTES CONSTANTES --********
		//**********-- LES CONSTANTES CONSTANTES CONSTANTES --********
		//Recuperer les valeurs des champs
		//Recuperer les valeurs des champs
		donnees['poids'] = $("#poids").val();
		donnees['taille'] = $("#taille").val();
		donnees['temperature'] = $("#temperature").val();
		donnees['tensionmaximale'] = $("#tensionmaximale").val();
		donnees['tensionminimale'] = $("#tensionminimale").val();
		donnees['pouls'] = $("#pouls").val();
		donnees['frequence_respiratoire'] = $("#frequence_respiratoire").val();
		donnees['glycemie_capillaire'] = $("#glycemie_capillaire").val();
		
		//Recuperer les donnees sur les bandelettes urinaires
		//Recuperer les donnees sur les bandelettes urinaires
		donnees['albumine'] = $('#BUcheckbox input[name=albumine]:checked').val();
		if(!donnees['albumine']){ donnees['albumine'] = 0;}
		donnees['croixalbumine'] = $('#BUcheckbox input[name=croixalbumine]:checked').val();
		if(!donnees['croixalbumine']){ donnees['croixalbumine'] = 0;}

		donnees['sucre'] = $('#BUcheckbox input[name=sucre]:checked').val();
		if(!donnees['sucre']){ donnees['sucre'] = 0;}
		donnees['croixsucre'] = $('#BUcheckbox input[name=croixsucre]:checked').val();
		if(!donnees['croixsucre']){ donnees['croixsucre'] = 0;}
		
		donnees['corpscetonique'] = $('#BUcheckbox input[name=corpscetonique]:checked').val();
		if(!donnees['corpscetonique']){ donnees['corpscetonique'] = 0;}
		donnees['croixcorpscetonique'] = $('#BUcheckbox input[name=croixcorpscetonique]:checked').val();
		if(!donnees['croixcorpscetonique']){ donnees['croixcorpscetonique'] = 0;}
		
		//GESTION DES ANDECEDENTS
		//GESTION DES ANDECEDENTS
		//GESTION DES ANDECEDENTS
		//GESTION DES ANDECEDENTS
		//**=== ANTECEDENTS PERSONNELS
		//**=== ANTECEDENTS PERSONNELS
		
		//LES HABITUDES DE VIE DU PATIENTS
		/*Alcoolique*/
		donnees['AlcooliqueHV'] = $("#AlcooliqueHV:checked").val();
		if(!donnees['AlcooliqueHV']){ donnees['AlcooliqueHV'] = 0;}
		donnees['DateDebutAlcooliqueHV'] = $("#DateDebutAlcooliqueHV").val();
		donnees['DateFinAlcooliqueHV'] = $("#DateFinAlcooliqueHV").val();
		/*Fumeur*/
		donnees['FumeurHV'] = $("#FumeurHV:checked").val();
		if(!donnees['FumeurHV']){ donnees['FumeurHV'] = 0;}
		donnees['DateDebutFumeurHV'] = $("#DateDebutFumeurHV").val();
		donnees['DateFinFumeurHV'] = $("#DateFinFumeurHV").val();
		donnees['nbPaquetFumeurHV'] = $("#nbPaquetFumeurHV").val();
		/*Droguer*/ 
		donnees['DroguerHV'] = $("#DroguerHV:checked").val(); 
		if(!donnees['DroguerHV']){ donnees['DroguerHV'] = 0;}
		donnees['DateDebutDroguerHV'] = $("#DateDebutDroguerHV").val();
		donnees['DateFinDroguerHV'] = $("#DateFinDroguerHV").val();
		/*AutresHV*/
		donnees['AutresHV'] = $("#AutresHV:checked").val(); 
		if(!donnees['AutresHV']){ donnees['AutresHV'] = 0;}
		donnees['NoteAutresHV'] = $("#NoteAutresHV").val();
		
		//LES ANTECEDENTS MEDICAUX
		/*Diabete*/ 
		donnees['DiabeteAM'] = $("#DiabeteAM:checked").val(); 
		if(!donnees['DiabeteAM']){ donnees['DiabeteAM'] = 0;}
		/*Hta*/
		donnees['htaAM'] = $("#htaAM:checked").val();
		if(!donnees['htaAM']){ donnees['htaAM'] = 0;}
		/*Drepanocytose*/
		donnees['drepanocytoseAM'] = $("#drepanocytoseAM:checked").val(); 
		if(!donnees['drepanocytoseAM']){ donnees['drepanocytoseAM'] = 0;}
		/*Dislipid?ie*/
		donnees['dislipidemieAM'] = $("#dislipidemieAM:checked").val(); 
		if(!donnees['dislipidemieAM']){ donnees['dislipidemieAM'] = 0;}
		/*Asthme*/ 
		donnees['asthmeAM'] = $("#asthmeAM:checked").val(); 
		if(!donnees['asthmeAM']){ donnees['asthmeAM'] = 0;}
		
		
		/*Ajout automatique des antecedents medicaux*/
		var $nbCheckboxAM = ($('#nbCheckboxAM').val())+1;
		var $nbCheck = 0;
		var $ligne;
		var $reste = ( $nbCheckboxAM - 1 ) % 5;
  		var $nbElement = parseInt( ( $nbCheckboxAM - 1 ) / 5 ); 
  		if($reste != 0){ $ligne = $nbElement + 1; }
  		else { $ligne = $nbElement; }
  		
  		var k=0;
  		var i;
		for(var j=1 ; j<=$ligne ; j++){
			for( i=0 ; i<5 ; i++){
				var $champValider = $('#champValider_'+j+'_'+i+':checked').val();
				if($champValider == 'on'){
					donnees['champValider_'+k] = 1;
					donnees['champTitreLabel_'+k] = $('#champTitreLabel_'+j+'_'+i).val();
					k++;
					$nbCheck++;
				}
			}
			i=0; 
		}
		
		donnees['nbCheckboxAM'] = $nbCheck;

		//GYNECO-OBSTETRIQUE
		/*Menarche*/
		donnees['MenarcheGO'] = $("#MenarcheGO:checked").val(); 
		if(!donnees['MenarcheGO']){ donnees['MenarcheGO'] = 0;}
		donnees['NoteMenarcheGO'] = $("#NoteMenarcheGO").val();
		/*Gestite*/
		donnees['GestiteGO'] = $("#GestiteGO:checked").val(); 
		if(!donnees['GestiteGO']){ donnees['GestiteGO'] = 0;}
		donnees['NoteGestiteGO'] = $("#NoteGestiteGO").val();
		/*Parite*/
		donnees['PariteGO'] = $("#PariteGO:checked").val(); 
		if(!donnees['PariteGO']){ donnees['PariteGO'] = 0;}
		donnees['NotePariteGO'] = $("#NotePariteGO").val();
		/*Cycle*/
		donnees['CycleGO'] = $("#CycleGO:checked").val(); 
		if(!donnees['CycleGO']){ donnees['CycleGO'] = 0;}
		donnees['DureeCycleGO'] = $("#DureeCycleGO").val();
		donnees['RegulariteCycleGO'] = $("#RegulariteCycleGO").val(); 
		donnees['DysmenorrheeCycleGO'] = $("#DysmenorrheeCycleGO").val();
		/*Autres*/
		donnees['AutresGO'] = $("#AutresGO:checked").val(); 
		if(!donnees['AutresGO']){ donnees['AutresGO'] = 0;}
		donnees['NoteAutresGO'] = $("#NoteAutresGO").val();

		//**=== ANTECEDENTS FAMILIAUX
		//**=== ANTECEDENTS FAMILIAUX 
		donnees['DiabeteAF'] = $("#DiabeteAF:checked").val(); 
		if(!donnees['DiabeteAF']){ donnees['DiabeteAF'] = 0;}
		donnees['NoteDiabeteAF'] = $("#NoteDiabeteAF").val();
		
		donnees['DrepanocytoseAF'] = $("#DrepanocytoseAF:checked").val(); 
		if(!donnees['DrepanocytoseAF']){ donnees['DrepanocytoseAF'] = 0;}
		donnees['NoteDrepanocytoseAF'] = $("#NoteDrepanocytoseAF").val();
		
		donnees['htaAF'] = $("#htaAF:checked").val(); 
		if(!donnees['htaAF']){ donnees['htaAF'] = 0;}
		donnees['NoteHtaAF'] = $("#NoteHtaAF").val();
		
		donnees['autresAF'] = $("#autresAF:checked").val(); 
		if(!donnees['autresAF']){ donnees['autresAF'] = 0;}
		donnees['NoteAutresAF'] = $("#NoteAutresAF").val();
		
		
		
		//************** SOUS DOSSIERS ***********************
		// ------------- SOUS DOSSIER TYROIDE ------------
		// **=== ANTECEDENTS
		donnees['irradiation_cervical_anterieur'] = $("#irradiation_cervical_anterieur").val();
		donnees['goitre_atcd'] = $("#goitre_atcd").val();
		donnees['autresAntecedent'] = $("#autres").val();
		// **=== MOTIFS DHOSPITALISATION
	
		donnees['tumefaction_cervical_anterieur'] = $("#tumefaction_cervical_anterieur").val();
		donnees['signes_thyroxicose'] = $("#signes_thyroxicose").val();
		donnees['signe_compression'] = $("#signe_compression").val();
		donnees['groupeIa'] = $("#groupeIa:checked").val(); if(!donnees['groupeIa']){ donnees['groupeIa'] = 0;}
		donnees['groupeIb'] = $("#groupeIb:checked").val();if(!donnees['groupeIb']){ donnees['groupeIb'] = 0;}
		donnees['groupeIc'] = $("#groupeIc:checked").val();if(!donnees['groupeIc']){ donnees['groupeIc'] = 0;}
		donnees['autresMotifHospitalisation'] = $("#autresMotifHospitalisation").val();
		// **=== HISTOIRE DE LA MALADIE
		donnees['histoire_maladie'] = $("#histoire_maladie").val();
		// **=== EXAMENS COMPLEMENTAIRES
		donnees['examen_complementaire'] = $("#examen_complementaire").val();		
		// **=== PEAU CERVICO-FASCIALE
		donnees['depigmentation_artificielle'] = $("#depigmentation_artificielle").val();
		donnees['cicatrices_taches_fistules'] = $("#cicatrices_taches_fistules").val();
		// **=== TYROIDE
		donnees['hypertrophie_globale'] = $("#hypertrophie_globale").val();
		donnees['hypertrophie_localise'] = $("#hypertrophie_localise").val();
		donnees['hypertrophie_nodulaire'] = $("#hypertrophie_nodulaire").val();
		donnees['hypertrophie_sensibilite'] = $("#hypertrophie_sensibilite").val();		
		donnees['consistance'] = $("#consistance").val();		
		donnees['mobilite_transversale'] = $("#mobilite_transversale").val();
		donnees['taille_tyroide'] = $("#taille_tyroide").val();
		// **=== GROUPES GANGLIONNAIRES
		donnees['groupeI'] = $("#groupeI:checked").val(); if(!donnees['groupeI']){ donnees['groupeI'] = 0;}
		donnees['groupeIIa'] = $("#groupeIIa:checked").val(); if(!donnees['groupeIIa']){ donnees['groupeIIa'] = 0;}
		donnees['groupeIIb'] = $("#groupeIIb:checked").val(); if(!donnees['groupeIIb']){ donnees['groupeIIb'] = 0;}
		donnees['groupeIII'] = $("#groupeIII:checked").val(); if(!donnees['groupeIII']){ donnees['groupeIII'] = 0;}
		donnees['groupeIV'] = $("#groupeIV:checked").val(); if(!donnees['groupeIV']){ donnees['groupeIV'] = 0;}
		donnees['groupeV'] = $("#groupeV:checked").val(); if(!donnees['groupeV']){ donnees['groupeV'] = 0;}
		donnees['groupeVI'] = $("#groupeVI:checked").val(); if(!donnees['groupeVI']){ donnees['groupeVI'] = 0;}
		donnees['libre'] = $("#libre").val();
		donnees['atteinte'] = $("#atteinte").val();
		// **=== LES HORMONES TYROIDIENNES
		donnees['t3'] = $("#t3").val();
		donnees['t4'] = $("#t4").val();
		donnees['tsh'] = $("#tsh").val();
		donnees['groupeIIIa'] = $("#groupeIIIa:checked").val(); if(!donnees['groupeIIIa']){ donnees['groupeIIIa'] = 0;}
		donnees['groupeIIIb'] = $("#groupeIIIb:checked").val(); if(!donnees['groupeIIIb']){ donnees['groupeIIIb'] = 0;}
		donnees['groupeIIIc'] = $("#groupeIIIc:checked").val(); if(!donnees['groupeIIIc']){ donnees['groupeIIIc'] = 0;}
		donnees['cytologie'] = $("#cytologie").val();
		donnees['autres'] = $("#autres").val();
		donnees['echographie_cervicale'] = $("#echographie_cervicale").val();
		//**=== INFORMATIONS OPERATOIRES
		donnees['indication_preoperatoire'] = $("#indication_preoperatoire").val();
		donnees['indication_peroperatoire'] = $("#indication_peroperatoire").val();
		donnees['incident_anesthesique'] = $("#incident_anesthesique").val();
		donnees['groupeIVa'] = $("#groupeIVa:checked").val(); if(!donnees['groupeIVa']){ donnees['groupeIVa'] = 0;}
		donnees['groupeIVb'] = $("#groupeIVb:checked").val(); if(!donnees['groupeIVb']){ donnees['groupeIVb'] = 0;}
		donnees['incident_chirurgicaux'] = $("#incident_chirurgicaux").val();
		donnees['incident_glandulaire'] = $("#incident_glandulaire").val();
		donnees['incident_tracheotomie'] = $("#incident_tracheotomie").val();
		donnees['anesthesie'] = $("#anesthesie").val();
		donnees['incision'] = $("#incision").val();
		donnees['exploitation'] = $("#exploitation").val();
		donnees['geste_sur_nerf'] = $("#geste_sur_nerf").val();
		donnees['loboithmectomie'] = $("#loboithmectomie").val();
		donnees['ithmectomie'] = $("#ithmectomie").val();
		donnees['thyroidectomie_subtotale'] = $("#thyroidectomie_subtotale").val();
		donnees['thyroidectomie_totale'] = $("#thyroidectomie_totale").val();
		donnees['glande_parathyroide'] = $("#glande_parathyroide").val();
		donnees['fermeture'] = $("#fermeture").val();
		donnees['description_piece'] = $("#description_piece").val();
		donnees['thyroide'] = $("#thyroide").val();

		donnees['calcemie'] = $("#calcemie").val();
		donnees['laryngectomie_indirecte'] = $("#laryngectomie_indirecte").val();
		donnees['ablation_drain'] = $("#ablation_drain").val();
		donnees['ablation_fil'] = $("#ablation_fil").val();
		donnees['accident_hemoragie'] = $("#accident_hemoragie").val();
		donnees['accident_infectieux'] = $("#accident_infectieux").val();
		donnees['autresAccident'] = $("#autresAccident").val();
		
		donnees['histologie'] = $("#histologie").val();
		donnees['plainte'] = $("#plainte").val();
		donnees['qualite_voix_parlee'] = $("#qualite_voix_parlee").val();
		donnees['qualite_voix_chantee'] = $("#qualite_voix_chantee").val();	
		donnees['qualite_cicatrice'] = $("#qualite_cicatrice").val();
		donnees['laryngoscopie_indirecte'] = $("#laryngoscopie_indirecte").val();
		donnees['palpation_cou'] = $("#palpation_cou").val();	
		donnees['radiographie_pulmonaire'] = $("#radiographie_pulmonaire").val();
		//SOUS DOSSIER
		donnees['type_dossier'] = $("#type_dossier").val();	
	
		
		
		updateexecuterRequetePost(donnees);
	});
	
	
	
	//Annuler le transfert au clic
	$("#annulertransfert").click(function() {
		$("#motif_transfert").val("");
		document.getElementById('service_accueil').value="";
		return false;
	});
	
	//Annuler le rendez-vous au clic
	$("#annulerrendezvous").click(function() {
		$("#motif_rv").val("");
		$("#date_rv").val("");
		document.getElementById('heure_rv').value="";
		return false;
	});
	
	//Annuler le traitement chirurgical au clic
	$("#annuler_traitement_chirurgical").click(function() {
		$("#diagnostic_traitement_chirurgical").val("");
		$("#intervention_prevue").val("");
		$("#observation").val("");
		return false;
	});

 /**************************************************************************************************************/
 
 /*======================================== MENU ANTECEDENTS MEDICAUX =========================================*/
 
 /**************************************************************************************************************/
 function AntecedentScript(){
	 $(function(){
		//CONSULTATION
		//CONSULTATION
		$("#titreTableauConsultation").toggle(false);
		$("#ListeConsultationPatient").toggle(false);
		$("#ListeCons").toggle(false);
		$("#boutonTerminerConsultation").toggle(false);
		$(".pager").toggle(false);
		
		//HOSPITALISATION
		//HOSPITALISATION
		$("#titreTableauHospitalisation").toggle(false);
		$("#boutonTerminerHospitalisation").toggle(false);
		$("#ListeHospitalisation").toggle(false);
		$("#ListeHospi").toggle(false);
		
		
		//CONSULTATION
		//CONSULTATION
		$(".image1").click(function(){
			
			 $("#MenuAntecedent").fadeOut(function(){ 
				 $("#titreTableauConsultation").fadeIn("fast");
				 $("#ListeConsultationPatient").fadeIn("fast"); 
				 $("#ListeCons").fadeIn("fast");
			     $("#boutonTerminerConsultation").toggle(true);
			     $(".pager").toggle(true);
			 });
		});
		
		$("#TerminerConsultation").click(function(){
			$("#boutonTerminerConsultation").fadeOut();
			$(".pager").fadeOut();
			$("#titreTableauConsultation").fadeOut();
			$("#ListeCons").fadeOut();
			$("#ListeConsultationPatient").fadeOut(function(){ 
			    $("#MenuAntecedent").fadeIn("fast");
			});
		});
		
		//HOSPITALISATION
		//HOSPITALISATION
		$(".image2").click(function(){
			 $("#MenuAntecedent").fadeOut(function(){ 
				 $("#titreTableauHospitalisation").fadeIn("fast");
			     $("#boutonTerminerHospitalisation").toggle(true);
			     $("#ListeHospitalisation").fadeIn("fast");
			     $("#ListeHospi").fadeIn("fast");
			 });
		});
		
		$("#TerminerHospitalisation").click(function(){
			$("#boutonTerminerHospitalisation").fadeOut();
			$("#ListeHospitalisation").fadeOut();
			$("#ListeHospi").fadeOut();
			$("#titreTableauHospitalisation").fadeOut(function(){ 
			    $("#MenuAntecedent").fadeIn("fast");
			});
		});
		
		
	 });

	 /*************************************************************************************************************/
	 
	 /*=================================== MENU ANTECEDENTS TERRAIN PARTICULIER ==================================*/
	 
	 /*************************************************************************************************************/
		 
	 $(function(){
		 
		
		    //ANTECEDENTS PERSONNELS
			//ANTECEDENTS PERSONNELS
			$("#antecedentsPersonnels").toggle(false);
			$("#AntecedentsFamiliaux").toggle(false);
			$("#MenuAntecedentPersonnel").toggle(false);
			$("#HabitudesDeVie").toggle(false);
			$("#AntecedentMedicaux").toggle(false);
			//$("#SousDossier").toggle(false);
			$("#AntecedentChirurgicaux").toggle(false);
			$("#GynecoObstetrique").toggle(false);
			
	//*****************************************************************
    //*****************************************************************
			//ANTECEDENTS PERSONNELS
			//ANTECEDENTS PERSONNELS
			$(".image1_TP").click(function(){
				 $("#MenuTerrainParticulier").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			$(".image_fleche").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#MenuTerrainParticulier").fadeIn("fast");
				 });
			});
			
			//HABITUDES DE VIE
			//HABITUDES DE VIE
			$(".image1_AP").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#HabitudesDeVie").fadeIn("fast");
				 });
			});
			
			$("#TerminerHabitudeDeVie").click(function(){
				$("#HabitudesDeVie").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			//ANTECEDENTS MEDICAUX
			//ANTECEDENTS MEDICAUX
			$(".image2_AP").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#AntecedentMedicaux").fadeIn("fast");
				 });
			});
			
			$("#TerminerAntecedentMedicaux").click(function(){
				$("#AntecedentMedicaux").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			//ANTECEDENTS CHIRURGICAUX
			//ANTECEDENTS CHIRURGICAUX
			$(".image3_AP").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#AntecedentChirurgicaux").fadeIn("fast");
				 });
			});
			
			$("#TerminerAntecedentChirurgicaux").click(function(){
				$("#AntecedentChirurgicaux").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			//ANTECEDENTS CHIRURGICAUX
			//ANTECEDENTS CHIRURGICAUX
			$(".image4_AP").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#GynecoObstetrique").fadeIn("fast");
				 });
			});
			
			$("#TerminerGynecoObstetrique").click(function(){
				$("#GynecoObstetrique").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			
			//HABITUDES DE VIE TESTER SI UNE HABITUDE EST COCHEE OU PAS
			//HABITUDES DE VIE TESTER SI UNE HABITUDE EST COCHEE OU PAS
			//$("#HabitudesDeVie input[name=testHV]").attr('checked', true);
			
			if(temoinAlcoolique != 1){
				$("#dateDebAlcoolique, #dateFinAlcoolique").toggle(false);
			}
			if(temoinFumeurHV != 1){
				$("#dateDebFumeur, #dateFinFumeur, #nbPaquetJour, #nbPaquetAnnee").toggle(false);
				$('#nbPaquetFumeurHV').val("");
				$('#nbPaquetAnnee').toggle(false);
			}else{
				if(nbPaquetFumeurHV != 0 ){
					var nbPaquetAnnee = nbPaquetFumeurHV*365;
					$("#nbPaquetAnnee label").html("<span style='font-weight: bold; color: green;'>"+nbPaquetAnnee+"</span> paquets/an");
				}else{
					$('#nbPaquetFumeurHV').val("");
					$('#nbPaquetAnnee').toggle(false);
				}
			}
			if(temoinDroguerHV != 1){
				$("#dateDebDroguer, #dateFinDroguer").toggle(false);
			}
			
			$("#DivNoteAutresHV").toggle(false);
			
			if($('#DateDebutAlcooliqueHV').val() == '00/00/0000'){ $('#DateDebutAlcooliqueHV').val("");}
			if($('#DateFinAlcooliqueHV').val() == '00/00/0000'){ $('#DateFinAlcooliqueHV').val("");}
			$('#HabitudesDeVie input[name=AlcooliqueHV]').click(function(){
				var boutons = $('#HabitudesDeVie input[name=AlcooliqueHV]');
				if( boutons[1].checked){ $("#dateDebAlcoolique, #dateFinAlcoolique").toggle(true); }
				if(!boutons[1].checked){ $("#dateDebAlcoolique, #dateFinAlcoolique").toggle(false); }
			});
			
			if($('#DateDebutFumeurHV').val() == '00/00/0000'){ $('#DateDebutFumeurHV').val("");}
			if($('#DateFinFumeurHV').val() == '00/00/0000'){ $('#DateFinFumeurHV').val("");}
			$('#HabitudesDeVie input[name=FumeurHV]').click(function(){
				var boutons = $('#HabitudesDeVie input[name=FumeurHV]');
				if( boutons[1].checked){ $("#dateDebFumeur, #dateFinFumeur, #nbPaquetJour, #nbPaquetAnnee").toggle(true); }
				if(!boutons[1].checked){ $("#dateDebFumeur, #dateFinFumeur, #nbPaquetJour, #nbPaquetAnnee").toggle(false); }
				if($('#nbPaquetFumeurHV').val() == ""){ $('#nbPaquetAnnee').toggle(false);} 
			});
			
			$('#nbPaquetFumeurHV').keyup(function(){
				var valeur = $('#nbPaquetFumeurHV').val();
				if(isNaN(valeur/1) || valeur > 10){
					$('#nbPaquetFumeurHV').val("");
					valeur = null;
				}
				if(valeur){
					var nbPaquetAnnee = valeur*365;
					$("#nbPaquetAnnee").toggle(true);
					$("#nbPaquetAnnee label").html("<span style='font-weight: bold; color: green;'>"+nbPaquetAnnee+"</span> paquets/an");
				}else{
					$("#nbPaquetAnnee").toggle(false);
				}
			}); 
			
			if($('#DateDebutDroguerHV').val() == '00/00/0000'){ $('#DateDebutDroguerHV').val("");}
			if($('#DateFinDroguerHV').val() == '00/00/0000'){ $('#DateFinDroguerHV').val("");}
			$('#HabitudesDeVie input[name=DroguerHV]').click(function(){
				var boutons = $('#HabitudesDeVie input[name=DroguerHV]');
				if( boutons[1].checked){ $("#dateDebDroguer, #dateFinDroguer").toggle(true); }
				if(!boutons[1].checked){ $("#dateDebDroguer, #dateFinDroguer").toggle(false); }
			});
			
			$('#HabitudesDeVie input[name=AutresHV]').click(function(){
				var boutons = $('#HabitudesDeVie input[name=AutresHV]');
				if( boutons[1].checked){ $("#DivNoteAutresHV").toggle(true); }
				if(!boutons[1].checked){ $("#DivNoteAutresHV").toggle(false); }
			});

			//ANTECEDENTS MEDICAUX TESTER SI C'EST COCHE
			//ANTECEDENTS MEDICAUX TESTER SI C'EST COCHE
			if(temoinDiabeteAM != 1){
				$(".imageValiderDiabeteAM").toggle(false);
			}
			if(temoinhtaAM != 1){
				$(".imageValiderHtaAM").toggle(false);
			}
			if(temoindrepanocytoseAM != 1){
				$(".imageValiderDrepanocytoseAM").toggle(false);
			}
			if(temoindislipidemieAM != 1){
				$(".imageValiderDislipidemieAM").toggle(false);
			}
			if(temoinasthmeAM != 1){
				$(".imageValiderAsthmeAM").toggle(false);
			}
			
		

			$('#AntecedentMedicaux input[name=DiabeteAM]').click(function(){
				var boutons = $('#AntecedentMedicaux input[name=DiabeteAM]');
				if( boutons[1].checked){ $(".imageValiderDiabeteAM").toggle(true); }
				if(!boutons[1].checked){ $(".imageValiderDiabeteAM").toggle(false); }
			});
			
			$('#AntecedentMedicaux input[name=htaAM]').click(function(){
				var boutons = $('#AntecedentMedicaux input[name=htaAM]');
				if( boutons[1].checked){ $(".imageValiderHtaAM").toggle(true); }
				if(!boutons[1].checked){ $(".imageValiderHtaAM").toggle(false); }
			});
			
			$('#AntecedentMedicaux input[name=drepanocytoseAM]').click(function(){
				var boutons = $('#AntecedentMedicaux input[name=drepanocytoseAM]');
				if( boutons[1].checked){ $(".imageValiderDrepanocytoseAM").toggle(true); }
				if(!boutons[1].checked){ $(".imageValiderDrepanocytoseAM").toggle(false); }
			});
			
			$('#AntecedentMedicaux input[name=dislipidemieAM]').click(function(){
				var boutons = $('#AntecedentMedicaux input[name=dislipidemieAM]');
				if( boutons[1].checked){ $(".imageValiderDislipidemieAM").toggle(true); }
				if(!boutons[1].checked){ $(".imageValiderDislipidemieAM").toggle(false); }
			});
			
			$('#AntecedentMedicaux input[name=asthmeAM]').click(function(){
				var boutons = $('#AntecedentMedicaux input[name=asthmeAM]');
				if( boutons[1].checked){ $(".imageValiderAsthmeAM").toggle(true); }
				if(!boutons[1].checked){ $(".imageValiderAsthmeAM").toggle(false); }
			});
			
			
		
			
			//GYNECO-OBSTETRIQUE TESTER SI C'EST COCHE
			//GYNECO-OBSTETRIQUE TESTER SI C'EST COCHE
			if(temoinMenarcheGO != 1){
				$("#NoteMonarche").toggle(false);
			}
			if(temoinGestiteGO != 1){
				$("#NoteGestite").toggle(false);
			}
			if(temoinPariteGO != 1){
				$("#NoteParite").toggle(false);
			}
			if(temoinCycleGO != 1){
				$("#RegulariteON, #DysmenorrheeON, #DureeGO").toggle(false);
			}
			$("#DivNoteAutresGO").toggle(false);
			
			$('#GynecoObstetrique input[name=MenarcheGO]').click(function(){
				var boutons = $('#GynecoObstetrique input[name=MenarcheGO]');
				if( boutons[1].checked){ $("#NoteMonarche").toggle(true); }
				if(!boutons[1].checked){ $("#NoteMonarche").toggle(false); }
			});
			
			$('#GynecoObstetrique input[name=GestiteGO]').click(function(){
				var boutons = $('#GynecoObstetrique input[name=GestiteGO]');
				if( boutons[1].checked){ $("#NoteGestite").toggle(true); }
				if(!boutons[1].checked){ $("#NoteGestite").toggle(false); }
			});
			
			$('#GynecoObstetrique input[name=PariteGO]').click(function(){
				var boutons = $('#GynecoObstetrique input[name=PariteGO]');
				if( boutons[1].checked){ $("#NoteParite").toggle(true); }
				if(!boutons[1].checked){ $("#NoteParite").toggle(false); }
			});
			
			$('#GynecoObstetrique input[name=CycleGO]').click(function(){
				var boutons = $('#GynecoObstetrique input[name=CycleGO]');
				if( boutons[1].checked){ $("#RegulariteON, #DysmenorrheeON, #DureeGO").toggle(true); }
				if(!boutons[1].checked){ $("#RegulariteON, #DysmenorrheeON, #DureeGO").toggle(false); }
			});
			
			$('#GynecoObstetrique input[name=AutresGO]').click(function(){
				var boutons = $('#GynecoObstetrique input[name=AutresGO]');
				if( boutons[1].checked){ $("#DivNoteAutresGO").toggle(true); }
				if(!boutons[1].checked){ $("#DivNoteAutresGO").toggle(false); }
			});
			
			//ANTECEDENTS FAMILIAUX TESTER SI C'EST COCHE
			//ANTECEDENTS FAMILIAUX TESTER SI C'EST COCHE
			if(temoinDiabeteAF != 1){
				$("#DivNoteDiabeteAF").toggle(false);
			}
			if(temoinDrepanocytoseAF != 1){
				$("#DivNoteDrepanocytoseAF").toggle(false);
			}
			if(temoinhtaAF != 1){
				$("#DivNoteHtaAF").toggle(false);
			}
			$("#DivNoteAutresAF").toggle(false);
			
			$('#AntecedentsFamiliaux input[name=DiabeteAF]').click(function(){ 
				
				var boutons = $('#AntecedentsFamiliaux input[name=DiabeteAF]');
				if( boutons[1].checked){ $("#DivNoteDiabeteAF").toggle(true); }
				if(!boutons[1].checked){ $("#DivNoteDiabeteAF").toggle(false); }
			});
			
			$('#AntecedentsFamiliaux input[name=DrepanocytoseAF]').click(function(){ 
				var boutons = $('#AntecedentsFamiliaux input[name=DrepanocytoseAF]');
				if( boutons[1].checked){ $("#DivNoteDrepanocytoseAF").toggle(true); }
				if(!boutons[1].checked){ $("#DivNoteDrepanocytoseAF").toggle(false); }
			});
			
			$('#AntecedentsFamiliaux input[name=htaAF]').click(function(){ 
				var boutons = $('#AntecedentsFamiliaux input[name=htaAF]');
				if( boutons[1].checked){ $("#DivNoteHtaAF").toggle(true); }
				if(!boutons[1].checked){ $("#DivNoteHtaAF").toggle(false); }
			});
			
			$('#AntecedentsFamiliaux input[name=autresAF]').click(function(){ 
				var boutons = $('#AntecedentsFamiliaux input[name=autresAF]');
				if( boutons[1].checked){ $("#DivNoteAutresAF").toggle(true); }
				if(!boutons[1].checked){ $("#DivNoteAutresAF").toggle(false); }
			});
    //******************************************************************************
	//******************************************************************************
			$(".image2_TP").click(function(){
				$("#MenuTerrainParticulier").fadeOut(function(){ 
					 $("#AntecedentsFamiliaux").fadeIn("fast");
				 });
			}); 
			
			$("#TerminerAntecedentsFamiliaux").click(function(){
				$("#AntecedentsFamiliaux").fadeOut(function(){ 
					 $("#MenuTerrainParticulier").fadeIn("fast");
				 });
			}); 
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			$(".imageValiderFOC").toggle(false); 
			
			$('.BUcheckbox input[name=fiche_observation_clinique]').click(function(){
				var boutons = $('.BUcheckbox input[name=fiche_observation_clinique]');
				
				//alert(boutons[1].checked);
				if( boutons[1].checked){ $(".imageValiderFOC").toggle(true); }
				if(!boutons[1].checked){ $(".imageValiderFOC").toggle(false); }
			});
	 });
}
 
 
 /***************************************************************************************/
 
 /**========================== PAGINATION INTERVENTION ================================**/
 
 /***************************************************************************************/

 function pagination(){
	  $(function(){
 		//CODE POUR INITIALISER LA LISTE 
 		$('#ListeConsultationPatient').each(function() {
             var currentPage = 0;
             var numPerPage = 3;
             var $table = $(this);
               $table.find('tbody tr').hide()
                 .slice(currentPage * numPerPage, (currentPage + 1) * numPerPage)
                 .show();
 		});
 		//CODE POUR LA PAGINATION
         $('#ListeConsultationPatient').each(function() {
             var currentPage = 0;
             var numPerPage = 3;
             var $table = $(this);
             var repaginate = function() {
               $table.find('tbody tr').hide()
                 .slice(currentPage * numPerPage, (currentPage + 1) * numPerPage)
                 .show();
             };
             var numRows = $table.find('tbody tr').length;
             var numPages = Math.ceil(numRows / numPerPage);
             var $pager = $('<div class="pager"></div>');
             
             
             for (var page = 0; page < numPages; page++) {
               $('<a class="page-number" id="page_number" style="cursor:pointer; margin-right: 5px; background: #efefef; width:80px; height:80px; padding-left: 10px; padding-right: 10px; padding-top: 2px; padding-bottom: 2px; border: 1px solid gray;"></a>').text(page + 1)
                 .bind('click', {newPage: page}, function(event) {
                   currentPage = event.data['newPage'];
                   repaginate();
                   $(this).addClass('active').css({'background': '#8e908d', 'color':'white'}).siblings().removeClass('active').css({'background': '#efefef', 'color':'black'});
                 }).appendTo($pager).addClass('clickable');
             }
           
             
             $pager.insertAfter($table)
               .find('a.page-number:first').addClass('active').css({'background': '#8e908d', 'color':'white'});
           });
	  });
 }
 
 function jsPagination() {
	    $('#ListeConsultationPatient, #ListeHospitalisation').dataTable
		( {
						"sPaginationType": "full_numbers",
						"aaSorting": [], //pour trier la liste affichee
						"oLanguage": {
							"sZeroRecords":  "Aucun &eacute;l&eacute;ment &agrave; afficher",
							"sInfo": "_START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
							"sInfoEmpty": "0 &eacute;l&eacute;ment &agrave; afficher",
							"sInfoFiltered": "",
							"sInfoPostFix":  "",
							"sSearch": "",
							"sUrl": "",
							"sWidth": "30px",
							"oPaginate": {
								"sFirst":    "|<",
								"sPrevious": "<",
								"sNext":     ">",
								"sLast":     ">|"
								}
						   },
						   "iDisplayLength": 3,
							"aLengthMenu": [1,2,3],
		} );
 }
 
/***************************************************************************************/
 
 /**========================== CONSTANTES CONSTANTES  ================================**/
 
 /***************************************************************************************/
		
    $('table input').attr('autocomplete', 'off');
	//*********************************************************************
	//*********************************************************************
	//*********************************************************************
		function dep1(){
			$('#depliantBandelette').click(function(){
				$("#depliantBandelette").replaceWith("<img id='depliantBandelette' style='cursor: pointer; position: absolute; padding-right: 120px; margin-left: -5px;' src='../img/light/plus.png' />");
				dep();
			    $('#BUcheckbox').animate({
			        height : 'toggle'
			    },1000);
			 return false;
			});
		}
		
		function dep(){ 
			$('#depliantBandelette').click(function(){
				$("#depliantBandelette").replaceWith("<img id='depliantBandelette' style='cursor: pointer; position: absolute; padding-right: 120px; margin-left: -5px;' src='../img/light/minus.png' />");
				dep1();
			    $('#BUcheckbox').animate({
			        height : 'toggle'
			    },1000);
			 return false;
			});
		}
			
 
    //TESTER LEQUEL DES CHECKBOX est coch?	//TESTER LEQUEL DES CHECKBOX est coch?	//maskDeSaisie();
	OptionCochee();
	function OptionCochee() {
	$("#labelAlbumine").toggle(false);
	$("#labelSucre").toggle(false);
	$("#labelCorpscetonique").toggle(false);

	//AFFICHER SI C'EST COCHE
	//AFFICHER SI C'EST COCHE
	var boutonsAlbumine = $('#BUcheckbox input[name=albumine]');
	if(boutonsAlbumine[1].checked){ $("#labelAlbumine").toggle(true); }
	
	var boutonsSucre = $('#BUcheckbox input[name=sucre]');
	if(boutonsSucre[1].checked){ $("#labelSucre").toggle(true); }

	var boutonsCorps = $('#BUcheckbox input[name=corpscetonique]');
	if(boutonsCorps[1].checked){ $("#labelCorpscetonique").toggle(true); }

	//AFFICHER AU CLICK SI C'EST COCHE
	//AFFICHER AU CLICK SI C'EST COCHE
	$('#BUcheckbox input[name=albumine]').click(function(){
		$("#ChoixPlus").toggle(false);
		var boutons = $('#BUcheckbox input[name=albumine]');
		if(boutons[0].checked){	$("#labelAlbumine").toggle(false); $("#BUcheckbox input[name=croixalbumine]").attr('checked', false); }
		if(boutons[1].checked){ $("#labelAlbumine").toggle(true); $("#labelCroixAlbumine").toggle(true);}
	});

	$('#BUcheckbox input[name=sucre]').click(function(){
		$("#ChoixPlus2").toggle(false);
		var boutons = $('#BUcheckbox input[name=sucre]');
		if(boutons[0].checked){	$("#labelSucre").toggle(false); $("#BUcheckbox input[name=croixsucre]").attr('checked', false); }
		if(boutons[1].checked){ $("#labelSucre").toggle(true); $("#labelCroixSucre").toggle(true);}
	});

	$('#BUcheckbox input[name=corpscetonique]').click(function(){
		$("#ChoixPlus3").toggle(false);
		var boutons = $('#BUcheckbox input[name=corpscetonique]');
		if(boutons[0].checked){	$("#labelCorpscetonique").toggle(false); $("#BUcheckbox input[name=croixcorpscetonique]").attr('checked', false); }
		if(boutons[1].checked){ $("#labelCorpscetonique").toggle(true); $("#labelCroixCorpscetonique").toggle(true);}
	});
	
	}
	
	//CHOIX DU CROIX
	//========================================================
	$("#ChoixPlus").toggle(false);
	albumineOption();
	function albumineOption(){
		var boutons = $('#BUcheckbox input[name=croixalbumine]');
		if(boutons[0].checked){
			$("#labelCroixAlbumine").toggle(false); 
			$("#ChoixPlus").toggle(true); 
			$("#ChoixPlus label").html("1+");

		}
		if(boutons[1].checked){ 
			$("#labelCroixAlbumine").toggle(false); 
			$("#ChoixPlus").toggle(true); 
			$("#ChoixPlus label").html("2+");

		}
		if(boutons[2].checked){ 
			$("#labelCroixAlbumine").toggle(false); 
			$("#ChoixPlus").toggle(true); 
			$("#ChoixPlus label").html("3+");
			
		}
		if(boutons[3].checked){ 
			$("#labelCroixAlbumine").toggle(false); 
			$("#ChoixPlus").toggle(true); 
			$("#ChoixPlus label").html("4+");

		}
	}
	
	$('#BUcheckbox input[name=croixalbumine]').click(function(){
		albumineOption();
	});

	//========================================================
	$("#ChoixPlus2").toggle(false);
	sucreOption();
	function sucreOption(){
		var boutons = $('#BUcheckbox input[name=croixsucre]');
		if(boutons[0].checked){
			$("#labelCroixSucre").toggle(false); 
			$("#ChoixPlus2").toggle(true); 
			$("#ChoixPlus2 label").html("1+");

		}
		if(boutons[1].checked){ 
			$("#labelCroixSucre").toggle(false); 
			$("#ChoixPlus2").toggle(true); 
			$("#ChoixPlus2 label").html("2+");

		}
		if(boutons[2].checked){ 
			$("#labelCroixSucre").toggle(false); 
			$("#ChoixPlus2").toggle(true); 
			$("#ChoixPlus2 label").html("3+");
			
		}
		if(boutons[3].checked){ 
			$("#labelCroixSucre").toggle(false); 
			$("#ChoixPlus2").toggle(true); 
			$("#ChoixPlus2 label").html("4+");

		}
	}
	$('#BUcheckbox input[name=croixsucre]').click(function(){
		sucreOption();
	});

	//========================================================
	$("#ChoixPlus3").toggle(false);
	corpscetoniqueOption();
	function corpscetoniqueOption(){
		var boutons = $('#BUcheckbox input[name=croixcorpscetonique]');
		if(boutons[0].checked){
			$("#labelCroixCorpscetonique").toggle(false); 
			$("#ChoixPlus3").toggle(true); 
			$("#ChoixPlus3 label").html("1+");

		}
		if(boutons[1].checked){ 
			$("#labelCroixCorpscetonique").toggle(false); 
			$("#ChoixPlus3").toggle(true); 
			$("#ChoixPlus3 label").html("2+");

		}
		if(boutons[2].checked){ 
			$("#labelCroixCorpscetonique").toggle(false); 
			$("#ChoixPlus3").toggle(true); 
			$("#ChoixPlus3 label").html("3+");
			
		}
		if(boutons[3].checked){ 
			$("#labelCroixCorpscetonique").toggle(false); 
			$("#ChoixPlus3").toggle(true); 
			$("#ChoixPlus3 label").html("4+");

		}
	}
	$('#BUcheckbox input[name=croixcorpscetonique]').click(function(){
		corpscetoniqueOption();
	});
	
	
	//******************* VALIDER LES DONNEES DU TABLEAU DES MOTIFS ******************************** 
	//******************* VALIDER LES DONNEES DU TABLEAU DES MOTIFS ******************************** 
	 	     
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	//******************* VALIDER LES DONNEES DU TABLEAU DES CONSTANTES ******************************** 
	 //******************* VALIDER LES DONNEES DU TABLEAU DES CONSTANTES ******************************** 

	   //Au debut on d�sactive le code cons et la date de consultation qui sont non modifiables
	  	var id_cons = $("#id_cons");
	  	var date_cons = $("#date_cons");
	  	id_cons.attr('readonly',true);
	  	date_cons.attr('readonly',true);

	  	var poids = $('#poids');
	  	var taille = $('#taille');
	  	var tension = $('#tension');
	  	var bu = $('#bu');
	  	var temperature = $('#temperature');
	  	var glycemie_capillaire = $('#glycemie_capillaire');
	  	var pouls = $('#pouls');
	  	var frequence_respiratoire = $('#frequence_respiratoire');
	  	var tensionmaximale = $("#tensionmaximale");
	  	var tensionminimale = $("#tensionminimale");
	  	
		  //Au debut on cache le bouton modifier et on affiche le bouton valider
	  	$( "#bouton_constantes_valider" ).toggle(true);
	  	$( "#bouton_constantes_modifier" ).toggle(false);

	  	//Au debut on active tous les champs
	  	poids.attr( 'readonly', false ).css({'background':'#fff'});
	  	taille.attr( 'readonly', false ).css({'background':'#fff'});
	  	tension.attr( 'readonly', false).css({'background':'#fff'}); 
	  	bu.attr( 'readonly', false).css({'background':'#fff'});  
	  	temperature.attr( 'readonly', false).css({'background':'#fff'}); 
	  	glycemie_capillaire.attr( 'readonly', false).css({'background':'#fff'});
	  	pouls.attr( 'readonly', false).css({'background':'#fff'});
	  	frequence_respiratoire.attr( 'readonly', false).css({'background':'#fff'});
	  	tensionmaximale.attr( 'readonly', false ).css({'background':'#fff'});
	  	tensionminimale.attr( 'readonly', false ).css({'background':'#fff'});

	  	$( "#bouton_constantes_valider" ).click(function(){
	  		if(valid == true){
		   		poids.attr( 'readonly', true ).css({'background':'#f8f8f8'});    
		   		taille.attr( 'readonly', true ).css({'background':'#f8f8f8'});
		   		tension.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		bu.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		temperature.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		glycemie_capillaire.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		pouls.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		frequence_respiratoire.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		tensionmaximale.attr( 'readonly', true ).css({'background':'#f8f8f8'});
		   		tensionminimale.attr( 'readonly', true ).css({'background':'#f8f8f8'});
		   		
	  		    $("#bouton_constantes_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
	  		    $("#bouton_constantes_valider").toggle(false); //on cache le bouton permettant de valider les champs
	  		}
	  		return false; 
	  	});
	  	
	  	$( "#bouton_constantes_modifier" ).click(function(){
	  		poids.attr( 'readonly', false ).css({'background':'#fff'});
	  		taille.attr( 'readonly', false ).css({'background':'#fff'}); 
	  		tension.attr( 'readonly', false).css({'background':'#fff'}); 
	  		bu.attr( 'readonly', false).css({'background':'#fff'});
	  		temperature.attr( 'readonly', false).css({'background':'#fff'});
	  		glycemie_capillaire.attr( 'readonly', false).css({'background':'#fff'});
	  		pouls.attr( 'readonly', false).css({'background':'#fff'});
	  		frequence_respiratoire.attr( 'readonly', false).css({'background':'#fff'});
	  		tensionmaximale.attr( 'readonly', false ).css({'background':'#fff'});
	  		tensionminimale.attr( 'readonly', false ).css({'background':'#fff'});
	  		
	  	 	$("#bouton_constantes_modifier").toggle(false);   //on cache le bouton permettant de modifier les champs
	  	 	$("#bouton_constantes_valider").toggle(true);    //on affiche le bouton permettant de valider les champs
	  	 	return  false;
	  	});

	  	$('#dateDebAlcoolique input, #dateFinAlcoolique input, #dateDebFumeur input, #dateFinFumeur input, #dateDebDroguer input, #dateFinDroguer input').datepicker(
				$.datepicker.regional['fr'] = {
						closeText: 'Fermer',
						changeYear: true,
						yearRange: 'c-80:c',
						prevText: '&#x3c;Préc',
						nextText: 'Suiv&#x3e;',
						currentText: 'Courant',
						monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
						'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
						monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
						'Jul','Aout','Sep','Oct','Nov','Dec'],
						dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
						dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
						dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
						weekHeader: 'Sm',
						dateFormat: 'dd/mm/yy',
						firstDay: 1,
						isRTL: false,
						showMonthAfterYear: false,
						yearRange: '1990:2025',
						showAnim : 'bounce',
						changeMonth: true,
						changeYear: true,
						yearSuffix: ''}
		);
	  	
	  	
	  	$('#date_fin_hospitalisation_prevue').datepicker(
				$.datepicker.regional['fr'] = {
						closeText: 'Fermer',
						changeYear: true,
						yearRange: 'c-80:c',
						prevText: '&#x3c;Préc',
						nextText: 'Suiv&#x3e;',
						currentText: 'Courant',
						monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
						'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
						monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
						'Jul','Aout','Sep','Oct','Nov','Dec'],
						dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
						dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
						dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
						weekHeader: 'Sm',
						dateFormat: 'dd/mm/yy',
						firstDay: 1,
						isRTL: false,
						minDate: 1,
						showMonthAfterYear: false,
						yearRange: '1990:2025',
						showAnim : 'bounce',
						changeMonth: true,
						changeYear: true,
						yearSuffix: '',
				}
		);
	  	
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	var itab = 1;
	  	var ligne = 0; 
	  	var tableau = [];
	  	
	  	function ajouterToutLabelAntecedentsMedicaux(tableau_){
	  		for(var l = 1; l <= ligne; l++){
	  			if( l == 1 ){
		  			$("#labelDesAntecedentsMedicaux_"+1).html("").css({'height' : '0px'});
		  			itab = 1;
	  			} else {
		  			$("#labelDesAntecedentsMedicaux_"+l).remove();
	  			}
	  		}
	  		
	  		var tab = [];
	  		var j = 1;
	  		
	  		for(var i=1 ; i<tableau_.length ; i++){
	  			if( tableau_[i] ){
	  				tab[j++] = tableau_[i];
	  				itab++;
	  				ajouterLabelAntecedentsMedicaux(tableau_[i]);
	  			}
	  		}

	  		tableau = tab;
	  		itab = j;
	  		$('#nbCheckboxAM').val(itab);

	  		stopPropagation();
	  	}
	  	
	  	
	  	//Ajouter des labels au click sur ajouter
	  	//Ajouter des labels au click sur ajouter
	  	//Ajouter des labels au click sur ajouter
	  	var scriptLabel = "";
	  	function ajouterLabelAntecedentsMedicaux(nomLabel){
	  		
	  		if(!nomLabel){ stopPropagation(); }
	  		
	  		var reste = ( itab - 1 ) % 5; 
	  		var nbElement = parseInt( ( itab - 1 ) / 5 ); 
	  		if(reste != 0){ ligne = nbElement + 1; }
	  		else { ligne = nbElement; }
	  		
	  		var i = 0;
	  		if(ligne == 1){
		  		i = $("#labelDesAntecedentsMedicaux_"+ligne+" td").length;
	  		} else {
	  			if(reste == 1){
		  			$("#labelDesAntecedentsMedicaux_"+(ligne-1)).after(
	            			"<tr id='labelDesAntecedentsMedicaux_"+ligne+"' style='width:100%; '>"+
	            			"</tr>");
	  			}
	  			i = $("#labelDesAntecedentsMedicaux_"+ligne+" td").length;
	  		}
	  		
	  		scriptLabel = 
  				"<td id='BUcheckbox' class='label_"+ligne+"_"+i+"' style='width: 20%; '> "+
                "<div > "+
                " <label style='width: 90%; height:30px; text-align:right; font-family: time new romans; font-size: 18px;'> "+
                "    <span style='padding-left: -10px;'> "+
                "       <a href='javascript:supprimerLabelAM("+ligne+","+i+");' ><img class='imageSupprimerAsthmeAM' style='cursor: pointer; float: right; margin-right: -10px; width:10px; height: 10px;' src='"+tabUrl[0]+"public/images_icons/sup.png' /></a> "+ 
                "       <img class='imageValider_"+ligne+"_"+i+"'  style='cursor: pointer; margin-left: -15px;' src='"+tabUrl[0]+"public/images_icons/tick-icon2.png' /> "+  
                "    </span> "+
                nomLabel +"  <input type='checkbox' checked='${this.checked}' name='champValider_"+ligne+"_"+i+"' id='champValider_"+ligne+"_"+i+"' > "+
                " <input type='hidden'  id='champTitreLabel_"+ligne+"_"+i+"' value='"+nomLabel+"' > "+
                " </label> "+
                "</div> "+
                "</td> "+
                
                "<script>"+
                "$('#champValider_"+ligne+"_"+i+"').click(function(){"+
	  			"var boutons = $('#champValider_"+ligne+"_"+i+"');"+
	  			"if( boutons[0].checked){ $('.imageValider_"+ligne+"_"+i+"').toggle(true);  }"+
	  			"if(!boutons[0].checked){ $('.imageValider_"+ligne+"_"+i+"').toggle(false); }"+
	  		    "});"+
	  		    "</script>"
                ;
	  		
	  		if( i == 0 ){
	  			//AJOUTER ELEMENT SUIVANT
	            $("#labelDesAntecedentsMedicaux_"+ligne).html(scriptLabel);
	            $("#labelDesAntecedentsMedicaux_"+ligne).css({'height' : '50px'});
	  	    } else if( i < 5 ){
	  	    	//AJOUTER ELEMENT SUIVANT
	            $("#labelDesAntecedentsMedicaux_"+ligne+" .label_"+ligne+"_"+(i-1)).after(scriptLabel);
	  	    }
	  		
	  	}

	  	//Ajouter un label --- Ajouter un label
	  	//Ajouter un label --- Ajouter un label
	  	//Ajouter un label --- Ajouter un label

	  	$('#imgIconeAjouterLabel').click(function(){
	  		if(!$('#autresAM').val()){ stopPropagation(); }
	  		else{
	  			tableau[itab++] = $('#autresAM').val();
	  			ajouterLabelAntecedentsMedicaux($('#autresAM').val());
	  			$('#nbCheckboxAM').val(itab);
	  			$('#autresAM').val("");
	  		}
	  		stopPropagation();
	  	});
	  	
	  	
	  	//Supprimer un label ajouter --- Supprimer un label ajouter
	  	//Supprimer un label ajouter --- Supprimer un label ajouter
	  	//Supprimer un label ajouter --- Supprimer un label ajouter
	  	function supprimerLabelAM(ligne, i){
	  		
	  		var pos = ((ligne - 1)*5)+i;
	  		var indiceTableau = pos+1; 
	  		tableau[indiceTableau] = "";
	  		
	  		$("#labelDesAntecedentsMedicaux_"+ligne+" .label_"+ligne+"_"+i).fadeOut(
	  			function(){	ajouterToutLabelAntecedentsMedicaux(tableau); }
	  		);
		  	
	  	}
        
	  	//Ajout de l'auto-completion sur le champ autre
	    //Ajout de l'auto-completion sur le champ autre
	  	
	  	function autocompletionAntecedent(myArrayMedicament){
		  	$( "#imageIconeAjouterLabel label input" ).autocomplete({
			  	  source: myArrayMedicament
			    });
	  	}
	  	
	  	
	  	function affichageAntecedentsMedicauxDuPatient(nbElement, tableau_){
	  		for(var i=1 ; i<=nbElement ; i++){
	  			itab++;
	  			ajouterLabelAntecedentsMedicaux(tableau_[i]);
	  		}
	  		tableau = tableau_;
	  	}
	  	
	    //===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	//===================================================================================================================
	  	
