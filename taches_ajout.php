<?
  $req_sql="SELECT * FROM categories WHERE type_categorie='tache' ORDER BY nom_categorie";
  $req_categories = mysql_query($req_sql);

  $req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";
  $req_vehicules = mysql_query($req_sql);

  $req_sql="SELECT * FROM lieux ORDER BY nom_lieu";
  $req_lieux = mysql_query($req_sql);

  $req_sql="SELECT * FROM talkies ORDER BY nom_talkie";
  $req_talkies = mysql_query($req_sql);

  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);
  
  $req_sql="SELECT materiels.nom_materiel FROM materiels ORDER BY nom_materiel";
  $req_materiels = mysql_query($req_sql);
?>

<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  var nb_plages=document.form.nb_plages.value;
  
  if (document.form.titre.value=="")
  {
    alert("Tu dois donner un titre à la tâche");
    ok=0;
  }
  if (document.form.consigne.value=="")
  {
    alert("Tu dois donner des consignes à la tâche");
    ok=0;
  }
  if ((document.form.nb_orgas.value=="") || (isNaN(document.form.nb_orgas.value)))
  {
    alert("Tu dois donner un nombre d'orgas à la tâche");
    ok=0;
  }
  if (document.form.id_lieu[0].selected)
  {
    alert("Tu dois donner un lieu à la tâche");
    ok=0;
  }
  if (document.form.id_categorie[0].selected)
  {
    alert("Tu dois donner une catégorie à la tâche");
    ok=0;
  }
  for (i=0;i<nb_plages;i++)
  {
	var current_begin_time=eval("document.form.begin_plage_"+i+".value");
	var current_end_time=eval("document.form.end_plage_"+i+".value");
    if (current_begin_time=="")
    {
      alert("Tu dois donner une date de début à la tâche");
      ok=0;
    }
    else if ((current_begin_time.length!=16) || (current_begin_time.charAt(2)!="-") || (current_begin_time.charAt(5)!="-") || (current_begin_time.charAt(10)!=" ") || (current_begin_time.charAt(13)!=":"))
    {
      alert("Tu dois une date de début dans le bon format (jj-mm-aaaa hh:mm)");
      ok=0;
    }
    if (current_end_time=="")
    {
      alert("Tu dois donner une date de fin à la tâche");
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
    for (i=0;i<nb_plages;i++)
	{
	  var current_begin_time=eval("document.form.begin_plage_"+i+".value");
	  var current_end_time=eval("document.form.end_plage_"+i+".value");
	  if (i==0) document.form.begin_time.value=current_begin_time;
      if (i==(nb_plages-1)) document.form.end_time.value=current_end_time;
      document.form.submit();
	}
  }
}

function ajout_plage()
{
  document.form.ajout_plage.value="yes";
  verify();
}
function duree(i)
{

  var new_end_time=eval("document.form.begin_plage_0.value");
  var moisanne="";
  for (a=2;a<11;a++)
  {
  moisanne=moisanne+new_end_time.charAt(a);
  }
  var heure=new_end_time.charAt(11)+new_end_time.charAt(12);
  var minu=new_end_time.charAt(14)+new_end_time.charAt(15);
  var jour=new_end_time.charAt(0)+new_end_time.charAt(1);
  
  
  if(i==0){
	minu=minu*1+30;
	if (minu>50)
	{
	  minu=minu*1-60;
	  heure=heure*1+1;
	}
  }
  if(i==1){
	heure=heure*1+1;
  }
  if(i==2){
	minu=minu*1+30;
	heure=heure*1+1
	if (minu>50)
	{
	  minu=minu*1-60;
	  heure=heure*1+1;
	}
  }
  if(i==3){
	heure=heure*1+2;
  }
  if(i==4){
	heure=heure*1+3;
  }
  if(i==5){
	heure=heure*1+12;
	if(heure>23)
	{
	  jour=jour*1+1;
	  heure=heure*1-24;
	}
  }
  if(i==6){
	jour=jour*1+1;
  }
  var maxi=eval("document.form.maxi.value");
  var heuremax=maxi.charAt(11)+maxi.charAt(12);
  var minumax=maxi.charAt(14)+maxi.charAt(15);
  var jourmax=maxi.charAt(0)+maxi.charAt(1);
  var maxok=1;
  if(jour>jourmax){
    maxok=0;}
    else {
	  if(jour==jourmax){
	    if(heure>heuremax){
		  maxok=0;}
		  else {
		    if(heure==heuremax){
	          if(minu>minumax){
	            maxok=0;}
	            }
			  }
	      }
    }
if(maxok==1){
if(heure<10){heure="0"+heure;}
if(minu==0){minu="00";}
   document.form.end_plage_0.value=jour+moisanne+heure+":"+minu;}
   else{
   document.form.end_plage_0.value=maxi;}


}
function materiel_ajout()
{
if(document.form.matos.value!=""){
document.form.matos.value=document.form.matos.value+", "+document.form.qt.value+" "+document.form.id_materiel.value;}
else{document.form.matos.value=document.form.qt.value+" "+document.form.id_materiel.value;}
}

