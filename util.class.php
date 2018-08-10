<?php

	/*
		Cette classe à vocation à regrouper des méthodes utiles à diérentes pages.
	*/
	class Util {
		
		public static function checkData($data) {
            foreach ($data as $key => $value) {
                $data[$key] = htmlentities($value);
            }
            return $data;
		}
	}
?>