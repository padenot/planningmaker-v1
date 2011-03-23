<?
  session_start();

  $session_db_name = $_SESSION['session_db_name'];
  
  include('connect_db.php');
  include('functions.php');
  include('classes.php');

 if ($session_db_name=="planning_users")
  {
    $current_db_name="";

    $db_list=mysql_list_dbs();
    for ($i=0;$i<mysql_num_rows($db_list);$i++)
    {
      $db_name=mysql_db_name($db_list, $i);
  	  if (!(strpos($db_name,"planning")===false))
	  {
        if (($id_db=="") && ($current_db_name=="")) $current_db_name=$db_name;
		if (($id_db!="") && ($i==$id_db)) $current_db_name=$db_name;
      }
	}

?>

<HTML>

<HEAD>

<TITLE>Planningmaker(c)</TITLE>
<LINK href="main.css" type="text/css" rel="stylesheet">
</HEAD>


<BODY>
<CENTER><H1>-- Module Administrateur --</H1>
  <TABLE width="1%">
    <TR>
      <TD valign="top" nowrap bgcolor="#D0DCE0">
        <P><B> Administration des bases</B></P>
        <P>Choisis une base :

<?
    $db_list=mysql_list_dbs();
    for ($i=0;$i<mysql_num_rows($db_list);$i++)
    {
      $db_name=mysql_db_name($db_list, $i);
  	  if (!(strpos($db_name,"planning")===false))
	  {
        if ($id_db=="") $id_db=$i;
?>
          <BR><A href="admin_bases_ajout.php?id_db=<? print($i); ?>"><? print($db_name); ?></A>

<?
      }
	}
?>

		</P>
        <P><A href="admin.php">Retour</A></P>
        <P><A href="logout.php">Logout</A></P>
      </TD>
      <TD align="center" valign="top" bgcolor="#D0DCE0"> 
        <P><B>ajoutons 
          &agrave; la 
          base &quot;<? print($current_db_name); ?>&quot;</B></P>
      
	  <form method="post" name="form" action="db_action.php?db_action=recup_db">
	  <TABLE width="100%" border="0" cellspacing="0" cellpadding="3">
            <TR> 
              <TD colspan="2" nowrap bgcolor="#D0DCE0">Les informations de : </TD>
              <TD bgcolor="#D0DCE0"> 
			  <select name="db_recup">
			  <option value="0"></option>
               <? $db_list=mysql_list_dbs();
    for ($i=0;$i<mysql_num_rows($db_list);$i++)
    {
	$db_name=mysql_db_name($db_list, $i);
	if (!(strpos($db_name,"planning")===false))
	  {
	  if($db_name!="planning_users"){
	  if($db_name!=$current_db_name){
	?>
				<option value"<? print($db_name); ?>"><? print($db_name); ?></option>
				
				<? }}}
				} ?>
				</select>
              </TD>
            </TR>
		<tr>
		      <td  colspan="2" nowrap> 
                récuperer 
                les orgas 
                : </td>
              <td>
		<input type="checkbox" name="orgas" value="yes">
		</td></tr>
		<tr>
		      <td  colspan="2" nowrap> 
                récuperer 
                les lieux 
                : </td>
              <td>
		<input type="checkbox" name="lieux" value="yes">
		</td></tr>	
			<tr>
		      <td  colspan="2" nowrap> 
                récuperer 
                les fournisseurs 
                :</td>
              <td>
		<input type="checkbox" name="fournisseurs" value="yes">
		</td></tr>
			<tr>
		      <td  colspan="2" nowrap> 
                récuperer 
                le materiel 
                : </td>
              <td>
		<input type="checkbox" name="materiels" value="yes">
		</td></tr></table>
		  <p>Attention, 
            les informations 
            r&eacute;cuper&eacute;e 
            seront ajout&eacute;es 
            mais je vous 
            conseille 
            quand m&ecirc;me 
            de le faire 
            a la cr&eacute;ation 
            du planning 
            ! </p>
          <p>&nbsp;</p>
          <p>
            <input type="submit" value="Envoyer">
            <INPUT type="hidden" name="db_name" value="<? print($current_db_name); ?>">
          </p>
        </form>
			
  </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>

<?
  }
  else include('piratage.php');
?>
