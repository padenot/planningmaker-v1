<?
  session_start();

  $session_db_name = $_SESSION['session_db_name'];
  $session_user_type = $_SESSION['session_user_type'];
  
  isset($_POST['select_display']) ? $select_display = $_POST['select_display'] : $select_display = "";
  isset($_POST['display_nom']) ? $display_nom = $_POST['display_nom'] : $display_nom = "";
  isset($_POST['display_prenom']) ? $display_prenom = $_POST['display_prenom'] : $display_prenom = "";
  isset($_POST['display_email']) ? $display_email = $_POST['display_email'] : $display_email = "";
  isset($_POST['display_mail_adress']) ? $display_mail_adress = $_POST['display_mail_adress'] : $display_mail_adress = "";
  isset($_POST['display_phone_number']) ? $display_phone_number = $_POST['display_phone_number'] : $display_phone_number = "";
  isset($_POST['display_begin_time']) ? $display_begin_time = $_POST['display_begin_time'] : $display_begin_time = "";
  isset($_POST['display_end_time']) ? $display_end_time = $_POST['display_end_time'] : $display_end_time = "";
  
  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT * FROM orgas ORDER BY id_categorie DESC, first_name ASC, last_name ASC";
  $req = mysql_query($req_sql);
?>

<HTML>

<HEAD>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<TITLE>Liste des orgas</TITLE>
<LINK href="print.css" type="text/css" rel="stylesheet">

</HEAD>


<BODY>

<FORM name="form" method="post" action="orgas_alpha_print.php">
  <TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
    <TR> 
    <TD colspan="7">
        <INPUT type="submit" name="Submit" value="Actualiser">
        <INPUT type="hidden" name="select_display" value="yes">
      </TD>
  </TR>
  <TR bgcolor="#CCCCCC"> 
      <TD COLSPAN="2" nowrap> <B>Liste des orgas</B> <INPUT type="checkbox" name="display_nom" value="yes" checked><INPUT type="checkbox" name="display_prenom" value="yes" checked></TD>

<?
  if ((($select_display=="") && ($display_email=="")) || (($select_display=="yes") && ($display_email=="yes")))
  {
?>

      <TD ALIGN="center" nowrap>
	    <TABLE width="1%" cellpadding="0" cellspacing="0">
		  <TR>
		    <TD nowrap><B>E-mail</B>&nbsp;</TD>
			<TD><INPUT type="checkbox" name="display_email" value="yes" checked></TD>
		  </TR>
		</TABLE>
    </TD>

<?
  }
  if ((($select_display=="") && ($display_mail_adress=="")) || (($select_display=="yes") && ($display_mail_adress=="yes")))
  {
?>

    <TD ALIGN="center" NOWRAP>
	    <TABLE width="1%" cellpadding="0" cellspacing="0">
		  <TR>
		    <TD nowrap><B>Equipe</B>&nbsp;</TD>
			<TD><INPUT type="checkbox" name="display_id_categorie" value="yes" checked></TD>
		  </TR>
		</TABLE>
	</TD>

<?
  }
  if ((($select_display=="") && ($display_phone_number=="")) || (($select_display=="yes") && ($display_phone_number=="yes")))
  {
?>

    <TD ALIGN="center" NOWRAP>
	    <TABLE width="1%" cellpadding="0" cellspacing="0">
		  <TR>
		    <TD nowrap><B>T&eacute;l.</B>&nbsp;</TD>
			<TD><INPUT type="checkbox" name="display_phone_number" value="yes" checked></TD>
		  </TR>
		</TABLE>
	</TD>

<?
  }
  if ((($select_display=="") && ($display_begin_time=="")) || (($select_display=="yes") && ($display_begin_time=="yes")))
  {
?>

      <TD ALIGN="center" nowrap>
	    <TABLE width="1%" cellpadding="0" cellspacing="0">
		  <TR>
		    <TD nowrap><B>D&eacute;but</B>&nbsp;</TD>
			<TD><INPUT type="checkbox" name="display_begin_time" value="yes" checked></TD>
		  </TR>
		</TABLE>
	</TD>

<?
  }
  if ((($select_display=="") && ($display_end_time=="")) || (($select_display=="yes") && ($display_end_time=="yes")))
  {
?>

      <TD ALIGN="center" nowrap>
	    <TABLE width="1%" cellpadding="0" cellspacing="0">
		  <TR>
		    <TD nowrap><B>Fin</B>&nbsp;</TD>
			<TD><INPUT type="checkbox" name="display_end_time" value="yes" checked></TD>
		  </TR>
		</TABLE>
	</TD>

<?
  }
?>

  </TR>
  <?
  $orgas_array=result_orgas($req);
  $bgcolor="#EAEAEA";
  for ($i=0;$i<count($orgas_array);$i++)
  {
    if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
	else $bgcolor="#EAEAEA";
?>
  <TR bgcolor="<? print($bgcolor); ?>"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
	<?
  if ((($select_display=="") && ($display_prenom=="")) || (($select_display=="yes") && ($display_prenom=="yes")))
  {
print($orgas_array[$i]->first_name); }
if ((($select_display=="") && ($display_nom=="")) || (($select_display=="yes") && ($display_nom=="yes")))
  {
      print(' '.$orgas_array[$i]->last_name);}?> </TD>

<?
  if ((($select_display=="") && ($display_email=="")) || (($select_display=="yes") && ($display_email=="yes")))
  {
?>

    <TD nowrap ALIGN="CENTER"> <? print($orgas_array[$i]->email); ?> </TD>

<?
  }

	// On récupère le nom d'équipe
	$idcat = $orgas_array[$i]->id_categorie;
	$req_sql_categorie='SELECT * FROM categories where id_categorie='.$idcat;
  	$req_categorie = mysql_query($req_sql_categorie);

  	$equipe = mysql_fetch_assoc($req_categorie);
?>

    <TD nowrap ALIGN="CENTER"> <? print($equipe["nom_categorie"]); ?> </TD>

<?
 
  if ((($select_display=="") && ($display_phone_number=="")) || (($select_display=="yes") && ($display_phone_number=="yes")))
  {
?>

    <TD nowrap ALIGN="CENTER"> <? print($orgas_array[$i]->phone_number); ?> </TD>

<?
  }
  if ((($select_display=="") && ($display_begin_time=="")) || (($select_display=="yes") && ($display_begin_time=="yes")))
  {
?>

    <TD nowrap ALIGN="CENTER"> <? print(substr(date_en_to_fr($orgas_array[$i]->begin_time),0,16)); ?> 
    </TD>

<?
  }
  if ((($select_display=="") && ($display_end_time=="")) || (($select_display=="yes") && ($display_end_time=="yes")))
  {
?>

    <TD nowrap ALIGN="CENTER"> <? print(substr(date_en_to_fr($orgas_array[$i]->end_time),0,16)); ?> 
    </TD>

<?
  }
?>

  </TR>
  <?
  }
?>
</TABLE>
</FORM>

</BODY>
</HTML>