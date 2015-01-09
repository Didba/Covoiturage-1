<?php

	include_once 'models/Trajet.class.php';
	include_once 'models/AdherentManager.class.php';

	/**
	* Classe de gestion des trajets
	*/
	class TrajetManager
	{
		private $_db;

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
			$date = $date . ' ' .$heure;
			$query = $this->_db->prepare('INSERT INTO trajet(commentaire,date_traj,lieu_arrivee,lieu_depart,nb_passagers_max,id_adherent) VALUES (:commentaire, :date, :lieu_arrivee, :lieu_depart, :nb_passagers_max, :id_adherent)');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query -> bindParam(':date', $date,PDO::PARAM_STR);
			$query -> bindParam(':lieu_depart', $lieu_depart,PDO::PARAM_STR);
			$query -> bindParam(':lieu_arrivee', $lieu_arrivee,PDO::PARAM_STR);
			$query -> bindParam(':nb_passagers_max', $nb_passagers_max,PDO::PARAM_STR);
			$query -> bindParam(':id_adherent', $Id_Adherent,PDO::PARAM_STR);
			return $query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Trajet
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_trajet))
			{
				$query = $this->_db->prepare('DELETE FROM trajet WHERE id_trajet=:id_trajet');
				$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
				return $query->execute() or die(print_r($query->errorInfo()));
			}
			return false;
		}

		/**
		* Fonction permettant de récupérer un Trajet.
		**/
		function get(array $data){
			extract($data);
			$mb_manager = new AdherentManager($this->_db);
			if(isset($id_trajet))
			{
				$query = $this->_db->prepare('SELECT * FROM trajet WHERE id_trajet=:id_trajet');
				$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));

				$result = $query->fetch();
				//Mise en forme de la date en passant par les méthodes SQL
				$this->_db->exec("SET lc_time_names = 'fr_FR';SELECT @@lc_time_names"); //On définit la locale pour la langue des jours/mois
				$query = $this->_db->prepare('SELECT YEAR(date_traj) as y, MONTHNAME(date_traj) as m, DAY(date_traj) as d, DAYNAME(date_traj) as D FROM trajet WHERE id_trajet=:id');
				$query -> bindParam(':id', $result['id_trajet'],PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result2 = $query->fetch();
				$result['date'] = $result2['D'] . ' ' . $result2['d'] . ' ' . $result2['m'] . ' ' . $result2['y'];

				if(isset($result['Trajet_Caracteristique']))
				{
					$result['Trajet_Caracteristique'] = $this->caManager->get(array("id_trajet"=>$result['Trajet_Caracteristique']));
				}

				$query = $this->_db->prepare('SELECT Prenom, Nom FROM adherent WHERE Id_Adherent=:id');
				$query -> bindParam(':id', $result['id_adherent'],PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result2 = $query->fetch();

				$geo = $this->get_geoData($result['lieu_depart'], $result['lieu_arrivee']);

				foreach ($geo as $cle => $va)
				{
					$result[$cle] = $va;
				}

				$result['conducteur'] = $mb_manager->get(array('id_adherent'=>$result['id_adherent']));

				$result['nb_passagers_rest'] = $result['nb_passagers_max'] - $this->get_rest($id_trajet);
			}

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

		/**
		* Fonction permettant d'obtenir une liste des trajets
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre.
			if(isset($champs['date'])):
				$champs['date_traj'] = $champs['date'];
				unset($champs['date']);
			endif;

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
				$query_str .= " ORDER BY date_traj DESC";
				$query = $this->_db->prepare($query_str);
			}
			$query->execute() or die(print_r($query->errorInfo()));
			$result = $query->fetchAll();

			$list = array();

			foreach ($result as $key => &$value) {
				$trajet = $this->get(array("id_trajet"=>$value['id_trajet']));
				array_push($list, $trajet);
			}

			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un trajet
		**/
		function update($trajet){
			extract($trajet);
			$query = $this->_db->prepare('UPDATE trajets SET commentaire=:commentaire,date_traj=:Date,lieu_depart=:lieu_depart,lieu_arrivee=:lieu_arrivee,nb_passagers_max=:nb_passagers_max WHERE id_trajet=:id_trajet');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query -> bindParam(':date', $Date,PDO::PARAM_STR);
			$query -> bindParam(':id_adherent', $id_Adherent,PDO::PARAM_STR);
			$query -> bindParam(':lieu_depart', $lieu_depart,PDO::PARAM_STR);
			$query -> bindParam(':nb_passagers_max', $nb_passagers_max,PDO::PARAM_STR);
			$query -> bindParam(':num_permis', $Num_Permis,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Retourne la distance et la durée d'un trajet
		**/
		function get_geoData($from,$to)
		{
			$from = urlencode($from);
			$to = urlencode($to);
			$data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=fr-FR&sensor=false");
			$data = json_decode($data);
			$time = 0;
			$distance = 0;
			foreach($data->rows[0]->elements as $road) {
				$time += $road->duration->value;
				$distance += $road->distance->text;
			}
			return array("distance"=>$distance, "time" => $time, "frais" => round($distance*0.06));
		}

		/**
		* Retourne la distance et la durée d'un trajet
		**/
		function get_rest($id_trajet)
		{
			$query = $this->_db->prepare('SELECT COUNT(id_trajet)+SUM(nb_invites) AS total FROM participe WHERE id_trajet=:id_trajet');
			$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			return $result['total'];
		}

	}

?>

