<?php

	/**
	* Class Message
	*/
	class Message
	{
		private $_id_msg;
		private $_id_Adherent_From;
		private $_id_Adherent_To;
		private $_date;
		private $_message;
		private $_sujet;


		public function idMsg()
		{
			return $this->_id_msg;
		}

		public function idAdherent_From()
		{
			return $this->_id_Adherent_From;
		}

		public function idAdherent_To()
		{
			return $this->_id_Adherent_To;
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

		public function setIdAdherent_From($i)
		{
			$this->_id_Adherent_From= $i;
		}

		public function setIdAdherent_To($i)
		{
			$this->_id_Adherent_To = $i;
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