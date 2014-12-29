<?php

	include_once 'models/Caracteristique.class.php';
	include_once 'models/Trajet.class.php';
	/**
	* Classe de gestion des caracteristique
	*/
	class Trajet_CaracteristiqueManager
	{
		private $_db;
		public $caManager;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un Trajet_Caracteristique
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO Trajet_Caracteristique(id_Caracteristique) VALUES (:id_Caracteristique)');
			$query -> bindParam(':id_Caracteristique', $id_Caracteristique,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Trajet_Caracteristique
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Trajet_Caracteristique))
			{
				$query = $this->_db->prepare('DELETE FROM Trajet_Caracteristique WHERE id_Trajet_Caracteristique=:id_Trajet_Caracteristique');
				$query -> bindParam(':id_Trajet_Caracteristique', $id_Trajet_Caracteristique,PDO::PARAM_INT);
			}
			else if(isset($id_Trajet))
			{
				$query = $this->_db->prepare('DELETE FROM Trajet_Caracteristique WHERE id_Trajet=:id_Trajet');
				$query -> bindParam(':id_Trajet', $id_Trajet,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Trajet_Caracteristique.
		**/
		function get(array $data){
			extract($data);
			if(isset($id_Trajet_Caracteristique))
			{
				$query = $this->_db->prepare('SELECT * FROM Trajet_Caracteristique WHERE id_Caracteristique=:id_Caracteristique');
				$query -> bindParam(':id_Caracteristique', $id_Trajet_Caracteristique,PDO::PARAM_INT);
			}
			else if(isset($id_Trajet))
			{
				$query = $this->_db->prepare('SELECT * FROM Trajet_Caracteristique WHERE id_Trajet=:id_Trajet');
				$query -> bindParam(':id_Trajet', $id_Trajet,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['Trajet_Caracteristique'] = $this->caManager->get(array("id_Caracteristique"=>$result['Trajet_Caracteristique']));
			$Trajet_Caracteristique = new Trajet_Caracteristique();
			$Trajet_Caracteristique->hydrate($result);
			return $Trajet_Caracteristique;
		}

		/**
		* Fonction permettant d'obtenir une liste des caracteristiques
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre.
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM Trajet_Caracteristique');
			}
			else
			{
				$query_str = "SELECT * FROM Trajet_Caracteristique WHERE 1"; //Début de la requête.
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

			// On ajoute au tableau de retour les objets Trajet_Caracteristique créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$Trajet_Caracteristique = new Trajet_Caracteristique();
				$value['Trajet_Caracteristique'] = $this->caManager->get(array("id_Caracteristique"=>$value['Trajet_Caracteristique']));
				$Trajet_Caracteristique->hydrate($value);
				array_push($list, $Trajet_Caracteristique);
			}
			return $list;
		}

	}
?>

