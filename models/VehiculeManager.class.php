<?php

	include_once 'models/Vehicule.class.php';

	/**
	* Classe de gestion des vehicules
	*/
	class VehiculeManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un Vehicule
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO vehicule(marque,modele,type,couleur,carburant,immarticulation) VALUES (:marque,:modele,:type,:couleur,:carburant,:immarticulation)');
			$query -> bindParam(':marque', $marque,PDO::PARAM_STR);
			$query -> bindParam(':modele', $modele,PDO::PARAM_STR);
			$query -> bindParam(':type', $type,PDO::PARAM_STR);
			$query -> bindParam(':couleur', $couleur,PDO::PARAM_STR);
			$query -> bindParam(':carburant', $carburant,PDO::PARAM_STR);
			$query -> bindParam(':immarticulation', $immarticulation,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Adherent
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Vehicule))
			{
				$query = $this->_db->prepare('DELETE FROM vehicule WHERE id_vehicule=:id_vehicule');
				$query -> bindParam(':id_vehicule', $id_Vehicule,PDO::PARAM_INT);
			}

			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un vehicule.
		**/
		function get(array $data){
			extract($data);
			if(isset($id_Vehicule))
			{
				$query = $this->_db->prepare('SELECT * FROM vehicule WHERE id_vehicule=:id_vehicule');
				$query -> bindParam(':id_vehicule', $id_Vehicule,PDO::PARAM_INT);
			}


			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['vehicule'] = $this->AdManager->get(array("id_vehicule"=>$result['vehicule']));
			$vehicule = new Vehicule();
			$vehicule->hydrate($result);
			return $vehicule;
		}

		/**
		* Fonction permettant d'obtenir une liste des vehicule
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			include_once 'models/ConducteurManager.class.php';
			$mb_manager = new conducteurManager($this->_db);
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM vehicule');
			}
			else
			{
				$query_str = "SELECT * FROM vehicule INNER JOIN conducteur ON vehicule.id_adherent = conducteur.id_adherent WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
				foreach ($champs as $champ => $val) {
					if($val!="") //On vérifie que la valeur ne soit pas nulle
					{
						$query_str .= ' AND conducteur.' . $champ . ' LIKE "%' . $val . '%"'; // Ici on priviligie le LIKE à l'égalité pour plus de tolérance dans la saisie
					}
				}
				$query = $this->_db->prepare($query_str);
			}
			
			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetchAll();
			//var_dump($result);
			$list = array();

			// On ajoute au tableau de retour les objets vehicule créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$vehicule = new vehicule();
				//$vehicule = $this->get(array("id_vehicule"=>$value['id_vehicule']));
				$vehicule->hydrate($value);
				array_push($list, $vehicule);
			}
			//var_dump($list);
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un vehicule
		**/
		function update($vehicule){
			extract($vehicule);
			$query = $this->_db->prepare('UPDATE vehicule SET marque=:marque,modele=:modele,type=:type,couleur=:couleur,carburant=:carburant,immarticulation=:immarticulation,WHERE id_vehicule=:id_vehicule');
			$query -> bindParam(':marque', $marque,PDO::PARAM_STR);
			$query -> bindParam(':modele', $modele,PDO::PARAM_STR);
			$query -> bindParam(':type', $type,PDO::PARAM_STR);
			$query -> bindParam(':couleur', $couleur,PDO::PARAM_STR);
			$query -> bindParam(':carburant', $carburant,PDO::PARAM_STR);
			$query -> bindParam(':immarticulation', $immarticulation,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>