<?php

	class DisplayFactory
	{
		private $_list = array();

		function __construct()
		{
			array_push($this->_list, {"trajet", new Trajet()}, {"trajets", new Trajets()});
			var_dump($this->_list);
		}

		function add($name, $constructeur);
		{
			array_push($this->_list, {$name, $constructeur});
		}

		function create($name,$manager,$id=null,$data=null)
		{
			if(isset($this->_list[$name])) throw "Le type " + $name + " n'existe pas";
			return $this->_list[$name]->create($manager, $id, $data);
		}
	}

?>