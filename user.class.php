
<?php
	class User extends 	{

		public $Id;
		public $Login;
		public $Firstname;
		public $Surname;
		public $BirthDate;
		public $Email;
		public $EmailValidated;

		public function __construct(int $Id, string $Login, string $Firstname, string $Surname, string $BirthDate, string $Email, boolean $EmailValidated) {
			this->$Id = $Id;
			this->$Login = $Login;
			this->$Firstname = $Firstname;
			this->$Surname = $Surname;
			this->$BirthDate = $BirthDate;
			this->$Email = $Email;
			this->$EmailValidated = $EmailValidated;
		}

	}
?>