<?php

	include_once 'models/Trajet.class.php';
	include_once 'models/Participe.class.php';
	
	/**
	* Classe de gestion des trajets
	*/
	class TrajetManager
	{
		private $_db;
		public $trManager;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
		}

		/**
		* Fonction permettant d'ajouter un Trajet
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO trajet(commentaire,Date,Lieu_arrive,Lieu_Depart,Nb_Passagers_Max) VALUES (:commentaire, :Date, :Lieu_arrive, :Lieu_Depart, :Nb_Passagers_Max)');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query -> bindParam(':Date', $Date,PDO::PARAM_STR);
			$query -> bindParam(':Lieu_Depart', $Lieu_Depart,PDO::PARAM_STR);
			$query -> bindParam(':Lieu_arrivee', $Lieu_arrivee,PDO::PARAM_STR);
			$query -> bindParam(':Nb_Passagers_Max', $Nb_Passagers_Max,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Trajet
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Trajet))
			{
				$query = $this->_db->prepare('DELETE FROM trajet WHERE id_Trajet=:id_Trajet');
				$query -> bindParam(':id_Trajet', $id_Trajet,PDO::PARAM_INT);
			}
			
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Trajet.
		**/
		function get(array $data){
			extract($data);
			if(isset($id_Trajet))
			{
				$query = $this->_db->prepare('SELECT * FROM trajet WHERE id_Trajet=:id_Trajet');
				$query -> bindParam(':id_Trajet', $id_Trajet,PDO::PARAM_INT);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			//On vérifie si la requête a bien retourné un trajet
			if(!empty($result))
			{
				$trajet = new Trajet();
				$trajet->hydrate($result);
			}
			else
			{
				$trajet = false;
			}
			return $trajet;
		}
		}

		/**
		* Fonction permettant d'obtenir une liste des trajets
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre.

			$mb_manager = new AdherantManager($this->_db);

			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM trajet');
			}
			else
			{
				$query_str = "SELECT * FROM trajet WHERE 1"; //Début de la requête.
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

				foreach ($result as $key => &$value) {
					$value['trajet'] = $this->trManager->get(array('id_Trajet'=>$value['Id_Trajet']));

					$trajet->hydrate($value);
					array_push($list, $trajet);
				}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un trajet
		**/
		function update($trajet){
			extract($trajet);
			$query = $this->_db->prepare('UPDATE trajets SET commentaire=:commentaire,Date=:Date,Lieu_Depart=:Lieu_Depart,Lieu_arrivee=:Lieu_arrivee,Nb_Passagers_Max=:Nb_Passagers_Max WHERE id_Trajet=:id_Trajet');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query -> bindParam(':Date', $Date,PDO::PARAM_STR);
			$query -> bindParam(':id_Adherant', $id_Adherant,PDO::PARAM_STR);
			$query -> bindParam(':Lieu_Depart', $Lieu_Depart,PDO::PARAM_STR);
			$query -> bindParam(':Nb_Passagers_Max', $Nb_Passagers_Max,PDO::PARAM_STR);
			$query -> bindParam(':Num_Permis', $Num_Permis,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
		
	

?>

