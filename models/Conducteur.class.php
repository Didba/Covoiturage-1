<?php
	/**
	* Classe conducteur
	*/
	class conducteur extends adherent
	{
		private $_num_permis;

		public function num_permis()
		{
			return $this->_num_permis;
		}

		public function setNum_permis($n)
		{
			$this->_num_permis =  $n;
		}
	}


?>