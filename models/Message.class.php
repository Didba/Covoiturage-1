<?php

	/**
	* Class Message
	*/
	class Message
	{
		private $_id_msg;
		private $_id_AdherantE;
		private $_id_AdherantR;
		private $_date;
		private $_message;
		private $_sujet;
		
		
		public function idMsg()
		{
			return $this->_id_msg;
		}
		
		public function idAdherantE()
		{
			return $this->_id_AdherantE;
		}
		
		public function idAdherantR()
		{
			return $this->_id_AdherantR;
		}

		public function date()
		{
			return $this->_date;
		}

		public function message()
		{
			return $this->_message;
		}

		public function sujet()
		{
			return $this->_sujet;
		}
		
		public function setIdMsg($i)
		{
			$this->_id_AdMsg = $i;
		}
		
		public function setIdAdherantE($i)
		{
			$this->_id_AdherantE = $i;
		}
		
		public function setIdAdherantR($i)
		{
			$this->_id_AdherantR = $i;
		}

		public function setDate($d)
		{
			$this->_date =  $d;
		}

		public function setMessage($m)
		{
			$this->_message = $m;
		}

		public function setSujet($s)
		{
			$this->_sujet = $s;
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