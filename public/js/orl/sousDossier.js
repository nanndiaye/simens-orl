
                       $(function(){


                        rtyuiop
                           $('#infos_tyroide_contenu_antecedent').toggle(false);
                           $('#infos_tyroide_contenu_motifs').toggle(false);
                           $('#infos_tyroide_contenu_histoireMaladie').toggle(false);
                           $('#infos_tyroide_contenu_peau').toggle(false);
                           $('#infos_tyroide_contenu_soustyroide').toggle(false);
                           $('#infos_tyroide_contenu_ganglions').toggle(false);
                           $('#infos_tyroide_contenu_examComplementair').toggle(false);
                           $('#infos_tyroide_contenu_surveillance').toggle(false);
                           $('#infos_tyroide_contenu_hormones').toggle(false);
                           $('#infos_tyroide_contenu_operation').toggle(false);
                           animationPliantDepliant5();
                           animationPliantDepliant6();
                           animationPliantDepliant7();
                           animationPliantDepliant8();
                           animationPliantDepliant9();
                           animationPliantDepliant10();
                           animationPliantDepliant11();
                           animationPliantDepliant12();
                           animationPliantDepliant13();
                           animationPliantDepliant23();
                           // ajouter le CRO au niveau du sous dossier sophie sylla
                       });
                       function depliantPlus5() {
                            $('#titre_info_antecedent').click(function(){
                              $("#titre_info_antecedent").replaceWith(
                                "<span class='titre_info_tyroide' id='titre_info_antecedent' style='margin-left:-5px; cursor:pointer;'>" +
                                "<img src='../img/light/plus.png' /> ANTECEDENTS "+
                                  "</span>");
                              animationPliantDepliant5();
                              $('#infos_tyroide_contenu_antecedent').animate({
                                height : 'toggle'
                              },1000);
                            });
                       }
                       function animationPliantDepliant5() {
                         $('#titre_info_antecedent').click(function(){
                          $("#titre_info_antecedent").replaceWith(
                            "<span class='titre_info_tyroide' id='titre_info_antecedent' style='margin-left:-5px; cursor:pointer;'>" +
                            "<img src='../img/light/minus.png' /> ANTECEDENTS "+
                              "</span>");
                          depliantPlus5();
                          $('#infos_tyroide_contenu_antecedent').animate({
                            height : 'toggle'
                          },1000);
                        });
                      }
                      /**LISTE MOTIFS **/
                      function depliantPlus6() {
                          $('#titre_info_motifs').click(function(){
                          $("#titre_info_motifs").replaceWith(
                              "<span class='titre_info_tyroide' id='titre_info_motifs' style='margin-left:-5px; cursor:pointer;'>" +
                              "<img src='../img/light/plus.png' /> MOTIFS DE CONSULTATION "+
                                "</span>");
                            animationPliantDepliant6();
                            $('#infos_tyroide_contenu_motifs').animate({
                              height : 'toggle'
                            },1000);
                          });
                      }
                      function animationPliantDepliant6() {
                        $('#titre_info_motifs').click(function(){
                          $("#titre_info_motifs").replaceWith(
                            "<span class='titre_info_tyroide' id='titre_info_motifs' style='margin-left:-5px; cursor:pointer;'>" +
                            "<img src='../img/light/minus.png' /> MOTIFS DE CONSULTATION "+
                              "</span>");
                          depliantPlus6();
                          $('#infos_tyroide_contenu_motifs').animate({
                            height : 'toggle'
                          },1000);
                        });
                      }
                      /** HISTOIRE DE LA MALADIE **/
                      function depliantPlus7() {
                          $('#titre_info_histoireMaladie').click(function(){
                          $("#titre_info_histoireMaladie").replaceWith(
                              "<span class='titre_info_tyroide' id='titre_info_histoireMaladie' style='margin-left:-5px; cursor:pointer;'>" +
                              "<img src='../img/light/plus.png' /> HISTOIRE DE LA MALADIE "+
                                "</span>");
                            animationPliantDepliant7();
                            $('#infos_tyroide_contenu_histoireMaladie').animate({
                              height : 'toggle'
                            },1000);
                          });
                      }
                      function animationPliantDepliant7() {
                        $('#titre_info_histoireMaladie').click(function(){
                          $("#titre_info_histoireMaladie").replaceWith(
                            "<span class='titre_info_tyroide' id='titre_info_histoireMaladie' style='margin-left:-5px; cursor:pointer;'>" +
                            "<img src='../img/light/minus.png' /> HISTOIRE DE LA MALADIE "+
                              "</span>");
                          depliantPlus7();
                          $('#infos_tyroide_contenu_histoireMaladie').animate({
                            height : 'toggle'
                          },1000);
                        });
                      }
                      /** PEAU CERVICO-FASCIALE **/
                      function depliantPlus8() {
                          $('#titre_info_peau').click(function(){
                          $("#titre_info_peau").replaceWith(
                              "<span class='titre_info_tyroide' id='titre_info_peau' style='margin-left:-5px; cursor:pointer;'>" +
                              "<img src='../img/light/plus.png' /> PEAU CERVICO FACIALE "+
                                "</span>");
                            animationPliantDepliant8();
                            $('#infos_tyroide_contenu_peau').animate({
                              height : 'toggle'
                            },1000);
                          });
                      }
                      function animationPliantDepliant8() {
                        $('#titre_info_peau').click(function(){
                          $("#titre_info_peau").replaceWith(
                            "<span class='titre_info_tyroide' id='titre_info_peau' style='margin-left:-5px; cursor:pointer;'>" +
                            "<img src='../img/light/minus.png' /> PEAU CERVICO FACIALE "+
                              "</span>");
                          depliantPlus8();
                          $('#infos_tyroide_contenu_peau').animate({
                            height : 'toggle'
                          },1000);
                        });
                      }
                      /** TYROIDE **/
                      function depliantPlus9() {
                          $('#titre_info_soustyroide').click(function(){
                          $("#titre_info_soustyroide").replaceWith(
                              "<span class='titre_info_tyroide' id='titre_info_soustyroide' style='margin-left:-5px; cursor:pointer;'>" +
                              "<img src='../img/light/plus.png' /> GLANDE THYROIDE "+
                                "</span>");
                            animationPliantDepliant9();
                            $('#infos_tyroide_contenu_soustyroide').animate({
                              height : 'toggle'
                            },1000);
                          });
                      }
                      function animationPliantDepliant9() {
                        $('#titre_info_soustyroide').click(function(){
                          $("#titre_info_soustyroide").replaceWith(
                            "<span class='titre_info_tyroide' id='titre_info_soustyroide' style='margin-left:-5px; cursor:pointer;'>" +
                            "<img src='../img/light/minus.png' /> GLANDE THYROIDE"+
                              "</span>");
                          depliantPlus9();
                          $('#infos_tyroide_contenu_soustyroide').animate({
                            height : 'toggle'
                          },1000);
                        });
                      }
                      /** LES GROUPES GANGLIONNAIRES CERVICAUX **/
                      function depliantPlus10() {
                          $('#titre_info_ganglions').click(function(){
                          $("#titre_info_ganglions").replaceWith(
                              "<span class='titre_info_tyroide' id='titre_info_ganglions' style='margin-left:-5px; cursor:pointer;'>" +
                              "<img src='../img/light/plus.png' /> AIRES GANGLIONNAIRES "+
                                "</span>");
                            animationPliantDepliant10();
                            $('#infos_tyroide_contenu_ganglions').animate({
                              height : 'toggle'
                            },1000);
                          });
                      }
                      function animationPliantDepliant10() {
                        $('#titre_info_ganglions').click(function(){
                          $("#titre_info_ganglions").replaceWith(
                            "<span class='titre_info_ganglions' id='titre_info_ganglions' style='margin-left:-5px; cursor:pointer;'>" +
                            "<img src='../img/light/minus.png' /> AIRES GANGLIONNAIRES"+
                              "</span>");
                          depliantPlus10();
                          $('#infos_tyroide_contenu_ganglions').animate({
                            height : 'toggle'
                          },1000);
                        });
                      }
                      /** LES EXAMENS COMPLEMENTAIRES **/
                      function depliantPlus11() {
                          $('#titre_info_examComplementair').click(function(){
                          $("#titre_info_examComplementair").replaceWith(
                              "<span class='titre_info_tyroide' id='titre_info_examComplementair' style='margin-left:-5px; cursor:pointer;'>" +
                              "<img src='../img/light/plus.png' /> LES EXAMENS COMPLEMENTAIRES "+
                                "</span>");
                            animationPliantDepliant11();
                            $('#infos_tyroide_contenu_examComplementair').animate({
                              height : 'toggle'
                            },1000);
                          });
                      }
                      function animationPliantDepliant11() {
                        $('#titre_info_examComplementair').click(function(){
                          $("#titre_info_examComplementair").replaceWith(
                            "<span class='titre_info_tyroide' id='titre_info_examComplementair' style='margin-left:-5px; cursor:pointer;'>" +
                            "<img src='../img/light/minus.png' /> LES EXAMENS COMPLEMENTAIRES "+
                              "</span>");
                          depliantPlus11();
                          $('#infos_tyroide_contenu_examComplementair').animate({
                            height : 'toggle'
                          },1000);
                        });
                      }
                      /** LES HORMONES TYROIDIENNES **/
                      function depliantPlus12() {
                          $('#titre_info_hormones').click(function(){
                          $("#titre_info_hormones").replaceWith(
                              "<span class='titre_info_tyroide' id='titre_info_hormones' style='margin-left:-5px; cursor:pointer;'>" +
                              "<img src='../img/light/plus.png' /> LES HORMONES TYROIDIENNES"+
                                "</span>");
                            animationPliantDepliant12();
                            $('#infos_tyroide_contenu_hormones').animate({
                              height : 'toggle'
                            },1000);
                          });
                      }
                      function animationPliantDepliant12() {
                        $('#titre_info_hormones').click(function(){
                          $("#titre_info_hormones").replaceWith(
                            "<span class='titre_info_tyroide' id='titre_info_hormones' style='margin-left:-5px; cursor:pointer;'>" +
                            "<img src='../img/light/minus.png' /> LES HORMONES TYROIDIENNES"+
                              "</span>");
                          depliantPlus12();
                          $('#infos_tyroide_contenu_hormones').animate({
                            height : 'toggle'
                          },1000);
                        });
                      }
                      /** COPMTE RENDU OPERATOIRE**/
                      function depliantPlus13() {
                            $('#titre_info_operation').click(function(){
                              $("#titre_info_operation").replaceWith(
                                "<span class='titre_info_tyroide' id='titre_info_operation' style='margin-left:-5px; cursor:pointer;'>" +
                                "<img src='../img/light/plus.png' /> COMPTE RENDU OPERATOIRE "+
                                  "</span>");
                              animationPliantDepliant13();
                              $('#infos_tyroide_contenu_operation').animate({
                                height : 'toggle'
                              },1000);
                            });
                       }
                       function animationPliantDepliant13() {
                         $('#titre_info_operation').click(function(){
                          $("#titre_info_operation").replaceWith(
                            "<span class='titre_info_tyroide' id='titre_info_operation' style='margin-left:-5px; cursor:pointer;'>" +
                            "<img src='../img/light/minus.png' /> COMPTE RENDU OPERATOIRE "+
                              "</span>");
                          depliantPlus13();
                          $('#infos_tyroide_contenu_operation').animate({
                            height : 'toggle'
                          },1000);
                        });
                      }
                       /** SURVEILLANCE  **/
                       function depliantPlus23() {
                           $('#titre_info_surveillance').click(function(){
                           $("#titre_info_surveillance").replaceWith(
                               "<span class='titre_info_tyroide' id='titre_info_surveillance' style='margin-left:-5px; cursor:pointer;'>" +
                               "<img src='../img/light/plus.png' /> SURVEILLANCE "+
                                 "</span>");
                             animationPliantDepliant23();
                             $('#infos_tyroide_contenu_surveillance').animate({
                               height : 'toggle'
                             },1000);
                           });
                       }
                       function animationPliantDepliant23() {
                         $('#titre_info_surveillance').click(function(){
                           $("#titre_info_surveillance").replaceWith(
                             "<span class='titre_info_tyroide' id='titre_info_surveillance' style='margin-left:-5px; cursor:pointer;'>" +
                             "<img src='../img/light/minus.png' /> SURVEILLANCE "+
                               "</span>");
                           depliantPlus23();
                           $('#infos_tyroide_contenu_surveillance').animate({
                             height : 'toggle'
                           },1000);
                         });
                       }