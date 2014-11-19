<?php

	/**
	* Classe véhicule
	*/
	class vehicule
	{
		private $_id;
		private $_marque;
		private $_modele;
		private $_type;
		private $_couleur;
		private $_carburant;
		private $_immarticulation;
		

		public function id()
		{
			return $this->_id;
		}

		public function marque()
		{
			return $this->_marque;
		}

		public function modele()
		{
			return $this->_modele;
		}

		public function type()
		{
			return $this->_type;
		}

		public function couleur()
		{
			return $this->_couleur;
		}
		
		public function carburant()
		{
			return $this->_carburant;
		}
		
		public function immarticulation()
		{
			return $this->_immarticulation;
		}
		
		
		
		public function setId($i)
		{
			$this->_id = $i;
		}

		public function setMarque($marque)
		{
			$this->_marque =  $marque;
		}

		public function setModele($modele)
		{
			$this->_modele = $modele;
		}

		public function setType($type)
		{
			$this->_type = $type;
		}
		
		public function setCouleur($couleur)
		{
			$this->_couleur = $couleur;
		}
		
		
		public function setImmarticulation($immarticulation)
		{
			$this->_immarticulation = $immarticulation;
		}
		
		
		public function toString()
		{
			return "Le véhicule " . $this->_id . ", marque : " . $this->_marque .  ", modèle : " . $this->_modele . ", type : " . $this->_type. ", couleur : " . $this->_couleur. ", carburant : " . $this->_carburant. ", immarticulation : " . $this->_immarticulation   ;
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