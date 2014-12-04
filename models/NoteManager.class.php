<?php

	include_once 'models/Note.class.php';
	include_once 'models/Adherant.class.php';
	
	/**
	* Class de gestion Note
	*/
	class NoteManager
	{
		private $_db;
		public $NoManager;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
			$this->NoManager = new NoteManager($db);
		}

		/**
		* Fonction permettant d'ajouter une Note
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO Note(id_AdherantE,id_AdherantR,date,commentaire) VALUES (:id_AdherantE,:id_AdherantR,:date,:commentaire)');
			$query -> bindParam(':id_note', $id_note,PDO::PARAM_STR);
			$query -> bindParam(':id_AdherantE', $id_AdherantE,PDO::PARAM_STR);
			$query -> bindParam(':id_AdherantR', $id_AdherantR,PDO::PARAM_STR);
			$query -> bindParam(':date', $date,PDO::PARAM_STR);
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un commentaire
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_note))
			{
				$query = $this->_db->prepare('DELETE FROM Note WHERE id_note=:id_note');
				$query -> bindParam(':id_note', $id_note,PDO::PARAM_INT);
			}
		
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Note. 
		**/
		function get(array $data){
			extract($data);
			if(isset($id_note))
			{
				$query = $this->_db->prepare('SELECT * FROM Note WHERE id_note=:id_note');
				$query -> bindParam(':id_note', $id_note,PDO::PARAM_INT);
			}
			

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['Note'] = $this->NoManager->get(array("id_note"=>$result['Note']));
			$Note = new Note();
			$Note->hydrate($result);
			return $Note;
		}

		/**
		* Fonction permettant d'obtenir une liste des Note
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM Note');
			}
			else
			{
				$query_str = "SELECT * FROM Note WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets Note créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$Note = new Note();
				$value['Note'] = $this->AdManager->get(array("id"=>$value['Note']));
				$Note->hydrate($value);
				array_push($list, $Note);
			}
			return $list;
		}
		
		/**
		* Fonction permettant de mettre à jour une note
		**/
		function update($Note){
			extract($Note);
			$query = $this->_db->prepare('UPDATE note SET commentaire=:commentaire,note=:note,WHERE id_note=:id_note');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query -> bindParam(':note', $note,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		
	}

?>