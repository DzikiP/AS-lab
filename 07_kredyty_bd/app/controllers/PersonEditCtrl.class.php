<?php

namespace app\controllers;

use app\forms\PersonEditForm;
use PDOException;

class PersonEditCtrl {

	private $form;

	public function __construct(){
		$this->form = new PersonEditForm();
	}

	// Walidacja danych przed zapisem
	public function validateSave() {

		$this->form->id = getFromRequest('id');
		$this->form->name = getFromRequest('name');
		$this->form->kredyt = getFromRequest('kredyt');
		$this->form->opr = getFromRequest('opr');
		$this->form->lata = getFromRequest('lata');

		// Sprawdzenie, czy wartości zostały przekazane
		if (!isset($this->form->kredyt) || !isset($this->form->opr) || !isset($this->form->lata)) {
			return false; // formularz nie został poprawnie wysłany
		}

		// Sprawdzenie wartości wymaganych
		if (empty(trim($this->form->name))) {
			getMessages()->addError('Nie podano imienia');
		}
		if ($this->form->kredyt === "") {
			getMessages()->addError('Nie podano wielkości kredytu');
		}
		if ($this->form->lata === "") {
			getMessages()->addError('Nie podano liczby lat');
		}
		if ($this->form->opr === "") {
			getMessages()->addError('Nie podano oprocentowania');
		}

		// Walidacja typów i wartości liczbowych
		if (!getMessages()->isError()) {
			if (!is_numeric($this->form->kredyt) || $this->form->kredyt <= 0) {
				getMessages()->addError('Wielkość kredytu musi być liczbą większą od 0');
			}
			if (!is_numeric($this->form->lata) || $this->form->lata <= 0) {
				getMessages()->addError('Ilość lat musi być liczbą całkowitą większą od 0');
			}
			if (!is_numeric($this->form->opr) || $this->form->opr <= 0) {
				getMessages()->addError('Oprocentowanie musi być większe od 0');
			}
		}

		return !getMessages()->isError();
	}


	// Walidacja danych do edycji
	public function validateEdit() {
		$this->form->id = getFromRequest('id', true, 'Błędne wywołanie aplikacji');
		return !getMessages()->isError();
	}

	public function action_personNew(){
		$this->generateView();
	}

	public function action_personEdit(){
		if ($this->validateEdit()){
			try {
				$record = getDB()->get("person", "*", [
					"idperson" => $this->form->id
				]);
				$this->form->id = $record['idperson'];
				$this->form->name = $record['name'];
				$this->form->kredyt = $record['kredyt'];
				$this->form->opr = $record['opr'];
				$this->form->lata = $record['lata'];
				$this->form->rata = $record['rata'];
			} catch (PDOException $e){
				getMessages()->addError('Błąd podczas odczytu rekordu');
				if (getConf()->debug) getMessages()->addError($e->getMessage());
			}
		}
		$this->generateView();
	}

	public function action_personDelete(){
		if ($this->validateEdit()){
			try {
				getDB()->delete("person", [
					"idperson" => $this->form->id
				]);
				getMessages()->addInfo('Pomyślnie usunięto rekord');
			} catch (PDOException $e){
				getMessages()->addError('Błąd podczas usuwania rekordu');
				if (getConf()->debug) getMessages()->addError($e->getMessage());
			}
		}
		forwardTo('personList');
	}

	public function action_personSave(){

		if ($this->validateSave()) {

			// Obliczenie raty miesięcznej
			$P = $this->form->kredyt;
			$r = $this->form->opr / 100 / 12;
			$n = $this->form->lata * 12;

			$this->form->rata = round($P * ($r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1), 2);

			try {
				if ($this->form->id == '') {
					getDB()->insert("person", [
						"name" => $this->form->name,
						"kredyt" => $this->form->kredyt,
						"opr" => $this->form->opr,
						"lata" => $this->form->lata,
						"rata" => $this->form->rata
					]);
				} else {
					getDB()->update("person", [
						"name" => $this->form->name,
						"kredyt" => $this->form->kredyt,
						"opr" => $this->form->opr,
						"lata" => $this->form->lata,
						"rata" => $this->form->rata
					], [
						"idperson" => $this->form->id
					]);
				}

				getMessages()->addInfo('Pomyślnie zapisano rekord');

			} catch (PDOException $e){
				getMessages()->addError('Nieoczekiwany błąd podczas zapisu');
				if (getConf()->debug) getMessages()->addError($e->getMessage());
			}

			forwardTo('personList');

		} else {
			$this->generateView();
		}
	}

	public function generateView(){
		getSmarty()->assign('form', $this->form);
		getSmarty()->display('PersonEdit.tpl');
	}
}
