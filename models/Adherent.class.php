<?php

	/**
	* Classe adhérant
	*/
	class adherent
	{
		private $id_adherent;
		private $_nom;
		private $_prenom;
		private $_sexe;
		private $_telephone;
		private $_dateNaiss;
		private $_mail;
		private $_password;

		public function id_adherent()
		{
			return $this->id_adherent;
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
			if($this->_sexe==0): return "Femme";
			else: return "Homme"; endif;
		}

		public function telephone()
		{
			return $this->_telephone;
		}

		public function date_naissance()
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

		public function setid_adherent($i)
		{
			$this->id_adherent = $i;
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
			$this->_dateNaiss = $DateNaiss;
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