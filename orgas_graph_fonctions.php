<?php

//fonction pour trouver l'écart de temps entre deux date a et b , t et le temps de ref en quart d'heure 
function index($a,$b,$t)
{ 
	$heure_a=decompose($a,"h");
	$heure_b=decompose($b,"h");
	$jour_a=decompose($a,"jour");
	$jour_b=decompose($b,"jour");

	 //je ne gère pas le changement de mois et d'année, tant pis !!! (à développer plus tard)	 
	 $nb=0;

	 $nb+=(($heure_a-$heure_b)*4/$t);

	 $nb+=(($jour_a-$jour_b)*24*4/$t);

	 return $nb+1;
}
	//récuperation du nombre d'orgas pour chaques plages //initialisation //test //
	//echo("gggg".index($end,$begin,$tranche)."ppp");
	//fonction pour avancer d'une heure 
function temps_suivant($h,$t)
{
	$heure_h=decompose($h,"h");
	$jour_h=decompose($h,"jour");
	$minute_h=decompose($h,"m");
	$annee_h=decompose($h,"annee");
	$mois_h=decompose($h,"mois");
	 //je ne gère pas le changement de mois et d'année, tant pis !!! (à développer plus tard)	 
	$minute_h+=(15*$t);
	
	while($minute_h>46){
		$heure_h++;
		$minute_h-=60;
	}
	while($heure_h>=24){
	$heure_h-=24;
	$jour_h++;
	}
	if($jour_h<10)
		$jour_h="0".(string)(int)$jour_h;
	if($minute_h<10)
		$minute_h="0".$minute_h;
	if($heure_h<10 && $minute_h=="00")
		$heure_h="0".$heure_h;
	return $annee_h."-".$mois_h."-".$jour_h." ".$heure_h.":".$minute_h.":00";
} //import direct de taches_time.php  

?>