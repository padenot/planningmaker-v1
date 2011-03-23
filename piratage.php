<CENTER>
<TABLE cellspacing="0" cellpadding="3">
  <TR>
    <TD>&nbsp;</TD>
  </TR>
  <TR>
      <TD> <FONT color="#FF0000"><B>Tu as essay&eacute; de pirater le site !!! 
        <BR>
        C'est pas bien, mais comme on a r&eacute;cup&eacute;r&eacute; ton IP, 
        on sera plusieurs &agrave; jouer...</B></FONT> </TD>
  </TR>
</TABLE>
</CENTER>

<?
  $client_ip=$_SERVER['HTTP_PC_REMOTE_ADDR'];
  $client_name=gethostbyaddr($client_ip);
  $client_page=$_SERVER['REQUEST_URI'];
  $filename="./../../log/planning.txt";

  if ($fp = fopen($filename,"r"))
  {
    $contents = fread($fp, filesize ($filename));
    fclose($fp);
  }

  $list_ip=explode("\r\n",$contents);
  $result="";
  $found=false;
  for ($i=0;$i<count($list_ip);$i++)
  {
	$caract_ip=explode("|",$list_ip[$i]);
	if ($caract_ip[1]==$client_ip)
	{
	  $caract_ip[0]++;
	  $result=$result.$caract_ip[0]."|".$caract_ip[1]."|".$caract_ip[2]."|".date('d-m-Y H:i')."|".$caract_ip[4].", ".$client_page."\r\n";
	  $found=true;
	}
	else if ($list_ip[$i]!="") $result=$result.$list_ip[$i]."\r\n";
  }
  if (!$found) $result=$result."1|".$client_ip."|".$client_name."|".date('d-m-Y H:i')."|".$client_page."\r\n";

  $fp = fopen($filename,"w");
  fputs($fp,$result);
  fclose($fp);
?>