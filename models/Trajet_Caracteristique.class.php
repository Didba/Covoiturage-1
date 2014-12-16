<?php

	/**
	* Classe trajet_Caractéristique
	*/
	class trajet_Caracterisque
	{
		private $_id_trajet;
		private $id_Caracteristique;


		public function id_trajet()
		{
			return $this->_id_trajet;
		}

		public function id_Caracteristique()
		{
			return $this->id_Caracteristique;
		}

		public function setId_trajet($i)
		{
			$this->_id_trajet = $i;
		}

		public function setId_Caracteristique($i)
		{
			$this->id_Caracteristique =  $i;
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