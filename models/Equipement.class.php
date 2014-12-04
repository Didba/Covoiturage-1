<?php

	/**
	* Classe Equipements
	*/
	class Equipements
	{
		private $_id_Equipement;
		private $_nom;

		public function id_Equipement()
		{
			return $this->_id_Equipement;
		}
		
		public function nom()
		{
			return $this->_nom;
		}
		
		public function setId_Equipement($i)
		{
			$this->_id_Equipement = $i;
		}

		public function setNom($n)
		{
			$this->_nom =  $n;
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