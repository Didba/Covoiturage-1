<?php

	/**
	* Classe Etapes
	*/
	class Etapes
	{
		private $_id_trajet;
		private $_id_Etapes;
		private $_Lieu;
		private $_Ordre;
		

		public function id_trajet()
		{
			return $this->_id_trajet;
		}
		
		public function id_Etapes()
		{
			return $this->_id_Etapes;
		}
		
		public function Lieu()
		{
			return $this->_Lieu;
		}
		
		public function Ordre()
		{
			return $this->_Ordre;
		}
		
		public function setId_trajet($i)
		{
			$this->_id_trajet = $i;
		}

		public function setId_Etapes($i)
		{
			$this->_id_Etapes =  $i;
		}
		
		public function setLieu($l)
		{
			$this->_Lieu =  $l;
		}
		
		public function setOrdre($o)
		{
			$this->_Ordre =  $o;
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