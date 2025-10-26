<?php
require_once dirname(__FILE__).'/../config.php';

// KONTROLER strony kalkulatora

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

//pobranie parametrów
function getParams(&$kredyt,&$lata,&$oprocentowanie){
	$kredyt = isset($_REQUEST['x']) ? $_REQUEST['x'] : null;
	$lata = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
	$oprocentowanie = isset($_REQUEST['op']) ? $_REQUEST['op'] : null;	
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$kredyt,&$lata,&$oprocentowanie,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($kredyt) && isset($lata) && isset($oprocentowanie))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $kredyt == "") {
		$messages [] = 'Nie podano wielkości kredytu';
	}
	if ( $lata == "") {
		$messages [] = 'Nie podano liczby lat';
	}

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $kredyt i $lata są liczbami całkowitymi
	if (! is_numeric( $kredyt )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $lata )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}	

	if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$kredyt,&$lata,&$oprocentowanie,&$messages,&$rata){
	global $role;
	
	//konwersja parametrów na int
	$kredyt = intval($kredyt);
	$lata = intval($lata);
	
	//wykonanie operacji
	switch ($oprocentowanie) {
		case '5%' :
			if ($role == 'admin'){
				$r = ((5/100) / 12); //miesieczne oprocentowanie
				$rata = $kredyt * ($r * pow(1 + $r, $lata)) / (pow(1 + $r, $lata) - 1);
			} else {
				$messages [] = 'Tylko administrator może dawać tak niskie oprocentowanie!';
			}
			break;
		case '10%' :
			$r = ((10/100) / 12); 
			$rata = $kredyt * ($r * pow(1 + $r, $lata)) / (pow(1 + $r, $lata) - 1);
			break;
		case '15%' :
			$r = ((15/100) / 12); 
			$rata = $kredyt * ($r * pow(1 + $r, $lata)) / (pow(1 + $r, $lata) - 1);
			break;
		case '20%' :
			if ($role == 'admin'){
				$r = ((20/100) / 12);
				$rata = $kredyt * ($r * pow(1 + $r, $lata)) / (pow(1 + $r, $lata) - 1);
			} else {
				$messages [] = 'Tylko administrator może dawać tak wysokie oprocentowanie!';
			}
			break;		
		default :
			$rata = "nie stać cię";
			break;
	}
}

//definicja zmiennych kontrolera
$kredyt = null;
$lata = null;
$oprocentowanie = null;
$rata = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($kredyt,$lata,$oprocentowanie);
if ( validate($kredyt,$lata,$oprocentowanie,$messages) ) { // gdy brak błędów
	process($kredyt,$lata,$oprocentowanie,$messages,$rata);
}

// Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$kredyt,$lata,$oprocentowanie,$rata)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';