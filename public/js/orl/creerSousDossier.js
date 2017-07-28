
setTimeout(function(){
	$('#tab-fiche-observation, #tab-tyroide').toggle(false);
	//$('#tab-tyroide, #tab-parotidien').toggle(false);
	$('#tabsSousDossier, #tabsSousDossier ul li a').toggle(false);
	$('#tabsCompteRendu ul li a').toggle(true);
	$('#tabsSurveillance ul li a').toggle(true);
}, 1000);

var tableauSousDossier = [];

//Gestion du choix des sous dossiers 
//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
function popupChoixSousDossier(){
  $( "#choix_sous_dossier" ).dialog({
    resizable: false,
    height:300,
    width:250,
    autoOpen: false,
    modal: true,
    buttons: {
    	"Annuler": function() {
            $( this ).dialog( "close" );
        },
        "Valider": function( ) {
            $( this ).dialog( "close" );
            
            var entre = 0;
            var first = 0;
            var i=1 ;
            for( ; i<tableauSousDossier.length ; i++){
            	if(tableauSousDossier[i] && entre == 0){
            		$('#tabsSousDossier').toggle(true);
            		entre = 1;
            		first = i; 
            	}
            	
            	//Affichage des sous-dossiers cochés
            	
            	if(i == 1){ 
            		if(tableauSousDossier[i]){
                		$('#tab-fiche-observation, .tab-fiche-observation a').toggle(true); $('.ls'+first+' a').trigger('click'); 
            		}else{ 
            			$('#tab-fiche-observation, .tab-fiche-observation a').toggle(false);
            		}
            	}
            	if(i == 2){ 
            		if(tableauSousDossier[i]){
                		$('#tab-tyroide, .tab-tyroide a').toggle(true); $('.ls'+first+' a').trigger('click'); 
            		}else{ 
            			$('#tab-tyroide, .tab-tyroide a').toggle(false);
            		}
            	}


            	
            	if(i == 3){ 
            		if(tableauSousDossier[i]){
                		$('#tab-otologie, .tab-otologie a').toggle(true);  $('.ls'+first+' a').trigger('click');
            		}else{ 
            			$('#tab-otologie, .tab-otologie a').toggle(false);
            		}
            	}
            	
            	if(i == 4){ 
            		if(tableauSousDossier[i]){
                		$('#tab-pharynx, .tab-pharynx a').toggle(true);  $('.ls'+first+' a').trigger('click');
            		}else{ 
            			$('#tab-pharynx, .tab-pharynx a').toggle(false);
            		}
            	}
            	
            	if(i == 5){ 
            		if(tableauSousDossier[i]){
                		$('#tab-larynx, .tab-larynx a').toggle(true);  $('.ls'+first+' a').trigger('click');
            		}else{ 
            			$('#tab-larynx, .tab-larynx a').toggle(false);
            		}
            	}

            }
            
            if(first == 0 ){
            	$('#tabsSousDossier').toggle(false);
            }
        },
   }
  });
}

function choixSousDossier(){
	popupChoixSousDossier();
	$("#choix_sous_dossier").dialog('open');
}


//Lorsqu'on clique sur le bouton pour ajouter un sous dossier 
$('#creerSousDossierPathologique').click(function(){ 
	choixSousDossier();
	return false ;
});


//En choisissant un sous dossier
//En choisissant un sous dossier

//Choix du sous dossier Fiche d'Obsercation Clinique
var boutonsTypeFicheObservation = $('#liste_choix_sous_dossier input[name="fiche-observation"]');
$(boutonsTypeFicheObservation).click(function(){

	if(boutonsTypeFicheObservation[0].checked){ 
		$('#choix1').css({'font-weight' : 'bold', 'font-size' : '17px', 'color' : 'green', 'font-family' : 'Iskoola Pota'});
		$('#choix1 span').html('<img style="padding-left: 10px;" src="../images_icons/tick-icon1.png">');

		tableauSousDossier[1] = 1;
	}else{
		$('#choix1').css({'font-weight' : 'normal',  'color' : 'black', 'font-size' : '17px', 'font-family' : 'times new roman'});
		$('#choix1 span').html('');
		tableauSousDossier[1] = null;
	}

});




//Choix du sous dossier Tyroide
var boutonsTypeTyroide = $('#liste_choix_sous_dossier input[name="tyroide"]');
$(boutonsTypeTyroide).click(function(){

	if(boutonsTypeTyroide[0].checked){ 
		$('#choix2').css({'font-weight' : 'bold', 'font-size' : '17px', 'color' : 'green', 'font-family' : 'Iskoola Pota'});
		$('#choix2 span').html('<img style="padding-left: 10px;" src="../images_icons/tick-icon1.png">');

		tableauSousDossier[2] = 2;
	}else{
		$('#choix2').css({'font-weight' : 'normal',  'color' : 'black', 'font-size' : '17px', 'font-family' : 'times new roman'});
		$('#choix2 span').html('');
		tableauSousDossier[2] = null;
	}

});



//Choix du sous dossier Tumeur Parotidienne
var boutonsTypeOtologie = $('#liste_choix_sous_dossier input[name="otologie"]');
$(boutonsTypeOtologie).click(function(){

	if(boutonsTypeOtologie[0].checked){ 
		$('#choix3').css({'font-weight' : 'bold', 'font-size' : '17px', 'color' : 'green', 'font-family' : 'Iskoola Pota'});
		$('#choix3 span').html('<img style="padding-left: 10px;" src="../images_icons/tick-icon1.png">');

		tableauSousDossier[3] = 3;
	}else{
		$('#choix3').css({'font-weight' : 'normal',  'color' : 'black', 'font-size' : '17px', 'font-family' : 'times new roman'});
		$('#choix3 span').html('');
		tableauSousDossier[3] = null;
	}

});



//Choix du sous dossier Corps Etrangers
var boutonsTypePharynx = $('#liste_choix_sous_dossier input[name="pharynx"]');
$(boutonsTypePharynx).click(function(){

	if(boutonsTypePharynx[0].checked){ 
		$('#choix4').css({'font-weight' : 'bold', 'font-size' : '17px', 'color' : 'green', 'font-family' : 'Iskoola Pota'});
		$('#choix4 span').html('<img style="padding-left: 10px;" src="../images_icons/tick-icon1.png">');

		tableauSousDossier[4] = 4;
	}else{
		$('#choix4').css({'font-weight' : 'normal',  'color' : 'black', 'font-size' : '17px', 'font-family' : 'times new roman'});
		$('#choix4 span').html('');
		tableauSousDossier[4] = null;
	}

});



//Choix du sous dossier Lesions Sphere Orl
var boutonsTypeLarynx = $('#liste_choix_sous_dossier input[name="larynx"]');
$(boutonsTypeLarynx).click(function(){

	if(boutonsTypeLarynx[0].checked){ 
		$('#choix5').css({'font-weight' : 'bold', 'font-size' : '17px', 'color' : 'green', 'font-family' : 'Iskoola Pota'});
		$('#choix5 span').html('<img style="padding-left: 10px;" src="../images_icons/tick-icon1.png">');

		tableauSousDossier[5] = 5;
	}else{
		$('#choix5').css({'font-weight' : 'normal',  'color' : 'black', 'font-size' : '17px', 'font-family' : 'times new roman'});
		$('#choix5 span').html('');
		tableauSousDossier[5] = null;
	}

});
