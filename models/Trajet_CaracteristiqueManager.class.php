<?php

	include_once 'models/Caracteristique.class.php';
	include_once 'models/CaracteristiqueManager.class.php';
	include_once 'models/Trajet_Caracteristique.class.php';
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
			$query = $this->_db->prepare('INSERT INTO covoiturage_trajet_caracteristique(id_trajet, id_caracteristique) VALUES (:id_trajet, :id_caracteristique)');
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
				$query = $this->_db->prepare('DELETE FROM covoiturage_trajet_caracteristique WHERE id_caracteristique=:id_caracteristique');
				$query -> bindParam(':id_caracteristique', $id_trajet_caracteristique,PDO::PARAM_INT);
			}
			else if(isset($id_trajet))
			{
				$query = $this->_db->prepare('DELETE FROM covoiturage_trajet_caracteristique WHERE id_caracteristique=:id_caracteristique');
				$query -> bindParam(':id_caracteristique', $id_trajet,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant d'obtenir une liste des caracteristiques
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre.
			$cr_manager = new CaracteristiqueManager($this->_db);
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_trajet_caracteristique');
			}
			else
			{
				$query_str = "SELECT * FROM covoiturage_trajet_caracteristique WHERE 1"; //Début de la requête.
				foreach ($champs as $champ => $val) {
					if($val!="") //On vérifie que la valeur ne soit pas nulle
					{
						$query_str .= ' AND ' . $champ . ' =' . $val ; // Ici on priviligie le LIKE à l'égalité pour plus de tolérance dans la saisie
					}
				}
				$query = $this->_db->prepare($query_str);
			}
			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetchAll();
			$list = array();
			// On ajoute au tableau de retour les objets trajet_caracteristique créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => $value) {
				$caracteristique = $cr_manager->get(array("id_caracteristique"=>$value['id_caracteristique']));
				array_push($list, $caracteristique);
			}
			return $list;
		}

	}
?>

