<?php
session_start();
/*--------------------------------------------------------------------------------------------------------*/
/*--------------Ceci est le super controlleur (et même unique controlleur ici) -----------*/
/*------------ Il se charge de récupérer toute donnée transmise, et de traiter ----------*/
/*--------------- chaque demande par le biais des modèles correspondants -----------*/
/*--------------------------------------------------------------------------------------------------------*/

	include_once 'config/connexion.php';
	include_once 'Action.class.php';
	include_once 'models/Manager.class.php';

	$managerMaker = new Manager($db);
	//On vérifie si l'utilisateur désire une page particulière

	if(isset($_GET)):extract($_GET);endif;

	/*-------------------------------------------------------------------------------*/
	/*--------------- Vérification si l'utilisateur est un admin -------------*/
	/*-------------------------------------------------------------------------------*/
	if(isset($application)&&isset($apptype))
	{
		//index.php?apptype=Action&application=Supp_trajet&id=152

		// $manager = array_reverse(explode('_', $application))[0] . 'Manager';
		// $manager = new $manager($db);

		if($apptype=="Action")
		{
			if(isset($_POST))
			{
				$POST = true;
				extract($_POST);
			}
			$actionStr = "Action" . $application;
			if(isset($id)&&$POST):$actionStr = new $action($manager, $application, $id, $_POST);
			elseif(isset($id)):$actionStr = new $action($manager, $application, $id);
			endif;
			$action->setStr();
			$action->exec();
		}

		//index.php?apptype=Display&application=trajets&id=152
		else if($apptype=="Display")
		{
			if(isset($_GET))
			{
				$GET = true;
				extract($_GET);
			}
			$actionStr = "Display" . $application;
			if(isset($id)&&$POST):$actionStr = new $action($manager, $application, $id, $_POST);
			elseif(isset($id)):$actionStr = new $action($manager, $application, $id);
			endif;
		}


		if (isset($_SESSION['admin']))
		{
			//Analyse de la page désirée




			switch ($application)
			{

				/*-------------------------------------------------------*/
				/*--- AFFICHAGE DES TRAJETS - ADMIN --*/
				/*-------------------------------------------------------*/
				case 'trajets':

					include_once 'views/admin/v_trajets.class.php';
					//On instancie alors la page correspondante
					$page = new v_trajets("Liste des trajets");
					$page->set_html($traj_manager->getList());
					break;

				/*-------------------------------------------------------*/
				/*--- AFFICHAGE D'UN TRAJET PRÉCIS -- */
				/*-------------------------------------------------------*/
				case 'trajet':
					//On vérifie si un ID a bien été fourni
					if(isset($id))
					{
						include_once 'views/admin/v_trajet.class.php';
						$page = new v_trajet("Trajet " + $id);
						$page->set_html($traj_manager->getTrajet($id));
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez demander un trajet valide';
						header('Location: index.php?action=trajets');
					}
					break;

				/*-------------------------------------------------------*/
				/*-------- AFFICHAGE DES MEMBRES -------*/
				/*-------------------------------------------------------*/
				case 'membres':

					include_once 'views/admin/v_membres.class.php';
					//On instancie alors la page correspondante
					$page = new v_membres("Liste des membres");
					$page->set_html($mb_manager->getList());
					break;

				/*-------------------------------------------------------*/
				/*--- AFFICHAGE D'UN MEMBRE PRÉCIS-- */
				/*-------------------------------------------------------*/
				case 'membre':
					//On vérifie si un ID a bien été fourni
					if(isset($id))
					{
						include_once 'views/admin/v_membre.class.php';
						$page = new v_membre("Membre " + $id);
						$page->set_html($mb_manager->getMembre($id));
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez demander un membre valide';
						header('Location: index.php?action=membres');
					}
					break;

				/*-------------------------------------------------------------------------------*/
				/*------------------- SUPPRESSION D'UN TRAJET -----------------*/
				/*-------------------------------------------------------------------------------*/
				case 'supp_trajet':
					//On vérifie si un id a bien été fourni
					if(isset($id))
					{
						if($traj_manager->remove($id))
						{
							$_SESSION['msg'] = 'Le trajet a bien été supprimé';
						}
						else
						{
							$_SESSION['msg'] = 'La suppression du trajet a échoué';
						}
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez supprimer un trajet valide';
					}

					header('Location: index.php?action=trajets');

					break;

				/*-------------------------------------------------------------------------------*/
				/*------------------- SUPPRESSION D'UN MEMBRE -----------------*/
				/*-------------------------------------------------------------------------------*/
				case 'supp_membre':
					//On vérifie si un id a bien été fourni
					if(isset($id))
					{
						if($mb_manager->remove($id))
						{
							$_SESSION['msg'] = 'Le membre a bien été supprimé';
						}
						else
						{
							$_SESSION['msg'] = 'La suppression du membre a échoué';
						}
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez supprimer un membre valide';
					}

					header('Location: index.php?action=membres');

					break;

				/*-------------------------------------------------------------------------------*/
				/*------------- ENVOI D'UN MESSAGE À UN MEMBRE -----------*/
				/*-------------------------------------------------------------------------------*/
				case 'message':
					//On vérifie si le formulaie du message a été envoyé
					if (isset($form_message)) {
						if($msg_manager->add($_POST, 0))
						{
							$_SESSION['msg'] = 'Votre message a bien été envoyé.';
						}
						else
						{
							$_SESSION['msg'] = 'L\'envoi du message a échoué';
						}
						header('Location: index.php?action=membres');
					}
					else if(isset($id))
					{
						include_once 'views/admin/v_newMessage.class.php';
						$page = new v_newMessage("Nouveau message");
						$page->set_html($mb_manager->getMembre($id));
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez demander un membre valide';
						header('Location: index.php?action=membres');
					}
					break;

				/*-------------------------------------------------------------------------------*/
				/*--------------------------- DÉCONNEXION -------------------------*/
				/*-------------------------------------------------------------------------------*/
				case 'deconnexion':
					session_destroy();
					header('Location: index.php');
					break;

				default:
					include_once 'views/admin/v_index.class.php';
					//On instancie alors la page correspondante
					$page = new v_index("Accueil administrateur");
					$page->set_html();
					break;

			}//if(switch)
		}//if(admin)

		/*-------------------------------------------------------------------------------*/
		/*--------------------------- Utilisateur connecté -------------------------*/
		/*-------------------------------------------------------------------------------*/

		else if(isset($_SESSION['login'])&&isset($_SESSION['id']))
		{
			include_once 'models/ReservationsManager.class.php';
			$res_manager = new MsgManager($db);

			switch ($application) {
				/*-------------------------------------------------------------------------------*/
				/*----------------------- AFFICHAGE DU PROFIL ----------------------*/
				/*-------------------------------------------------------------------------------*/

				case 'profil':
					include_once 'views/user/v_profile.class.php';
					//On instancie alors la page correspondante
					$page = new v_trajets("Mon profil");
					$page->set_user($mb_manager->get($_SESSION['id']));
					$page->set_html($mb_manager->getMembre($_SESSION['id']));

					break;

				/*-------------------------------------------------------*/
				/*--- AFFICHAGE DES TRAJETS - USER --*/
				/*-------------------------------------------------------*/
				case 'trajets':

					include_once 'views/user/v_trajets.class.php';
					//On instancie alors la page correspondante
					$page = new v_trajets("Liste des trajets");
					$page->set_user($mb_manager->get($_SESSION['id']));
					$page->set_html($traj_manager->getList());
					break;

				/*-------------------------------------------------------*/
				/*--- AFFICHAGE D'UN TRAJET PRÉCIS-- */
				/*-------------------------------------------------------*/
				case 'trajet':
					//On vérifie si un ID a bien été fourni
					if(isset($id))
					{
						include_once 'views/user/v_trajet.class.php';
						$page = new v_trajet("Trajet " + $id);
						$page->set_user($mb_manager->get($_SESSION['id']));
						$page->set_html($traj_manager->getTrajet($id));
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez demander un trajet valide';
						header('Location: index.php?action=trajets');
					}
					break;


				/*-------------------------------------------------------------------------------*/
				/*------------------- RESERVATION D'UN TRAJET ------------------*/
				/*-------------------------------------------------------------------------------*/

				case 'reserver':
					if (isset($id))
					{
						if($res_manager->add($id, $_SESSION['id']))
						{
							$_SESSION['msg'] = 'Votre trajet est réservé';
						}
						else
						{
							$_SESSION['msg'] = 'La réservation a échoué';
						}
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez fournir un trajet';
					}
					header('Location: index?action=profil');

					break;

				/*-------------------------------------------------------------------------------*/
				/*--------------------- ANNULATION D'UN TRAJET -------------------*/
				/*-------------------------------------------------------------------------------*/
				case 'annuler':
					if(isset($id))
					{
						if($res_manager->remove($id,$_SESSION['id']))
						{
							$_SESSION['msg'] = 'Votre réservation a été annulée';
						}
						else
						{
							$_SESSION['msg'] = 'Votre annulation a échoué';
						}
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez fournir un trajet';
					}

					header('Location: index?action=profil');
					break;

				/*-------------------------------------------------------------------------------*/
				/*------------------------ ENVOI D'UN MESSAGE ----------------------*/
				/*-------------------------------------------------------------------------------*/
				case 'envoi':
					if(isset($id)&&isset($msg))
					{
						if($msg_manager->new($_POST, $_SESSION['id']))
						{
							$_SESSION['msg'] = 'Votre message a bien été envoyé';
						}
						else
						{
							$_SESSION['msg'] = 'L\'envoi de votre message a échoué';
						}
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez fournir un message et un destinataire';
					}
					break;

				/*-------------------------------------------------------------------------------*/
				/*---------------------- MISE À JOUR DU PROFIL ---------------------*/
				/*-------------------------------------------------------------------------------*/
				case 'miseajour':
					if(isset($_POST))
					{
						if($mb_manager->update($_SESSION['id']))
						{
							$_SESSION['msg'] = 'Votre profil a bien été mis à jour';
						}
						else
						{
							$_SESSION['msg'] = 'La mise à jour de votre profil à échouée';
						}
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez faire quelque chose :\'(';
					}
					header('Location: index.php?action=profil');
					break;

				/*-------------------------------------------------------------------------------*/
				/*--------------------------- DÉCONNEXION -------------------------*/
				/*-------------------------------------------------------------------------------*/
				case 'deconnexion':
					session_destroy();
					header('Location: index.php');
					break;

				default:
					include_once 'views/user/v_index.class.php';
					//On instancie alors la page correspondante
					$page = new v_index("Accueil");
					$page->set_user($mb_manager->get($_SESSION['id']));
					$page->set_html();
					break;
			}//switch
		}//if(user)
		else
		{
			switch ($application) {
				/*-------------------------------------------------------------------------------*/
				/*------------------------ Formulaire de recherche ---------------------*/
				/*-------------------------------------------------------------------------------*/
				case 'recherche':
					include_once 'views/v_trajets.class.php';
					include_once 'models/TrajetManager.class.php';
					$traj_manager = new TrajetManager($db);
					if (isset($_POST)) {
						extract($_POST);
						$datas = array("Lieu_Depart" => $start,"Lieu_arrivee" => $finish, "date" => $date);
						$_SESSION['recherche'] = $datas;
						$page = new v_trajets("Résultat de la recherche");
						$page->set_html($traj_manager->getList($datas));
					}
					else
					{
						$page = new v_trajets("Résultat de la recherche");
						$_SESSION['msg'] = 'Veuillez saisir des informations.';
						$page->set_html($traj_manager->getList());
					}
					break;

				/*-------------------------------------------------------*/
				/*--- AFFICHAGE D'UN TRAJET PRÉCIS-- */
				/*-------------------------------------------------------*/
				case 'trajet':
					//On vérifie si un ID a bien été fourni
					if(isset($id))
					{
						include_once 'views/v_trajet.class.php';
						$page = new v_trajet("Trajet " + $id);
						$page->set_html($traj_manager->getTrajet($id));
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez demander un trajet valide';
						header('Location: index.php?action=trajets');
					}
					break;

				default:
					include_once 'views/v_index.class.php';
					//On instancie alors la page correspondante
					$page = new v_index("Accueil");
					$page->set_html();
					break;
			}
		}//if(!user&&!admin)

	}//if(isset($application))

	else
	{
		include_once 'views/v_index.class.php';
		//On instancie alors la page correspondante
		$page = new v_index("Accueil");
		$page->set_html();
	}












	// 		/*-------------------------------------------------------*/
	// 		/*------- MODIFICATION D'UN produit -------*/
	// 		/*-------------------------------------------------------*/
	// 		case 'modifier':
	// 			include_once 'views/v_modifier2.class.php';
	// 			//Si le premier formulaire de modification a été soumis (transmission du nom de le produit à modifier)
	// 			if (isset($_POST['modif_nom_x'])) {
	// 				if(isset($_POST['id']))
	// 				{
	// 					$data = array("id"=>$_POST['id']);
	// 				}
	// 				else if(isset($_POST['nom']))
	// 				{
	// 					$data = array("nom"=>$_POST['nom']);
	// 				}
	// 				//On récupère le produit à modifier à l'aide de son nom, puis on affiche la vue correspondante avec les données de cet produit
	// 				$produit = $manager->get($data);
	// 				$page = new v_modifier("Modifier le produit");
	// 				$page->set_html($manager->catManager->getList(),$produit);
	// 			}
	// 			//Sinon, on vérifie si le second formulaire avec les nouvelles données a été transmis. Si oui, on appelle la methode update du manager
	// 			else
	// 			{
	// 				if (isset($_POST['modif_produit']))
	// 				{
	// 					$manager->update($_POST);
	// 					$GLOBALS['msg'] = "Le produit " . $_POST['nom'] . " a bien été mis à jour";
	// 				}
	// 				//On affiche alors la vue de base de la page de modification
	// 				$page = new v_modifier("Modifier un produit");
	// 				$page->set_html($manager->catManager->getList());
	// 			}
	// 			break;

	// 		/*-------------------------------------------------------*/
	// 		/*---------------- DECONNEXION ----------------*/
	// 		/*-------------------------------------------------------*/
	// 		case 'deconnexion':
	// 			include_once 'views/v_modifier2.class.php';
	// 			session_destroy();
	// 			header('Location: TD-04.php');
	// 			break;

	// 		default:

	// 			// include_once 'views/v_produit.class.php';
	// 			// $page = new v_produit("Liste des produits");
	// 			// $page->set_html($manager->getList());
	// 			break;
	// 	}
	// }
	// else if(isset($_GET['action']))
	// {
	// 	switch ($_GET['action']) {

	// 		/*-------------------------------------------------------*/
	// 		/*-------- RECHERCHE D'UN produit --------*/
	// 		/*-------------------------------------------------------*/

	// 		case 'rechercher':
	// 			include_once 'views/v_rechercher2.class.php';

	// 			if(isset($_GET['rech_av']))
	// 			{
	// 				unset($_GET['action']);
	// 				unset($_GET['rech_av']);
	// 				$page = new v_rechercher("Rechercher un produit");
	// 				$page->set_html($manager->catManager->getList(),$manager->getList($_GET));
	// 			}
	// 			else
	// 			{
	// 				$page = new v_rechercher("Rechercher un produit");
	// 				$page->set_html($manager->catManager->getList());
	// 			}
	// 			break;

	// 		/*-------------------------------------------------------*/
	// 		/*----- CONNEXION ADMINISTRATEUR -----*/
	// 		/*-------------------------------------------------------*/

	// 		case 'admin':
	// 			include_once 'views/v_connexion.class.php';

	// 			if(isset($_POST['conn']))
	// 			{
	// 				extract($_POST);
	// 				$mdp = sha1($mdp . SALT);
	// 				$query = $db->prepare('SELECT * FROM utilisateurs WHERE login=:login AND mdp=:mdp');
	// 				$query -> bindParam(':login', $login,PDO::PARAM_STR);
	// 				$query -> bindParam(':mdp', $mdp,PDO::PARAM_STR);
	// 				$query->execute() or die(print_r($query->errorInfo()));

	// 				$result = $query->fetchAll();
	// 				if (count($result)==1) {
	// 					$_SESSION['admin'] = $login;
	// 					$GLOBALS['msg'] = 'Bonjour ' . $login;
	// 				}
	// 				else
	// 				{
	// 					$GLOBALS['msg'] = 'Login ou mot de passe erronné';
	// 				}
	// 				header('Location: TD-04.php');
	// 			}
	// 			else
	// 			{
	// 				$page = new v_connexion("Connexion des administrateurs");
	// 				$page->set_html();
	// 			}
	// 			break;

	// 		/*-------------------------------------------------------*/
	// 		/*--- AJOUT D'UN PRODUIT AU PANIER ---*/
	// 		/*-------------------------------------------------------*/

	// 		case 'aj_panier':
	// 			include 'views/v_produit.class.php';
	// 			$produit = array('id'=>$_POST['id'],'nom'=>$_POST['nom']);
	// 			$push = false;
	// 			foreach ($_SESSION['panier'] as $key => &$value) {
	// 				if ($value['id']==$produit['id']) {
	// 					$value['quantité']++;
	// 					$push = true;
	// 				}
	// 			}

	// 			if(!$push)
	// 			{
	// 				$produit = array('id'=>$produit['id'],'nom'=>$produit['nom'],'quantité'=>1);
	// 				array_push($_SESSION['panier'],$produit);
	// 			}
	// 			$GLOBALS['msg'] = 'Le produit ' . $_POST['nom'] . ' a bien été ajouté au panier.';
	// 			$page = new v_produit('Liste des produits');
	// 			$page->set_html($manager->getList());
	// 			break;

	// 		/*-------------------------------------------------------------------*/
	// 		/*--- SUPPRESSION D'UN PRODUIT DU PANIER ---*/
	// 		/*-------------------------------------------------------------------*/

	// 		case 'supp_panier':
	// 			//var_dump($_SESSION['panier']);
	// 			foreach ($_SESSION['panier'] as $key => &$value) {
	// 				if ($value['id']==$_POST['id']) {
	// 					if ($value['quantité']>1) {
	// 						$value['quantité']--;
	// 					}
	// 					else
	// 					{
	// 						unset($_SESSION['panier'][$key]);
	// 					}
	// 				}
	// 			}
	// 			header('Location: TD-04.php?action=panier');

	// 			break;

	// 		/*-------------------------------------------------------*/
	// 		/*-------- VISUALISATION DU PANIER --------*/
	// 		/*-------------------------------------------------------*/

	// 		case 'panier':
	// 			include 'views/v_panier.class.php';
	// 			if (empty($_SESSION['panier'])) {
	// 				$GLOBALS['msg'] = 'Votre panier est vide.';
	// 			}
	// 			$panier = array();
	// 			$id = 0;
	// 			foreach ($_SESSION['panier'] as $key => $value) {
	// 				$produit = $manager->get(array('id'=>$value['id']));
	// 				$panier[$id] = array('produit'=>$produit,'quantité'=>$value['quantité']);
	// 				$id++;
	// 			}
	// 			$page = new v_panier('Mon panier');
	// 			$page->set_html($panier);
	// 			break;

	// 		default:
	// 			include 'views/Page.class.php';
	// 			$GLOBALS['msg'] = 'Cette page n\'existe pas';
	// 			$page = new Page('Boutique');
	// 			break;
	// 	}
	// }
	// //Sinon on affiche l'accueil, c'est à dire la liste des produits
	// else
	// {
	// 		/*-------------------------------------------------------*/
	// 		/*------------- LISTE DES produits ------------*/
	// 		/*-------------------------------------------------------*/

	// 	if($GLOBALS['co'])
	// 	{
	// 		include_once 'views/v_produit.class.php';
	// 		$page = new v_produit("Liste des produits");
	// 		$page->set_html($manager->getList());
	// 	}
	// 	else
	// 	{
	// 		//Si le connexion n'a pas été validée, on envoie une page par défaut, dans laquelle le message d'alerte sera indiqué
	// 		include_once 'views/Page.class.php';
	// 		$page =  new Page("Boutique");
	// 	}
	// }

	//On ajoute les feuilles de styles nécessaires à la page
	$page->head->add_css("css/style.css");
	$page->head->add_css("http://fonts.googleapis.com/css?family=Raleway");
?>