<?php

	include_once 'models/Message.class.php';
	include_once 'models/Adherent.class.php';

	/**
	* Class de gestion Message
	*/
	class MessageManager
	{
		private $_db;
		public $MeManager;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un Message
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO message(id_adherent_from,id_adherent_to,date,sujet,message) VALUES (:id_adherent_from,:id_adherent_to,:date,:sujet,:message)');
			$query -> bindParam(':id_adherent_from', $id_AdherentE,PDO::PARAM_STR);
			$query -> bindParam(':id_adherent_to', $id_AdherentR,PDO::PARAM_STR);
			$query -> bindParam(':date', $date,PDO::PARAM_STR);
			$query -> bindParam(':sujet', $sujet,PDO::PARAM_STR);
			$query -> bindParam(':message', $message,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Message
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_msg))
			{
				$query = $this->_db->prepare('DELETE FROM message WHERE id_adherent_from=:id_adherent_from');
				$query -> bindParam(':id_adherent_from', $id_msg,PDO::PARAM_INT);
			}

			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Message.
		**/
		function get(array $data){
			extract($data);
			if(isset($id_msg))
			{
				$query = $this->_db->prepare('SELECT * FROM message WHERE id_adherent_from=:id_adherent_from');
				$query -> bindParam(':id_adherent_from', $id_msg,PDO::PARAM_INT);
			}


			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['message'] = $this->MeManager->get(array("id_adherent_from"=>$result['message']));
			$Message = new Message();
			$Message->hydrate($result);
			return $Message;
		}

		/**
		* Fonction permettant d'obtenir une liste des Message
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM message');
			}
			else
			{
				$query_str = "SELECT * FROM message WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets Message créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$Message = new Message();
				//$value['message'] = $this->MeManager->get(array("id_adherent_from"=>$value['message']));
				$Message->hydrate($value);
				array_push($list, $Message);
			}
			return $list;
		}


	}

?>