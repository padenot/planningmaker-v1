<?
  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);

  $min_time="";
  $max_time="";
  $req_sql="SELECT MIN(`current_time`) FROM plannings";
  $req = mysql_query($req_sql);
  while ($data = mysql_fetch_array($req))
  {
    $min_time=$data['MIN(`current_time`)'];
  }
  $req_sql="SELECT MAX(`current_time`) FROM plannings";
  $req = mysql_query($req_sql);
  while ($data = mysql_fetch_array($req))
  {
    $max_time=$data['MAX(`current_time`)'];
  }
  if ($min_time == "") $min_time = $global_begin_date.":00";
  if ($max_time == "") $max_time = $global_end_date.":00";

  $min_time=substr($min_time,0,10)." 00:00";
  $max_time=substr($max_time,0,10)." 00:00";
?>

<SCRIPT language="JavaScript">
function envoi()
{
  ok=1;
  id_orga=document.form.id_orga.value;
  for (i=0;i<document.form.list_id_orga.length;i++)
  {
    if (eval("document.form.list_id_orga["+i+"].selected")) id_orga=id_orga+eval("document.form.list_id_orga["+i+"].value")+"|";
  }
  document.form.id_orga.value=id_orga;
  
  min_time="";
  max_time="";
  for (i=0;i<document.form.list_days.length;i++)
  {
    if (eval("document.form.list_days["+i+"].selected"))
	{
	  if (min_time=="") min_time=eval("document.form.list_days["+i+"].value");
	  max_time=eval("document.form.list_days["+i+"].value");
	}
  }
  document.form.min_time.value=min_time;
  document.form.max_time.value=max_time;
  
  if (id_orga=="|")
  {
    ok=0;
    alert("Tu dois au moins choisir un orga");
  }
  if ((min_time=="") && (max_time==""))
  {
    ok=0;
    alert("Tu dois une plage de jours");
  }
  if (ok==1) document.form.submit();
}
</SCRIPT>

<TABLE width="1%" cellspacing="0" cellpadding="3">
  <FORM method="POST" name="form" action="main.php?file=make_pdf">
    <TR> 
      <TD colspan="2">&nbsp;</TD>
    </TR>
    <TR class="plannings_top"> 
      <TD colspan="2" nowrap> <B>Impression des plannings</B></TD>
    </TR>
    <TR class="plannings_top"> 
      <TD colspan="2">&nbsp;</TD>
    </TR>
    <TR class="plannings_top"> 
      <TD colspan="2" nowrap>Choisis un ou des orgas...</TD>
    </TR>
    <TR class="plannings"> 
      <TD width="1%"> 
        <SELECT name="list_id_orga" size="10" multiple>
          <?
  $orgas_array=result_orgas($req_orgas);
  for ($i=0;$i<count($orgas_array);$i++)
  {
?>
          <OPTION value="<? print($orgas_array[$i]->id_orga); ?>"><? print($orgas_array[$i]->first_name." ".$orgas_array[$i]->last_name); ?></OPTION>
          <?
  }
?>
        </SELECT>
      </TD><td>
	  format de la page <select name="format"><option value="a4">a4 paysage</option><option value="a3">a3 portrait</option></select>
	  <br><br><br>
	  limiter le nombre d'orga affiché dans l'emplacement "avec qui tu bosses" (0 = voir tout) <input width="30px" name="nbr_orga" type="text" value="0">
	  <br><br><br>
	  
	  </td>
    </TR>
    <TR class="plannings"> 
      <TD colspan="2">... et choisis une plage de jours</TD>
    </TR>
    <TR class="plannings"> 
      <TD>
        <SELECT name="list_days" size="4" multiple>

<?
  for ($i=date_en_to_number($min_time);$i<=date_en_to_number($max_time);$i=$i+10000)
  {
?>

          <OPTION value="<? print($i); ?>"><? print(substr(date_number_to_fr($i),0,10)); ?></OPTION>

<?
  }
?>

        </SELECT>
      </TD>
    </TR>
    <TR class="plannings"> 
      <TD colspan="2">&nbsp;</TD>
    </TR>
    <TR class="plannings"> 
      <TD colspan="2" align="center"> 
        <INPUT type="hidden" value="|" name="id_orga">
        <INPUT type="hidden" value="" name="min_time">
        <INPUT type="hidden" value="" name="max_time">
        <INPUT type="button" value="Envoyer" onClick="envoi()">
      </TD>
    </TR>
    <TR class="plannings"> 
      <TD colspan="2" align="center">&nbsp;</TD>
    </TR>
    </FORM>
</TABLE>
