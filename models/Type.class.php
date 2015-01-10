<?php
	/**
	* Classe conducteur
	*/
	class Type
	{
		private $_id_type;
		private $_libelle;

		public function id_type()
		{
			return $this->_id_type;
		}

		public function setId_type($n)
		{
			$this->_id_type =  $n;
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