-->
</SCRIPT>

<TABLE width="1%" cellspacing="0" cellpadding="3">
  <FORM method="POST" name="form" action="db_action.php?db_action=insert_tache">
    <TR> 
      <TD colspan="3">&nbsp;</TD>
    </TR>
    <TR class="taches_top"> 
      <TD colspan="3"> <B>Ajout d'une t&acirc;che</B> </TD>
    </TR>
    <TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Titre&nbsp;:&nbsp; </TD>
      <TD width="1%"> <INPUT type="text" name="titre" size="20" maxlength="40"> 
      </TD>
    </TR>
    <TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD valign="top" nowrap> Consignes&nbsp;:&nbsp; </TD>
      <TD width="1%"> <TEXTAREA name="consigne" cols="36" rows="6" wrap="virtual"></TEXTAREA> 
      </TD>
    </TR>
    <TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Cat&eacute;gorie&nbsp;:&nbsp; </TD>
      <TD width="1%"> <SELECT name="id_categorie">
          <OPTION value="0" selected></OPTION>
          <?
  $categories_array=result_categories($req_categories);
  for ($i=0;$i<count($categories_array);$i++)
  {
?>
          <OPTION value="<? print($categories_array[$i]->id_categorie); ?>"> <? print($categories_array[$i]->nom); ?> 
          </OPTION>
          <?
  }
?>
        </SELECT> </TD>
    </TR>
    <TR class="taches"> 
      <TD>&nbsp;</TD>
      <TD nowrap>Nombre d'orgas&nbsp;:&nbsp;</TD>
      <TD width="1%"> 
        <? for ($i=1;$i<10;$i++){
		?>
		<input type="button" value="<? print($i); ?>" onClick="document.form.nb_orgas.value='<? print($i); ?>'">
		<? } ?>
		<INPUT type="text" name="nb_orgas" value="" size="3" maxlength="40"> 
      </TD>
    </TR>
    <TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Lieu&nbsp;:&nbsp; </TD>
      <TD width="1%"> <SELECT name="id_lieu">
          <OPTION value="0"></OPTION>
          <?
  $lieux_array=result_lieux($req_lieux);
  for ($i=0;$i<count($lieux_array);$i++)
  {
?>
          <OPTION value="<? print($lieux_array[$i]->id_lieu); ?>"> <? print($lieux_array[$i]->nom); ?> 
          </OPTION>
          <?
  }
?>
        </SELECT> </TD>
    </TR>
    <TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> V&eacute;hicule&nbsp;:&nbsp; </TD>
      <TD width="1%"> <SELECT name="id_vehicule">
          <OPTION value="0"></OPTION>
          <?
  $vehicules_array=result_vehicules($req_vehicules);
  for ($i=0;$i<count($vehicules_array);$i++)
  {
?>
          <OPTION value="<? print($vehicules_array[$i]->id_vehicule); ?>"> <? print($vehicules_array[$i]->nom); ?> 
          </OPTION>
          <?
  }
?>
        </SELECT> </TD>
    </TR>
    <TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Responsable&nbsp;:&nbsp; </TD>
      <TD width="1%"> <SELECT name="id_resp">
          <OPTION value="0"></OPTION>
          <?
  $orgas_array=result_orgas($req_orgas);
  for ($i=0;$i<count($orgas_array);$i++)
  {
?>
          <OPTION value="<? print($orgas_array[$i]->id_orga); ?>"> <? print($orgas_array[$i]->first_name." ".$orgas_array[$i]->last_name); ?> 
          </OPTION>
          <?
  }
