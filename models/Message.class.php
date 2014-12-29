<?php

	/**
	* Class Message
	*/
	class Message
	{
		private $_id_msg;
		private $_id_Adherant_From;
		private $_id_Adherant_To;
		private $_date;
		private $_message;
		private $_sujet;
		
		
		public function idMsg()
		{
			return $this->_id_msg;
		}
		
		public function idAdherant_From()
		{
			return $this->_id_Adherant_From;
		}
		
		public function idAdherant_To()
		{
			return $this->_id_Adherant_To;
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
		
		public function setIdAdherant_From($i)
		{
			$this->_id_Adherant_From= $i;
		}
		
		public function setIdAdherant_To($i)
		{
			$this->_id_Adherant_To = $i;
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