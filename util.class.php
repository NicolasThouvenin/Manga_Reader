<?php

	/*
		Cette classe à vocation à regrouper des méthodes utiles à diérentes pages.
	*/
	class Util {
		
		public static function checkPostData($data) {
			/* Cette fonction utilise la function htmlentities sur les valeurs d'un array $_POST et renvoi un array sécurisé */
            foreach ($data as $key => $value) {
                $data[$key] = htmlentities($value);
            }
            return $data;
		}
	}
?>