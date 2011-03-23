<?
isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = "";
isset($_POST['id_tache']) ? $id_tache = $_POST['id_tache'] : $id_tache = "";
isset($_GET['id_categorie']) ? $id_categorie = $_GET['id_categorie'] : $id_categorie = $id_categorie;
isset($_GET['id_tache']) ? $id_tache = $_GET['id_tache'] : $id_tache = $id_tache;
$req_sql="SELECT * FROM categories WHERE type_categorie='orga'";
$req = mysql_query($req_sql);
$categories_orgas_array=result_categories($req);
if ($id_categorie==""){
	$req_sql="SELECT MIN(id_categorie) FROM categories ";
	$req = mysql_query($req_sql);
    while ($data = @mysql_fetch_array($req))
    {
	$id_categorie=$data['MIN(id_categorie)'];
    }
	}
	if ($id_tache=="" || $modiftache==1)
	{
    $req_sql="SELECT MIN(id_tache) FROM taches WHERE taches.id_categorie='".$id_categorie."'";
    $req = @mysql_query($req_sql);
    while ($data = @mysql_fetch_array($req))
    {
	$id_tache=$data['MIN(id_tache)'];
    }
	}
	$req_sql="SELECT MAX(id_tache) FROM taches";
    $req = mysql_query($req_sql);
    $max_tache= mysql_fetch_array($req);
	$req_sql="SELECT plannings.* FROM plannings WHERE plannings.id_tache='".$id_tache."' AND plannings.id_orga!='|0|' ORDER BY plannings.current_time";
	$req_plannings = mysql_query($req_sql);
	$req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
	$req_orgas = mysql_query($req_sql);
	$consigne_tache="";
	$req_sql="SELECT consigne FROM taches WHERE id_tache=".$id_tache;
	$req = mysql_query($req_sql);
	while ($data = @mysql_fetch_array($req))
	{
    $consigne_tache=$data['consigne'];
	}
	$req_sql="SELECT * FROM taches ORDER BY titre";
	$req_taches = mysql_query($req_sql);
    $req_sql="SELECT * FROM categories WHERE type_categorie='tache' ORDER BY nom_categorie";
	$req_categories_tache = mysql_query($req_sql);
	?>
	<SCRIPT language="Javascript">
	<!--
	var begin_time;
	var end_time;
	var duree="00:15:00";
	var changement=0;
	function change_img(){
	//remet tout en blanc
	var i=0;
	for (i=0;i<document.images.length;i++)
	{
    document.images[i].src="images/blanc.gif";
	}
	//r?cup?re les info li? ? l'orga choisi
	var valeur=document.form_choix.id_orga[document.form_choix.id_orga.selectedIndex].value;
	var plages=valeur.substring(valeur.indexOf("|")+1,valeur.length-1);
	plages_array=new Array();
	i=0;
    var id_orga_select="a"+valeur.substring(0,1);
	dizcent="";
	plus="";
	plusp="";
	dizcent=valeur.substring(1,3);
	plus=dizcent.substring(0,1);
	plusp=dizcent.substring(1,2);
	//alert(valeur+"<--->"+dizcent+"<--->"+plus+"<--->"+plusp);
	if (plus==0 || plus==1 || plus==2 || plus==3 || plus==4 || plus==5 || plus==6 || plus==7 || plus==8 || plus==9)
	{
	var id_orga_select=id_orga_select+plus;
	if (plusp==0 || plusp==1 || plusp==2 || plusp==3 || plusp==4 || plusp==5 || plusp==6 || plusp==7 || plusp==8 || plusp==9)
	{
	var id_orga_select=id_orga_select+plusp;
	}
	}
	var id_orga_select=id_orga_select+"a";
	//alert(id_orga_select);
	while(plages.indexOf("|")!=-1)
	{
    plages_array[i]=plages.substring(0,plages.indexOf("|"));
	plages=plages.substring(plages.indexOf("|")+1,plages.length);
    i++;
	}
	plages_array[i]=plages;
	end_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);
	end_time=end_time.substr(0,4)+end_time.substr(5,2)+end_time.substr(8,2)+end_time.substr(11,2)+end_time.substr(14,2);
	valeur=valeur.substring(0,valeur.lastIndexOf("|"));
	begin_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);
	begin_time=begin_time.substr(0,4)+begin_time.substr(5,2)+begin_time.substr(8,2)+begin_time.substr(11,2)+begin_time.substr(14,2);
	for (i=0;i<document.images.length;i++)
	{
    var nom=document.images[i].name;
    nom=nom.substring(nom.lastIndexOf("_")+1,nom.length);
    for(j=0;j<plages_array.length;j++)
    {
	begin_time=plages_array[j];
	begin_time=begin_time.substring(0,begin_time.indexOf(","));
	begin_time=begin_time.substr(0,4)+begin_time.substr(5,2)+begin_time.substr(8,2)+begin_time.substr(11,2)+begin_time.substr(14,2);
	end_time=plages_array[j];
	end_time=end_time.substring(end_time.indexOf(",")+1,end_time.length);
	end_time=end_time.substr(0,4)+end_time.substr(5,2)+end_time.substr(8,2)+end_time.substr(11,2)+end_time.substr(14,2);
	if ((nom>=begin_time) && (nom<end_time))
	{
	document.images[i].src="images/coche.gif";
	var liste = document.images[i].title;
	//alert(id_orga_select+"<----->"+liste+"    result ->"+liste.search(id_orga_select));
	if(liste.search(id_orga_select)>0)
	{
	document.images[i].src="images/busy.gif";
	}
	break;
	}
    }
	}
	/*  var valeur=document.form_choix.id_orga[document.form_choix.id_orga.selectedIndex].value;  end_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);  end_time=end_time.substr(0,4)+end_time.substr(5,2)+end_time.substr(8,2)+end_time.substr(11,2)+end_time.substr(14,2);  valeur=valeur.substring(0,valeur.lastIndexOf("|"));  begin_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);  begin_time=begin_time.substr(0,4)+begin_time.substr(5,2)+begin_time.substr(8,2)+begin_time.substr(11,2)+begin_time.substr(14,2);  for (i=0;i<document.images.length;i++)  {    var nom=document.images[i].name;    nom=nom.substring(nom.lastIndexOf("_")+1,nom.length);    if ((nom>=begin_time) && (nom<end_time)) document.images[i].src="images/coche.gif";  }*/
	}
	function change_txt(nb,longueur){
	/*pas de boucle, c est tp complique - a voir par la suite  duree=document.form_choix.duree_orga[document.form_choix.duree_orga.selectedIndex].value;  var heure=duree.substr(0,2);  heure=heure*4;  var minute=duree.substr(3,2);  var boucle=heure+minute/15;  for (i=0;i<boucle;i++)  {*/
    var source=eval("document.coche_"+nb+".src");
    if ((source.indexOf("images/coche.gif")!=-1) || (source.indexOf("images/busy.gif")!=-1) || (document.form_choix.id_orga.selectedIndex==0))
    {
	var valeur=document.form_choix.id_orga[document.form_choix.id_orga.selectedIndex].value;
	valeur=valeur.substring(0,valeur.indexOf("|"));
	var deja_pris=0;
	for (j=0;j<longueur;j++)
	{ 
	if (eval("document.form_planning.id_orga_"+nb+"_"+j+".value")==valeur)
	{
	alert("Cet orga est d?j? affect? ? cette t?che.\nChoisis-en un autre !");          deja_pris=1;          break;
	}
	}
	if ((eval("document.form_planning.id_orga_"+nb+"_"+longueur+".value").indexOf("|"+valeur+"|")!=-1) || (eval("document.form_planning.id_orga_"+nb+"_"+longueur+".value").indexOf(valeur+"|")==0))
	{
	alert("Cet orga est d?j? affect? ? cette t?che.\nChoisis-en un autre !");
	deja_pris=1;
	}
	if (deja_pris==0)
	{
	valeur=valeur+"|";
	eval("document.form_planning.id_orga_"+nb+"_"+longueur+".value=document.form_planning.id_orga_"+nb+"_"+longueur+".value+valeur");
	separ="";
	if (eval("document.form_planning.name_"+nb+"_"+longueur+".value")!="") separ=", ";        eval("document.form_planning.name_"+nb+"_"+longueur+".value=document.form_planning.name_"+nb+"_"+longueur+".value+separ+document.form_choix.id_orga.options[document.form_choix.id_orga.selectedIndex].text");
	}
	/*      nb=nb+15;      nb_txt=""+nb;//manque changement de mois et d'ann?e      if (nb_txt.substr(8,4)=="2360") nb=nb+7640;      else if (nb_txt.substr(8,2)>=24) nb=nb+7600;      else if (nb_txt.substr(10,2)=="60") nb=nb+40;*/
    }
	//  }
	changement=1;
	}
	function confirm_record(opt){
	if (opt==1){ document.form_choix.modiftache.value=1;}
	if (changement==1)
	{
	if (confirm("Voulez-vous enregistrez les modifications avant de changer de t?che ?"))
    {
	document.form_planning.id_tache_new.value=document.form_choix.id_tache.value;
	document.form_planning.submit();
    }
    else document.form_choix.submit();
	}
    else document.form_choix.submit();
	}
	function confirm_record_tache(){
	document.form_choix.modiftache.value=1;
	if (changement==1)
	{
    if (confirm("Voulez-vous enregistrez les modifications avant de changer de t?che ?"))
    {
	document.form_planning.id_tache_new.value=document.form_choix.id_tache.value;
	document.form_planning.submit();
    }
    else document.form_choix.submit();
	}
    else document.form_choix.submit();}
	-->
	</SCRIPT>
	<TABLE width="1%" cellspacing="0" cellpadding="3">
	<TR>
    <TD>&nbsp;</TD>
	</TR>
    <FORM method="POST" name="form_choix" action="main.php?file=plannings&action=affect"><input type="hidden" name="modiftache" value="0">
	<TR class="plannings_top">
    <TD> 
	<TABLE width="1%" cellspacing="0" cellpadding="3">
	<TR>
	<TD valign="top" nowrap> <TABLE width="1%" border="0" cellspacing="0" cellpadding="3">
	<TR>
	<TD nowrap><B>Choisis une categorie :</B></TD>
	<TD valign="top" align="center"> <SELECT name="id_categorie" onChange="confirm_record(1)">
	<?
	$categories_array=result_categories($req_categories_tache);
	for ($i=0;$i<count($categories_array);$i++)
	{
	$is_selected="";
	if($categories_array[$i]->id_categorie==$id_categorie){$is_selected="selected";}
	?>
	<OPTION <? print($is_selected); ?> value="<? print($categories_array[$i]->id_categorie); ?>"><? print($categories_array[$i]->nom); ?></OPTION>
	<?
	}
	?>
	</select>
	</td>
	</tr>
	<TR>
	<TD nowrap><B>Choisis une t&acirc;che :</B></TD>
	<TD valign="top" align="center"> <SELECT name="id_tache" onChange="confirm_record(2)">
	<?
	$begin_time_tache="";
	$end_time_tache="";
	$plages_tache="";
	$nb_orgas_tache=0;
	$taches_array=result_taches($req_taches);
	for ($i=0;$i<count($taches_array);$i++)
	{
    if($id_categorie==$taches_array[$i]->id_categorie){
	$is_selected="";
    if ($taches_array[$i]->id_tache==$id_tache)
    {
	$is_selected="selected";
	$begin_time_tache=date_en_to_number($taches_array[$i]->begin_time);
	$end_time_tache=date_en_to_number($taches_array[$i]->end_time);
	$plages_tache=$taches_array[$i]->plages;
	$nb_orgas_tache=$taches_array[$i]->nb_orgas;
    }
	?>
	<OPTION <? print($is_selected); ?> value="<? print($taches_array[$i]->id_tache); ?>"><?  print($taches_array[$i]->titre); ?></OPTION>
	<?
	}
	}
	$list_plages_tache=explode("|",$plages_tache);
	$list_days_tache=array();
	for ($i=0;$i<count($list_plages_tache);$i++)
	{
    if ($list_plages_tache[$i]!="")
    {
	$list_days_tache[count($list_days_tache)]=substr(list_to_begin_plage($list_plages_tache[$i]),0,10);      $list_days=list_days_between(substr(list_to_begin_plage($list_plages_tache[$i]),0,10),substr(list_to_end_plage($list_plages_tache[$i]),0,10));
	for($j=0;$j<count($list_days);$j++)
	{
	$list_days_tache[count($list_days_tache)]=$list_days[$j];
	}
	$list_days_tache[count($list_days_tache)]=substr(list_to_end_plage($list_plages_tache[$i]),0,10);
    }
	}
	?>
	</SELECT></TD>
	</TR>
	<TR>
	<TD colspan="2"><B>Consignes : </B> <BR> <? print(nl2br($consigne_tache)); ?></TD>
	</TR>
	</TABLE>
	</TD>
	<TD>&nbsp;&nbsp;&nbsp;</TD>
	<TD valign="top" nowrap>
	<B>Choisis un orga :</B>
	</TD>
	<TD valign="top" align="center">
	<SELECT name="id_orga" size="10" onChange="change_img()">
	<OPTION value="0|<? print($begin_time_tache); ?>|<? print($begin_time_tache); ?>"></OPTION>
	<?
	$orgas_array=result_orgas($req_orgas);
	for ($i=0;$i<count($orgas_array);$i++)
	{
	$plages_orga=$orgas_array[$i]->plages;
	$list_plages_orga=explode("|",$plages_orga);
	$list_days_orga=array();
    for ($j=0;$j<count($list_plages_orga);$j++)
    {
	if ($list_plages_orga[$j]!="")
	{
	$list_days_orga[count($list_days_orga)]=substr(list_to_begin_plage($list_plages_orga[$j]),0,10);        $list_days=list_days_between(substr(list_to_begin_plage($list_plages_orga[$j]),0,10),substr(list_to_end_plage($list_plages_orga[$j]),0,10));
	for($k=0;$k<count($list_days);$k++)
	{
	$list_days_orga[count($list_days_orga)]=$list_days[$k];
	}
	$list_days_orga[count($list_days_orga)]=substr(list_to_end_plage($list_plages_orga[$j]),0,10);
	}
    }
    $orga_in_plage_tache=false;
    for ($j=0;$j<count($list_days_orga);$j++)
	{
	if (in_array($list_days_orga[$j],$list_days_tache))
	{
	$orga_in_plage_tache=true;
	break;
	}
	}
	if ($orga_in_plage_tache)
	{
	?>
	<OPTION value="<? print($orgas_array[$i]->id_orga.$orgas_array[$i]->plages); ?>" class="<?
	for ($u=0;$u<count($categories_orgas_array);$u++){
	if($orgas_array[$i]->id_categorie==$categories_orgas_array[$u]->id_categorie)
	print($categories_orgas_array[$u]->couleur);
	}
	?>"><? print($orgas_array[$i]->first_name." ".$orgas_array[$i]->last_name); ?></OPTION>
	<?
    }
	}
	?>
	</SELECT></TD>
	<!--	// pas de boucle, c est tp complique - a voir par la suite          <TD>&nbsp;&nbsp;&nbsp;</TD>          <TD VALIGN="top" nowrap>            <B>Choisis une dur&eacute;e :</B>          </TD>          <TD VALIGN="top" ALIGN="center">            <SELECT NAME="duree_orga" SIZE="10">              <OPTION VALUE="00:15:00" selected>0h15</OPTION>              <OPTION VALUE="00:30:00">0h30</OPTION>              <OPTION VALUE="00:45:00">0h45</OPTION>              <OPTION VALUE="01:00:00">1h00</OPTION>              <OPTION VALUE="01:15:00">1h15</OPTION>              <OPTION VALUE="01:30:00">1h30</OPTION>              <OPTION VALUE="01:45:00">1h45</OPTION>              <OPTION VALUE="02:00:00">2h00</OPTION>            </SELECTED>          </TD>-->
	<TD>&nbsp;&nbsp;&nbsp;</TD>
	<TD valign="top">
	<INPUT type="button" value="Envoyer" onClick="document.form_planning.submit()">
	</TD>
	<TD valign="top">
	<INPUT type="submit" value="Effacer">
	</TD>
	</TR>
	</TABLE>
    </TD>
	</TR></FORM><FORM method="POST" name="form_planning" action="db_action.php?db_action=update_planning_tache">
	<TR class="plannings">
    <TD>
	<TABLE width="1%" cellspacing="0" cellpadding="3"><INPUT type="hidden" name="id_categorie" value="<? print($id_categorie); ?>"><INPUT type="hidden" name="id_tache" value="<? print($id_tache); ?>"><INPUT type="hidden" name="id_tache_new" value="<? print($id_tache); ?>"><INPUT type="hidden" name="begin_time_loop" value="<? print($begin_time_tache); ?>"><INPUT type="hidden" name="end_time_loop" value="<? print($end_time_tache); ?>"><?
	$plannings_array=result_plannings($req_plannings);
	$current_time="";
	$current_day="";
	$last_position=0;
	$list_plages=explode("|",$plages_tache);
	$nb_plages=count($list_plages)-2;
	for ($boucle_plage=0;$boucle_plage<$nb_plages;$boucle_plage++)
	{
	$begin_time_tache=list_to_begin_plage($list_plages[$boucle_plage+1]);
	$begin_time_tache=$begin_time_tache.":00";
	$begin_time_tache=date_fr_to_number($begin_time_tache);
	$end_time_tache=list_to_end_plage($list_plages[$boucle_plage+1]);
	$end_time_tache=$end_time_tache.":00";
	$end_time_tache=date_fr_to_number($end_time_tache);
	if ($boucle_plage!=0)  {
	?>
	<TR>
	<TD width="1%" colspan="2" nowrap><HR width="100%" noshade></TD>
	</TR>
	<?
	}
    for ($i=$begin_time_tache;$i<$end_time_tache;$i=$i+15)
	{
    $k=0;
    $i=test_time($i);
    if ($i>=$end_time_tache) break;
    if (substr(date_number_to_fr($i),0,10)!=$current_day)
    {
	$current_day=substr(date_number_to_fr($i),0,10);
	?>
	<TR>
	<TD width="1%" colspan="2" nowrap>
	<B><? print($current_day); ?></B> 
	</TD>
	</TR>
	<?
    }
    if ($i!=$current_time)
    {
	?>
	<TR>
	<TD valign="top" align="right" width="1%" nowrap>
	<? print(substr(date_number_to_fr($i),11,6)); ?>
	</TD>
	<TD nowrap>
	<?
	$current_time=$i;
    }
	$nb_orgas=0;
    for ($j=$last_position;$j<count($plannings_array);$j++)
    {
	//print($current_time);
	if (date_en_to_number($plannings_array[$j]->current_time)!=$current_time)
	{
	$last_position=$j;
	break;
	}
	$list_orgas=explode("|",$plannings_array[$j]->id_orga);
	$nb_orgas=count($list_orgas)-2;
	for ($l=0;$l<count($list_orgas);$l++)
	{
	for ($m=0;$m<count($orgas_array);$m++)
	{
	if ($orgas_array[$m]->id_orga==$list_orgas[$l])
	{
	?> 
	<A href="main.php?file=plannings&action=define&id_orga=<? print($orgas_array[$m]->id_orga); ?>" class="<?
	for ($u=0;$u<count($categories_orgas_array);$u++){
	if($orgas_array[$m]->id_categorie==$categories_orgas_array[$u]->id_categorie)
	print($categories_orgas_array[$u]->couleur);
	}
	?>"><? print($orgas_array[$m]->nom_orga); ?></A>&nbsp;-
	<INPUT type="hidden" name="id_orga_<? print($i); ?>_<? print($k); ?>" value="<? 
	print($orgas_array[$m]->id_orga);
	?>"><?
	break;
	}
	}
	if (($l!=0) && (fmod($l,5)==0)) print("<BR>");
	}
	$k++;
    }
	//-------		  
	$ask=date_number_to_en($i).":00";
	//print("*".$ask."*");
	//autre id?e qui sera retenue pour des questions de rapidit?e, une seule reqete par 15min
	$req_sql="SELECT plannings.id_orga FROM plannings WHERE plannings.id_tache!='0' AND plannings.id_orga!='|0|' AND plannings.current_time='".$ask."' ORDER BY plannings.id_tache";
	$req_total = mysql_query($req_sql);
    $total_array=result_plannings($req_total);
	//petit essai	/*	$aa=array(10,20,30);	$bb=array(40,50);	array_push($aa,$bb);	var_dump($aa);*/
	$orgas_occupes=array();	for($o=0;$o<count($total_array);$o++)
	{
	$temp=explode("|",$total_array[$o]->id_orga);
	for($p=1;$p<count($temp)-1;$p++)
	{
	array_push($orgas_occupes,$temp[$p]);
	}
	//print("ligne ".$o." -->".$total_array[$o]->id_orga."//".$ask."  // ".$orgas_occupes."<br>");
	}
	//print($i."//".$k."==");
	//var_dump($orgas_occupes);	
	//--------
	?>
	<INPUT type="text" name="name_<? print($i); ?>_<? print($k); ?>" value="" onClick="change_txt(<? print($i); ?>,<? print($k); ?>)">
	<IMG name="coche_<? print($i); ?>" title="<? print("a0a"); for ($o=0;$o<count($orgas_occupes);$o++){print($orgas_occupes[$o]."a");} print("0a"); ?>" src="images/blanc.gif" height="15" width="15"><? print($nb_orgas-$nb_orgas_tache); ?>
	<INPUT type="hidden" name="id_orga_<? print($i); ?>_<? print($k); ?>" value="">
	<INPUT type="hidden" name="nb_orgas_<? print($i); ?>" value="<? print($k); ?>">
	<INPUT type="hidden" name="current_time_<? print($i); ?>_<? print($k); ?>" value="<? print(date_number_to_en($i).":00"); ?>">
	</TD>
	</TR>
	<?
	}
	}
	?>
	</TABLE>
    </TD>
	</TR></FORM></TABLE>