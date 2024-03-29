<?php

	include_once 'models/Trajet.class.php';
	include_once 'models/AdherentManager.class.php';
	include_once 'models/VehiculeManager.class.php';
	include_once 'models/Trajet_CaracteristiqueManager.class.php';

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
			$resp = true;
			$tc_manager = new Trajet_CaracteristiqueManager($this->_db);
			$date = $date . ' ' . $hour . ':' . $minute;
			$query = $this->_db->prepare('INSERT INTO covoiturage_trajet(commentaire,date_traj,lieu_arrivee,lieu_depart,nb_passagers_max,id_adherent, id_vehicule, num_permis) VALUES (:commentaire, :date, :lieu_arrivee, :lieu_depart, :nb_passagers_max, :id_adherent, :id_vehicule, :num_permis)');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query -> bindParam(':date', $date,PDO::PARAM_STR);
			$query -> bindParam(':lieu_depart', $lieu_depart,PDO::PARAM_STR);
			$query -> bindParam(':lieu_arrivee', $lieu_arrivee,PDO::PARAM_STR);
			$query -> bindParam(':nb_passagers_max', $nb_passagers_max,PDO::PARAM_STR);
			$query -> bindParam(':id_adherent', $id_adherent,PDO::PARAM_STR);
			$query -> bindParam(':id_vehicule', $id_vehicule,PDO::PARAM_INT);
			$query -> bindParam(':num_permis', $num_permis,PDO::PARAM_INT);
			if(!$query->execute()): $resp = false;endif;


			//ajout des carcteristiques du trajet dans la table trajet_caracteristique
			$query = $this->_db->prepare('SELECT id_trajet FROM covoiturage_trajet ORDER BY id_trajet DESC LIMIT 0,1');
			$query->execute() or die(print_r($query->errorInfo()));
			$result = $query->fetch();

			$list = array();
			var_dump($caracteristique);
			foreach ($caracteristique as $key => $value) {
				$tc_manager->add(array('id_trajet'=>$result['id_trajet'], 'id_caracteristique'=>$value));
			}

			return $resp;
		}

		/**
		* Fonction permettant de retirer un Trajet
		**/
		function remove(array $data){
			extract($data);
			if(isset($id_trajet))
			{
				$query = $this->_db->prepare('DELETE FROM covoiturage_trajet WHERE id_trajet=:id_trajet');
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
			$vh_manager = new VehiculeManager($this->_db);
			$tcr_manager = new Trajet_CaracteristiqueManager($this->_db);
			if(isset($id_trajet))
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_trajet WHERE id_trajet=:id_trajet');
				$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));

				$result = $query->fetch();
				//Mise en forme de la date en passant par les méthodes SQL
				$this->_db->exec("SET lc_time_names = 'fr_FR';SELECT @@lc_time_names"); //On définit la locale pour la langue des jours/mois
				$query = $this->_db->prepare('SELECT YEAR(date_traj) as y, MONTHNAME(date_traj) as m, DAY(date_traj) as d, DAYNAME(date_traj) as D FROM covoiturage_trajet WHERE id_trajet=:id');
				$query -> bindParam(':id', $result['id_trajet'],PDO::PARAM_INT);
				$query->execute() or die(print_r($query->errorInfo()));
				$result2 = $query->fetch();
				//On formate la date
				$result['date'] = $result2['D'] . ' ' . $result2['d'] . ' ' . $result2['m'] . ' ' . $result2['y'];

				$geo = $this->get_geoData($result['lieu_depart'], $result['lieu_arrivee']);

				foreach ($geo as $cle => $va)
				{
					$result[$cle] = $va;
				}

				$result['conducteur'] = $mb_manager->get(array('id_adherent'=>$result['id_adherent']));

				$result['nb_passagers_rest'] = $result['nb_passagers_max'] - $this->get_rest($id_trajet);

				$result['caracteristiques'] = $tcr_manager->getList(array('id_trajet'=>$id_trajet));

				$result['vehicule'] = $vh_manager->get(array('id_vehicule'=>$result['id_vehicule']));
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

			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_trajet');
			}
			else if(isset($champs['lieu_depart'])&&isset($champs['lieu_arrivee']))
			{
				//On récupère les villes proches
				$depart = $this->getNearby($champs['lieu_depart']);
				$arrivee = $this->getNearby($champs['lieu_arrivee']);

				$query_str = "SELECT * FROM covoiturage_trajet WHERE lieu_depart REGEXP \"" . $champs['lieu_depart']; //Début de la requête.
				foreach ($depart as $key => $val) {
					if($val!="") //On vérifie que la valeur ne soit pas nulle
					{
						$query_str .= '|' . $val['nom']; // On ajoute chaque ville proche
					}
				}

				$query_str .= '" AND lieu_arrivee REGEXP "' . $champs['lieu_arrivee'];
				foreach ($arrivee as $key => $val) {
					if($val!="") //On vérifie que la valeur ne soit pas nulle
					{
						$query_str .= '|' . $val['nom'];
					}
				}

				$query_str .= "\" AND date_traj > '" . $champs['date_traj'] . ' ' . ($champs['hour']-1) . ':' . $champs['minute'] . "' AND date_traj < '" . $champs['date_traj'] . ' ' . ($champs['hour']+10) . ':' . $champs['minute'] . "' ORDER BY date_traj ASC"; //On ajoute la vérification de la date (-1h et +10h)
				$query = $this->_db->prepare($query_str);
			}
			else
			{
				$query_str = "SELECT * FROM covoiturage_trajet WHERE 1"; //Début de la requête.
				foreach ($champs as $champ => $val) {
					if($val!="") //On vérifie que la valeur ne soit pas nulle
					{
						$query_str .= ' AND ' . $champ . ' =' . $val ; // Ici on priviligie le LIKE à l'égalité pour plus de tolérance dans la saisie
					}
				}
				$query_str .= " ORDER BY date_traj ASC";
				$query = $this->_db->prepare($query_str);
			}
			$query->execute() or die(print_r($query->errorInfo()));
			$result = $query->fetchAll();

			$list = array();

			foreach ($result as $key => &$value) {
				//On créé un objet trajet pour chaque élément retourné par la requête
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
			$query = $this->_db->prepare('UPDATE covoiturage_trajets SET commentaire=:commentaire,date_traj=:Date,lieu_depart=:lieu_depart,lieu_arrivee=:lieu_arrivee,nb_passagers_max=:nb_passagers_max WHERE id_trajet=:id_trajet');
			$query -> bindParam(':commentaire', $commentaire,PDO::PARAM_STR);
			$query -> bindParam(':date', $Date,PDO::PARAM_STR);
			$query -> bindParam(':id_adherent', $id_Adherent,PDO::PARAM_STR);
			$query -> bindParam(':lieu_depart', $lieu_depart,PDO::PARAM_STR);
			$query -> bindParam(':nb_passagers_max', $nb_passagers_max,PDO::PARAM_STR);
			$query -> bindParam(':num_permis', $Num_Permis,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Retourne la distance, la durée d'un trajet et les frais calculés
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
			return array("distance"=>$distance, "time" => $time, "frais" => round($distance*0.06)); //0.06, c'est à dire 6 centimes par km
		}

		/**
		* Retourne le nombre de passagers prévus pour un trajet
		**/
		function get_rest($id_trajet)
		{
			$query = $this->_db->prepare('SELECT COUNT(id_trajet)+SUM(nb_invites) AS total FROM covoiturage_participe WHERE id_trajet=:id_trajet');
			$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			return $result['total'];
		}


		/*-------------------------------------------------------------------------------*/
		/*--------- Retourne la liste des villes dans un rayon donné -------*/
		/*-------------------------------------------------------------------------------*/

		function getNearby($ville)
		{
			$ville = urlencode($ville);
			$data = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$ville&key=AIzaSyDgvEoJJoF0I6N_Vo_3LUyhcTZUI75WR14");
			$data = json_decode($data);
			$lat = $data->results[0]->geometry->location->lat;
			$lng = $data->results[0]->geometry->location->lng;

			$type = 'cities';
			$limit = 10; //nombre de villes
			$distance = 10; //rayon

			// Rayon de la Terre
			$radius = 6371.009; // en km

			// Bornes latitudes
			$maxLat = (float) $lat + rad2deg($distance / $radius);
			$minLat = (float) $lat - rad2deg($distance / $radius);

			// Bornes longitude
			$maxLng = (float) $lng + rad2deg($distance / $radius / cos(deg2rad((float) $lat)));
			$minLng = (float) $lng - rad2deg($distance / $radius / cos(deg2rad((float) $lat)));

			// Récupération des résultat par distance
			$query = $this->_db->prepare('SELECT ville_nom_reel AS nom FROM covoiturage_villes WHERE lat > :minLat AND lat < :maxLat AND lng > :minLng AND lng < :maxLng ORDER BY ABS(lat - :lat) + ABS(lng - :lng) ASC LIMIT :limit');
			$query -> bindParam(':minLat', $minLat,PDO::PARAM_INT);
			$query -> bindParam(':maxLat', $maxLat,PDO::PARAM_INT);
			$query -> bindParam(':minLng', $minLng,PDO::PARAM_INT);
			$query -> bindParam(':maxLng', $maxLng,PDO::PARAM_INT);
			$query -> bindParam(':lat', $lat,PDO::PARAM_STR);
			$query -> bindParam(':lng', $lng,PDO::PARAM_STR);
			$query -> bindParam(':limit', $limit,PDO::PARAM_INT);
			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetchAll();
			return $result;
		}

	}

?>

