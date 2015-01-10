<?php

	include_once 'models/carburant.class.php';

	/**
	* Classe de gestion des carburant
	*/
	class CarburantManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un carburant
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO carburant(libelle) VALUES (:libelle)');
			$query -> bindParam(':libelle', $libelle,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un carburant
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_carburant))
			{
				$query = $this->_db->prepare('DELETE FROM carburant WHERE id_carburant=:id_carburant');
				$query -> bindParam(':id_carburant', $id_carburant,PDO::PARAM_INT);
			}
			else if(isset($libelle))
			{
				$query = $this->_db->prepare('DELETE FROM carburant WHERE libelle=:libelle');
				$query -> bindParam(':libelle', $libelle,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un carburant. Paramètre: array contenant soit id_carburant=>$id_carburant soit libelle=>$libelle (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);

			if(isset($id_carburant))
			{
				$query = $this->_db->prepare('SELECT * FROM carburant WHERE id_carburant=:id_carburant');
				$query -> bindParam(':id_carburant', $id_carburant,PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result = $query->fetch();
			}
			else if(isset($libelle))
			{
				$query = $this->_db->prepare('SELECT * FROM carburant WHERE libelle=:libelle');
				$query -> bindParam(':libelle', $libelle,PDO::PARAM_STR);
				$query->execute() or die(print_r($query->errorInfo()));
				$result = $query->fetch();
			}

			$carburant = new Carburant();

			if(!empty($result))
			{
				$carburant->hydrate($result);
			}
			else
			{
				$carburant = false;
			}
			return $carburant;
		}

		/**
		* Fonction permettant d'obtenir une liste des carburant
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM carburant');
			}
			else
			{
				$query_str = "SELECT * FROM carburant WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets carburant créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$carburant = $this->get(array("id_carburant"=>$value['id_carburant']));
				array_push($list, $carburant);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un carburant
		**/
		function update($carburant){
			extract($carburant);
			$query = $this->_db->prepare('UPDATE carburant SET libelle=:libelle WHERE id_carburant=:id_carburant');
			$query -> bindParam(':id_carburant', $id_carburant,PDO::PARAM_INT);
			$query -> bindParam(':libelle', $libelle,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>