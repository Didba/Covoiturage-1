<?php

	include_once 'models/Trajet.class.php';
	include_once 'models/Participe.class.php';
	include_once'models/AdherentManager.class.php';

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
			$query = $this->_db->prepare('INSERT INTO trajet(commentaire,date_traj,lieu_arrivee,lieu_depart,nb_passagers_max,id_adherent) VALUES (:commentaire, :date, :lieu_arrivee, :lieu_depart, :nb_passagers_max, :id_adherent)');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query -> bindParam(':date', $date,PDO::PARAM_STR);
			$query -> bindParam(':lieu_depart', $Lieu_Depart,PDO::PARAM_STR);
			$query -> bindParam(':lieu_arrivee', $Lieu_arrivee,PDO::PARAM_STR);
			$query -> bindParam(':nb_passagers_max', $Nb_Passagers_Max,PDO::PARAM_STR);
			$query -> bindParam(':id_adherent', $Id_Adherent,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Trajet
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_Trajet))
			{
				$query = $this->_db->prepare('DELETE FROM trajet WHERE id_trajet=:id_trajet');
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
				$query = $this->_db->prepare('SELECT * FROM trajet WHERE id_trajet=:id_trajet');
				$query -> bindParam(':id_trajet', $id_Trajet,PDO::PARAM_INT);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			//On vérifie si la requête a bien retourné un trajet

			$geo = $this->get_geoData($result['lieu_depart'], $result['lieu_arrivee']);

			$result['time'] = $geo['time'];
			$result['distance'] = $geo['distance'];

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

			$mb_manager = new AdherentManager($this->_db);
			$champs['date_traj'] = $champs['date'];
			unset($champs['date']);

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
					//Mise en forme de la date en passant par les méthodes SQL
					$this->_db->exec("SET lc_time_names = 'fr_FR';SELECT @@lc_time_names"); //On définit la locale pour la langue des jours/mois
					$query = $this->_db->prepare('SELECT YEAR(date_traj) as y, MONTHNAME(date_traj) as m, DAY(date_traj) as d, DAYNAME(date_traj) as D FROM trajet WHERE id_trajet=:id');
					$query -> bindParam(':id', $value['id_trajet'],PDO::PARAM_INT);
					$query->execute() or die(print_r($query->errorInfo()));
					$result2 = $query->fetch();
					$value['date'] = $result2['D'] . ' ' . $result2['d'] . ' ' . $result2['m'] . ' ' . $result2['y'];

					$trajet = new Trajet();
					if(isset($value['Trajet_Caracteristique']))
					{
						$value['Trajet_Caracteristique'] = $this->caManager->get(array("id_trajet"=>$value['Trajet_Caracteristique']));
					}
					$query = $this->_db->prepare('SELECT Prenom, Nom FROM adherent WHERE Id_Adherent=:id');
					$query -> bindParam(':id', $value['id_adherent'],PDO::PARAM_INT);
					$query->execute() or die(print_r($query->errorInfo()));
					$result2 = $query->fetch();


					$geo = $this->get_geoData($value['lieu_depart'], $value['lieu_arrivee']);

					foreach ($geo as $cle => $va) {
						$value[$cle] = $va;
					}

					$value['conducteur'] = $mb_manager->get(array('id_adherent'=>$value['id_adherent']));
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
			$query = $this->_db->prepare('UPDATE trajets SET commentaire=:commentaire,date_traj=:Date,lieu_depart=:lieu_depart,lieu_arrivee=:lieu_arrivee,nb_passagers_max=:nb_passagers_max WHERE id_trajet=:id_trajet');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query -> bindParam(':date', $Date,PDO::PARAM_STR);
			$query -> bindParam(':id_adherent', $id_Adherent,PDO::PARAM_STR);
			$query -> bindParam(':lieu_depart', $Lieu_Depart,PDO::PARAM_STR);
			$query -> bindParam(':nb_passagers_max', $Nb_Passagers_Max,PDO::PARAM_STR);
			$query -> bindParam(':num_permis', $Num_Permis,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Retourne la distance et la durée d'un trajet
		**/
		function get_geoData($from,$to){

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

	}

?>

