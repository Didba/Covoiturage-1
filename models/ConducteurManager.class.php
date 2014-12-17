<?php

	include_once 'models/conducteur.class.php';
	include_once 'models/Adherant.class.php';
	include_once 'models/AdherantManager.class.php';

	/**
	* Classe de gestion des conducteur
	*/
	class conducteurManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un conducteur
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO conducteur(numPermis) VALUES (:numPermis )');
			$query -> bindParam(':numPermis', $numPermis,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un conducteur
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Adherant))
			{
				$query = $this->_db->prepare('DELETE FROM conducteur WHERE id_Adherant=:id_Adherant');
				$query -> bindParam(':id_Adherant', $id_Adherant,PDO::PARAM_INT);
			}
			else if(isset($numPermis))
			{
				$query = $this->_db->prepare('DELETE FROM conducteur WHERE numPermis=:numPermis');
				$query -> bindParam(':numPermis', $numPermis,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un conducteur. Paramètre: array contenant soit id_Adherant=>$id_Adherant soit numPermis=>$numPermis (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);
			if(isset($id_Adherent_Conducteur))
			{
				$query = $this->_db->prepare('SELECT * FROM conducteur WHERE id_Adherent_Conducteur=:id_Adherent_Conducteur');
				$query -> bindParam(':id_Adherent_Conducteur', $id_Adherent_Conducteur,PDO::PARAM_INT);
			}
			else if(isset($numPermis))
			{
				$query = $this->_db->prepare('SELECT * FROM conducteur WHERE numPermis=:numPermis');
				$query -> bindParam(':numPermis', $numPermis,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();

			$conducteur = new conducteur();

			if(!empty($result))
			{
				$result['conducteur'] = $this->get(array("id_Adherent_Conducteur"=>$result['conducteur']));
				$conducteur->hydrate($result);
			}
			else
			{
				$conducteur = false;
			}
			return $conducteur;
		}

		/**
		* Fonction permettant d'obtenir une liste des conducteur
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM conducteur');
			}
			else
			{
				$query_str = "SELECT * FROM conducteur WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets conducteur créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$conducteur = new conducteur();
				$value['conducteur'] = $this->get(array("id_Adherant"=>$value['conducteur']));
				$conducteur->hydrate($value);
				array_push($list, $conducteur);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un conducteur
		**/
		function update($conducteur){
			extract($conducteur);
			$query = $this->_db->prepare('UPDATE conducteur SET numPermis=:numPermis WHERE id_Adherant=:id_Adherant');
			$query -> bindParam(':id_Adherant', $id_Adherant,PDO::PARAM_INT);
			$query -> bindParam(':numPermis', $numPermis,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>