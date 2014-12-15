<?php

	// include_once 'models/TrajetsManager.class.php';
	include_once 'models/AdherantManager.class.php';
	// include_once 'models/MessagesManager.class.php';


	class Manager
	{
		private $_db;

		function __construct($db)
		{
			$this->_db = $db;
		}

		function getManager($type)
		{
			switch ($type) {
				case 'trajet':
					return new TrajetManager($this->_db);
					break;

				case 'membre':
					return new MbManager($this->_db);
					break;

				case 'message':
					return new MsgManager($this->_db);
					break;

				default:
					# code...
					break;
			}
		}
	}



?>