<?
  include ('session.php');
  
  isset($_GET['file']) ? $file = $_GET['file'] : $file = "";
  isset($_GET['action']) ? $action = $_GET['action'] : $action = ""; 
  
  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT * FROM dates ORDER BY id_date";
  $req = mysql_query($req_sql);

  $global_begin_date="";
  $global_end_date="";

  while ($data = mysql_fetch_array($req)) 
  {
    if ($data['id_date']==1) $global_begin_date=substr($data['valeur'],0,16);
    if ($data['id_date']==2) $global_end_date=substr($data['valeur'],0,16);
  }

  $db_error="no";
  $req_sql="SELECT * FROM plannings WHERE id_orga='' OR id_orga='||' OR id_orga='|' OR id_orga LIKE '%||%'";
  $req = @mysql_query($req_sql);
  $res = @mysql_numrows($req);
  if ($res!=0) $db_error="yes";

?>

<HTML>

<HEAD>

<TITLE>Planningmaker(c)</TITLE>
<LINK href="main.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
if ($action=="alpha") echo '<META http-equiv="Refresh" content="600">';
?>

</HEAD>


<BODY>

<?
  if (!(strpos($file, "http://")===FALSE)) $file="piratage1";
  if (strpos($session_db_name, "planning")===FALSE) $file="piratage2";

/*
  $nb_type_orgas=7;
  $type_orgas_array=array('orgas','vehicules','lieux','talkies','categories','taches','plannings');
  $titre_orgas_array=array('Orgas','Véhicules','Lieux','Talkies','Catégories','Tâches','Plannings');

  $nb_type_eq=3;
  $type_eq_array=array('equipes','activites','plannings_eq');
  $titre_eq_array=array('Equipes','Activités','Plannings');

  $menu_top="<A HREF=\"main.php?file=menu\" CLASS=\"menu2\">[Menu]</A>";

  $users_top="<A HREF=\"main.php?file=users\" CLASS=\"menu\">[Utilisateurs]</A>";
  $users_ajout_top="<A HREF=\"main.php?file=users&action=ajout\" CLASS=\"menu\">Ajout</A>";
  $users_liste_top="<A HREF=\"main.php?file=users&action=alpha\" CLASS=\"menu\">Liste</A>";
  $users_alpha_top="<A HREF=\"main.php?file=users&action=alpha\" CLASS=\"menu\">Alphabétique</A>";
*/

$type = "";
  switch($file)
  {
	case "fournisseurs":
      $title="Les fournisseurs";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="fournisseurs";
      break; 
	case "materiels":
      $title="Le materiel";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="materiels";
      break;
    case "orgas":
      $title="Les orgas";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="orgas";
      break;
    case "vehicules":
      $title="Les véhicules";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="vehicules";
      break;
    case "lieux":
      $title="Les lieux";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="lieux";
      break;
    case "talkies":
      $title="Les talkies";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="talkies";
      break;
    case "categories":
      $title="Les catégories";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="categories";
      break;
    case "taches":
      $title="Les tâches";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="taches";
      break;
    case "plannings":
      $title="Les plannings des orgas";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="plannings";
      break;
    case "equipes":
      $title="Les équipes";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="equipes";
      break;
    case "activites":
      $title="Les activités";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="activites";
      break;
    case "plannings_eq":
      $title="Les plannings des équipes";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="plannings_eq";
      break;
    case "users":
      $title="Les utilisateurs";
      if ($action=="") $file="menu_spec";
      else $file=$file."_".$action;
      $type="users";
      break;
    default:
      $title="Menu";
      break;
  }

?>


<CENTER>
<TABLE width="100%">
  <TBODY>
  <TR>
    <TD width="1%">&nbsp;</TD>
 	<TD width="100%" class "<? $type ?>" align="center"><H1>-- <? print($title); ?> --</H1></TD>
  </TR>
  <TR>
      <TD width="1%" valign="top">
        <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="185" height="500">
          <PARAM name="movie" value="bde.swf">
          <PARAM name="quality" value="high">
          <EMBED src="bde.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="185" height="500"></EMBED></OBJECT>
      </TD>
      <TD align="center" width="81%" valign="top" align="left"> 
        <?


  if ($db_error=="yes")
  {
    if ($file=="menu_spec") $redirect=$type;
	else $redirect=$file;

?>
        <P>&nbsp;</P><P>&nbsp;</P><P><B>Erreur dans la base de données</B> <BR>
          Clique sur le bouton pour la corriger
        <FORM name="form" method="post" action="db_action.php?db_action=correct_db">
          <INPUT type="submit" name="Submit" value="Corriger">
		  <INPUT type="hidden" name="file" value="<? print($redirect); ?>">
		  <INPUT type="hidden" name="type" value="<? print($type); ?>">
        </FORM> </P>
        <?
  }
  else
  {
  	  	
	if ($session_user_type=="admin") 
    {
	include($file.'.php');
    }
    if ($session_user_type=="soft")
    {
      if ((!(strpos($file, "taches")===FALSE)) ||(!(strpos($file, "materiels")===FALSE)) ||(!(strpos($file, "lieux")===FALSE)) ||(!(strpos($file, "orgas")===FALSE)) ||(!(strpos($file, "fournisseurs")===FALSE)) || ($file=="menu") || ($file=="menu_spec")) include($file.'.php');
	  else print("Tu n'as pas le droit d'afficher cette page");
    }
  }
?> 

    </TD>
  </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>
