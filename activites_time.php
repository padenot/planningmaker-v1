<?
  isset($_POST['current_time']) ? $current_time = $_POST['current_time'] : $current_time = "";
  if ($current_time=="") $current_time=$global_begin_date.":00";  else $current_time=date_fr_to_en($current_time.":00");  $req_sql="SELECT activites.*, lieux.nom_lieu FROM activites, lieux WHERE activites.begin_time<='".$current_time."' AND activites.end_time>'".$current_time."' AND activites.id_lieu=lieux.id_lieu ORDER BY activites.titre, activites.id_activite";  $req_activites = mysql_query($req_sql);  $req_sql="SELECT plannings_eq.* FROM plannings_eq WHERE plannings_eq.current_time='".$current_time."' AND plannings_eq.id_equipe!='|0|'";  $req_plannings_eq = mysql_query($req_sql);  $req_sql="SELECT * FROM equipes ORDER BY nom_equipe";  $req_equipes = mysql_query($req_sql);  $current_time=substr(date_en_to_fr($current_time),0,16);?><SCRIPT language="Javascript"><!--function verify(){  var ok=1;  if (document.form.current_time.value=="")  {    alert("Tu dois donner une heure de recherche");    ok=0;  }  else if ((document.form.current_time.value.length!=16) || (document.form.current_time.value.charAt(2)!="-") || (document.form.current_time.value.charAt(5)!="-") || (document.form.current_time.value.charAt(10)!=" ") || (document.form.current_time.value.charAt(13)!=":"))  {    alert("Tu dois une heure de recherche dans le bon format (jj-mm-aaaa hh:mm)");    ok=0;  }  if (ok==1) document.form.submit();}--></SCRIPT><TABLE width="1%" cellspacing="0" cellpadding="3"><FORM method="POST" name="form" action="main.php?file=activites&action=time">  <TR>    <TD colspan="4">&nbsp;</TD>  </TR>  <TR class="activites_top">    <TD colspan="4" nowrap>      <B>Choisis une heure (jj-mm-aaaa hh:mm)</B>&nbsp;&nbsp;&nbsp;      <INPUT type="text" name="current_time" value="<? print($current_time); ?>" size="20" maxlength="40">      <INPUT type="button" value="Go" onClick="verify()">    </TD>  </TR>  <TR class="activites_top">    <TD colspan="2" nowrap>      <B>Liste des activit&eacute;s</B>    </TD>    <TD align="center">      <B>Lieu</B>    </TD>    <TD align="center">      <B>Equipes</B>    </TD>  </TR><?  $activites_array=result_activites($req_activites);  $plannings_eq_array=result_plannings_eq($req_plannings_eq);  $equipes_array=result_equipes($req_equipes);  for ($i=0;$i<count($activites_array);$i++)  {    $nom_equipes="";    for ($j=0;$j<count($plannings_eq_array);$j++)    {      if ($plannings_eq_array[$j]->id_activite==$activites_array[$i]->id_activite)      {        $list_equipes=explode("|",$plannings_eq_array[$j]->id_equipe);        for ($k=0;$k<count($list_equipes);$k++)        {          for ($l=0;$l<count($equipes_array);$l++)          {            if ($equipes_array[$l]->id_equipe==$list_equipes[$k])            {		      if ($nom_equipes!="") $nom_equipes=$nom_equipes."<BR>";  		      $nom_equipes=$nom_equipes.$equipes_array[$l]->nom;              break;            }          }        }      }    }    if ($nom_equipes=="") $nom_equipes="personne";?>  <TR class="activites">      <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>    <TD valign="top" nowrap>      <? print($activites_array[$i]->titre); ?>    </TD>    <TD align="center" valign="top" nowrap>      <? print($activites_array[$i]->nom_lieu); ?>    </TD>    <TD align="center" nowrap>      <? print($nom_equipes); ?>    </TD>  </TR><?  }?></FORM></TABLE>