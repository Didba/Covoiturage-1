<?php

	/**
	* Classe de gestion des animaux
	*/
	class AnimalsManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un animal
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO covoiturage_animaux(nom,espece,cri,proprietaire,age) VALUES (:nom, :espece, :cri, :proprietaire, :age)');
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query -> bindParam(':espece', $espece,PDO::PARAM_STR);
			$query -> bindParam(':proprietaire', $proprietaire,PDO::PARAM_STR);
			$query -> bindParam(':cri', $cri,PDO::PARAM_STR);
			$query -> bindParam(':age', $age,PDO::PARAM_INT);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un animal
		**/
		function remove(array $data){
			extract($data);
			if(isset($id))
			{
				$query = $this->_db->prepare('DELETE FROM covoiturage_animaux WHERE id=:id');
				$query -> bindParam(':id', $id,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('DELETE FROM covoiturage_animaux WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un animal. Paramètre: array contenant soit id=>$id soit nom=>$nom (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);
			if(isset($id))
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_animaux WHERE id=:id');
				$query -> bindParam(':id', $id,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_animaux WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$animal = new Animal();
			$animal->hydrate($result);
			return $animal;
		}

		/**
		* Fonction permettant d'obtenir une liste des animaux
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_animaux');
			}
			else
			{
				$query_str = "SELECT * FROM covoiturage_animaux WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
				foreach ($champs as $champ => $val) {
					if($val!="") //On vérifie que la valeur ne soit pas nulle
					{
						$query_str .= ' AND ' . $champ . ' LIKE "%' . $val . '%"'; // Ici on priviligie le LIKE à l'égalité pour plus de tolérance dans la saisie
					}
				}
				$query = $this->_db->prepare($query_str);
			}
			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetchAll();

			$list = array();

			// On ajoute au tableau de retour les objets Animal créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => $value) {
				$animal = new Animal();
				$animal->hydrate($value);
				array_push($list, $animal);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un animal
		**/
		function update($animal){
			extract($animal);
			$query = $this->_db->prepare('UPDATE covoiturage_animaux SET nom=:nom,espece=:espece,cri=:cri,proprietaire=:proprietaire,age=:age WHERE id=:id');
			$query -> bindParam(':id', $id,PDO::PARAM_INT);
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query -> bindParam(':espece', $espece,PDO::PARAM_STR);
			$query -> bindParam(':cri', $cri,PDO::PARAM_STR);
			$query -> bindParam(':proprietaire', $proprietaire,PDO::PARAM_STR);
			$query -> bindParam(':age', $age,PDO::PARAM_INT);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>