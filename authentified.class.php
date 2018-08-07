<?php
        class Authentified extends User {
            
            /* Cette classe correspond aux informations sur un utilisateur authentifié. */

            private $Token;

            public function __construct(int $Id, string $uniqid) {

            	try {
            	    parent::__construct($Id);
                	$this->setToken($uniqid);

            	} catch (Exception $e) {
                    throw new Exception("\nErreur lors de la création de l'objet Authentified : ".$e->getMessage());
                }
            }

            private function setToken($uniqid) {
            	try {
	            	$this->Token = hash('sha256', session_id().$uniqid.$this->Login);
	                $addToken = $db->prepare("CALL addToken(:token, :login)");
	                $addToken->bindParam(':token', $this->token, PDO::PARAM_STR, 64);
	                $addToken->bindParam(':login', $this->Login, PDO::PARAM_STR, 255);
	                $addToken->execute();
	                $addToken->closeCursor();	
            	} catch (Exception $e) {
                    throw new Exception("\nErreur lors de la création du token dans la base de données : ".$e->getMessage());
                }

            }

            public function checkToken() {
            	try {
            	    require('connection');
	                $checkToken = $db->prepare("CALL createUser(:token, :login, @isAuthentified)");
	                $checkToken->bindParam(':token', $this->Token, PDO::PARAM_STR, 64);
	                $checkToken->bindParam(':login', $this->Login, PDO::PARAM_STR, 255);
	                $checkToken->execute();
	                $checkToken->closeCursor();
	                $result = $db->query("SELECT @isAuthentified")->fetch(PDO::FETCH_ASSOC);
	                $isChecked = ($result['@isAuthentified'] === '1' ? true : false);
            	} catch (Exception $e) {
                    throw new Exception("\nErreur lors de la vérification du token de la base de données : ".$e->getMessage());
                }

                return $isChecked;
            }
            
            private function _validateLength(string $string, int $maxLength) {
                if (strlen($string) > $maxLength) {
                    throw new Exception('La longueur de la chaine de caractère est trop longue.');
                }
            }
    }
?>