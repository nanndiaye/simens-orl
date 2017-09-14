var base_url = window.location.toString();
var tabUrl = base_url.split("public");


function sciptListeAntecedent(){ 
	
	setTimeout(function(){
		
		$id_cons = $('#id_cons').val();
		$id_patient = $('#id_patient').val();
		
		$('#listeAntecedentsConsultations').dataTable
		( {
						"sPaginationType": "full_numbers",
						"aaSorting": "", //pour trier la liste affich�e
						"oLanguage": {
							//"sProcessing":   "Traitement en cours...",
							//"sLengthMenu":   "Afficher _MENU_ &eacute;l&eacute;ments",
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
						   "sAjaxSource": tabUrl[0]+"public/orl/liste-consultation-precedente-ajax?id_patient="+$id_patient+"&id_cons="+$id_cons,
						   "iDisplayLength": 5,
							"bProcessing": false,
							"aLengthMenu": [5,10,15],
		} );
	
	
	},500);
    
}











function sciptListeAntecedent(){ 
	
	setTimeout(function(){
		
		$id_cons = $('#id_cons').val();
		$id_patient = $('#id_patient').val();
		
		$('#listeAntecedentsNoteMedical').dataTable
		( {
						"sPaginationType": "full_numbers",
						"aaSorting": "", //pour trier la liste affich�e
						"oLanguage": {
							//"sProcessing":   "Traitement en cours...",
							//"sLengthMenu":   "Afficher _MENU_ &eacute;l&eacute;ments",
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
						   "sAjaxSource": tabUrl[0]+"public/orl/liste-consultation-precedente-ajax?id_patient="+$id_patient+"&id_cons="+$id_cons,
						   "iDisplayLength": 5,
							"bProcessing": false,
							"aLengthMenu": [5,10,15],
		} );
	
	
	},500);
    
}







function scriptListeAntecedent(){ 
	
	setTimeout(function(){
		
		$id_cons = $('#id_cons').val();
		$id_patient = $('#id_patient').val();
		
		$('#listeAntecedentsNotesMedicales').dataTable
		( {
						"sPaginationType": "full_numbers",
						"aaSorting": "", //pour trier la liste affich�e
						"oLanguage": {
							//"sProcessing":   "Traitement en cours...",
							//"sLengthMenu":   "Afficher _MENU_ &eacute;l&eacute;ments",
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
						   "sAjaxSource": tabUrl[0]+"public/orl/liste-notes-medicales-precedente-ajax?id_patient="+$id_patient+"&id_cons="+$id_cons,
						   "iDisplayLength": 5,
							"bProcessing": false,
							"aLengthMenu": [5,10,15],
		} );
	
	
	},500);
    
}