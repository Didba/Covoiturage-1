<?php

	/**
	* Class note
	*/
	class note
	{
		private $_id_note;
		private $_id_Adherant_From;
		private $_id_Adherant_To;
		private $_date;
		private $_commentaire;
		
		
		
		public function idNote()
		{
			return $this->_id_note;
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

		public function commentaire()
		{
			return $this->_commentaire;
		}

		
		public function setIdNote($i)
		{
			$this->_id_Note = $i;
		}
		
		public function setIdAdherant_From($i)
		{
			$this->_id_Adherant_From = $i;
		}
		
		public function setIdAdherant_To($i)
		{
			$this->_id_Adherant_To = $i;
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