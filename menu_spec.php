<?
  $nb_lignes=0;
  $instructions_array=array('- Ajouter','- Voir la liste','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;alphab&eacute;tique','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;heure','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;cat&eacute;gorie','- Editer','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;heures','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;r&egrave;gles');
  $actions_array=array('&action=ajout','&action=liste','&action=alpha','&action=time','&action=cat','&action=edit','&action=rules');

  switch($type)
  {
	case orgas:
      $nb_lignes=4;
      $instructions_array[0]=$instructions_array[0]." un orga";
      $instructions_array[1]=$instructions_array[1]." des orgas par ordre";
      break;
    case vehicules:
      $nb_lignes=4;
      $instructions_array[0]=$instructions_array[0]." un v&eacute;hicule";
      $instructions_array[1]=$instructions_array[1]." des v&eacute;hicules par ordre";
      break;
    case lieux:
      $nb_lignes=4;
      $instructions_array[0]=$instructions_array[0]." un lieu";
      $instructions_array[1]=$instructions_array[1]." des lieux par ordre";
      break;
    case talkies:
      $nb_lignes=4;
      $instructions_array[0]=$instructions_array[0]." un talkie";
      $instructions_array[1]=$instructions_array[1]." des talkies par ordre";
      break;
    case categories:
      $nb_lignes=3;
      $instructions_array[0]=$instructions_array[0]." une cat&eacute;gorie";
      $instructions_array[1]=$instructions_array[1]." des cat&eacute;gories par ordre";
      break;
    case taches:
      $nb_lignes=5;
      $instructions_array[0]=$instructions_array[0]." une t&acirc;che";
      $instructions_array[1]=$instructions_array[1]." des t&acirc;ches par ordre";
      break;
    case plannings:
      $nb_lignes=4;
      $instructions_array[1]=$instructions_array[1]." des plannings orgas par ordre";
      break;
    case equipes:
      $nb_lignes=4;
      $instructions_array[0]=$instructions_array[0]." une &eacute;quipe";
      $instructions_array[1]=$instructions_array[1]." des &eacute;quipes par ordre";
      break;
    case activites:
      $nb_lignes=4;
      $instructions_array[0]=$instructions_array[0]." une activit&eacute;";
      $instructions_array[1]=$instructions_array[1]." des activit&eacute;s par ordre";
      break;
    case plannings_eq:
      $nb_lignes=7;
      $instructions_array[0]="- D&eacute;finir";
      $actions_array[0]="&action=define";
      $instructions_array[1]=$instructions_array[1]." des plannings &eacute;quipes par ordre";
      $instructions_array[4]=$instructions_array[5];
      $instructions_array[5]=$instructions_array[6];
      $instructions_array[6]=$instructions_array[7];
      break;
    case users:
      $nb_lignes=3;
      $instructions_array[0]=$instructions_array[0]." un utilisateur";
      $instructions_array[1]=$instructions_array[1]." des utilisateurs par ordre";
      break;
  }
?>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="<? print($type."_top"); ?>">
    <TD colspan="3">
      Tu peux
    </TD>
  </TR>

<?
  $i=0;
  for ($i;$i<$nb_lignes;$i++)
  {
?>

  <TR CLASS="<? print($type); ?>">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      <? print($instructions_array[$i]); ?>
    </TD>
    <TD WIDTH="1%">
      
<?
    if ($i!=1)
    {
?>

      <A HREF="main.php?file=<? print($type.$actions_array[$i]); ?>" CLASS="menu">Go</A>

<?
    }
?>

    </TD>
  </TR>

<?
  }
?>

</TABLE>
