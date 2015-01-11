<?php

	include_once 'models/Caracteristique.class.php';
	include_once 'models/Trajet.class.php';
	/**
	* Classe de gestion des caracteristique
	*/
	class Trajet_CaracteristiqueManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un trajet_caracteristique
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO trajet_caracteristique(id_trajet, id_caracteristique) VALUES (:id_trajet, :id_caracteristique)');
			$query -> bindParam(':id_caracteristique', $id_caracteristique,PDO::PARAM_INT);
			$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un trajet_caracteristique
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_trajet_caracteristique))
			{
				$query = $this->_db->prepare('DELETE FROM trajet_caracteristique WHERE id_caracteristique=:id_caracteristique');
				$query -> bindParam(':id_caracteristique', $id_trajet_caracteristique,PDO::PARAM_INT);
			}
			else if(isset($id_trajet))
			{
				$query = $this->_db->prepare('DELETE FROM trajet_caracteristique WHERE id_caracteristique=:id_caracteristique');
				$query -> bindParam(':id_caracteristique', $id_trajet,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un trajet_caracteristique.
		**/
		function get(array $data){
			extract($data);
			if(isset($id_trajet_caracteristique))
			{
				$query = $this->_db->prepare('SELECT * FROM trajet_caracteristique WHERE id_caracteristique=:id_caracteristique');
				$query -> bindParam(':id_caracteristique', $id_trajet_caracteristique,PDO::PARAM_INT);
			}
			else if(isset($id_trajet))
			{
				$query = $this->_db->prepare('SELECT * FROM trajet_caracteristique WHERE id_trajet=:id_trajet');
				$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['trajet_caracteristique'] = $this->caManager->get(array("id_caracteristique"=>$result['trajet_caracteristique']));
			$trajet_caracteristique = new Trajet_Caracteristique();
			$trajet_caracteristique->hydrate($result);
			return $trajet_caracteristique;
		}

		/**
		* Fonction permettant d'obtenir une liste des caracteristiques
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre.
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM trajet_caracteristique');
			}
			else
			{
				$query_str = "SELECT * FROM trajet_caracteristique WHERE 1"; //Début de la requête.
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

			// On ajoute au tableau de retour les objets trajet_caracteristique créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$trajet_caracteristique = new Trajet_Caracteristique();
				$value['trajet_caracteristique'] = $this->get(array("id_caracteristique"=>$value['trajet_caracteristique']));
				$trajet_caracteristique->hydrate($value);
				array_push($list, $trajet_caracteristique);
			}
			return $list;
		}

	}
?>

