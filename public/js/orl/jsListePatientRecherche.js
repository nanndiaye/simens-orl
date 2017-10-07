
    var nb="_TOTAL_";
    var asInitVals = new Array();
    var base_url = window.location.toString();
	var tabUrl = base_url.split("public");
	//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
    function confirmation(id_admission){
	  $( "#confirmation" ).dialog({
	    resizable: false,
	    height:170,
	    width:435,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Oui": function() {
	            $( this ).dialog( "close" );
	            var chemin = tabUrl[0]+'public/facturation/supprimer-admission-bloc';
	            $.ajax({
	                type: 'POST',
	                url: chemin ,
	                data:{'id_admission':id_admission},
	                success: function(data) {
	                	     var result = jQuery.parseJSON(data);
	                	     if(result == 1){
	                	    	 alert('impossible de supprimer le patient est deja consulter'); return false;
	                	     } else {
		                	     $("#"+id_admission).parent().parent().parent().fadeOut(function(){ 
		                	    	 vart=tabUrl[0]+'public/facturation/liste-patients-admis-bloc';
		                	    	 $(location).attr("href",vart);
		                	     });
	                	     }
	                },
	                error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
	                dataType: "html"
	            });
	        },
	        "Annuler": function() {
                $( this ).dialog( "close" );
            }
	   }
	  });
    }
    function envoyer(id){
   	   confirmation(id);
       $("#confirmation").dialog('open');
   	}
    
    /**********************************************************************************/
    var diagnostic = "";
	var intervention_prevue = "";
	var vpa = "";
	var salle = "";
	var operateur = "";
	
    var diagnostic2 = "";
	var intervention_prevue2 = "";
	var vpa2 = "";
	var salle2 = "";
	var operateur2 = "";
	
	function valeursChamps(){
	    diagnostic2 = $('#diagnostic').val();
		intervention_prevue2 = $('#intervention_prevue').val();
		vpa2 = $('#vpa').val();
		salle2 = $('#salle').val();
		$('#operateur').attr('disabled', false).css({'background' : '#ffffff'});
		operateur2 = $('#operateur').val();
	}
    
    
    
    /**********************************************************************************/
	var oTable;
	function initialisation(){ 
		var id_patient = $('#id_patient').val();
		
    	//$(".boutonAnnuler").html('<button type="submit" id="annuler" style=" font-family: police2; font-size: 17px; font-weight: bold;"> Annuler </button>');
    	//$(".boutonTerminer").html('<button type="submit" id="terminer" style=" font-family: police2; font-size: 17px; font-weight: bold;"> Terminer </button>');
    	//$("#informationAdmissionBloc").toggle(false);
    	
    	oTable = $('#patient').dataTable
    	( {
    					"sPaginationType": "full_numbers",
    					"aLengthMenu": [5,7,10,15],
    					"aaSorting": [], //On ne trie pas la liste automatiquement
    					"oLanguage": {
    						"sInfo": "_START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    						"sInfoEmpty": "0 &eacute;l&eacute;ment &agrave; afficher",
    						"sInfoFiltered": "",
    						"sUrl": "",
    						"oPaginate": {
    							"sFirst":    "|<",
    							"sPrevious": "<",
    							"sNext":     ">",
    							"sLast":     ">|"
    							}
    					   },

    					"sAjaxSource": tabUrl[0]+"public/orl/info-patient-recherche-ajax?id_patient="+id_patient,
    					"fnDrawCallback": function() 
    					{
    						//markLine();
    						//clickRowHandler();
    					}

    	} );

    	//le filtre du select
    	$('#filter_statut').change(function() 
    	{					
    		oTable.fnFilter( this.value );
    	});

    	$('#liste_service').change(function()
    	{					
    		oTable.fnFilter( this.value );
    	});

    	$("tfoot input").keyup( function () {
    		/* Filter on the column (the index) of this element */
    		oTable.fnFilter( this.value, $("tfoot input").index(this) );
    	} );

    	/*
    	 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
    	 * the footer
    	 */
    	$("tfoot input").each( function (i) {
    		asInitVals[i] = this.value;
    	} );

    	$("tfoot input").focus( function () {
    		if ( this.className == "search_init" )
    		{
    			this.className = "";
    			this.value = "";
    		}
    	} );

    	$("tfoot input").blur( function (i) {
    		if ( this.value == "" )
    		{
    			this.className = "search_init";
    			this.value = asInitVals[$("tfoot input").index(this)];
    		}
    	} );
    	
    	
    	$('#afficherAujourdhui').css({'font-weight':'bold', 'font-size': '17px' });
    	oTable.fnFilter( $('#effectuer_ input').val() , 6 );
    	
    	$('#afficherAujourdhui').click(function(i){
    		oTable.fnFilter( $('#effectuer_ input').val() , 6 );
    		$('#afficherAujourdhui').css({'font-weight':'bold', 'font-size': '17px' });
    		$('#afficherTous').css({'font-weight':'normal', 'font-size': '15px' });
    	});

    	$('#afficherTous').click(function(){
    		oTable.fnFilter( '' , 6 );
    		$('#afficherAujourdhui').css({'font-weight':'normal', 'font-size': '15px'});
    		$('#afficherTous').css({'font-weight':'bold', 'font-size': '17px' });
    	});
    }
    function desactiverChampsInit(){
    	$('#diagnostic').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#intervention_prevue').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#vpa').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#salle').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#operateur').attr('disabled', true).css({'background' : '#f8f8f8'});
    	$('#service').attr('disabled', true).css({'background' : '#f8f8f8'});
    	
    	diagnostic = $('#diagnostic').val();
    	intervention_prevue = $('#intervention_prevue').val();
    	vpa = $('#vpa').val();
    	salle = $('#salle').val();
    	operateur = $('#operateur').val();
    }
    
    function desactiverChamps(){
    	$('#diagnostic').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#intervention_prevue').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#vpa').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#salle').attr('readonly', true).css({'background' : '#f8f8f8'});
    	$('#operateur').attr('disabled', true).css({'background' : '#f8f8f8'});
    }

    function activerChamps(){
    	$('#diagnostic').attr('readonly', false).css({'background' : '#ffffff'});
    	$('#intervention_prevue').attr('readonly', false).css({'background' : '#ffffff'});
    	$('#vpa').attr('readonly', false).css({'background' : '#ffffff'});
    	$('#salle').attr('readonly', false).css({'background' : '#ffffff'});
    	$('#operateur').attr('disabled', false).css({'background' : '#ffffff'});
    }
    
    var i = 0;
    function modifierDonnees(){
    	if(i == 0){
        	activerChamps(); i = 1;
    	}else{
    		desactiverChamps(); i = 0;
    	}
    }
    
    function getservice(id_medecin){
    	var chemin = tabUrl[0]+'public/facturation/get-service';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data:'id_medecin='+id_medecin,
            success: function(data) {    
            	var result = jQuery.parseJSON(data);  
            	$('#service').attr('disabled','false');
            	$('#service').val(result).attr('disabled','false');
            }
        });
    }
    
    
    function getInfosPatients(id_medecin){
    	var chemin = tabUrl[0]+'public/facturation/get-service';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data:'id_medecin='+id_medecin,
            success: function(data) {    
            	var result = jQuery.parseJSON(data);  
            	$('#service').attr('disabled','false');
            	$('#service').val(result).attr('disabled','false');
            }
        });
    }
    
    

    function affichervue(idPatient){
    	
        $.ajax({
            type: 'POST',
            url: tabUrl[0]+'public/orl/vue-infos-patient',
            data:{'idPatient':idPatient},
            success: function(data) {
            	var result = jQuery.parseJSON(data);  
            	
            	$("#vue_patient").html(result);

            }
            
        });
        
    }

