<?php
	/**
	* Classe conducteur
	*/
	class conducteur extends adherent
	{
		private $_numPermis;

		public function numPermis()
		{
			return $this->_numPermis;
		}

		public function setNumPermis($n)
		{
			$this->_numPermis =  $n;
		}
	}


?>