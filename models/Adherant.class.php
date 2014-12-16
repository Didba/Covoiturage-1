<?php

	/**
	* Classe adhérant
	*/
	class adherant
	{
		private $Id_Adherent;
		private $_nom;
		private $_prenom;
		private $_sexe;
		private $_telephone;
		private $_dateNaiss;
		private $_mail;
		private $_password;

		public function Id_Adherent()
		{
			return $this->Id_Adherent;
		}

		public function nom()
		{
			return $this->_nom;
		}

		public function prenom()
		{
			return $this->_prenom;
		}

		public function sexe()
		{
			return $this->_sexe;
		}

		public function telephone()
		{
			return $this->_telephone;
		}

		public function Date_Naissance()
		{
			return $this->_dateNaiss;
		}

		public function mail()
		{
			return $this->_mail;
		}

		public function password()
		{
			return $this->_password;
		}

		public function setId_Adherent($i)
		{
			$this->Id_Adherent = $i;
		}

		public function setNom($nom)
		{
			$this->_nom =  $nom;
		}

		public function setPrenom($prenom)
		{
			$this->_prenom = $prenom;
		}

		public function setSexe($sexe)
		{
			$this->_sexe = $sexe;
		}

		public function setTelephone($telephone)
		{
			$this->_telephone = $telephone;
		}

		public function setDate_Naissance($DateNaiss)
		{
			$this->_DateNaiss = $DateNaiss;
		}

		public function setMail($mail)
		{
			$this->_mail = $mail;
		}

		public function setPassword($password)
		{
			$this->_password = md5($password);
		}


		public function hydrate(array $data)
		{
			foreach ($data as $key => $value)
			{
				$setter = "set" . ucfirst($key);
				if(method_exists($this, $setter))
				{
					$this->$setter($value);
				}
			}
		}
	}


?>