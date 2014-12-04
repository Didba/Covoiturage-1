<?php

	include_once 'models/caracteristique.class.php';
	
	/**
	* Classe de gestion des caracteristique
	*/
	class caracteristiquesManager
	{
		private $_db;
		public $_CarManager;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
			$this->_CarManager = new caracteristiqueManager($db);
		}

		/**
		* Fonction permettant d'ajouter un caracteristique
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO caracteristique(nom) VALUES (:nom )');
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un caracteristique
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Caracteristique))
			{
				$query = $this->_db->prepare('DELETE FROM caracteristique WHERE id_Caracteristique=:id_Caracteristique');
				$query -> bindParam(':id_Caracteristique', $id_Caracteristique,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('DELETE FROM caracteristique WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un caracteristique. Paramètre: array contenant soit id_Caracteristique=>$id_Caracteristique soit nom=>$nom (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);
			if(isset($id_Caracteristique))
			{
				$query = $this->_db->prepare('SELECT * FROM caracteristique WHERE id_Caracteristique=:id_Caracteristique');
				$query -> bindParam(':id_Caracteristique', $id_Caracteristique,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('SELECT * FROM caracteristique WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['caracteristique'] = $this->_CarManager->get(array("id_Caracteristique"=>$result['caracteristique']));
			$caracteristique = new caracteristique();
			$caracteristique->hydrate($result);
			return $caracteristique;
		}

		/**
		* Fonction permettant d'obtenir une liste des caracteristique
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM caracteristique');
			}
			else
			{
				$query_str = "SELECT * FROM caracteristique WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets caracteristique créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$caracteristique = new caracteristique();
				$value['caracteristique'] = $this->_CarManager->get(array("id_Caracteristique"=>$value['caracteristique']));
				$caracteristique->hydrate($value);
				array_push($list, $caracteristique);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un caracteristique
		**/
		function update($caracteristique){
			extract($caracteristique);
			$query = $this->_db->prepare('UPDATE caracteristique SET nom=:nom WHERE id_Caracteristique=:id_Caracteristique');
			$query -> bindParam(':id_Caracteristique', $id_Caracteristique,PDO::PARAM_INT);
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>