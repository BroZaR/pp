<?php

class ErrorMessage {

	public $key;

	public function __construct( $key ) {
		$this->key = $key;
	}

	public function __toString() {
		switch ( $this->key ) {
			case 'login':
				$message = 'Неправильно введено логін/пароль. Перевірте дані та спробуйте ще раз.';
				break;
			case 'signup':
				$message = 'Неправильно введені дані реєстрації. Перевірте введені поля, та спробуйте ще раз';
				break;
			case 'topic_add_success':
				$message = 'Тему успішно додано';
				break;
			case 'topic_add_error':
				$message = 'Неправильно введено назву теми. Поле повинно містити видимі символи';
				break;
			case 'topic_edit_success':
				$message = 'Назву теми успішно змінено';
				break;
			case 'topic_edit_name_error':
				$message = 'Неправильне значення нового ім`я теми. Спробуйте ввести ще раз';
				break;
			case 'topic_edit_error':
				$message = 'Даної теми не існує';
				break;
			default:
				$message = 'Помилка';
		}

		return $message;
	}
}

?>