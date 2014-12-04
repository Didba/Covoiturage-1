<?php

	/**
	* Classe caractéristique
	*/
	class caracteristique
	{
		private $_id_Caracteristique;
		private $_nom;
		

		public function id()
		{
			return $this->_id_Caracteristique;
		}

		public function nom()
		{
			return $this->_nom;
		}
		
		public function setId($i)
		{
			$this->_id_Caracteristique = $i;
		}

		public function setNom($nom)
		{
			$this->_nom =  $nom;
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