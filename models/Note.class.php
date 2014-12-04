<?php

	/**
	* Class note
	*/
	class note
	{
		private $_id_note;
		private $_id_AdherantE;
		private $_id_AdherantR;
		private $_date;
		private $_commentaire;
		
		
		
		public function idNote()
		{
			return $this->_id_note;
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

		public function commentaire()
		{
			return $this->_commentaire;
		}

		
		public function setIdNote($i)
		{
			$this->_id_Note = $i;
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

		public function setCommentaire($c)
		{
			$this->_commentaire = $c;
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