<?php

	abstract class Action
	{
		private $_manager;
		private $_function;
		private $_data;
		private $_id;
		private $_success;
		private $_fail;
		private $_location;

		function __construct($manager,$function,$id=null,$data=null)
		{
			$this->_manager = $manager;
			$this->_function = $function;
			if(isset($id)):$this->_id = $id;endif;
			if(isset($data)):$this->_data = $data;endif;
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
	}





?>