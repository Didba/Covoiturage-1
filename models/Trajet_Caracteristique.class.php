<?php

	/**
	* Classe trajet_Caractéristique
	*/
	class Trajet_Caracteristique
	{
		private $_id_trajet;
		private $id_caracteristique;


		public function id_trajet()
		{
			return $this->_id_trajet;
		}

		public function id_caracteristique()
		{
			return $this->id_caracteristique;
		}

		public function setId_trajet($i)
		{
			$this->_id_trajet = $i;
		}

		public function setId_caracteristique($i)
		{
			$this->id_caracteristique =  $i;
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