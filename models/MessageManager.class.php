<?php

	include_once 'models/Message.class.php';
	include_once 'models/Adherent.class.php';
	include_once 'models/AdherentManager.class.php';

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
			$date = date('Y-m-d H-i');
			$query = $this->_db->prepare('INSERT INTO covoiturage_message(id_adherent_from,id_adherent_to,date,sujet,message) VALUES (:id_adherent_from,:id_adherent_to,:date,:sujet,:message)');
			$query -> bindParam(':id_adherent_from', $id_adherent_from,PDO::PARAM_STR);
			$query -> bindParam(':id_adherent_to', $id_adherent_to,PDO::PARAM_STR);
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
				$query = $this->_db->prepare('DELETE FROM covoiturage_message WHERE id_adherent_from=:id_adherent_from');
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
				$query = $this->_db->prepare('SELECT * FROM covoiturage_message WHERE id_adherent_from=:id_adherent_from');
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
			$mb_manager = new AdherentManager($this->_db);
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_message');
			}
			else if(isset($champs['id_adherent_from']))
			{
				$query_str = "SELECT * FROM covoiturage_message WHERE id_adherent_from=:id_adherent_from ORDER BY date DESC";
				$query = $this->_db->prepare($query_str);
				$query -> bindParam(':id_adherent_from', $champs['id_adherent_from'],PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result = $query->fetchAll();
			}
			else if(isset($champs['id_adherent_to']))
			{
				$query_str = "SELECT * FROM covoiturage_message WHERE id_adherent_to=:id_adherent_to ORDER BY date DESC";
				$query = $this->_db->prepare($query_str);
				$query -> bindParam(':id_adherent_to', $champs['id_adherent_to'],PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result = $query->fetchAll();
			}
			$list = array();

			// On ajoute au tableau de retour les objets Message créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$adhF = new Adherent();
				$adhT = new Adherent();
				$mess = new Message();
				$query = $this->_db->prepare('SELECT * FROM covoiturage_adherent WHERE id_adherent=:id_adherent_from');
				$query -> bindParam(':id_adherent_from', $value['id_adherent_from'],PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result1 = $query->fetch();
				$adhF->hydrate($result1);
				$value['adherent_from'] = $adhF;

				$query = $this->_db->prepare('SELECT * FROM covoiturage_adherent WHERE id_adherent=:id_adherent_to');
				$query -> bindParam(':id_adherent_to', $value['id_adherent_to'],PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result1 = $query->fetch();
				$adhT->hydrate($result1);
				$value['adherent_to'] = $adhT;

				$mess->hydrate($value);
				array_push($list, $mess);
			}
			return $list;
		}


	}

?>