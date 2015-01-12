<?php
	include_once('models/Trajet.class.php');
	/**
	* Classe participe
	*/
	class Participe extends Trajet
	{
		private $_id_adherent;
		private $_id_trajet;
		private $_nb_invites;
		private $_frais;


		public function id_adherent()
		{
			return $this->_id_adherent;
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

		public function setId_adherent($i)
		{
			$this->_id_adherent = $i;
		}

		public function setId_trajet($i)
		{
			$this->_id_trajet = $i;
		}

		public function setNb_invites($nb)
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