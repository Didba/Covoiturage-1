<?php
session_start();
/*--------------------------------------------------------------------------------------------------------*/
/*--------------Ceci est le super controlleur (et même unique controlleur ici) -----------*/
/*------------ Il se charge de récupérer toute donnée transmise, et de traiter ----------*/
/*--------------- chaque demande par le biais des modèles correspondants -----------*/
/*--------------------------------------------------------------------------------------------------------*/

	include_once 'config/connexion.php';

	if(isset($_GET)):extract($_GET);endif;
	if(isset($_POST)):extract($_POST);endif;

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
						$datas = array("Lieu_Depart" => $start,"Lieu_arrivee" => $finish, "date" => $date); //On transmet les données de la requete dans un tableau
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
					include 'models/AdherantManager.class.php';
					$mb_manager = new AdherantManager($db);

					if($adherent = $mb_manager->get($_POST))
					{
						$_SESSION['id'] = $adherent->Id_Adherent();
						$_SESSION['co'] = true;
						header('Location: super_controller.php');
					}
					else
					{
						$_SESSION['msg'] = "Votre identification a échoué";
						header('Location: super_controller.php');
					}

					break;

				case 'deconnexion':
					session_destroy();
					header('Location: super_controller.php');
					break;


				/*-------------------------------------------------------------------------------*/
				/*------------------------------ INSCRIPTION ----------------------------*/
				/*-------------------------------------------------------------------------------*/

				case 'inscription':
					include_once('views/v_inscription.class.php');
					$page = new v_inscription("Inscription");
					$page->set_html();
					break;

				case 'nouvelle_inscription':
					include_once('models/AdherantManager.class.php');
					$mb_manager = new AdherantManager($db);
					$mb_manager->add($_POST);
					$_SESSION['msg'] = "Votre inscription a bien été prise en compte";
					header('Location: super_controller.php');
					break;

				/*-------------------------------------------------------------------------------*/
				/*---------------------------- Affichage du profil --------------------------*/
				/*-------------------------------------------------------------------------------*/
				case 'profil':
					//On vérifie si un ID a bien été fourni
					if(isset($id))
					{
						include_once 'views/v_profil.class.php';
						include 'models/AdherantManager.class.php';
						$mb_manager = new AdherantManager($db);
						$page = new v_profil("Mon profil");
						$page->set_html(array("adherent" => $mb_manager->get(array("id_Adherent" => $id))));
					}
					else
					{
						$_SESSION['msg'] = 'Non disponible';
						header('Location: super_controller.php');
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

	//On ajoute les feuilles de styles nécessaires à la page
	$page->head->add_css("css/style.css");
	$page->head->add_css("http://fonts.googleapis.com/css?family=Raleway");
?>