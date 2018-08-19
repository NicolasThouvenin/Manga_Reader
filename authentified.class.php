<?php
    class Authentified extends User {
        
        /* 
            This class has the authentified user data. It has methods to manipulate user token in cookie and database.
         */

        private $Token;

        public function __construct(int $Id) {

        	try {
        	    parent::__construct($Id); // It is necessary to set parent attributes
            	$this->SetToken();

        	} catch (Exception $e) {
                throw new Exception("<br>Error during the creation of the authentified object : ".$e->getMessage());
            }
        }

        private function SetToken() {
        	/*
        		This method creates a token with 3 inputs : the session Id, an uniq id and the user login. It set this token in the tokens table in the database.
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
                throw new Exception("<br>Error during the token creation in the database : ".$e->getMessage());
            }

        }

        public function CheckToken() {
        	/*
        		This method checks if the authentified object has a valid token. This method is usefull to check the token inside the cookie
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
                throw new Exception("<br>Error during the user token verification inside database : ".$e->getMessage());
            }
        }
    }
?>