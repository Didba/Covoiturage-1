<?php

	include_once 'models/type.class.php';

	/**
	* Classe de gestion des type
	*/
	class typeManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un type
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO type(libelle) VALUES (:libelle)');
			$query -> bindParam(':libelle', $libelle,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un type
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_type))
			{
				$query = $this->_db->prepare('DELETE FROM type WHERE id_type=:id_type');
				$query -> bindParam(':id_type', $id_type,PDO::PARAM_INT);
			}
			else if(isset($libelle))
			{
				$query = $this->_db->prepare('DELETE FROM type WHERE libelle=:libelle');
				$query -> bindParam(':libelle', $libelle,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un type. Paramètre: array contenant soit id_type=>$id_type soit libelle=>$libelle (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);

			if(isset($id_type))
			{
				$query = $this->_db->prepare('SELECT * FROM type WHERE id_type=:id_type');
				$query -> bindParam(':id_type', $id_type,PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result = $query->fetch();
			}
			else if(isset($libelle))
			{
				$query = $this->_db->prepare('SELECT * FROM type WHERE libelle=:libelle');
				$query -> bindParam(':libelle', $libelle,PDO::PARAM_STR);
				$query->execute() or die(print_r($query->errorInfo()));
				$result = $query->fetch();
			}

			$type = new Type();

			if(!empty($result))
			{
				$type->hydrate($result);
			}
			else
			{
				$type = false;
			}
			return $type;
		}

		/**
		* Fonction permettant d'obtenir une liste des type
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM type');
			}
			else
			{
				$query_str = "SELECT * FROM type WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets type créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$type = $this->get(array("id_type"=>$value['id_type']));
				array_push($list, $type);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un type
		**/
		function update($type){
			extract($type);
			$query = $this->_db->prepare('UPDATE type SET libelle=:libelle WHERE id_type=:id_type');
			$query -> bindParam(':id_type', $id_type,PDO::PARAM_INT);
			$query -> bindParam(':libelle', $libelle,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>