<?php

	/**
	* Classe caractéristique
	*/
	class caracteristique
	{
		private $_id;
		private $_nom;
		

		public function id()
		{
			return $this->_id;
		}

		public function nom()
		{
			return $this->_nom;
		}
		
		public function setId($i)
		{
			$this->_id = $i;
		}

		public function setNom($nom)
		{
			$this->_nom =  $nom;
		}
		
		public function toString()
		{
			return "Le caractéristique " . $this->_id . ", ". $this->_nom ;
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