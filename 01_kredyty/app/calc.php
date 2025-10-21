<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// 1. pobranie parametrów

$x = $_REQUEST ['x'];
$y = $_REQUEST ['y'];
$operation = $_REQUEST ['op'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($x) && isset($y) && isset($operation))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $x == "") {
	$messages [] = 'Nie podano wielkości kredytu';
}
if ( $y == "") {
	$messages [] = 'Nie podano liczby lat';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $x )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $y )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}	

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$x = intval($x);
	$y = intval($y);
	
	//wykonanie operacji
	switch ($operation) {
		case '5%' :
			$r = ((5/100) / 12); //miesieczne oprocentowanie
			$result = $x * ($r * pow(1 + $r, $y)) / (pow(1 + $r, $y) - 1);
			break;
		case '10%' :
			$r = ((10/100) / 12);
			$result = $x * ($r * pow(1 + $r, $y)) / (pow(1 + $r, $y) - 1);
			break;
		case '15%' :
			$r = ((15/100) / 12);
			$result = $x * ($r * pow(1 + $r, $y)) / (pow(1 + $r, $y) - 1);
			break;
		case '20%' :
			$r = ((20/100) / 12);
			$result = $x * ($r * pow(1 + $r, $y)) / (pow(1 + $r, $y) - 1);
			break;
		default :
			$result = "nie stać cię";
			break;
	}
}

// 4. Wywołanie widoku z przekazaniem zmiennych
include 'calc_view.php';