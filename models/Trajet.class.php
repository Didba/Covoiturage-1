<?php

	/**
	* Classe trajet
	*/
	class trajet
	{
		private $_id_trajet;
		private $_nom;
		private $_commentaire;
		private $_date;
		private $_id_adherant;
		private $_lieu_depart;
		private $_lieu_arrivee;
		private $_nb_passager_max;
		private $_num_permis;

		public function id_trajet()
		{
			return $this->_id_trajet;
		}
		
		public function num_permis()
		{
			return $this->_num_permis;
		}

		public function id_adherant()
		{
			return $this->_id_adherant;
		}

		public function commentaire()
		{
			return $this->_commentaire;
		}

		public function date()
		{
			return $this->_date;
		}

		public function id_adherant()
		{
			return $this->_id_adherant;
		}
		
		public function lieu_depart()
		{
			return $this->_lieu_depart;
		}
		
		public function lieu_arrivee()
		{
			return $this->_lieu_arrivee;
		}
		
		public function nb_passager_max()
		{
			return $this->_nb_passager_max;
		}
		
		public function setId_trajet($i)
		{
			$this->_id_trajet = $i;
		}

		public function setId_adherant($i)
		{
			$this->_id_adherant =  $i;
		}

		public function setCom($commentaire)
		{
			$this->_commentaire = $commentaire;
		}

		public function setDate($date)
		{
			$this->_date = $date;
		}
		
		public function setIdAdherant($id_adherant)
		{
			$this->_id_adherant = $id_adherant;
		}
		
		public function setLieuA($lieu_arrivee)
		{
			$this->_lieu_arrivee = $lieu_arrivee;
		}
		
		public function setLieuD($lieu_depart)
		{
			$this->_lieu_depart = $lieu_depart;
		}
		
		public function setNb_Passagers_Max($nb_passager_max)
		{
			$this->_nb_passager_max = $nb_passager_max;
		}
		
		public function toString()
		{
			return "Le trajet " . $this->_id_trajet;
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