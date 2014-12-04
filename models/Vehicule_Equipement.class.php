<?php

	/**
	* Classe vehicule equipement 
	*/
	class vehicule_equipement
	{
		private $_id_Vehicule;
		private $_id_equipement;
		private $_commentaire;
		

		public function id()
		{
			return $this->_id_Vehicule;
		}

		public function equipement()
		{
			return $this->_id_equipement;
		}

		public function commentaire()
		{
			return $this->_commentaire;
		}
		
		
		public function setIdVehicule($i)
		{
			$this->_id_Vehicule = $i;
		}

		public function setIdEquipement($i)
		{
			$this->_id_equipement =  $i;
		}

		public function setCommentaire($c)
		{
			$this->commentaire = $c;
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