<?php

	include_once 'models/Adherent.class.php';

	/**
	* Classe de gestion des adherent
	*/
	class AdherentManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un Adherent
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
		* Fonction permettant de retirer un Adherent
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Adherent))
			{
				$query = $this->_db->prepare('DELETE FROM adherent WHERE id_adherent=:id_adherent');
				$query -> bindParam(':id_adherent', $id_Adherent,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('DELETE FROM adherent WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Adherent. Paramètre: array contenant soit id_Adherent=>$id_Adherent soit nom=>$nom (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);
			if(isset($id_adherent))
			{
				$query = $this->_db->prepare('SELECT * FROM adherent WHERE id_adherent=:id_adherent');
				$query -> bindParam(':id_adherent', $id_adherent,PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));

				$result = $query->fetch();
			}
			else if(isset($mail))
			{
				$query = $this->_db->prepare('SELECT * FROM adherent WHERE mail=:mail && password=:pwd');
				$query -> bindParam(':mail', $mail,PDO::PARAM_STR);
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
				$adherent = new adherent();
				$adherent->hydrate($result);
			}
			else
			{
				$adherent = false;
			}
			return $adherent;
		}

		/**
		* Fonction permettant d'obtenir une liste des adherent
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM adherent');
			}
			else
			{
				$query_str = "SELECT * FROM adherent WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
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

			// On ajoute au tableau de retour les objets adherent créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$adherent = new adherent();
				$value['adherent'] = $this->AdManager->get(array("id_adherent"=>$value['adherent']));
				$adherent->hydrate($value);
				array_push($list, $adherent);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un adherent
		**/
		function update($adherent){
			//extract($adherent);
			$query = $this->_db->prepare('UPDATE adherent SET nom=:nom,prenom=:prenom,sexe=:sexe,telephone=:telephone,date_naissance=:dateNaiss,mail=:mail,password=:password WHERE id_adherent=:id_adherent');
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