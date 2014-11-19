<?php

	/**
	* Classe adhérant
	*/
	class Produit
	{
		private $_id;
		private $_nom;
		private $_prenom;
		private $_sexe;
		private $_telephone;
		private $_dateNaiss;
		private $mail;
		private $_password;

		public function id()
		{
			return $this->_id;
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
		
		public function dateNaiss()
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
		
		public function setId($i)
		{
			$this->_id = $i;
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
		
		public function setDateNaiss($DateNaiss)
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
		
		public function toString()
		{
			return "L'animal " . $this->_id . ", un(e) " . $this->_prenom . " de " . $this->_age . "ans, s'appelle " . $this->_nom . ", appartient à " . $this->_sexe . " et pousse souvent des " . $this->_cri;
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