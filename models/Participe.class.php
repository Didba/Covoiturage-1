<?php

	/**
	* Classe participe
	*/
	class participe
	{
		private $_id_adherant;
		private $_id_trajet;
		private $_nb_invites;
		private $_frais;
		

		public function id_adherant()
		{
			return $this->_id_adherant;
		}
		
		public function id_trajet()
		{
			return $this->_id_trajet;
		}

		public function nb_invites()
		{
			return $this->_nb_invites;
		}

		public function frais()
		{
			return $this->_frais;
		}
		
		public function setIdAdherant($i)
		{
			$this->_id_adherant = $i;
		}
		
		public function setIdTrajet($i)
		{
			$this->_id_trajet = $i;
		}

		public function setNb_Invites($nb)
		{
			$this->_nb_invites =  $nb;
		}
		
		public function setFrais($nb)
		{
			$this->_frais =  $nb;
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