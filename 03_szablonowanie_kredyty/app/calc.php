<?php
require_once dirname(__FILE__).'/../config.php';
require_once _ROOT_PATH.'/lib/smarty/libs/Smarty.class.php';

// Pobranie parametrów z formularza
function getParams(&$form){
    $form['kredyt'] = isset($_REQUEST['kredyt']) ? $_REQUEST['kredyt'] : null;
    $form['lata'] = isset($_REQUEST['lata']) ? $_REQUEST['lata'] : null;
    $form['oprocentowanie'] = isset($_REQUEST['oprocentowanie']) ? $_REQUEST['oprocentowanie'] : null;
}

// Walidacja parametrów
function validate(&$form, &$infos, &$msgs){
    
    // sprawdzenie, czy pola istnieją
    if (!isset($form['kredyt'], $form['lata'], $form['oprocentowanie'])) {
        $msgs[] = 'Błędne wywołanie aplikacji - brak danych.';
        return false;
    }

    // sprawdzenie pustych wartości
    if ($form['kredyt'] === "") $msgs[] = 'Nie podano kwoty kredytu.';
    if ($form['lata'] === "") $msgs[] = 'Nie podano liczby lat.';

    // walidacja typów danych
    if (empty($msgs)) {
        if (!is_numeric($form['kredyt'])) $msgs[] = 'Kwota kredytu musi być liczbą.';
        if (!is_numeric($form['lata'])) $msgs[] = 'Liczba lat musi być liczbą.';
    }

    return empty($msgs);
}

// Obliczenie raty kredytu (annuitet)
function process(&$form, &$infos, &$msgs, &$rata){
    
    $infos[] = 'Parametry poprawne. Wykonuję obliczenia.';

    // konwersje typów
    $kwota = floatval($form['kredyt']);
    $lata = intval($form['lata']);
    $miesiecy = $lata * 12;

    // konwersja oprocentowania
    switch ($form['oprocentowanie']) {
        case '5%':  $r = 0.05/12; break;
        case '10%': $r = 0.10/12; break;
        case '15%': $r = 0.15/12; break;
        case '20%': $r = 0.20/12; break;
        default:
            $msgs[] = "Nieprawidłowe oprocentowanie.";
            return;
    }

    // wzór na ratę
    $rata = $kwota * ($r * pow(1 + $r, $miesiecy)) / (pow(1 + $r, $miesiecy) - 1);
}

$form = [];
$infos = [];
$messages = [];
$rata = null;

getParams($form);
if (validate($form, $infos, $messages)) {
    process($form, $infos, $messages, $rata);
}

// Smarty
$smarty = new Smarty\Smarty();
$smarty->assign('app_url', _APP_URL);
$smarty->assign('root_path', _ROOT_PATH);
$smarty->assign('page_title', 'Kalkulator kredytowy');
$smarty->assign('page_description', 'Kalkulator kredytowy oparty na Smarty');
$smarty->assign('page_header', 'Kalkulator kredytowy');

$smarty->assign('form', $form);
$smarty->assign('messages', $messages);
$smarty->assign('infos', $infos);
$smarty->assign('rata', $rata);

$smarty->display(_ROOT_PATH.'/app/calc.html');
