<?
  isset($_GET['id_orga']) ? $id_orga = $_GET['id_orga'] : $id_orga = ""; 
  $req_sql="SELECT * FROM orgas WHERE id_orga='".$id_orga."'";
  $req_orgas = mysql_query($req_sql);
  
?>
<SCRIPT language="Javascript">
<!--
  function redirection_maj()
  	{
  	document.form.maj.value="1";
  	verify();
  	}
  function redirection_envoi()
  	{
  	document.form.maj.value="0";
  	verify();
  	}
  function verify()
  {
    var ok=1;
    var nb_plages=document.form.nb_plages.value;
    if (document.form.first_name.value=="")
    {
        alert("Tu dois donner un prenom a l'orga");
        ok=0;
    }
    if (document.form.last_name.value=="")
    {
        alert("Tu dois donner un nom a l'orga");
        ok=0;
    }
    if (document.form.email.value=="")
    {
        alert("Tu dois donner l'e-mail de l'orga");
        ok=0;
    }
    if (document.form.phone_number.value=="")
    {
        alert("Tu dois donner le numero de telephone de l'orga");
        ok=0;
    }
    for (i=0;i<nb_plages;i++)
    {
    	var current_begin_time=eval("document.form.begin_plage_"+i+".value");
    	var current_end_time=eval("document.form.end_plage_"+i+".value");
    	if (current_begin_time=="")
        {
              alert("Tu dois donner une date de debut a l'orga");
              ok=0;
        }
        else if ((current_begin_time.length!=16) || (current_begin_time.charAt(2)!="-") || (current_begin_time.charAt(5)!="-") || (current_begin_time.charAt(10)!=" ") || (current_begin_time.charAt(13)!=":"))
        {
              alert("Tu dois une date de debut dans le bon format (jj-mm-aaaa hh:mm)");
              ok=0;
        }
        if (current_end_time=="")
        {
              alert("Tu dois donner une date de fin a l'orga");
              ok=0;
        }
        else if ((current_end_time.length!=16) || (current_end_time.charAt(2)!="-") || (current_end_time.charAt(5)!="-") || (current_end_time.charAt(10)!=" ") || (current_end_time.charAt(13)!=":"))
        {
              alert("Tu dois une date de fin dans le bon format (jj-mm-aaaa hh:mm)");
              ok=0;
         }
     }
     if (ok==1)
     	{
     	document.form.submit();
     	}
  }
  function ajout_plage(){
    document.form.ajout_plage.value="yes";
    verify();
  }
  function suppr_plage(id_plage){
    document.form.suppr_plage.value="yes";
    document.form.id_suppr_plage.value=id_plage;
    verify();
  }
  -->
  </SCRIPT>
  <style>
  #block {float:left;padding:3px;}
  </style>
  <TABLE width="1%" cellspacing="0" cellpadding="3">  <FORM method="POST" name="form" action="db_action.php?db_action=update_orga">    <TR>       <TD colspan="3">&nbsp;</TD>    </TR>    <TR class="orgas_top">       <TD colspan="3"> <B>Modification d'un orga</B> </TD>    </TR>
