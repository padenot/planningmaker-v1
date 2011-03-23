<?
  session_start();
  
  $session_db_name = $_SESSION['session_db_name'];

  include('connect_db.php');
  include('functions.php');
  include('classes.php');

//*  if ($session_db_name=="planning_users")
//*  {
?>

<SCRIPT language="JavaScript">
function verif()
{
  if (confirm('Es-tu sûr de vouloir supprimer cette base ? \n-----------ACTION IRREVERSSIBLE!------------ \n' +document.form_base.db_name.value+ " sera détruites ainssi que ses informations"))
  {
	//j'arrive pas à le faire marcher
	document.form_base.submit();
  }
}
</SCRIPT>
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
        <P><A href="admin_new.php"> Ajouter une base de<BR>
          gestion des plannings</A></P>
        <P><A href="admin_bases.php">Gestion des bases<BR>
          enregistrées</A></P>
		  <P><A href="admin_bases_ajout.php">Récupération <br>d'informations<BR>
          enregistrées</A></P>
        <P><A href="logout.php">Logout</A></P>
      </TD>
      <TD align="center" valign="top" nowrap bgcolor="#F5F5F5">
<P><B>Liste des bases et des tables enregistr&eacute;es</B></P>
        <TABLE width="100%" border="0" cellspacing="3" cellpadding="3">
          <?
    $db_list=mysql_list_dbs();
    for ($i=0;$i<mysql_num_rows($db_list);$i++)
    {
      $db_name=mysql_db_name($db_list, $i);
  	  if (!(strpos($db_name,"planning")===false))
	  {
        if ($id_db=="") $id_db=$i;
?>
          <TR> 
            <TD colspan="2" nowrap bgcolor="#D0DCE0"><A href="admin.php?id_db=<? print($i); ?>"><? print($db_name); ?></A></TD>
          </TR>

<?
        if ($id_db==$i)
	    {
          $tables_list = mysql_list_tables ($db_name);
          for ($j=0;$j<mysql_num_rows($tables_list);$j++)
          {
            $tb_name=mysql_tablename($tables_list,$j);
?>

          <TR> 
            <TD nowrap><? print($tb_name); ?></TD>
            <TD><A href="admin_view.php?tb_name=<? print($tb_name); ?>&db_name=<? print($db_name); ?>&id_db=<? print($id_db); ?>">View</A></TD>
          </TR>

<?
          }
?>
<tr>
<td nowrap><P><B><? if ($db_name=="planning_users"){ print("impossible de suprimer cette base");} 
else {print("supprimer la 
                base $db_name 
                </B></P></td>
<td><A HREF='javascript:verif()' class='lien'>Go</A>
<form name='form_base' method='post' action='db_action.php?db_action=delete_db'>
<INPUT name='db_name' value='".$db_name."' type='hidden'></input>
</FORM>"); }?> </b></td></tr>

<?     } 
	  }
    }
?>

        </TABLE>
      </TD>
  </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>

<?
//*  }
//*  else include('piratage.php');
?>
