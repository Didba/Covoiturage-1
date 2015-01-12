<?php

	include_once 'models/Adherent.class.php';

	/**
	* Classe conducteur
	*/
	class Conducteur extends Adherent
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