<?php

	/**
	* Classe véhicule
	*/
	class vehicule
	{
		private $_id_Vehicule;
		private $_marque;
		private $_modele;
		private $_type;
		private $_couleur;
		private $_carburant;
		private $_immatriculation;


		public function id_vehicule()
		{
			return $this->_id_Vehicule;
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

		public function immatriculation()
		{
			return $this->_immatriculation;
		}



		public function setId_vehicule($i)
		{
			$this->_id_Vehicule = $i;
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

		public function setCarburant($carburant)
		{
			$this->_carburant = $carburant;
		}

		public function setCouleur($couleur)
		{
			$this->_couleur = $couleur;
		}


		public function setImmatriculation($immatriculation)
		{
			$this->_immatriculation = $immatriculation;
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