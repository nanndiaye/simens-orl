
$(function() {
var spinner = $( "#date_rv" ).spinner();
var spinner_heure = $("#motif_rv").spinner();
  $( "#disable" ).click(function(){
      spinner.spinner( "disable" ); //d�sactiver la date
      spinner_heure.spinner( "disable" ); //d�sactiver l'heure
      $("#disable_bouton").toggle(true); //on affiche le bouton permettant de d�sactiver les champs
      
  });
  
  $( "button" ).button();

  //Au debut on affiche pas le bouton modifier, on l'affiche seulement apres impression
  $("#disable_bouton").toggle(false);
  
  //Activer avec le bouton 'modifier'
  $( "#disable_bouton" ).click(function(){
	  spinner_heure.spinner( "enable" ); //activer l'heure
	  spinner.spinner( "enable" ); //activer la date
	  $("#disable_bouton").toggle(false); //on cache le bouton permettant de d�sactiver
	  return  false;
  });
  
});

