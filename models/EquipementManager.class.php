<?php

	include_once 'models/Equipement.class.php';

	/**
	* Classe de gestion des Equipement
	*/
	class EquipementManager
	{
		private $_db;
		public $eqManager;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
			$this->eqManager = new EquipementManager($db);
		}

		/**
		* Fonction permettant d'ajouter un Etapes
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO Equipement(Nom) VALUES (:Nom)');
			$query -> bindParam(':Nom', $Nom,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Equipement
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Equipement))
			{
				$query = $this->_db->prepare('DELETE FROM Equipement WHERE id_Equipement=:id_Equipement');
				$query -> bindParam(':id_Equipement', $id_Equipement,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('DELETE FROM Equipement WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un equipement.
		**/
		function get(array $data){
			extract($data);
			if(isset($id_Equipement))
			{
				$query = $this->_db->prepare('SELECT * FROM Equipement WHERE id_Equipement=:id_Equipement');
				$query -> bindParam(':id_Equipement', $id_Equipement,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('SELECT * FROM Equipement WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['Equipement'] = $this->etManager->get(array("id_Equipement"=>$result['Equipement']));
			$Equipement = new Equipement();
			$Equipement->hydrate($result);
			return $Equipement;
		}

		/**
		* Fonction permettant d'obtenir une liste des equipements
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. 
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM Equipement');
			}
			else
			{
				$query_str = "SELECT * FROM Equipement WHERE 1"; //Début de la requête.
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

			// On ajoute au tableau de retour les objets Equipement créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$Equipement = new Equipement();
				$value['Equipement'] = $this->etManager->get(array("id_Equipement"=>$value['Equipement']));
				$Equipement->hydrate($value);
				array_push($list, $Equipement);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un Equipement
		**/
		function update($Equipement){
			extract($Equipement);
			$query = $this->_db->prepare('UPDATE Equipement SET ,Nom=:Nom WHERE id_Equipement=:id_Equipement');
			$query -> bindParam(':Nom', $Nom,PDO::PARAM_INT);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>

