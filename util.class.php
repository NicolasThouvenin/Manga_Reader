<?php

	/*
		Cette classe à vocation à regrouper des méthodes utiles à différentes pages.
	*/
	class Util {
		
		public static function checkPostData($data) {
			/* Cette fonction utilise la function htmlentities sur les valeurs d'un array $_POST et renvoi un array sécurisé */
            foreach ($data as $key => $value) {
                $data[$key] = htmlentities($value);
            }
            return $data;
		}


		public static function getGenreOptions() {

            /* Cette fonction permet de retourner une liste d'options de genres */
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