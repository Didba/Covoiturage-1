<?php

	include_once 'models/Vehicule_Equipement.class.php';
	include_once 'models/Equipement.class.php';
	include_once 'models/Vehicule.class.php';


	/**
	* Classe de gestion des Vehicule_equipement
	*/
	class Vehicule_equipementManager
	{
		private $_db;
		public $VeEqManager;

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
			$query = $this->_db->prepare('INSERT INTO Vehicule_equipement(commentaire) VALUES (:commentaire)');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Vehicule_equipement
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Vehicule_equipement))
			{
				$query = $this->_db->prepare('DELETE FROM Vehicule_equipement WHERE id_Vehicule_equipement=:id_Vehicule_equipement');
				$query -> bindParam(':id_Vehicule_equipement', $id_Vehicule_equipement,PDO::PARAM_INT);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Vehicule_equipement.
		**/
		function get(array $data){
			extract($data);
			if(isset($id_Vehicule))
			{
				$query = $this->_db->prepare('SELECT * FROM Vehicule_equipement WHERE id_Vehicule=:id_Vehicule');
				$query -> bindParam(':id_Vehicule', $id_Vehicule,PDO::PARAM_INT);
			}
			else if(isset($id_Equipement))
			{
				$query = $this->_db->prepare('SELECT * FROM Vehicule_equipement WHERE id_Equipement=:id_Equipement');
				$query -> bindParam(':id_Equipement', $id_Equipement,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['Vehicule_equipement'] = $this->etManager->get(array("id_Vehicule_equipement"=>$result['Vehicule_equipement']));
			$Vehicule_equipement = new Vehicule_equipement();
			$Vehicule_equipement->hydrate($result);
			return $Vehicule_equipement;
		}

		/**
		* Fonction permettant d'obtenir une liste des equipements
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. 
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM Vehicule_equipement');
			}
			else
			{
				$query_str = "SELECT * FROM Vehicule_equipement WHERE 1"; //Début de la requête.
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

			// On ajoute au tableau de retour les objets Vehicule_equipement créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$Vehicule_equipement = new Vehicule_equipement();
				$value['Vehicule_equipement'] = $this->etManager->get(array("id_Vehicule"=>$value['Vehicule_equipement']));
				$Vehicule_equipement->hydrate($value);
				array_push($list, $Vehicule_equipement);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un Vehicule_equipement d'un vehicule
		**/
		function update($Vehicule_equipement){
			extract($Vehicule_equipement);
			$query = $this->_db->prepare('UPDATE Vehicule_equipement SET ,commentaire=:commentaire WHERE id_Vehicule=:id_Vehicule');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_INT);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>

