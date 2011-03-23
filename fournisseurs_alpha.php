<?
  $req_sql="SELECT * FROM fournisseurs ORDER BY name";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="JavaScript">
function verif(id)
{
  if (confirm('Es-tu sûr de vouloir supprimer ce fournisseur ?'))
  {
    document.form_suppr.id_fournisseur.value=id;
	document.form_suppr.submit();
  }
}

</SCRIPT>



<TABLE width="1%" cellspacing="0" cellpadding="3">
  <TR>
    <TD colspan="9"><B><A href="<? print($file."_print.php"); ?>" target="_blank" class="menu"><img src="images/print.jpg"></A></B> &nbsp;</TD>
  </TR>
  
  <TR class="orgas_top"> 
    <TD colspan="2" nowrap> <B>Liste des fournisseurs</B> </TD>
	<TD align="center"> <B>Nom du contact</B> </TD>
	<TD align="center" nowrap><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Commentaire&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></TD>
    <TD align="center" nowrap><B>E-mail</B></TD>
    <TD align="center" nowrap><B>Adresse</B></TD>
    <TD align="center" nowrap><B>T&eacute;l.</B></TD>
	<TD align="center" nowrap><B>Fax.</B></TD>
    
	<td align="center"> <b>voir l'&eacute;tat des commandes</b></td>
    <TD align="center"> <B>Supprimer</B> </TD>
  </TR>
  <?
  $fournisseurs_array=result_fournisseurs($req);
  for ($i=0;$i<count($fournisseurs_array);$i++)
  {
?>
  <TR class="orgas" onMouseOver="this.className='over'" onMouseOut="this.className='orgas'">
<!--  <TR class="orgas"> -->
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD valign="top" nowrap> <A href="main.php?file=fournisseurs&action=modify&id_fournisseur=<? print($fournisseurs_array[$i]->id_fournisseur); ?>" class="lien"><? print($fournisseurs_array[$i]->name); ?> 
    </A> </TD>
    <TD align="CENTER" valign="top" nowrap> <? print($fournisseurs_array[$i]->contact);?>
    </TD>
	<TD align="CENTER" valign="top" > <? print($fournisseurs_array[$i]->commentaire);?>
    </TD>
	<TD align="CENTER" valign="top" nowrap> <? print($fournisseurs_array[$i]->email); ?> 
    </TD>
    <TD align="CENTER" valign="top" nowrap> <? print($fournisseurs_array[$i]->mail_adress); ?> 
    </TD>
    <TD align="CENTER" valign="top" nowrap> <? print($fournisseurs_array[$i]->phone_number); ?> 
    </TD>
	<TD align="CENTER" valign="top" nowrap> <? print($fournisseurs_array[$i]->fax_number); ?> 
    </TD>
	<TD width="1%" align="center" valign="top"> <A href="main.php?file=materiels&action=fourniss&id_fournisseur=<? print($fournisseurs_array[$i]->id_fournisseur); ?>" class="lien">Go</A> 
    </TD>
    <TD width="1%" align="center" valign="top"><? if ($session_user_type!="soft") {?> <A href="javascript:verif(<? print($fournisseurs_array[$i]->id_fournisseur); ?>)" class="lien">Go</A> <? } ?>
    </TD>
  </TR>
  <?
  }
?>
</TABLE>

<FORM name="form_suppr" action="db_action.php?db_action=delete_fournisseur" method="post">
<INPUT name="id_fournisseur" type="hidden">
</FORM>
