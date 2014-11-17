<?php

	include_once 'models/Categorie.class.php';
	/**
	* Classe de gestion des categories
	*/
	class CategoriesManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un categorie
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO categories(nom) VALUES (:nom)');
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un categorie
		**/
		function remove(array $data){
			extract($data);
			if(isset($id))
			{
				$query = $this->_db->prepare('DELETE FROM categories WHERE id=:id');
				$query -> bindParam(':id', $id,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('DELETE FROM categories WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un categorie. Paramètre: array contenant soit id=>$id soit nom=>$nom (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);
			if(isset($id))
			{
				$query = $this->_db->prepare('SELECT * FROM categories WHERE id=:id');
				$query -> bindParam(':id', $id,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('SELECT * FROM categories WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$categorie = new Categorie($this->_db);
			$categorie->hydrate($result);
			return $categorie;
		}

		/**
		* Fonction permettant d'obtenir une liste des categories
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM categories');
			}
			else
			{
				$query_str = "SELECT * FROM categories WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets categorie créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => $value) {
				$categorie = new Categorie($this->_db);
				$categorie->hydrate($value);
				array_push($list, $categorie);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un categorie
		**/
		function update($categorie){
			extract($categorie);
			$query = $this->_db->prepare('UPDATE categories SET nom=:nom WHERE id=:id');
			$query -> bindParam(':id', $id,PDO::PARAM_INT);
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>