<?php
//Tu już nie ładujemy konfiguracji - sam widok nie będzie już punktem wejścia do aplikacji.
//Wszystkie żądania idą do kontrolera, a kontroler wywołuje skrypt widoku.
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Kalkulator kredytowy</title>
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
</div>

<div style="width:90%; margin: 2em auto;">

<form action="<?php print(_APP_ROOT); ?>/app/calc.php" method="post" class="pure-form pure-form-stacked">
	<legend>Kalkulator kredytowy</legend>
	<fieldset>
		<label for="id_x">Jak duzy kredyt chcesz wziąć? </label>
	<input id="id_x" type="text" name="x" value="<?php isset($x)?print($x):print(""); ?>" /><br />
		<label for="id_op">Oprocentowanie: </label>
		<select name="op">
			<option value="5%">5%</option>
			<option value="10%">10%</option>
			<option value="15%">15%</option>
			<option value="20%">20%</option>
		</select><br />
		<label for="id_y">Ile lat chcesz spłacać kredyt: </label>
	<input id="id_y" type="text" name="y" value="<?php isset($y)?print($y):print("") ?>" /><br />
	</fieldset>	
	<input type="submit" value="Oblicz" class="pure-button pure-button-primary" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #f88; width:25em;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($rata)){ ?>
<div style="margin-top: 1em; padding: 1em; border-radius: 0.5em; background-color: rgba(0, 190, 0, 1); width:25em;">
<?php echo 'Twoja rata będzie wynosić: '.number_format($rata, 2, '.', ' '); ?>
</div>
<?php } ?>

</div>

</body>
</html>