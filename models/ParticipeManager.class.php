<?php

	include_once 'models/Participe.class.php';
	include_once 'models/AdherentManager.class.php';

	/**
	* Classe de gestion des participants
	*/
	class ParticipeManager
	{
		private $_db;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un Participant
		**/
		function add(array $data){
			extract($data);
			var_dump($data);
			$query = $this->_db->prepare('INSERT INTO participe(id_adherent, id_trajet,nb_invites,frais) VALUES (:id_adherent, :id_trajet,:nb_invites, :frais)');
			$query -> bindParam(':id_adherent', $id_adherent,PDO::PARAM_INT);
			$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
			$query -> bindParam(':nb_invites', $nb_invites,PDO::PARAM_INT);
			$query -> bindParam(':frais', $frais,PDO::PARAM_INT);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Participe
		**/
		function remove(array $data){
			extract($data);
			if(isset($id))
			{
				$query = $this->_db->prepare('DELETE FROM participe WHERE id_trajet=:id_trajet');
				$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
			}

			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Participe. Paramètre: array contenant soit id=>$id soit nom=>$nom (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);
			if(isset($id_trajet))
			{
				$query = $this->_db->prepare('SELECT * FROM participe WHERE id_trajet=:id_trajet');
				$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['participe'] = $this->AdManager->get(array("id_trajet"=>$result['participe']));
			$participe = new Participe();
			$participe->hydrate($result);
			return $participe;
		}

		/**
		* Fonction permettant d'obtenir une liste des participants
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			$mb_manager = new AdherentManager($this->_db);
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM participe');
			}
			else
			{
				$query_str = "SELECT * FROM trajet INNER JOIN participe ON trajet.id_trajet = participe.id_trajet WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
				foreach ($champs as $champ => $val) {
					if($val!="") //On vérifie que la valeur ne soit pas nulle
					{
						$query_str .= ' AND participe.' . $champ . ' LIKE "%' . $val . '%"'; // Ici on priviligie le LIKE à l'égalité pour plus de tolérance dans la saisie
					}
				}

				$query_str .= ' ORDER BY date_traj DESC';

				$query = $this->_db->prepare($query_str);
			}
			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetchAll();
			$list = array();

			// On ajoute au tableau de retour les objets participe créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$participe = new Participe();
				$query = $this->_db->prepare('SELECT Prenom, Nom FROM adherent WHERE Id_Adherent=:id');
				$query -> bindParam(':id', $value['id_adherent'],PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result2 = $query->fetch();

				$value['conducteur'] = $mb_manager->get(array('id_adherent'=>$value['id_adherent']));
				$participe->hydrate($value);
				array_push($list, $participe);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour participe
		**/
		function update($participe){
			extract($participe);
			$query = $this->_db->prepare('UPDATE participe SET nb_invites = :nb_invites,frais=:frais,WHERE id_trajet=:id_trajet');
			$query -> bindParam(':id_participe', $id_participe,PDO::PARAM_INT);
			$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_STR);
			$query -> bindParam(':nb_invites', $nb_invites,PDO::PARAM_STR);
			$query -> bindParam(':frais', $frais,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>