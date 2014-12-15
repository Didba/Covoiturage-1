<?php

	class ActionSupp_trajet extends Action
	{
		function setStrings(){
			$this->_success = 'Le trajet a bien été supprimé';
			$this->_fail = 'La suppression du trajet a échoué';
			$this->_location = 'Location: index.php?action=trajets';
			$this->_function = 'remove';
		}
	}


?>