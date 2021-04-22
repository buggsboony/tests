<?php

// Fonction permettant de compter le nombre de jours ouvrés entre deux dates
function get_nb_open_days($date_start, $date_stop) {	
	$arr_bank_holidays = array(); // Tableau des jours feriés	
	
	// On boucle dans le cas où l'année de départ serait différente de l'année d'arrivée
	$diff_year = date('Y', $date_stop) - date('Y', $date_start);
	for ($i = 0; $i <= $diff_year; $i++) {			
		$year = (int)date('Y', $date_start) + $i;
		// Liste des jours feriés
		$arr_bank_holidays[] = '1_1_'.$year; // Jour de l'an
		$arr_bank_holidays[] = '1_5_'.$year; // Fete du travail
		$arr_bank_holidays[] = '8_5_'.$year; // Victoire 1945
		$arr_bank_holidays[] = '14_7_'.$year; // Fete nationale
		$arr_bank_holidays[] = '15_8_'.$year; // Assomption
		$arr_bank_holidays[] = '1_11_'.$year; // Toussaint
		$arr_bank_holidays[] = '11_11_'.$year; // Armistice 1918
		$arr_bank_holidays[] = '25_12_'.$year; // Noel
				
		// Récupération de paques. Permet ensuite d'obtenir le jour de l'ascension et celui de la pentecote	
		$easter = easter_date($year);
		$arr_bank_holidays[] = date('j_n_'.$year, $easter + 86400); // Paques
		$arr_bank_holidays[] = date('j_n_'.$year, $easter + (86400*39)); // Ascension
		$arr_bank_holidays[] = date('j_n_'.$year, $easter + (86400*50)); // Pentecote	
	}
	//print_r($arr_bank_holidays);
	$nb_days_open = 0;
	// Mettre <= si on souhaite prendre en compte le dernier jour dans le décompte	
	while ($date_start < $date_stop) {
		// Si le jour suivant n'est ni un dimanche (0) ou un samedi (6), ni un jour férié, on incrémente les jours ouvrés	
		if (!in_array(date('w', $date_start), array(0, 6)) 
		&& !in_array(date('j_n_'.date('Y', $date_start), $date_start), $arr_bank_holidays)) {
			$nb_days_open++;		
		}
		$date_start = mktime(date('H', $date_start), date('i', $date_start), date('s', $date_start), date('m', $date_start), date('d', $date_start) + 1, date('Y', $date_start));			
	}		
	return $nb_days_open;
}



// while ($date_depart < $date_fin) {
//     echo date('j_n_Y', $date_depart).' : ';
//     // Si le jour suivant n'est ni un dimanche (0) ou un samedi (6), ni un jour férié, on incrémente les jours ouvrés

//     if (in_array(date('w', $date_depart) , array(0,6))) {
//         echo "week-end<br>";
//     } elseif(in_array(date('j_n_' . date('Y', $date_depart) , $date_depart) , $arr_bank_holidays)) {
//         echo "férié<br>";
//     } else {
//         echo "ouvré<br>";
//         $nb_days_open++;
//     }
//     $date_depart+= 86400;
// }



//Fonction pratique, mais non utilisé pour la suite
function est_bissextile($annee)
{
    return date("m-d", strtotime("$annee-02-29")) == "02-29";
}
//cal_days_in_month  #Retourner le nombre de jour dans un mois

//nécessite de compiler php avec --enable-calendar ou activer dans php.ini : extension=calendar
// easter_date — Retourne un timestamp UNIX pour Pâques, à minuit pour une année donnée
// easter_days — Retourne le nombre de jours entre le 21 Mars et Pâques, pour une année donnée

////Utilisation:
//https://www.joursouvres.fr/calendrier_joursouvres_2021_4.htm
//Jours ouvrables = working days
//Jour ouvrés = opendays
//countFrenchBusinessDays($year=2021, $month=0) //$month = 1 => Janvier
function countFrenchBusinessDays(int $year, int $month, array $weekdays_off = [6, 7]): int
{
    $holidays = [
        1  => [1],       // jour de l'an
        5  => [1, 8],    // fête du travail et armistice 39-45
        7  => [14],      // fête nationale
        8  => [15],      // Assomption
        11 => [1, 11],   // Toussaint et armistice 14-18
        12 => [25]       // noël
    ];
 
    $easterStart=22; //cétait 21, mais ça renvoie les bonnes valeurs avec 22
    $easter_day                = (new DateTime("{$year}-03-$easterStart"))->modify('+'.easter_days($year, CAL_GREGORIAN).' days');
    $easter_month              = $easter_day->format('n');
    $holidays[$easter_month][] = $easter_day->format('j');

    // echo "easter_month=";var_dump( $easter_month );
    // echo "\neaster_day=";var_dump( $easter_day );
 
    // no business days
    $start = new DateTimeImmutable("{$year}-{$month}-01");
    $end   = $start->modify('first day of next month');
    $days  = new DatePeriod($start, new DateInterval('P1D'), $end);
 
    foreach ($days as $dt) {
        if (in_array($dt->format('N'), $weekdays_off)) {
            $holidays[$month][] = $dt->format('j');
        }
    }
 
    return $start->format('t') - count(array_unique($holidays[$month]));
}



//éclater le mois en jour ouvrés et ouvrables (passage par référence)
function jours_ouvr($year,$month, &$ouvres, &$ouvrables)
{
    $ouvrables =  countFrenchBusinessDays($year,$month);//$month=4 soit Avril renvoie 23 jours
    $total = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
    $ouvres = $total-$ouvrables;    
}//jours_ouvr




$ouvres=-1; $ouvrables=-1;
jours_ouvr($year=2021, $month=4, $ouvres, $ouvrables);

var_dump(
   $ouvres, $ouvrables
);


?>