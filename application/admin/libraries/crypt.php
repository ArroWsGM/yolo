<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Crypt {
	public function generateHash($password, $cost=11){
		/**
		* Чтобы сгенерировать соль, нужно сгенерировать достаточно случайных байт.
		* Т.к. base64 возвращает один символ на каждые 6 бит, нужно сгенерировать
		* хотябы 22*6/8=16.5 байт, поэтому мы сгенерируем 17 и возьмем первые
		* 22 base64 символа
		*/
		$salt=substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);
		
		/**
		* Т.к. blowfish принимает только символы ./A-Za-z0-9 мы должны заменить
		* каждый '+' в строке base64 точкой '.'. По поводу знака '=' мы можем не
		* беспокоиться, так как они могут появиться только после 22 знаков.
		*/
		$salt=str_replace("+",".",$salt);
		
		/**
		* Теперь создадим строку для функции crypt, содержащую все необходимые
		* настройки, разделенные знаком доллара
		*/
		$param='$'.implode('$',array(
				"2y", //выбираем наиболее безопасную версию blowfish (>=PHP 5.3.7)
				str_pad($cost,2,"0",STR_PAD_LEFT), //число итераций, д.б. от 04 до 31
				$salt //добавляем соль
		));
	   
		//Создаем хеш
		return crypt($password, $param);
	}

	/**
	* Сверяем пароль и хеш, сгенерированный функцией generate_hash
	*/
	public function validatePW($password, $hash){
			/**
			* Regenerating the with an available hash as the options parameter should
			* produce the same hash if the same password is passed.
			*/
			return crypt($password, $hash)==$hash;
	}
}