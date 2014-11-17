<?php

	/**
	* Classe animal
	*/
	class Produit
	{
		private $_id;
		private $_nom;
		private $_prix;
		private $_categorie;

		public function id()
		{
			return $this->_id;
		}

		public function nom()
		{
			return $this->_nom;
		}

		public function prix()
		{
			return $this->_prix;
		}

		public function categorie()
		{
			return $this->_categorie;
		}

		public function setId($i)
		{
			$this->_id = $i;
		}

		public function setNom($nom)
		{
			$this->_nom =  $nom;
		}

		public function setPrix($prix)
		{
			$this->_prix = $prix;
		}

		public function setCategorie($cat)
		{
			$this->_categorie = $cat;
		}

		public function toString()
		{
			return "L'animal " . $this->_id . ", un(e) " . $this->_prix . " de " . $this->_age . "ans, s'appelle " . $this->_nom . ", appartient à " . $this->_categorie . " et pousse souvent des " . $this->_cri;
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