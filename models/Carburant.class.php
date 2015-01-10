<?php
	/**
	* Classe conducteur
	*/
	class Carburant
	{
		private $_id_carburant;
		private $_libelle;

		public function id_carburant()
		{
			return $this->_id_carburant;
		}

		public function setId_carburant($n)
		{
			$this->_id_carburant =  $n;
		}

		public function libelle()
		{
			return $this->_libelle;
		}

		public function setLibelle($n)
		{
			$this->_libelle =  $n;
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