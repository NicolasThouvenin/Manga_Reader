<?php
        class User {
            
            /* Cette classe correspond aux informations sur un utilisateur */

            private $Id;
            private $Login;
            private $Firstname;
            private $Surname;
            private $BirthDate;
            private $Email;
            private $EmailValidated;
            private $token;

            public function __construct(int $Id, string $Login, string $Firstname, string $Surname, string $BirthDate, string $Email, bool $EmailValidated, string $Token) {
                $this->Id = $Id;
                $this->Login = $Login;
                $this->Firstname = $Firstname;
                $this->Surname = $Surname;
                $this->BirthDate = $BirthDate;
                $this->Email = $Email;
                $this->EmailValidated = $EmailValidated;
                $this->Token = $Token;
            }
            
            public function getId() {
                return $this->Id;
            }
            public function getLogin() {
                return $this->Login;
            }

            public function getFirstname() {
                return $this->Firstname;
            }

            public function getSurname() {
                return $this->Surname;
            }

            public function getBirthDate() {
                return $this->BirthDate;
            }

            public function getEmail() {
                return $this->Email;
            }

            public function getEmailValidated() {
                return $this->EmailValidated;
            }

            public function setLogin($Login) {
                $this->_validateLength($Login, 255);
                $this->Login = $Login;
            }

            public function setFirstname($Firstname) {
                $this->_validateLength($Firstname, 255);
                $this->Firstname = $Firstname;
            }

            public function setSurname($Surname) {
                $this->_validateLength($Surname, 255);
                $this->Surname = $Surname;
            }

            public function setBirthDate($BirthDate) {
                $this->_validateLength($BirthDate, 255);
                $this->BirthDate = $BirthDate;
            }

            public function setEmail($Email) {
                $this->_validateLength($Email, 254);
                $this->Email = $Email;
            }

            public function setEmailValidated($EmailValidated) {
                $this->EmailValidated = $EmailValidated;
            }

            public function checkToken() {
                required('connection');
                $checkToken = $db->prepare("CALL createUser(:token, :login, @isAuthentified)");
                $checkToken->bindParam(':token', $this->Token, PDO::PARAM_STR, 64);
                $checkToken->bindParam(':login', $this->Login, PDO::PARAM_STR, 255);
                $checkToken->execute();
                $checkToken->closeCursor();
                $result = $db->query("SELECT @isAuthentified")->fetch(PDO::FETCH_ASSOC);
                $isChecked = ($result['@isAuthentified'] === '1' ? true : false);
                return $isChecked;
            }
            
            private function _validateLength(string $string, int $maxLength) {
                if (strlen($string) > $maxLength) {
                    throw new Exception('La longueur de la chaine de caractère est trop longue');
                }
            }
    }
?>