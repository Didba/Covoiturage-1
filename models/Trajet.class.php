<?php

	/**
	* Classe trajet
	*/
	class trajet
	{
		private $_id_trajet;
		private $_commentaire;
		private $_date_traj;
		private $_id_adherent;
		private $_lieu_depart;
		private $_lieu_arrivee;
		private $_nb_passager_max;
		private $_conducteur;

		public function id_trajet()
		{
			return $this->_id_trajet;
		}

		public function num_permis()
		{
			return $this->_num_permis;
		}

		public function id_adherent()
		{
			return $this->_id_adherent;
		}

		public function conducteur()
		{
			return $this->_conducteur;
		}

		public function commentaire()
		{
			return $this->_commentaire;
		}

		public function date_traj()
		{
			return $this->_date_traj;
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

		public function setId_adherent($i)
		{
			$this->_id_adherent =  $i;
		}

		public function setCom($commentaire)
		{
			$this->_commentaire = $commentaire;
		}

		public function setDate_traj($date_traj)
		{
			$this->_date_traj = $date_traj;
		}

		public function setIdAdherent($id_adherent)
		{
			$this->_id_adherent = $id_adherent;
		}

		public function setLieu_arrivee($lieu_arrivee)
		{
			$this->_lieu_arrivee = $lieu_arrivee;
		}

		public function setLieu_depart($lieu_depart)
		{
			$this->_lieu_depart = $lieu_depart;
		}

		public function setNb_Passagers_Max($nb_passager_max)
		{
			$this->_nb_passager_max = $nb_passager_max;
		}

		public function setConducteur($adh)
		{
			$this->_conducteur = $adh;
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