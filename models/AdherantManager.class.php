<?php

	include_once 'models/Adherant.class.php';

	/**
	* Classe de gestion des adherant
	*/
	class AdherantManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un Adherant
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO adherent(nom,prenom,sexe,telephone,date_naissance,mail,password) VALUES (:nom, :prenom, :sexe, :telephone, :dateNaiss, :mail, :password)');
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query -> bindParam(':prenom', $prenom,PDO::PARAM_STR);
			$query -> bindParam(':sexe', $sexe,PDO::PARAM_STR);
			$query -> bindParam(':telephone', $telephone,PDO::PARAM_STR);
			$query -> bindParam(':dateNaiss', $dateNaiss,PDO::PARAM_STR);
			$query -> bindParam(':mail', $mail,PDO::PARAM_STR);
			$query -> bindParam(':password', $password,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Adherant
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Adherant))
			{
				$query = $this->_db->prepare('DELETE FROM adherant WHERE id_Adherant=:id_Adherant');
				$query -> bindParam(':id_Adherant', $id_Adherant,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('DELETE FROM adherant WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Adherant. Paramètre: array contenant soit id_Adherant=>$id_Adherant soit nom=>$nom (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);
			if(isset($id_adherent))
			{
				$query = $this->_db->prepare('SELECT * FROM adherent WHERE id_Adherent=:id_Adherent');
				$query -> bindParam(':id_Adherent', $id_adherent,PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));

				$result = $query->fetch();
			}
			else if(isset($mail))
			{
				$query = $this->_db->prepare('SELECT * FROM adherent WHERE Mail=:Mail && Password=:pwd');
				$query -> bindParam(':Mail', $mail,PDO::PARAM_STR);
				$query -> bindParam(':pwd', $pwd,PDO::PARAM_STR);
				$query->execute() or die(print_r($query->errorInfo()));

				$result = $query->fetch();
			}
			else
			{
				$_SESSION['msg'] = 'Adherent get échoué';
			}

			//On vérifie si la requête a bien retourné un utilisateur
			if(!empty($result))
			{
				$adherant = new Adherant();
				$adherant->hydrate($result);
			}
			else
			{
				$adherant = false;
			}
			return $adherant;
		}

		/**
		* Fonction permettant d'obtenir une liste des adherant
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM adherant');
			}
			else
			{
				$query_str = "SELECT * FROM adherant WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets adherant créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$adherant = new Adherant();
				$value['adherant'] = $this->AdManager->get(array("id_Adherant"=>$value['adherant']));
				$adherant->hydrate($value);
				array_push($list, $adherant);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un adherant
		**/
		function update($adherant){
			extract($adherant);
			$query = $this->_db->prepare('UPDATE adherant SET nom=:nom,prenom=:prenom,sexe=:sexe,telephone=:telephone,dateNaiss=:dateNaiss,mail=:mail,password=:password WHERE id_Adherant=:id_Adherant');
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query -> bindParam(':prenom', $prenom,PDO::PARAM_STR);
			$query -> bindParam(':sexe', $sexe,PDO::PARAM_STR);
			$query -> bindParam(':telephone', $telephone,PDO::PARAM_STR);
			$query -> bindParam(':dateNaiss', $dateNaiss,PDO::PARAM_STR);
			$query -> bindParam(':mail', $mail,PDO::PARAM_STR);
			$query -> bindParam(':password', $password,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>