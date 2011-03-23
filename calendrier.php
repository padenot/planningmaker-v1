<SCRIPT LANGUAGE="JavaScript">
/*SCRIPT TROUVE SUR L'EDITEUR JAVASCRIPT
http://www.editeurjavascript.com*/
/******************************************************** CALENDRIER GREGORIEN PERPETUEL v1.0 ** par SKAMP (skamp@befrance.com) (09/09/2000) ********************************************************** Ce script permet de choisir un mois et une annee en ** particulier, afin d'afficher dynamiquement le ** calendrier correspondant. Par defaut c'est celui du ** mois courant qui s'affiche. Note : la 1ere semaine ** de l'annee commence le 1er lundi. ** ** Le code suivant s'inspire de celui de Jean-Michel ** Berthier (berth@cybercable.fr, ** perso.cybercable.fr/berth/jstips/calendrier.htm). ** ** MODIFICATIONS NECESSAIRES POUR PORTAGE VERS D'AUTRES ** NAVIGATEURS : N'A ETE TESTE QUE SOUS MICROSOFT ** INTERNET EXPLORER 5.00.2614.3500 ********************************************************/
var HTMLCode = "";
var DaysList = new Array("Jour_Vide", "L", "M", "Me", "J", "V", "S", "D");
var MonthsList = new Array("Mois_Vide", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
var MonthLength = new Array("Mois_longueur_vide",31,29,31,30,31,30,31,31,30,31,30,31);
var Today = new Date();
//var TodaysYear = Today.getYear();
var TodaysYear = <? print(substr($global_begin_date,0,4)); ?>;
//var TodaysMonth = Today.getMonth() + 1;
var TodaysMonth = <? print(substr($global_begin_date,5,2)); ?>;
var TodaysDate = Today.getDate();
//var TodaysDay = Today.getDay() + 1;
var TodaysDay = <? print(substr($global_begin_date,8,2)); ?>;
if (TodaysYear < 2000) { TodaysYear += 1900; }
var QueryDate = TodaysDate;	
/* Jour demande (date)*/
var QueryMonth = TodaysMonth;	
/* Mois demande*/
var QueryYear = TodaysYear;	
/* Annee demandee*/
var QueryDay = 0;	
/* Jour de la semaine du jour demande, inconnu*/
var FirstDay = 0;	
/* Jour de la semaine du 1er jour du mois*/
var WeekRef = 0;	
/* Numerotation des semaines*/
var WeekOne = 0;	
/* Numerotation des semaines*/
function nextMonth(){  
QueryDate = TodaysDate;  
if (QueryDate<10)  QueryDate = "0"+QueryDate;  
QueryMonth = document.Cal.currentMonth.value;  
QueryMonth++;  
QueryYear = document.Cal.currentYear.value;  
if (QueryMonth>12)  {    
QueryMonth=1;	
QueryYear++;  
}  
document.Cal.currentMonth.value = QueryMonth;  
document.Cal.currentYear.value = QueryYear;  
MonthLength[2] = CheckLeap(QueryYear);  
DisplaySchedule();
}

function prevMonth(){  
QueryDate = TodaysDate;  
if (QueryDate<10)  
QueryDate = "0"+QueryDate;  
QueryMonth = document.Cal.currentMonth.value;  
QueryMonth--;  
QueryYear = document.Cal.currentYear.value;  
if (QueryMonth<1)  {    
QueryMonth=12;	
QueryYear--;  
}  
document.Cal.currentMonth.value = QueryMonth;  
document.Cal.currentYear.value = QueryYear;  
MonthLength[2] = CheckLeap(QueryYear);  
DisplaySchedule();
}

/* Teste une annee pour determiner si elle est bissextile ou pas*/
function CheckLeap(yy){  
if ((yy % 100 != 0 && yy % 4 == 0) || (yy % 400 == 0)) return 29;  
else return 28;
}

/* Renvoie le numero de la semaine correspondant a la date requise*/
function DefWeekNum(dd){  
numd = 0;  
numw = 0;  
for (n=1; n<QueryMonth; n++)  {    
numd += MonthLength[n];  
}  
numd = numd + dd - (9 - DefDateDay(QueryYear,1,1));  
numw = Math.floor(numd / 7) + 1;  
if (DefDateDay(QueryYear,1,1) == 1) numw++;  
return numw;
}

/* Renvoie le numero du jour de la semaine correspondant a la date requise */
function DefDateDay(yy,mm,dd){  
return Math.floor((Date2Days(yy,mm,dd)-2) % 7) + 1;
}

/* Transforme la date en nb de jours theoriques */
function Date2Days(yy,mm,dd){  
if (mm > 2)  {    
var bis = Math.floor(yy/4) - Math.floor(yy/100) + Math.floor(yy/400);    
var zy = Math.floor(yy * 365 + bis);    
var zm = (mm-1) * 31 - Math.floor(mm * 0.4 + 2.3);    
return (zy + zm + dd);  
}  else  {    
var bis = Math.floor((yy-1)/4) - Math.floor((yy-1)/100) + Math.floor((yy-1)/400);    
var zy = Math.floor(yy * 365 + bis);    
return (zy + (mm-1) * 31 + dd);  
}
}

/* Produit le code HTML qui formera le calendrier */
function DisplaySchedule(){  
HTMLCode = "<table cellspacing=0 cellpadding=1 border=1 bordercolor=#000033>";  
QueryDay = DefDateDay(QueryYear,QueryMonth,QueryDate);  
WeekRef = DefWeekNum(QueryDate);  
WeekOne = DefWeekNum(1);  
HTMLCode += "<tr align=center><td colspan=6>&nbsp;</td><td class=\"cal\"><A href=\"javascript:CloseSchedule()\" class=\"cal\">X</A></td>";  
HTMLCode += "<tr align=center><td colspan=7 class=\"cal\"><INPUT type=\"button\" value=\"<-\" onClick=\"prevMonth()\">&nbsp;&nbsp;&nbsp;<b>" + MonthsList[QueryMonth] + " " + QueryYear + "</b>&nbsp;&nbsp;&nbsp;<INPUT type=\"button\" value=\"->\" onClick=\"nextMonth()\"></td></tr><tr align=center>";  
for (s=1; s<8; s++)  {    
if (QueryDay == s) HTMLCode += "<td class=\"cal\"><b><font color=#ff0000>" + DaysList[s] + "</font></b></td>";    
else HTMLCode += "<td class=\"cal\"><b>" + DaysList[s] + "</b></td>";  
}  
HTMLCode += "</tr>";  
for (i=(1-DefDateDay(QueryYear,QueryMonth,1)); i<MonthLength[QueryMonth]; i++)  {    
HTMLCode += "<tr align=center>";    
for (j=1; j<8; j++)    
{      
if ((i+j) <= 0) HTMLCode += "<td>&nbsp;</td>";      
else if ((i+j) == QueryDate) HTMLCode += "<td class=\"cal\"><b><font color=#ff0000>" + (i+j) + "</font></b></td>";      
else if ((i+j) > MonthLength[QueryMonth]) HTMLCode += "<td class=\"cal\">&nbsp;</td>";      
else HTMLCode += "<td class=\"cal\">" + (i+j) + "</td>";    
}    
HTMLCode += "</tr>";    
i = i + 6;  
}  
Calendrier.innerHTML = HTMLCode + "</table>";  
Lien.innerHTML = "";
}

function texteLien(texte){  
if (texte=="affiche") Lien.innerHTML = "<A href=\"javascript:DisplaySchedule()\" class=\"menu2\">Calendrier</A>";
}

function CloseSchedule(){  
Calendrier.innerHTML = "";  
Lien.innerHTML = "<A href=\"javascript:DisplaySchedule()\" class=\"menu2\">Calendrier</A>";
}
</SCRIPT>
<STYLE type="text/css">
<!--
INPUT.cal { font-family : Verdana; font-size : 6px; color : #000033; }
TD.cal { font-family : Verdana; font-size : 9px; color : #000033; }
A.cal { font-size: 9; font-family: "Verdana"; color: "#000033"; text-decoration: none; font-weight: none }
A.cal:hover { font-size: 9; font-family: "Verdana"; color: "#000033"; text-decoration: none; font-weight: none }
-->
</STYLE>
<form name="Cal">
<script language="JavaScript1.2" type="text/javascript">
document.write("<input type=\"hidden\" value=\""+TodaysMonth+"\" name=\"currentMonth\" class=\"cal\">");
document.write("<input type=\"hidden\" value=\""+TodaysYear+"\" name=\"currentYear\" class=\"cal\">");
</script>
<div id="Lien">
</div>
<SCRIPT language="JavaScript">texteLien('affiche')</SCRIPT>
<div id="Calendrier"></div>
</form>