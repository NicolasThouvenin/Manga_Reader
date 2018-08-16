<?php
    class Authentified extends User {
        
        /* 
            Cette classe correspond aux informations sur un utilisateur authentifié.
            L'intérêt de la classe Authentified par rapport à ça classe parente User est qu'elle possède des méthodes pour créer
            et gérer les token d'uahtneitifcation dans les cookie et la base de données.
         */

        private $Token;

        public function __construct(int $Id) {

        	try {
        	    parent::__construct($Id); // Construit toutes les valeurs utiles de la classe parente User
            	$this->SetToken();

        	} catch (Exception $e) {
                throw new Exception("<br>Erreur lors de la création de l'objet Authentified : ".$e->getMessage());
            }
        }

        private function SetToken() {
        	/*
        		Cette function créer un token à partir d'un uniq Id de formulaire et l'intégre à la table tokens de la base de donnée.
				L'idée est que l'utilsateur possède un token par machine dans un cookie.
        	*/
        	try {
                require('connection.php');
                $uniqId = uniqid();
            	$this->Token = hash('sha256', session_id().$uniqId.$this->getLogin());
                $addToken = $db->prepare("CALL addToken(:login, :token)");
                $login = $this->getLogin();
                $addToken->bindParam(':login', $login, PDO::PARAM_STR, 255);
                $addToken->bindParam(':token', $this->Token, PDO::PARAM_STR, 64);
                $addToken->execute();
                $addToken->closeCursor();	
        	} catch (Exception $e) {
                throw new Exception("<br>Erreur lors de la création du token dans la base de données : ".$e->getMessage());
            }

        }

        public function CheckToken() {
        	/*
        		Cette function vérifie que l'objet Authentified possède un token valide.
        		C'est notamment utile pour vérifié l'objet générer à partir du cookie
        	*/
        	try {
        	    require('connection.php');
                $checkToken = $db->prepare("CALL checkUserToken(:login, :token, @isAuthentified)");
                $login = $this->getLogin();
                $checkToken->bindParam(':login', $login, PDO::PARAM_STR, 255);
                $checkToken->bindParam(':token', $this->Token, PDO::PARAM_STR, 64);
                $checkToken->execute();
                $checkToken->closeCursor();
                $result = $db->query("SELECT @isAuthentified")->fetch(PDO::FETCH_ASSOC);
                return ($result['@isAuthentified'] === '1' ? true : false);

        	} catch (Exception $e) {
                throw new Exception("<br>Erreur lors de la vérification du token utilisateur de la base de données : ".$e->getMessage());
            }
        }
    }
?>