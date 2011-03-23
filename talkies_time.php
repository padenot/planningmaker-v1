<?
  isset($_POST['current_time']) ? $current_time = $_POST['current_time'] : $current_time = "";
  if ($current_time=="") $current_time=$global_begin_date.":00";  else $current_time=date_fr_to_en($current_time.":00");  $req_sql="SELECT taches.titre, talkies.nom_talkie, plannings.id_orga, lieux.nom_lieu FROM taches, talkies, plannings, lieux WHERE plannings.id_tache=taches.id_tache AND taches.id_talkie=talkies.id_talkie AND taches.id_lieu=lieux.id_lieu AND plannings.id_orga!='|0|' AND plannings.current_time='".$current_time."' ORDER BY talkies.nom_talkie, taches.titre";  $req_talkies = mysql_query($req_sql);  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";  $req_orgas = mysql_query($req_sql);  $current_time=substr(date_en_to_fr($current_time),0,16);?><SCRIPT language="Javascript"><!--
  function verify(){
  var ok=1;
  if (document.form.current_time.value=="")
  {
  alert("Tu dois donner une heure de recherche");
  ok=0;
  }
  else if ((document.form.current_time.value.length!=16) || (document.form.current_time.value.charAt(2)!="-") || (document.form.current_time.value.charAt(5)!="-") || (document.form.current_time.value.charAt(10)!=" ") || (document.form.current_time.value.charAt(13)!=":"))
  {
  alert("Tu dois une heure de recherche dans le bon format (jj-mm-aaaa hh:mm)");
  ok=0;
  }
  if (ok==1) document.form.submit();
  }
  --></SCRIPT><TABLE width="1%" cellspacing="0" cellpadding="3"><FORM method="POST" name="form" action="main.php?file=talkies&action=time">  <TR>    <TD colspan="5">&nbsp;</TD>  </TR>  <TR class="talkies_top">    <TD colspan="5" nowrap>      <B>Choisis une heure (jj-mm-aaaa hh:mm)</B>&nbsp;&nbsp;&nbsp;      <INPUT type="text" name="current_time" value="<? print($current_time); ?>" size="20" maxlength="40">      <INPUT type="button" value="Go" onClick="verify()">    </TD>  </TR>  <TR class="talkies_top">    <TD colspan="2" nowrap>      <B>Liste des talkies</B>    </TD>    <TD align="center">      <B>T&acirc;ches</B>    </TD>    <TD align="center">      <B>Lieu</B>    </TD>    <TD align="center">      <B>Orgas</B>    </TD>  </TR><?  $talkies_array=result_talkies($req_talkies);  $orgas_array=result_orgas($req_orgas);  $current_talkie="";  $current_tache="";  for ($i=0;$i<count($talkies_array);$i++)  {    $nom="";    $titre="";    $nom_lieu="";	$nom_orgas="";    if (($current_talkie!=$talkies_array[$i]->nom) || ($current_tache!=$talkies_array[$i]->titre))    {      $nom=$talkies_array[$i]->nom;      $titre=$talkies_array[$i]->titre;      $nom_lieu=$talkies_array[$i]->nom_lieu;      $current_talkie=$nom;      $current_tache=$titre;      $list_orgas=explode("|",$talkies_array[$i]->id_orga);      for ($j=0;$j<count($list_orgas);$j++)      {        for ($k=0;$k<count($orgas_array);$k++)        {          if ($orgas_array[$k]->id_orga==$list_orgas[$j])          {		    if ($nom_orgas!="") $nom_orgas=$nom_orgas."<BR>";		    $nom_orgas=$nom_orgas.$orgas_array[$k]->nom_orga;            break;          }        }      }    }?>  <TR class="talkies">      <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>    <TD valign="top" nowrap>      <? print($nom); ?>    </TD>    <TD align="center" valign="top" nowrap>      <? print($titre); ?>    </TD>    <TD align="center" valign="top" nowrap>      <? print($nom_lieu); ?>    </TD>    <TD align="center" nowrap>      <? print($nom_orgas); ?>    </TD>  </TR><?  }?></FORM></TABLE>