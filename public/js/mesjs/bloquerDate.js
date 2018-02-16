function bloquerDate(){
  $(function () {
	 
    var daysToDisable = [];
    var j = 0;

    /*************************************************************************************************************/
    /*************************************************************************************************************/
    /*************************************************************************************************************/
    /********PREMIER MOIS*********/
    var lemois = mois1;
    var amois = dimanche1;
    for(var cpt=0; cpt<5 ; cpt++){
    	if(amois   < 10){daysToDisable[j++] = annee1+'-'+lemois+'-0'+amois;    }else daysToDisable[j++] = annee1+'-'+lemois+'-'+amois;

    	if(amois-2 < 10){daysToDisable[j++] = annee1+'-'+lemois+'-0'+(amois-2);}else daysToDisable[j++] = annee1+'-'+lemois+'-'+(amois-2);
    	if(amois-1 < 10){daysToDisable[j++] = annee1+'-'+lemois+'-0'+(amois-1);}else daysToDisable[j++] = annee1+'-'+lemois+'-'+(amois-1);
    	

    	if(amois-4 < 10){daysToDisable[j++] = annee1+'-'+lemois+'-0'+(amois-4);}else daysToDisable[j++] = annee1+'-'+lemois+'-'+(amois-4);
    	if(amois-6 < 10){daysToDisable[j++] = annee1+'-'+lemois+'-0'+(amois-6);}else daysToDisable[j++] = annee1+'-'+lemois+'-'+(amois-6);

    	amois = amois+07;
    }
    
    /********DEUXIEME MOIS*********/
    lemois = mois2;
    var amois = dimanche2;
    for(var cpt=0; cpt<5 ; cpt++){

    	if(amois   < 10){daysToDisable[j++] = annee2+'-'+lemois+'-0'+amois;    }else daysToDisable[j++] = annee2+'-'+lemois+'-'+amois;

    	if(amois-2 < 10){daysToDisable[j++] = annee2+'-'+lemois+'-0'+(amois-2);}else daysToDisable[j++] = annee2+'-'+lemois+'-'+(amois-2);
    	if(amois-1 < 10){daysToDisable[j++] = annee2+'-'+lemois+'-0'+(amois-1);}else daysToDisable[j++] = annee2+'-'+lemois+'-'+(amois-1);
    	

    	if(amois-4 < 10){daysToDisable[j++] = annee2+'-'+lemois+'-0'+(amois-4);}else daysToDisable[j++] = annee2+'-'+lemois+'-'+(amois-4);
    	if(amois-6 < 10){daysToDisable[j++] = annee2+'-'+lemois+'-0'+(amois-6);}else daysToDisable[j++] = annee2+'-'+lemois+'-'+(amois-6);
    	
    	amois = amois+07;
    }
    
    /********TROISIEME MOIS*********/
    lemois = mois3;
    var amois = dimanche3;
    for(var cpt=0; cpt<5 ; cpt++){



    	if(amois   < 10){daysToDisable[j++] = annee3+'-'+lemois+'-0'+amois;    }else daysToDisable[j++] = annee3+'-'+lemois+'-'+amois;

    	if(amois-2 < 10){daysToDisable[j++] = annee3+'-'+lemois+'-0'+(amois-2);}else daysToDisable[j++] = annee3+'-'+lemois+'-'+(amois-2);
    	if(amois-1 < 10){daysToDisable[j++] = annee3+'-'+lemois+'-0'+(amois-1);}else daysToDisable[j++] = annee3+'-'+lemois+'-'+(amois-1);
    	

    	if(amois-4 < 10){daysToDisable[j++] = annee3+'-'+lemois+'-0'+(amois-4);}else daysToDisable[j++] = annee3+'-'+lemois+'-'+(amois-4);
    	if(amois-6 < 10){daysToDisable[j++] = annee3+'-'+lemois+'-0'+(amois-6);}else daysToDisable[j++] = annee3+'-'+lemois+'-'+(amois-6);
    	
    	amois = amois+07;
    
    }

    /********QUATRIEME MOIS*********/
    lemois = mois4;
    var amois = dimanche4;
    for(var cpt=0; cpt<5 ; cpt++){



    	if(amois   < 10){daysToDisable[j++] = annee4+'-'+lemois+'-0'+amois;    }else daysToDisable[j++] = annee4+'-'+lemois+'-'+amois;

    	if(amois-2 < 10){daysToDisable[j++] = annee4+'-'+lemois+'-0'+(amois-2);}else daysToDisable[j++] = annee4+'-'+lemois+'-'+(amois-2);
    	if(amois-1 < 10){daysToDisable[j++] = annee4+'-'+lemois+'-0'+(amois-1);}else daysToDisable[j++] = annee4+'-'+lemois+'-'+(amois-1);
    	

    	if(amois-4 < 10){daysToDisable[j++] = annee4+'-'+lemois+'-0'+(amois-4);}else daysToDisable[j++] = annee4+'-'+lemois+'-'+(amois-4);
    	if(amois-6 < 10){daysToDisable[j++] = annee4+'-'+lemois+'-0'+(amois-6);}else daysToDisable[j++] = annee4+'-'+lemois+'-'+(amois-6);
    	
    	amois = amois+07;
    
    }
    
    /********CINQUIEME MOIS*********/
    lemois = mois5;
    var amois = dimanche5;
    for(var cpt=0; cpt<5 ; cpt++){



    	if(amois   < 10){daysToDisable[j++] = annee5+'-'+lemois+'-0'+amois;    }else daysToDisable[j++] = annee5+'-'+lemois+'-'+amois;

    	if(amois-2 < 10){daysToDisable[j++] = annee5+'-'+lemois+'-0'+(amois-2);}else daysToDisable[j++] = annee5+'-'+lemois+'-'+(amois-2);
    	if(amois-1 < 10){daysToDisable[j++] = annee5+'-'+lemois+'-0'+(amois-1);}else daysToDisable[j++] = annee5+'-'+lemois+'-'+(amois-1);
    	

    	if(amois-4 < 10){daysToDisable[j++] = annee5+'-'+lemois+'-0'+(amois-4);}else daysToDisable[j++] = annee5+'-'+lemois+'-'+(amois-4);
    	if(amois-6 < 10){daysToDisable[j++] = annee5+'-'+lemois+'-0'+(amois-6);}else daysToDisable[j++] = annee5+'-'+lemois+'-'+(amois-6);
    	
    	amois = amois+07;
    
    }
    
    
    /********SIXIEME MOIS*********/
    lemois = mois6;
    var amois = dimanche6;
    for(var cpt=0; cpt<5 ; cpt++){



    	if(amois   < 10){daysToDisable[j++] = annee6+'-'+lemois+'-0'+amois;    }else daysToDisable[j++] = annee6+'-'+lemois+'-'+amois;

    	if(amois-2 < 10){daysToDisable[j++] = annee6+'-'+lemois+'-0'+(amois-2);}else daysToDisable[j++] = annee6+'-'+lemois+'-'+(amois-2);
    	if(amois-1 < 10){daysToDisable[j++] = annee6+'-'+lemois+'-0'+(amois-1);}else daysToDisable[j++] = annee6+'-'+lemois+'-'+(amois-1);
    	

    	if(amois-4 < 10){daysToDisable[j++] = annee6+'-'+lemois+'-0'+(amois-4);}else daysToDisable[j++] = annee6+'-'+lemois+'-'+(amois-4);
    	if(amois-6 < 10){daysToDisable[j++] = annee6+'-'+lemois+'-0'+(amois-6);}else daysToDisable[j++] = annee6+'-'+lemois+'-'+(amois-6);
    	
    	amois = amois+07;
    }
    
    /********SEPTIEME MOIS*********/
    lemois = mois7;
    var amois = dimanche7;
    for(var cpt=0; cpt<5 ; cpt++){



    	if(amois   < 10){daysToDisable[j++] = annee7+'-'+lemois+'-0'+amois;    }else daysToDisable[j++] = annee7+'-'+lemois+'-'+amois;

    	if(amois-2 < 10){daysToDisable[j++] = annee7+'-'+lemois+'-0'+(amois-2);}else daysToDisable[j++] = annee7+'-'+lemois+'-'+(amois-2);
    	if(amois-1 < 10){daysToDisable[j++] = annee7+'-'+lemois+'-0'+(amois-1);}else daysToDisable[j++] = annee7+'-'+lemois+'-'+(amois-1);
    	

    	if(amois-4 < 10){daysToDisable[j++] = annee7+'-'+lemois+'-0'+(amois-4);}else daysToDisable[j++] = annee7+'-'+lemois+'-'+(amois-4);
    	if(amois-6 < 10){daysToDisable[j++] = annee7+'-'+lemois+'-0'+(amois-6);}else daysToDisable[j++] = annee7+'-'+lemois+'-'+(amois-6);
    	
    	amois = amois+07;
    
    }
    
    /*************************************************************************************************************/
    /*************************************************************************************************************/
    /*************************************************************************************************************/
	
    $('#date_rv').datepicker({
        beforeShowDay: disableSpecificDates,
        dateFormat: 'dd/mm/yy',
        showAnim : 'bounce',
        minDate : '1',
        maxDate : '180',
        yearRange : '2013:2050',
        
    });

    function disableSpecificDates(date) {
    	date = $.datepicker.formatDate('yy-mm-dd', date);
        return [$.inArray(date, daysToDisable) == -1];
    }
  });
}