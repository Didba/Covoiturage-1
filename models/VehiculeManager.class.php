<?php

	include_once 'models/Vehicule.class.php';
	include_once 'models/CarburantManager.class.php';
	include_once 'models/TypeManager.class.php';

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
			$query = $this->_db->prepare('INSERT INTO covoiturage_vehicule(id_adherent, num_permis, marque,modele,type,couleur,carburant,immatriculation) VALUES (:id_adherent, :num_permis, :marque,:modele,:type,:couleur,:carburant,:immatriculation)');
			$query -> bindParam(':id_adherent', $_SESSION['id'],PDO::PARAM_INT);
			$query -> bindParam(':num_permis', $_SESSION['permis'],PDO::PARAM_INT);
			$query -> bindParam(':marque', $marque,PDO::PARAM_STR);
			$query -> bindParam(':modele', $modele,PDO::PARAM_STR);
			$query -> bindParam(':type', $type,PDO::PARAM_STR);
			$query -> bindParam(':couleur', $couleur,PDO::PARAM_STR);
			$query -> bindParam(':carburant', $carburant,PDO::PARAM_STR);
			$query -> bindParam(':immatriculation', $immatriculation,PDO::PARAM_STR);
			return $query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Adherent
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_vehicule))
			{
				$query = $this->_db->prepare('DELETE FROM covoiturage_vehicule WHERE id_vehicule=:id_vehicule AND id_adherent=:id_adherent');
				$query -> bindParam(':id_vehicule', $id_vehicule,PDO::PARAM_INT);
				$query -> bindParam(':id_adherent', $_SESSION['id'],PDO::PARAM_INT);
			}
			return $query->execute();
		}

		/**
		* Fonction permettant de récupérer un vehicule.
		**/
		function get(array $data){
			extract($data);
			if(isset($id_vehicule))
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_vehicule WHERE id_vehicule=:id_vehicule');
				$query -> bindParam(':id_vehicule', $id_vehicule,PDO::PARAM_INT);
			}
			$query->execute() or die(print_r($query->errorInfo()));
			$result = $query->fetch();

			$cb_manager = new CarburantManager($this->_db);
			$result['carburant'] = $cb_manager->get(array('id_carburant'=>$result['carburant']));
			$result['carburant'] = $result['carburant']->libelle();

			$cb_manager = new TypeManager($this->_db);
			$result['type'] = $cb_manager->get(array('id_type'=>$result['type']));
			$result['type'] = $result['type']->libelle();

			$vehicule = new Vehicule();
			$vehicule->hydrate($result);
			return $vehicule;
		}

		/**
		* Fonction permettant d'obtenir une liste des vehicule
		**/
		function getList($champs=NULL){
			extract($champs);
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				return false;
			}
			else
			{
				$query = $this->_db->prepare('SELECT id_vehicule FROM covoiturage_vehicule WHERE id_adherent = :id_adherent');
				$query -> bindParam(':id_adherent', $id_adherent,PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result = $query->fetchAll();

				$list = array();
				if($query->rowCount()>0)
				{
					// On ajoute au tableau de retour les objets vehicule créés avec chaque ligne de la BDD retournée
					foreach ($result as $key => &$value) {
						$vehicule = $this->get(array("id_vehicule"=>$value['id_vehicule']));
						array_push($list, $vehicule);
					}
				}
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un vehicule
		**/
		function update($vehicule){
			extract($vehicule);
			$query = $this->_db->prepare('UPDATE covoiturage_vehicule SET marque=:marque,modele=:modele,type=:type,couleur=:couleur,carburant=:carburant,immatriculation=:immatriculation,WHERE id_vehicule=:id_vehicule');
			$query -> bindParam(':marque', $marque,PDO::PARAM_STR);
			$query -> bindParam(':modele', $modele,PDO::PARAM_STR);
			$query -> bindParam(':type', $type,PDO::PARAM_STR);
			$query -> bindParam(':couleur', $couleur,PDO::PARAM_STR);
			$query -> bindParam(':carburant', $carburant,PDO::PARAM_STR);
			$query -> bindParam(':immatriculation', $immatriculation,PDO::PARAM_STR);
			$query -> bindParam(':id_vehicule', $id_vehicule,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>