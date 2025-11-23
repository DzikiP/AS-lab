<?php
require_once $conf->root_path.'/lib/smarty/libs/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/CalcForm.class.php';
require_once $conf->root_path.'/app/CalcResult.class.php';

/** Kontroler kalkulatora kredytowego
 * @author Patryk Dziki
 * autor przykładu : Przemysław Kudłacik
 */
class CalcCtrl {

	private $msgs;   //wiadomości dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku
	private $hide_intro; //zmienna informująca o tym czy schować intro

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new CalcForm();
		$this->result = new CalcResult();
		$this->hide_intro = false;
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->kredyt = isset($_REQUEST ['kredyt']) ? $_REQUEST ['kredyt'] : null;
		$this->form->lata = isset($_REQUEST ['lata']) ? $_REQUEST ['lata'] : null;
		$this->form->opr = isset($_REQUEST ['opr']) ? $_REQUEST ['opr'] : null;
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->kredyt ) && isset ( $this->form->lata ) && isset ( $this->form->opr ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false; //zakończ walidację z błędem
		} else { 
			$this->hide_intro = true; //przyszły pola formularza, więc - schowaj wstęp
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->kredyt == "") {
			$this->msgs->addError('Nie podano wielkości kredytu');
		}
		if ($this->form->lata == "") {
			$this->msgs->addError('Nie podano liczby lat');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! $this->msgs->isError()) {
			
			// sprawdzenie, czy $kredyt i $lata są liczbami całkowitymi
			if (! is_numeric ( $this->form->kredyt )) {
				$this->msgs->addError('Wielkość kredytu nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->lata )) {
				$this->msgs->addError('Ilość lat nie jest liczbą całkowitą');
			}
		}
		
		return ! $this->msgs->isError();
	}
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getparams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
			$this->form->kredyt = intval($this->form->kredyt);
			$this->form->lata = intval($this->form->lata);
			$this->msgs->addInfo('Parametry poprawne.');
				
			//wykonanie operacji
			$miesiace = $this->form->lata * 12;
			switch ($this->form->opr) {
				case '5%' :
					$r = 0.05/12;
					$this->result->opr_name = '5%';
					$this->msgs->addInfo('Wykonano obliczenia.');
					break;
				case '10%' :
					$r = 0.10/12;
					$this->result->opr_name = '10%';
					$this->msgs->addInfo('Wykonano obliczenia.');
					break;
				case '15%' :
					$r = 0.15/12;
					$this->result->opr_name = '15%';
					$this->msgs->addInfo('Wykonano obliczenia.');
					break;
				case '20%' :
					$r = 0.20/12;
					$this->result->opr_name = '20%';
					$this->msgs->addInfo('Wykonano obliczenia.');
					break;
				default :
					$this->msgs->addInfo('Niepoprawidłowe oprocentowanie');
			}
		}
		
		$this->result->result = round($this->form->kredyt * ($r * pow(1 + $r, $miesiace)) / (pow(1 + $r, $miesiace) - 1), 2);
		$this->generateView();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		global $conf;
		
		$smarty = new Smarty\Smarty();
		$smarty->assign('conf',$conf);
		
		$smarty->assign('page_title','Zadanie 04 by Patryk Dziki');
		$smarty->assign('page_description','Obiektowość. Funkcjonalność aplikacji zamknięta w metodach różnych obiektów. Pełen model MVC.');
		$smarty->assign('page_header','Obiekty w PHP');
				
		$smarty->assign('hide_intro',$this->hide_intro);
		
		$smarty->assign('msgs',$this->msgs);
		$smarty->assign('form',$this->form);
		$smarty->assign('res',$this->result);
		
		$smarty->display($conf->root_path.'/app/CalcView.html');
	}
}
