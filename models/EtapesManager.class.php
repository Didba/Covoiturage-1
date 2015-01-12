<?php

	include_once 'models/Etapes.class.php';
	include_once 'models/Trajet.class.php';
	/**
	* Classe de gestion des etapes
	*/
	class EtapesManager
	{
		private $_db;
		public $etManager;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un Etapes
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO covoiturage_etapes(lieu, ordre) VALUES (:lieu, :ordre)');
			$query -> bindParam(':lieu', $Lieu,PDO::PARAM_STR);
			$query -> bindParam(':ordre', $Ordre,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer une Etape
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Etapes))
			{
				$query = $this->_db->prepare('DELETE FROM covoiturage_etapes WHERE id_etapes=:id_etapes');
				$query -> bindParam(':id_etapes', $id_Etapes,PDO::PARAM_INT);
			}
			else if(isset($id_Trajet))
			{
				$query = $this->_db->prepare('DELETE FROM covoiturage_etapes WHERE id_trajet=:id_trajet');
				$query -> bindParam(':id_trajet', $id_Trajet,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer une Etape.
		**/
		function get(array $data){
			extract($data);
			if(isset($id_Etapes))
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_etapes WHERE id_etapes=:id_etapes');
				$query -> bindParam(':id_etapes', $id_Etapes,PDO::PARAM_INT);
			}
			else if(isset($id_Trajet))
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_etapes WHERE id_trajet=:id_trajet');
				$query -> bindParam(':id_trajet', $id_Trajet,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['etapes'] = $this->etManager->get(array("id_etapes"=>$result['etapes']));
			$Etapes = new Etapes();
			$Etapes->hydrate($result);
			return $Etapes;
		}

		/**
		* Fonction permettant d'obtenir une liste des caracteristiques
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre.
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_etapes');
			}
			else
			{
				$query_str = "SELECT * FROM covoiturage_etapes WHERE 1"; //Début de la requête.
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

			// On ajoute au tableau de retour les objets Etapes créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$Etapes = new Etapes();
				$value['etapes'] = $this->etManager->get(array("id_etapes"=>$value['etapes']));
				$Etapes->hydrate($value);
				array_push($list, $Etapes);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un Etapes
		**/
		function update($Etapes){
			extract($Etapes);
			$query = $this->_db->prepare('UPDATE covoiturage_etapes SET ,lieu=:lieu, ordre=:ordre WHERE id_etapes=:id_etapes');
			$query -> bindParam(':lieu', $Lieu,PDO::PARAM_INT);
			$query -> bindParam(':ordre', $Ordre,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>