<?
  $orgas_array=result_orgas($req_orgas);
  for ($i=0;$i<count($orgas_array);$i++)
  {
?>
<TR CLASS="orgas">             <TD>&nbsp;&nbsp;&nbsp;</TD>            <TD nowrap> Categorie&nbsp;:&nbsp; </TD>            <TD WIDTH="1%">               
<?
   $req_sql="SELECT * FROM categories WHERE type_categorie='orga' ORDER BY nom_categorie ";
   $req = mysql_query($req_sql);
   $categories_array=result_categories($req);
   for ($j=0;$j<count($categories_array);$j++)
   { 
?>
<div id="block" class="<? print($categories_array[$j]->couleur); ?>"><input type="radio" name="id_categorie" value="<? print($categories_array[$j]->id_categorie); ?>" 
<?
	if($categories_array[$j]->id_categorie==$orgas_array[$i]->id_categorie) print("checked"); 
?>><? print($categories_array[$j]->nom); ?></div>					
<?
	}
?>
</TD>
</TR>
<TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap> Pr&eacute;nom&nbsp;:&nbsp; </TD>      <TD width="1%">         <INPUT type="text" name="first_name" value="<? print($orgas_array[$i]->first_name); ?>" size="20" maxlength="40">        <INPUT type="hidden" name="id_orga" value="<? print($orgas_array[$i]->id_orga); ?>">      </TD>    </TR>    <TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD valign="top" nowrap> Nom&nbsp;:&nbsp; </TD>      <TD width="1%">         <INPUT type="text" name="last_name" value="<? print($orgas_array[$i]->last_name); ?>" size="20" maxlength="40">      </TD>    </TR>    <TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap>E-mail&nbsp;:&nbsp;</TD>      <TD width="1%">         <INPUT type="text" name="email" value="<? print($orgas_array[$i]->email); ?>" size="20" maxlength="40">      </TD>    </TR>    <TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap>Adresse&nbsp;:&nbsp;</TD>      <TD width="1%">         <INPUT type="text" name="mail_adress" value="<? print($orgas_array[$i]->mail_adress); ?>" size="20" maxlength="40">      </TD>    </TR>    <TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap>T&eacute;l&eacute;phone&nbsp;:&nbsp;</TD>      <TD width="1%">         <INPUT type="text" name="phone_number" value="<? print($orgas_array[$i]->phone_number); ?>" size="20" maxlength="40">      </TD>    </TR>
<TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap>Motivation&nbsp;:&nbsp;</TD>      <TD width="1%">         <INPUT type="text" name="motiv" value="<? print($orgas_array[$i]->motivation); ?>" size="20" maxlength="40">      </TD>    </TR>
<TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap>D&eacute;partement&nbsp;:&nbsp;</TD>      <TD width="1%">         <INPUT type="text" name="departement" value="<? print($orgas_array[$i]->departement); ?>" size="20" maxlength="40">      </TD>    </TR>
<TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap>C&eacute;lib&nbsp;:&nbsp;</TD>      <TD width="1%">         <INPUT type="text" name="celib" value="<? print($orgas_array[$i]->celib); ?>" size="20" maxlength="40">      </TD>    </TR>
<TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap>Permis&nbsp;:&nbsp;</TD>      <TD width="1%">         <INPUT type="text" name="permis" value="<? print($orgas_array[$i]->permis); ?>" size="20" maxlength="40">      </TD>    </TR>
<TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap>Potes&nbsp;:&nbsp;</TD>      <TD width="1%">         <TEXTAREA name="potes" cols="40" rows="7"><? print($orgas_array[$i]->potes); ?> </TEXTAREA>      </TD>    </TR>
<?
	$list_plages=explode("|",$orgas_array[$i]->plages);
	$m=1;$n=0;
	while($list_plages[$m])
		{
		$plages[$m]=explode(",", $list_plages[$m]);
		$debut[$m]=$plages[$m][0]; 
		$fin[$m]=$plages[$m][1];
		$m++;
		}
			
	$nb_plages=count($list_plages)-2;
	
	
	for ($j=0;$j<$nb_plages;$j++)
	{
?>
<TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap> Heure de d&eacute;but&nbsp;:&nbsp; <BR>        (jj-mm-aaaa hh:mm) - plage <? print($j+1); ?></TD>      <TD width="1%">         <INPUT type="text" name="begin_plage_<? print($j); ?>" value="<? print(list_to_begin_plage($list_plages[$j+1])); ?>" size="20" maxlength="40">      </TD>    </TR>    <TR class="orgas">       <TD>&nbsp;&nbsp;&nbsp;</TD>      <TD nowrap> Heure de fin&nbsp;:&nbsp; <BR>        (jj-mm-aaaa hh:mm) - plage <? print($j+1); ?></TD>      <TD width="1%">         <INPUT type="text" name="end_plage_<? print($j); ?>" value="<? print(list_to_end_plage($list_plages[$j+1])); ?>" size="20" maxlength="40">      </TD>    </TR>
<?
	if ($nb_plages!=1)
	{
?>    <TR class="orgas">	  <TD colspan="3" align="right" nowrap>	    <A href="javascript:suppr_plage('<? print($j); ?>')">Supprimer cette plage</A>	  </TD>	</TR>
<?
	}
	}
?>
<TR class="orgas">	  <TD colspan="3" nowrap>	    <A href="javascript:ajout_plage()">Ajouter une plage horaire</A>        <INPUT type="hidden" name="ajout_plage" value="">        <INPUT type="hidden" name="suppr_plage" value="">        <INPUT type="hidden" name="id_suppr_plage" value="">        <INPUT type="hidden" name="nb_plages" value="<? print($nb_plages); ?>">	  </TD>	</TR>    <TR class="orgas">       <TD colspan="3">&nbsp;</TD>    </TR><?  }?>    <TR class="orgas">       <TD colspan="3" align="center">         <input type="hidden" name="maj" value=1><INPUT type="button" value="Mettre &agrave; jour" onClick="redirection_maj()">    <INPUT type="button" value="Valider" onClick="redirection_envoi()">&nbsp;&nbsp;/&nbsp;&nbsp;<INPUT type="reset" value="Effacer">      </TD>    </TR>

 </FORM></TABLE>

