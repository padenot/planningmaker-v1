<?
  session_start();

  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT taches.*, lieux.nom_lieu FROM taches, lieux WHERE taches.id_lieu=lieux.id_lieu ORDER BY taches.titre";
  $req = mysql_query($req_sql);

  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);
?>

<HTML>

<HEAD>

<TITLE>Liste des tâches</TITLE>
<LINK href="print.css" type="text/css" rel="stylesheet">

</HEAD>


<BODY>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="6">&nbsp;</TD>
  </TR>
  <TR bgcolor="#CCCCCC">
    <TD COLSPAN="2" nowrap>
      <B>Liste des t&acirc;ches</B>
    </TD>
    <TD ALIGN="center">
      <B>D&eacute;but</B>
    </TD>
    <TD ALIGN="center">
      <B>Fin</B>
    </TD>
    <TD ALIGN="center">
      <B>Lieu</B>
    </TD>
    <TD ALIGN="center">
      <B>Responsable</B>
    </TD>
  </TR>

<?
  $orgas_array=result_orgas($req_orgas);

  $taches_array=result_taches($req);
  $bgcolor="#EAEAEA";
  for ($i=0;$i<count($taches_array);$i++)
  {
    if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
	else $bgcolor="#EAEAEA";
    $resp="";
    if ($taches_array[$i]->id_resp==0) $resp="personne";
    else
    {
      for ($j=0;$j<count($orgas_array);$j++)
      {
        if ($orgas_array[$j]->id_orga==$taches_array[$i]->id_resp)
        {
          $resp=$orgas_array[$j]->first_name." ".$orgas_array[$j]->last_name;
          break;
        }
      }
    }
?>

  <TR bgcolor="<? print($bgcolor); ?>">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      <? print($taches_array[$i]->titre); ?>
    </TD>
    <TD nowrap>
      <? print(substr(date_en_to_fr($taches_array[$i]->begin_time),0,16)); ?>
    </TD>
    <TD nowrap>
      <? print(substr(date_en_to_fr($taches_array[$i]->end_time),0,16)); ?>
    </TD>
    <TD nowrap>
      <? print($taches_array[$i]->nom_lieu); ?>
    </TD>
    <TD nowrap>
      <? print($resp); ?>
    </TD>
  </TR>

<?
  }

  $req_sql="SELECT taches.* FROM taches, lieux WHERE taches.id_lieu='0' ORDER BY taches.titre";
  $req = mysql_query($req_sql);

  $taches_array=result_taches($req);
  for ($i=0;$i<count($taches_array);$i++)
  {
    if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
	else $bgcolor="#EAEAEA";
    $resp="";
    if ($taches_array[$i]->id_resp==0) $resp="personne";
    else
    {
      for ($j=0;$j<count($orgas_array);$j++)
      {
        if ($orgas_array[$j]->id_orga==$taches_array[$i]->id_resp)
        {
          $resp=$orgas_array[$j]->first_name." ".$orgas_array[$j]->last_name;
          break;
        }
      }
    }
    if ($i==0)
	{
?>

  <TR bgcolor="<? print($bgcolor); ?>">
    <TD colspan="8"><HR width="75%"></TD>
  </TR>

<?
    }
?>

  <TR bgcolor="<? print($bgcolor); ?>">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      <? print($taches_array[$i]->titre); ?>
    </TD>
    <TD nowrap>
      <? print(substr(date_en_to_fr($taches_array[$i]->begin_time),0,16)); ?>
    </TD>
    <TD nowrap>
      <? print(substr(date_en_to_fr($taches_array[$i]->end_time),0,16)); ?>
    </TD>
    <TD nowrap>
      A d&eacute;finir
    </TD>
    <TD nowrap>
      <? print($resp); ?>
    </TD>
  </TR>

<?
  }
?>

</TABLE>

</BODY>
</HTML>