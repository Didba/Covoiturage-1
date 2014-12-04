<?php

	include_once 'models/Adherant.class.php';
	
	/**
	* Classe de gestion des administrateur
	*/
	class AdministrateurManager
	{
		private $_db;
		public $AdminManager;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
			$this->AdminManager = new AdministrateurManager($db);
		}

		/**
		* Fonction permettant de retirer un Admin
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Adherant))
			{
				$query = $this->_db->prepare('DELETE FROM administrateur WHERE id_Adherant=:id_Adherant');
				$query -> bindParam(':id_Adherant', $id_Adherant,PDO::PARAM_INT);
			}
		
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Adherant. 
		**/
		function get(array $data){
			extract($data);
			if(isset($id))
			{
				$query = $this->_db->prepare('SELECT * FROM administrateur WHERE id_Adherant=:id_Adherant');
				$query -> bindParam(':id_Adherant', $id_Adherant,PDO::PARAM_INT);
			}
			

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['administrateur'] = $this->AdminManager->get(array("id_Adherant"=>$result['administrateur']));
			$administrateur = new Administrateur();
			$administrateur->hydrate($result);
			return $administrateur;
		}

		/**
		* Fonction permettant d'obtenir une liste des administrateur
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM administrateur');
			}
			else
			{
				$query_str = "SELECT * FROM administrateur WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets administrateur créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$administrateur = new Adherant();
				$value['administrateur'] = $this->AdminManager->get(array("id"=>$value['administrateur']));
				$administrateur->hydrate($value);
				array_push($list, $administrateur);
			}
			return $list;
		}

		
	}

?>