<?php
session_start();
/*--------------------------------------------------------------------------------------------------------*/
/*--------------Ceci est le super controlleur (et même unique controlleur ici) -----------*/
/*------------ Il se charge de récupérer toute donnée transmise, et de traiter ----------*/
/*--------------- chaque demande par le biais des modèles correspondants -----------*/
/*--------------------------------------------------------------------------------------------------------*/

	include_once 'config/connexion.php';
	include_once 'Action.class.php';

	if(isset($_GET)):extract($_GET);endif;
	if(isset($_POST)):extract($_POST);endif;

	var_dump($_POST);
	var_dump($_GET);
	/*-------------------------------------------------------------------------------*/
	/*--------------- Vérification si l'utilisateur est un admin -------------*/
	/*-------------------------------------------------------------------------------*/
	if(isset($application))
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
						$datas = array("lieu_depart" => $start,"lieu_arrivee" => $finish, "date" => $date); //On transmet les données de la requete dans un tableau
						$_SESSION['recherche'] = $datas; //Afin de conserver la requete en mémoire pour l'affichage ultérieur, on le stock dans une var de session
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

				/*-------------------------------------------------------*/
				/*----------------- CONNEXION------------------- */
				/*-------------------------------------------------------*/
				case 'connexion':
					include 'models/AdherentManager.php';
					$mb_manager = new AdherentManager($db);

					if($adherent = $mb_manager->get($_POST))
					{
						echo "tg";
						$_SESSION['id'] = $adherent->Id_Adherent();
						$_SESSION['co'] = true;
						header('Location: super_controller.php');
					}
					else
					{
						var_dump($adherent);
					}

					break;

				default:
					include_once 'views/v_index.class.php';
					//On instancie alors la page correspondante
					$page = new v_index("Accueil");
					$page->set_html();
					break;
			}

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