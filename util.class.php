<?php
	class Util {
		/* This file provides some util methodes */
		public static function checkPostData($data) {
			/* This method use the php function htmlentities for each values in $_POST and return an array with securised data */
            foreach ($data as $key => $value) {
                $data[$key] = htmlentities($value);
            }
            return $data;
		}
	}
?>