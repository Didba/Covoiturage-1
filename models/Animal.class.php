<?php

	/**
	* Classe animal
	*/
	class Animal
	{
		private $_id;
		private $_nom;
		private $_espece;
		private $_proprietaire;
		private $_cri;
		private $_age;

		public function id()
		{
			return $this->_id;
		}

		public function nom()
		{
			return $this->_nom;
		}

		public function espece()
		{
			return $this->_espece;
		}

		public function proprietaire()
		{
			return $this->_proprietaire;
		}

		public function cri()
		{
			return $this->_cri;
		}

		public function age()
		{
			return $this->_age;
		}

		public function setId($i)
		{
			$this->_id = $i;
		}

		public function setNom($nom)
		{
			$this->_nom =  $nom;
		}

		public function setEspece($espece)
		{
			$this->_espece = $espece;
		}

		public function setProprietaire($proprio)
		{
			$this->_proprietaire = $proprio;
		}

		public function setCri($cri)
		{
			$this->_cri = $cri;
		}

		public function setAge($age)
		{
			$this->_age = $age;
		}

		public function toString()
		{
			return "L'animal " . $this->_id . ", un(e) " . $this->_espece . " de " . $this->_age . "ans, s'appelle " . $this->_nom . ", appartient à " . $this->_proprietaire . " et pousse souvent des " . $this->_cri;
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