?>
        </SELECT> </TD>
    </TR>
    <!--<TR class="taches"> 
      <TD>&nbsp;</TD>
      <TD colspan="2" nowrap>Affecter le responsable &agrave; la t&acirc;che 
        <INPUT type="checkbox" name="affect_resp" value="yes"></TD>
    </TR>-->
    <TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Talkie&nbsp;:&nbsp; </TD>
      <TD width="1%"> <SELECT name="id_talkie">
          <OPTION value="0"></OPTION>
          <?
  $talkies_array=result_talkies($req_talkies);
  for ($i=0;$i<count($talkies_array);$i++)
  {
?>
          <OPTION value="<? print($talkies_array[$i]->id_talkie); ?>"> <? print($talkies_array[$i]->nom); ?> 
          </OPTION>
          <?
  }
?>
        </SELECT> </TD>
    </TR>
    <TR class="taches">
      <TD>&nbsp;</TD>
      <TD valign="top" nowrap><p> Matériel enregistré<br><select name="id_materiel">
		<option value="0" selected></option>
		
		
		<? $materiels_array=result_materiels($req_materiels);
		for ($i=0;$i<count($materiels_array);$i++)
		{
		?>
		<option value="<? print($materiels_array[$i]->nom_materiel); ?>"><? print($materiels_array[$i]->nom_materiel); ?></option>
		<? } ?>
		
		
		</select><br><select name="qt">
		<? for ($i=0;$i<21;$i++)
		{
		?>
		<option value="<? print($i); ?>"><? print($i); ?></option>
		<? } ?></select>
		<input type="button" value="Ajouter" onClick="materiel_ajout()">
		<br>On peut en rajouter à la liste --></p>
		</TD>
      <TD><TEXTAREA name="matos" cols="18" rows="5" wrap="virtual"></TEXTAREA> </TD>
    </TR>
    <TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Heure de d&eacute;but&nbsp;:&nbsp; <BR>
        (jj-mm-aaaa hh:mm)  - plage 1</TD>
      <TD width="1%"> <INPUT type="text" name="begin_plage_0" value="<? print(date_en_to_fr($global_begin_date)); ?>" size="20" maxlength="40"> 
      </TD>
    </TR>
	<TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap>Dur&eacute;e&nbsp;: 
      </TD>
      <TD width="1%"> <? 
	  $temps=array("30m","1h","1h30","2h","3h","12h","1 j");
	  for ($i=0;$i<7;$i++){
		?>
		<input type="button" value="<? print($temps[$i]); ?>" onClick="duree(<? print($i); ?>)">
		<? } ?>
		<input type="hidden" name="maxi" value="<? print(date_en_to_fr($global_end_date)); ?>">
      </TD>
    </TR>
    <TR class="taches"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Heure de fin&nbsp;:&nbsp; <BR>
        (jj-mm-aaaa hh:mm)  - plage 1</TD>
      <TD width="1%"> <INPUT type="text" name="end_plage_0" value="<? print(date_en_to_fr($global_end_date)); ?>" size="20" maxlength="40"> 
      </TD>
    </TR>
    <TR class="taches">
	  <TD colspan="3" nowrap>
	    <A href="javascript:ajout_plage()">Ajouter une plage horaire</A>
        <INPUT TYPE="hidden" NAME="begin_time" VALUE="">
        <INPUT TYPE="hidden" NAME="end_time" VALUE="">
        <INPUT TYPE="hidden" NAME="ajout_plage" VALUE="">
        <INPUT TYPE="hidden" NAME="nb_plages" VALUE="1">
	  </TD>
	</TR>
    <TR class="taches"> 
      <TD colspan="3">&nbsp;</TD>
    </TR>
    <TR class="taches"> 
      <TD colspan="3" align="center"> <INPUT type="button" value="Envoyer" onClick="verify()"> 
        <INPUT type="reset" value="Effacer"> </TD>
    </TR>
  </FORM>
</TABLE>
