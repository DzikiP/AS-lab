<?php
require_once dirname(__FILE__).'/../config.php';
require_once _ROOT_PATH.'/lib/smarty/libs/Smarty.class.php';

// Pobranie parametrów
function getParams(&$form){
    $form['kredyt'] = isset($_REQUEST['kredyt']) ? $_REQUEST['kredyt'] : null;
    $form['lata'] = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
    $form['oprocentowanie'] = isset($_REQUEST['op']) ? $_REQUEST['op'] : null;
}

// Walidacja
function validate(&$form, &$infos, &$msgs){
    if (!isset($form['kredyt'], $form['lata'], $form['oprocentowanie'])) {
        $msgs[] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
        return false;
    }

    if ($form['kredyt'] === "") $msgs[] = 'Nie podano wielkości kredytu';
    if ($form['lata'] === "") $msgs[] = 'Nie podano liczby lat';

    if (empty($msgs)) {
        if (!is_numeric($form['kredyt'])) $msgs[] = 'Wielkość kredytu nie jest liczbą';
        if (!is_numeric($form['lata'])) $msgs[] = 'Liczba lat nie jest liczbą';
    }

    return empty($msgs);
}

// Obliczenia
function process(&$form, &$infos, &$msgs, &$result){
    $infos[] = 'Parametry poprawne. Wykonuję obliczenia.';

    $form['kredyt'] = floatval($form['kredyt']);
    $form['lata'] = intval($form['lata']);

    switch ($form['oprocentowanie']) {
        case '5%': $r = 0.05/12; break;
        case '10%': $r = 0.10/12; break;
        case '15%': $r = 0.15/12; break;
        case '20%': $r = 0.20/12; break;
        default: $msgs[] = "Nieprawidłowe oprocentowanie"; return;
    }

    $result = $form['kredyt'] * ($r * pow(1+$r,$form['lata'])) / (pow(1+$r,$form['lata'])-1);
}

// Inicjacja zmiennych
$form = [];
$infos = [];
$messages = [];
$result = null;
$hide_intro = false;

getParams($form);
if (validate($form,$infos,$messages)){
    process($form,$infos,$messages,$result);
}

// Smarty
$smarty = new Smarty\Smarty();
$smarty->assign('app_url', _APP_URL);
$smarty->assign('root_path', _ROOT_PATH);
$smarty->assign('page_title', 'Kalkulator kredytowy');
$smarty->assign('page_description', 'Kalkulator kredytowy oparty na Smarty');
$smarty->assign('page_header', 'Kalkulator kredytowy');
$smarty->assign('hide_intro', $hide_intro);

$smarty->assign('form', $form);
$smarty->assign('messages', $messages);
$smarty->assign('infos', $infos);
$smarty->assign('result', $result);

$smarty->display(_ROOT_PATH.'/app/calc.html');
