<?php
namespace app\controllers;

use app\forms\CalcForm;
use app\transfer\CalcResult;


class CalcCtrl {

	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->kredyt = getFromRequest('kredyt');
		$this->form->lata = getFromRequest('lata');
		$this->form->opr = getFromRequest('opr');
	}
	
	//Walidacja parametrów
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->kredyt ) && isset ( $this->form->lata ) && isset ( $this->form->opr ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false;
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->kredyt == "") {
			getMessages()->addError('Nie podano wielkości kredytu');
		}
		if ($this->form->lata == "") {
			getMessages()->addError('Nie podano liczby lat');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! getMessages()->isError()) {
			
			// sprawdzenie, czy $kredyt i $lata są liczbami całkowitymi
			if (! is_numeric ( $this->form->kredyt )) {
				getMessages()->addError('Wielkość kredytu nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->lata )) {
				getMessages()->addError('Ilość lat nie jest liczbą całkowitą');
			}
		}
		
		return ! getMessages()->isError();
	}
	
	//Pobranie wartości, walidacja, obliczenie i wyświetlenie
	public function process(){

		$this->getParams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
			$this->form->kredyt = intval($this->form->kredyt);
			$this->form->lata = intval($this->form->lata);
			getMessages()->addInfo('Parametry poprawne.');
				
			//wykonanie operacji
			$miesiace = $this->form->lata * 12;
			switch ($this->form->opr) {
				case '5%' :
					$r = 0.05/12;
					$this->result->opr_name = '5%';
					getMessages()->addInfo('Wykonano obliczenia.');
					break;
				case '10%' :
					$r = 0.10/12;
					$this->result->opr_name = '10%';
					getMessages()->addInfo('Wykonano obliczenia.');
					break;
				case '15%' :
					$r = 0.15/12;
					$this->result->opr_name = '15%';
					getMessages()->addInfo('Wykonano obliczenia.');
					break;
				case '20%' :
					$r = 0.20/12;
					$this->result->opr_name = '20%';
					getMessages()->addInfo('Wykonano obliczenia.');
					break;
				default :
					$this->msgs->addInfo('Niepoprawidłowe oprocentowanie');
			}
		}
		
		$this->result->result = round($this->form->kredyt * ($r * pow(1 + $r, $miesiace)) / (pow(1 + $r, $miesiace) - 1), 2);
		$this->generateView();
	}
	
	
	//Wygenerowanie widoku
	public function generateView(){
		//nie trzeba już tworzyć Smarty i przekazywać mu konfiguracji i messages
		
		getSmarty()->assign('page_title','Przykład 05');
		getSmarty()->assign('page_description','Kolejne rozszerzenia dla aplikacja z jednym "punktem wejścia". Do nowej struktury dołożono automatyczne ładowanie klas wykorzystując w strukturze przestrzenie nazw.');
		getSmarty()->assign('page_header','Kontroler główny');
					
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('CalcView.tpl'); // już nie podajemy pełnej ścieżki - foldery widoków są zdefiniowane przy ładowaniu Smarty
	}
}
