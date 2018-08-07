<?php
        class Authentified extends User {
            
            /* Cette classe correspond aux informations sur un utilisateur authentifié. */

            private $Token;

            public function __construct(int $Id, string $uniqid) {

            	try {
            	    parent::__construct($Id);
                	$this->SetToken($uniqid);

            	} catch (Exception $e) {
                    throw new Exception("\nErreur lors de la création de l'objet Authentified : ".$e->getMessage());
                }
            }

            private function SetToken($uniqid) {
            	try {
                    require('connection.php');
	            	$this->Token = hash('sha256', session_id().$uniqid.$this->getLogin());
	                $addToken = $db->prepare("CALL addToken(:login, :token)");
                    $login = $this->getLogin();
	                $addToken->bindParam(':login', $login, PDO::PARAM_STR, 255);
                    $addToken->bindParam(':token', $this->Token, PDO::PARAM_STR, 64);
	                $addToken->execute();
	                $addToken->closeCursor();	
            	} catch (Exception $e) {
                    throw new Exception("\nErreur lors de la création du token dans la base de données : ".$e->getMessage());
                }

            }

            public function CheckToken() {
            	try {
            	    require('connection');
	                $checkToken = $db->prepare("CALL createUser(:token, :login, @isAuthentified)");
	                $checkToken->bindParam(':token', $this->Token, PDO::PARAM_STR, 64);
	                $checkToken->bindParam(':login', $this->getLogin(), PDO::PARAM_STR, 255);
	                $checkToken->execute();
	                $checkToken->closeCursor();
	                $result = $db->query("SELECT @isAuthentified")->fetch(PDO::FETCH_ASSOC);
	                return ($result['@isAuthentified'] === '1' ? true : false);

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