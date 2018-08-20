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


		public static function getGenreOptions() {

            /* This method returns the genre array */
            
            try {

                require('connection.php');

                $result = $db->prepare("SELECT * FROM genres");
                $result->execute();

                $options = '';

                while ($line = $result->fetch()) {
                    $options = $options.'<option value="'.$line['Id'].'">'.$line['Label'].'</option>';
                }

                return $options;

            } catch (Exception $e) {
                throw new Exception("<br>Erreur lors de la création de la liste d'options de genres : ". $e->getMessage());
            }
		}

	}
?>