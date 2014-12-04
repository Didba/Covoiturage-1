<?php

	/**
	* Classe conducteur
	*/
	class conducteur
	{
		private $_idAdherent;
		private $_numPermis;
		

		public function idAdherent()
		{
			return $this->_idAdherent;
		}

		public function numPermis()
		{
			return $this->_numPermis;
		}
		
		public function setIdAdherent($i)
		{
			$this->_idAdherent = $i;
		}

		public function setNumPermis($n)
		{
			$this->_numPermis =  $n;
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