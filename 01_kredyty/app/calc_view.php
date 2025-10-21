<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
</head>
<body>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
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
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: rgba(0, 190, 0, 1); width:300px;">
<?php echo 'Twoja miesięczna rata będzie wynosić: '.$result; ?>
</div>
<?php } ?>

</body>
</html>