<?php

// Graphe de disponibilités

	setlocale (LC_TIME, 'fr_FR','fra');  // Affichage des dates au format français
	$timestamp_debut = timestamp_extract($global_begin_date);
	$timestamp_fin = timestamp_extract($global_end_date);	
	$date_flottante = $timestamp_debut; // Date de début de l'organisation de la manifestation
	$creneau = 15; // Créneaux de 15 minutes
	$j=1;
	// On s'intéresse en premier lieu à la première dispo de l'orga
	$timestamp_debut_dispo = timestamp_extract($debut[1]);
	$timestamp_fin_dispo = timestamp_extract($fin[1]);


	echo '<br /><br />';
	echo '<div id="frise">';
	
		echo '<div class="titre_barre"></div>';
		echo '<div style="float:left;padding-left:2px;">';
		$k = 0;
		
		// Ligne des heures
		while ($k < 24)
			{
			echo '<div style="float:left;width:24px;margin-right:1px;">'.$k.'</div>';	
			$k++;
			}
		echo '</div>';
	
	// Décalage d'horaire lié à l'heure de début de la manif
	$offset_horaire = date("G", $timestamp_debut)*3600;
	
	// On balaye tous les jours de dispo entre les 2 dates extrêmes de l'organisaiton de la manif
	while($date_flottante < $timestamp_fin)
		{
			
		$compteur_horaire = 0;
		$heure_incrementee = 0;
		$minutes_incrementees = 0;
	
		
		echo '<br clear="all">';
		
		echo '<div class="titre_barre">'.strftime("%A %d", $date_flottante).'</div>';
		echo '<div class="barre"><div id=h0" style="float:left;">';
	
			// On balaye les différents jours
			while ($compteur_horaire < $creneau*4*24) // 4 créneaux de 15 minutes x 24 heures
				{
						
				// On affiche un séparateur chaque heure balayée
				if ($minutes_incrementees == 60)
					{
					echo '</div>';
					$heure_incrementee++;
					$minutes_incrementees=0;
					$compteur_horaire+=60;
					if ($heure_incrementee < 24) echo '<div id="h'.$heure_incrementee.'" style="float:left;width:25px;"><div class="separateur_horaire">&nbsp;</div>';
					}
					
				// On affiche 4 créneaux par heure de couleur différente suivant la dispo
				else
					{
					$timestamp_flottant = $date_flottante-$offset_horaire+($heure_incrementee*60+$minutes_incrementees)*60;
										
					//  disponibilité
					if (($timestamp_flottant < $timestamp_fin_dispo) && ($timestamp_flottant >= $timestamp_debut_dispo))
						{
						$dispo=1;	
						}
					// On quitte une plage de disponibilité
					else if ($dispo==1)
						{
						$dispo=0;
						if ($j < $nb_plages) // On s'intéresse à la plage de disponibilités suivante si elle existe
							{
							$j++; 					
							$timestamp_debut_dispo = timestamp_extract($debut[$j]);
							$timestamp_fin_dispo = timestamp_extract($fin[$j]);
							}
						}
							
					echo '<a href="javascript:ajout_plage('.strftime("%G", $timestamp_flottant).','.strftime("%m", $timestamp_flottant).','.strftime("%d", $timestamp_flottant).','.$heure_incrementee.')" id="h'.$heure_incrementee.':'.$minutes_incrementees.'" class="creneau';
					if ($dispo) echo ' vert';
					echo '">';
					echo '&nbsp;</a>';
					$minutes_incrementees+=$creneau;
					}
				}
		echo '</div>';
		
		// On passe au jour suivant
		$date_flottante += 24*3600;
		
		}
	echo '</div>';

?>

