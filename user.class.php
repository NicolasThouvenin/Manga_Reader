<?php
        class User {
            
            /* Cette classe correspond aux informations sur un utilisateur */

            protected $Id;
            protected $Login;
            protected $Firstname;
            protected $Surname;
            protected $BirthDate;
            protected $Email;
            protected $EmailValidated;

            public function __construct(int $Id) {

                $this->Id = (int)$Id;

                try {

                    require('connection.php');

                    $user = $db->prepare("SELECT users.* FROM users WHERE Id = :id;");
                    $user->execute(array('id' => $Id));

                    if ($user->rowCount() == 1) {
                        while ($line = $user->fetch()) {
                            $this->Login = $line['Login'];
                            $this->Firstname = $line['Firstname'];
                            $this->Surname = $line['Surname'];
                            $this->BirthDate = $line['BirthDate'];
                            $this->Email = $line['Email'];
                            $this->EmailValidated = ($line['EmailValidated'] === '1' ? true : false);
                        }
                    } else {
                        throw new Exception('Utilisateur inconnu dans la base.');
                    }
                    $user->closeCursor();

                } catch (Exception $e) {
                    throw new Exception("\nErreur lors de la création de l'objet user : ".$e->getMessage());
                } 
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
                $this->_validateLength($BirthDate, 255); //hétité de la class user
                $this->BirthDate = $BirthDate;
            }

            public function setEmail($Email) {
                $this->_validateLength($Email, 254);
                $this->Email = $Email;
            }

            public function setEmailValidated($EmailValidated) {
                $this->EmailValidated = $EmailValidated;
            }
            
            private function _validateLength(string $string, int $maxLength) {
                if (strlen($string) > $maxLength) {
                    throw new Exception('La longueur de la chaine de caractère est trop longue');
                }
            }
    }
?>