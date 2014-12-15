<?php

	abstract class Display
	{
		private $_manager;
		private $_function;
		private $_data;
		private $_id;
		private $_success;
		private $_fail;
		private $_location;
		private $_title;

		function __construct($manager,$id=null,$data=null)
		{
			extract($data);
			$this->_manager = $manager;
			if(isset($id)):$this->_id = $id;endif;
			if(isset($data)):$this->_data = $data;endif;

			if(isset($auth))
			{
				include_once 'views/' . $auth .  '/v_' . substr_replace(strtolower(get_class($this)),'',0,8) . '.class.php';
			}
			else
			{
				include_once 'views/v_' . substr_replace(strtolower(get_class($this)),'',0,8) . '.class.php';
			}

			$this->setTitle();
		}

		/**
		* Execution de l'action
		**/
		function exec(){
			if(isset($this->_id))
			{
				$_SESSION['msg'] = call_user_func(array($this->_manager, $this->_function), $this->_id)?$this->_success:$this->_fail;
			}
			else if(isset($this->_data))
			{
				$_SESSION['msg'] = call_user_func(array($this->_manager, $this->_function), $this->_data)?$this->_success:$this->_fail;
			}
			else
			{
				$_SESSION['msg'] = call_user_func(array($this->_manager, $this->_function))?$this->_success:$this->_fail;
			}

			header($this->_location);
		}

		abstract function setStr();

		abstract function setTitle();
	}





?>