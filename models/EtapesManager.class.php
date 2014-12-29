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
			$query = $this->_db->prepare('INSERT INTO Etapes(Lieu, Ordre) VALUES (:Lieu, :Ordre)');
			$query -> bindParam(':Lieu', $Lieu,PDO::PARAM_STR);
			$query -> bindParam(':Ordre', $Ordre,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer une Etape
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Etapes))
			{
				$query = $this->_db->prepare('DELETE FROM Etapes WHERE id_Etapes=:id_Etapes');
				$query -> bindParam(':id_Etapes', $id_Etapes,PDO::PARAM_INT);
			}
			else if(isset($id_Trajet))
			{
				$query = $this->_db->prepare('DELETE FROM Etapes WHERE id_Trajet=:id_Trajet');
				$query -> bindParam(':id_Trajet', $id_Trajet,PDO::PARAM_STR);
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
				$query = $this->_db->prepare('SELECT * FROM Etapes WHERE id_Etapes=:id_Etapes');
				$query -> bindParam(':id_Etapes', $id_Etapes,PDO::PARAM_INT);
			}
			else if(isset($id_Trajet))
			{
				$query = $this->_db->prepare('SELECT * FROM Etapes WHERE id_Trajet=:id_Trajet');
				$query -> bindParam(':id_Trajet', $id_Trajet,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['Etapes'] = $this->etManager->get(array("id_Etapes"=>$result['Etapes']));
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
				$query = $this->_db->prepare('SELECT * FROM Etapes');
			}
			else
			{
				$query_str = "SELECT * FROM Etapes WHERE 1"; //Début de la requête.
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
				$value['Etapes'] = $this->etManager->get(array("id_Etapes"=>$value['Etapes']));
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
			$query = $this->_db->prepare('UPDATE Etapes SET ,Lieu=:Lieu, Ordre=:Ordre WHERE id_Etapes=:id_Etapes');
			$query -> bindParam(':Lieu', $Lieu,PDO::PARAM_INT);
			$query -> bindParam(':Ordre', $Ordre,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>

