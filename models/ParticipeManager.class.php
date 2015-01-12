<?php
	include_once('models/AdherentManager.class.php');
	include_once('models/TrajetManager.class.php');
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

			$ad_manager = new AdherentManager($this->_db);
			$tr_manager = new TrajetManager($this->_db);

			$frais = $frais * ($nb_invites+1);
			$query = $this->_db->prepare('INSERT INTO covoiturage_participe(id_adherent, id_trajet,nb_invites,frais) VALUES (:id_adherent, :id_trajet,:nb_invites, :frais)');
			$query -> bindParam(':id_adherent', $id_adherent,PDO::PARAM_INT);
			$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
			$query -> bindParam(':nb_invites', $nb_invites,PDO::PARAM_INT);
			$query -> bindParam(':frais', $frais,PDO::PARAM_INT);
			if($query->execute())
			{
				$adh = $ad_manager->get(array("id_adherent"=>$id_adherent));
				$tr = $tr_manager->get(array("id_trajet"=>$id_trajet));
				$this->send_mail(array("adherent"=>$adh,"trajet"=>$tr,"frais"=>$frais));
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
		* Fonction permettant de retirer un Participe
		**/
		function remove(array $data){
			extract($data);
			$ad_manager = new AdherentManager($this->_db);
			$tr_manager = new TrajetManager($this->_db);
			if(isset($id_trajet))
			{
				$query = $this->_db->prepare('DELETE FROM covoiturage_participe WHERE id_trajet=:id_trajet AND id_adherent=:id_adherent');
				$query -> bindParam(':id_adherent', $_SESSION['id'],PDO::PARAM_INT);
				$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_INT);
			}

			if($query->execute())
			{
				$adh = $ad_manager->get(array("id_adherent"=>$_SESSION['id']));
				$tr = $tr_manager->get(array("id_trajet"=>$id_trajet));
				$this->send_mail2(array("adherent"=>$adh,"trajet"=>$tr));
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
		* Fonction permettant de récupérer un Participe. Paramètre: array contenant soit id=>$id soit nom=>$nom (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			include_once 'models/Participe.class.php';
			extract($data);
			if(isset($id_trajet))
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_participe WHERE id_trajet=:id_trajet');
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
			include_once 'models/TrajetManager.class.php';
			include_once 'models/Participe.class.php';
			include_once 'models/AdherentManager.class.php';
			include_once 'models/VehiculeManager.class.php';
			$mb_manager = new AdherentManager($this->_db);
			$tr_manager = new TrajetManager($this->_db);
			$vh_manager = new VehiculeManager($this->_db);
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM covoiturage_participe');
			}
			else
			{
				$query_str = "SELECT * FROM covoiturage_participe INNER JOIN covoiturage_trajet ON covoiturage_trajet.id_trajet = covoiturage_participe.id_trajet WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
				foreach ($champs as $champ => $val) {
					if($val!="") //On vérifie que la valeur ne soit pas nulle
					{
						$query_str .= ' AND covoiturage_participe.' . $champ . '=' . $val ; // Ici on priviligie le LIKE à l'égalité pour plus de tolérance dans la saisie
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
				$trajet = $tr_manager->get(array('id_trajet'=>$value['id_trajet']));
				$value = array_merge($value, $trajet->dump());
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
			$query = $this->_db->prepare('UPDATE covoiturage_participe SET nb_invites = :nb_invites,frais=:frais,WHERE id_trajet=:id_trajet');
			$query -> bindParam(':id_participe', $id_participe,PDO::PARAM_INT);
			$query -> bindParam(':id_trajet', $id_trajet,PDO::PARAM_STR);
			$query -> bindParam(':nb_invites', $nb_invites,PDO::PARAM_STR);
			$query -> bindParam(':frais', $frais,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Envoie un mail de confirmation
		**/
		function send_mail($champs){
			 $message = "
			<html>
			<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\">
			  <title>Confirmation de réservation</title>
			</head>
			<body>
			<div style=\"display:inline-block;width:100%;text-align:center\">
			    <a href=\"http://www.thomasboulongne.fr\"  style=\"margin:5px;text-align:center\"><img src=\"http://thomasboulongne.com/logo.png\" style=\"width:200px\"></a>
			</div>
			<h2>Confirmation de réservation</h2>
			  <p>Votre réservation pour le trajet de <b>" . $champs['trajet']->lieu_depart() . " à " . $champs['trajet']->lieu_arrivee() . ", le " . date('d/m/y', strtotime($champs['trajet']->date_traj())) . " à " . date('H:i', strtotime($champs['trajet']->date_traj())) . " est confirmée. Le montant total est de ". $champs['frais'] ."€</p>
			<p>À bientôt sur Covoiturage !</p>
			<p style=\"font-style:italic\">Ceci est un mail automatique, merci de ne pas y répondre. Vous pouvez nous contacter à l'adresse <a href=\"mailto:contact@thomasboulongne.com\">contact@covoiturage.fr</a>.</p>
			</body>
			</html>
			";
			$subject = "Confirmation de votre réservation";

			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset: ISO-8859-1\r\n";
			$headers .= 'From: Covoiturage <confirmation@covoiturage.fr>' . "\r\n";

			// Mail it
			mail($champs['adherent']->mail(), $subject, $message, $headers);
		}

		/**
		* Envoie un mail de confirmation
		**/
		function send_mail2($champs){
			 $message = "
			<html>
			<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\">
			  <title>Confirmation d'annulation</title>
			</head>
			<body>
			<div style=\"display:inline-block;width:100%;text-align:center\">
			    <a href=\"http://www.thomasboulongne.fr\"  style=\"margin:5px;text-align:center\"><img src=\"http://thomasboulongne.com/logo.png\" style=\"width:200px\"></a>
			</div>
			<h2>Confirmation d'annulation</h2>
			  <p>Votre réservation pour le trajet de <b>" . $champs['trajet']->lieu_depart() . " à " . $champs['trajet']->lieu_arrivee() . ", le " . date('d/m/y', strtotime($champs['trajet']->date_traj())) . " à " . date('H:i', strtotime($champs['trajet']->date_traj())) . " est annulée. </p>
			<p>À bientôt sur Covoiturage !</p>
			<p style=\"font-style:italic\">Ceci est un mail automatique, merci de ne pas y répondre. Vous pouvez nous contacter à l'adresse <a href=\"mailto:contact@thomasboulongne.com\">contact@covoiturage.fr</a>.</p>
			</body>
			</html>
			";
			$subject = "Confirmation de votre annulation";

			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset: ISO-8859-1\r\n";
			$headers .= 'From: Covoiturage <confirmation@covoiturage.fr>' . "\r\n";

			// Mail it
			mail($champs['adherent']->mail(), $subject, $message, $headers);
		}
	}

?>