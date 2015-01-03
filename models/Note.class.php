<?php

	/**
	* Class note
	*/
	class note
	{
		private $_id_Adherent_From;
		private $_id_Adherent_To;
		private $_date;
		private $_note;
		private $_commentaire;



		public function Note()
		{
			return $this->_id_note;
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

		public function commentaire()
		{
			return $this->_commentaire;
		}


		public function setIdNote($i)
		{
			$this->_id_Note = $i;
		}

		public function setIdAdherent_From($i)
		{
			$this->_id_Adherent_From = $i;
		}

		public function setIdAdherent_To($i)
		{
			$this->_id_Adherent_To = $i;
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