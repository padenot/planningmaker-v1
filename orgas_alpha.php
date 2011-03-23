<?
$req_sql="SELECT * FROM categories WHERE type_categorie='orga'";
$req = mysql_query($req_sql);
$categories_array=result_categories($req);

  $req_sql="SELECT * FROM orgas ORDER BY id_categorie DESC, timestamp_inscription DESC, first_name, last_name";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="JavaScript">
function verif(id)
{
  if (confirm('Es-tu sûr de vouloir supprimer cet orga ?'))
  {
    document.form_suppr.id_orga.value=id;
	document.form_suppr.submit();
  }
}
</SCRIPT>

<?
  if ($msg_mail=="ok") $msg_mail=" : <FONT color=\"#FF0000\">envoi réussi</FONT>";
  if ($msg_mail=="ko") $msg_mail=" : <FONT color=\"#FF0000\">échec lors de l'envoi</FONT>";
  $orgas_array=result_orgas($req);
?>

<TABLE width="1%" cellspacing="0" cellpadding="3">
  <TR>
    <TD colspan="9" align="center"><h3><b><? print(count($orgas_array));?>&nbsp;orgas</b> enregistrés (màj <?php echo strftime("%Hh%M",time()); ?>)</h3></TD>
  </TR>
  <TR class="orgas_top">
    <TD colspan="9" valign="middle"> 
      <B><A href="<? print($file."_print.php"); ?>" target="_blank" class="menu"><img src="images/print.jpg"></A> 
      <A href="main.php?file=orgas&action=email" class="menu"><img src="images/mail.jpg"></A> 
      <a href="main.php?file=orgas&action=graph" class="lien"><img src="images/graph.jpg"></a> <A href="main.php?file=orgas&action=email_list" class="menu">R&eacute;cuperer 
      adresses</A><? print($msg_mail); ?></B> 
    </TD>
  </TR>
  <TR class="orgas_top"> 
    <TD colspan="2" nowrap> <B>Liste des orgas</B> </TD>
    <TD align="center" nowrap><B>E-mail</B></TD>
    <TD align="center" nowrap><B>T&eacute;l.</B></TD>
    <TD align="center"> <B>Horaires</B> </TD>
    <TD align="center"> <B>Planning</B> </TD>
    <TD align="center"> <B>Supprimer</B> </TD>
  </TR>
  <?
  
  for ($i=0;$i<count($orgas_array);$i++)
  {
?>
  <TR onMouseOver="this.className='over'" onMouseOut="this.className='orgas'">
<!--  <TR class="orgas"> -->
    <TD width="1%" class="<? 
  for ($j=0;$j<count($categories_array);$j++){
  if($orgas_array[$i]->id_categorie==$categories_array[$j]->id_categorie) print($categories_array[$j]->couleur);
  } ?>">&nbsp;&nbsp;&nbsp;</TD>
    <TD valign="top" nowrap> <A href="main.php?file=orgas&action=modify&id_orga=<? print($orgas_array[$i]->id_orga); ?>" class="lien"><? print($orgas_array[$i]->first_name); ?> 
      <? print($orgas_array[$i]->last_name); ?></A> </TD>
    <TD align="CENTER" valign="top" nowrap> <? print('<a href="mailto:'.$orgas_array[$i]->email.'">'.$orgas_array[$i]->email.'</a>'); ?> 
    </TD>
    <TD align="CENTER" valign="top" nowrap> <? print($orgas_array[$i]->phone_number); ?> 
    </TD>
    <TD align="CENTER" valign="top" nowrap>

<?
    $list_plages=explode("|",$orgas_array[$i]->plages);
	$nb_plages=count($list_plages)-2;
    for ($j=0;$j<$nb_plages;$j++)
	{
	  if ($j!=0) print("<BR>");
	  print(list_to_begin_plage($list_plages[$j+1])." à ".list_to_end_plage($list_plages[$j+1]));
    }
?>

    </TD>
    <TD width="1%" align="center" valign="top"> <A href="main.php?file=plannings&action=edit&id_orga=<? print($orgas_array[$i]->id_orga); ?>" class="lien">[Planning]</A> 
    </TD>
    <TD width="1%" align="center" valign="top"> <A href="javascript:verif(<? print($orgas_array[$i]->id_orga); ?>)" class="lien">[Suppr.]</A> 
    </TD>
  </TR>
  <?
  }
?>
</TABLE>

<FORM name="form_suppr" action="db_action.php?db_action=delete_orga" method="post">
<INPUT name="id_orga" type="hidden">
</FORM>
