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
						$datas = array("Lieu_Depart" => $start,"Lieu_arrivee" => $finish, "date" => $date); //On écrit les données de la requete dans un tableau
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
					include 'models/ConducteurManager.class.php';
					$mb_manager = new AdherantManager($db);
					$cd_manager = new ConducteurManager($db);

					if($adherent = $mb_manager->get($_POST))
					{
						if($conducteur = $cd_manager->get(array("id_Adherent"=>$adherent->Id_Adherent())))
						{
							$_SESSION['id'] = $conducteur->Id_Adherent();
							$_SESSION['co'] = true;
							$_SESSION['permis'] = $conducteur->numPermis();
							header('Location: super_controller.php');
						}
						else
						{
							$_SESSION['id'] = $adherent->Id_Adherent();
							$_SESSION['co'] = true;
							header('Location: super_controller.php');
						}
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
				/*------------------------------ MESSAGERIE ----------------------------*/
				/*-------------------------------------------------------------------------------*/

				case 'message':
					include_once('views/v_message.class.php');
					$page = new v_message("message");
					$page->set_html();
					break;

				case 'nouvelle_message':
					include_once('models/MessageManager.class.php');
					$mb_manager = new MessageManager($db);
					$mb_manager->add($_POST);
					$_SESSION['msg'] = "Votre message a bien été envoyé";
					header('Location: super_controller.php');
					break;

				/*-------------------------------------------------------------------------------*/
				/*------------------------------ AJOUT VEHICULE ----------------------------*/
				/*-------------------------------------------------------------------------------*/

				case 'ajoutVehicule':
					include_once('views/v_ajoutVehicule.class.php');
					$page = new v_ajoutVehicule("ajoutVehicule");
					$page->set_html();
					break;

				case 'nouvelle_ajoutVehicule':
					include_once('models/AdherantManager.class.php');
					$mb_manager = new VehiculeManager($db);
					$mb_manager->add($_POST);
					$_SESSION['msg'] = "Votre ajout a bien été prise en compte";
					header('Location: super_controller.php');
					break;

				/*-------------------------------------------------------------------------------*/
				/*------------------------------PROPOSER TRAJET ----------------------------*/
				/*-------------------------------------------------------------------------------*/

				case 'proposer':
					include_once('views/v_proposer.class.php');
					$page = new v_proposer("Proposer un nouveau trajet");
					$page->set_html();
					break;

				case 'nouvelle_proposition':
					include_once('models/TrajetManager.class.php');
					$mb_manager = new TrajetManager($db);
					$mb_manager->add($_POST);
					$_SESSION['msg'] = "Votre proposition a bien été prise en compte";
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

						include_once('models/conducteurManager.class.php');
						$cd_manager = new conducteurManager($db);
						$page = new v_profil("Mon profil");

						if($conducteur = $cd_manager->get(array("id_adherent_conducteur"=>$id)))
						{
							$page->set_html(array("adherent" => $cd_manager->get(array("id_adherent_conducteur" => $id))));
						}
						else
						{
							$page->set_html(array("adherent" => $mb_manager->get(array("id_adherent" => $id))));
						}

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