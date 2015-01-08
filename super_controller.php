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
					include 'models/AdherentManager.class.php';
					include 'models/ConducteurManager.class.php';
					$mb_manager = new AdherentManager($db);
					$cd_manager = new ConducteurManager($db);

					if($adherent = $mb_manager->get($_POST))
					{
						if($conducteur = $cd_manager->get(array("id_adherent"=>$adherent->id_adherent())))
						{
							$_SESSION['id'] = $conducteur->id_adherent();
							$_SESSION['co'] = true;
							$_SESSION['permis'] = $conducteur->numPermis();
							header('Location: super_controller.php');
						}
						else
						{
							$_SESSION['id'] = $adherent->id_adherent();
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
					include_once('models/AdherentManager.class.php');
					$mb_manager = new AdherentManager($db);
					$mb_manager->add($_POST);
					$_SESSION['msg'] = "Votre inscription a bien été prise en compte";
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
					include_once('models/AdherentManager.class.php');
					$mb_manager = new VehiculeManager($db);
					$mb_manager->add($_POST);
					$_SESSION['msg'] = "Votre ajout de véhicule a bien été prise en compte";
					header('Location: super_controller.php');
					break;

				/*-------------------------------------------------------------------------------*/
				/*------------------------------PROPOSER TRAJET ----------------------------*/
				/*-------------------------------------------------------------------------------*/

				case 'proposer':
					if(isset($_SESSION['permis'])):
						include_once('views/v_proposer.class.php');
						$page = new v_proposer("Proposer un nouveau trajet");
						$page->set_html();
					else:
						$_SESSION['msg'] = "Vous n'êtes pas autorisés à accèder à cette page";
						header('Location: super_controller.php');
					endif;
					break;

				case 'nouvelle_proposition':
					include_once('models/TrajetManager.class.php');
					$mb_manager = new TrajetManager($db);
					$mb_manager->add($_POST);
					$_SESSION['msg'] = "Votre proposition a bien été prise en compte";
					header('Location: super_controller.php');
					break;

				/*-------------------------------------------------------------------------------*/
				/*------------------------------MODIFIER PROFIL ----------------------------*/
				/*-------------------------------------------------------------------------------*/

				case 'modif_profil':

					include_once('views/v_modif_profil.class.php');
					include_once('models/AdherentManager.class.php');

					$ad_manager = new AdherentManager($db);
					$page = new v_modif_profil("Modifier profil");
					//$page->set_html();
					$page->set_html(array("adherent" => $ad_manager->get(array("id_adherent" => $_SESSION['id']))));

					break;

				case 'nouvelle_modif':
					include_once('models/AdherentManager.class.php');
					$ad_manager = new AdherentManager($db);
					$ad_manager->update($_POST);

					$_SESSION['msg'] = "Votre modification a bien été prise en compte";
					header('Location: super_controller.php?application=modif_profil');
					break;

				case 'supprimer':
					include_once('models/AdherentManager.class.php');
					$ad_manager = new AdherentManager($db);
					if($ad_manager->remove(array("id_adherent" => $_SESSION['id']))):
						$_SESSION['msg'] = "Votre compte a bien été supprimé";
						unset($_SESSION['id']);
						unset($_SESSION['permis']);
						unset($_SESSION['co']);
					else:
						$_SESSION['msg'] = "Une erreur est survenue dans la suppression de votre compte";
					endif;
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

						include 'models/AdherentManager.class.php';
						$mb_manager = new AdherentManager($db);

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

				case 'reserver':
					include_once('models/ParticipeManager.class.php');
					$pa_manager = new ParticipeManager($db);

					if($pa_manager->add($_POST)):
						$_SESSION['msg'] = "Votre inscription a bien été prise en compte";
					else:
						$_SESSION['msg'] = "Une erreur a empêché votre réservation";
					endif;
					header('Location: super_controller.php');
					break;

				case 'annuler':
					include_once('models/ParticipeManager.class.php');
					$pa_manager = new ParticipeManager($db);

					if($pa_manager->remove($_GET)):
						$_SESSION['msg'] = "Votre réservation a bien été annulée";
					else:
						$_SESSION['msg'] = "Une erreur a empêché votre annulation";
					endif;
					header('Location: super_controller.php');
					break;

				case 'mes_trajets':
					include_once 'views/v_mes_trajets.class.php';
					include_once('models/ParticipeManager.class.php');
					$pa_manager = new ParticipeManager($db);
					$traj_cond = array();
					if(isset($_SESSION['permis']))
					{
						include_once('models/TrajetManager.class.php');
						$tr_manager = new TrajetManager($db);
						$traj_cond = $tr_manager->getList(array('id_adherent' => $_SESSION['id']));
					}
					$page = new v_mes_trajets("Mes trajets");

					$page->set_html(array("passager"=>$pa_manager->getList(array("id_adherent"=>$_SESSION['id'])), "conducteur" => $traj_cond));

					break;


				/*-------------------------------------------------------------------------------*/
				/*------------------------------ MESSAGERIE ----------------------------*/
				/*-------------------------------------------------------------------------------*/

				case 'new_message':
					include_once('models/MessageManager.class.php');
					include_once('views/v_msg_new.class.php');
					$me_manager = new MessageManager($db);
					$page = new v_msg_new("Envoyer message");
					$page->set_html($me_manager->getList(array("id_adherent_from"=>$_SESSION['id'], "id_adherent_to"=>$_SESSION['id'])));
					break;

				case 'nouvelle_message':
					include_once('models/MessageManager.class.php');
					$mb_manager = new MessageManager($db);
					$mb_manager->add($_POST);
					$_SESSION['msg'] = "Votre message a bien été envoyer";
					header('Location: super_controller.php');
					break;

				case 'mes_messages':
					include_once('models/MessageManager.class.php');
					$me_manager = new MessageManager($db);

					include_once 'views/v_mes_messages.class.php';

					$page = new v_mes_messages("Mes messages");
					$page->set_html();

					break;

				case 'recu':
					include_once('models/MessageManager.class.php');
					$me_manager = new MessageManager($db);

					include_once 'views/v_msg_recu.class.php';

					$page = new v_msg_recu("Mes messages reçu");
					$page->set_html($me_manager->getList(array("id_adherent_from"=>$_SESSION['id'], "id_adherent_to"=>$_SESSION['id'])));

					break;

				case 'envoyer':
					include_once('models/MessageManager.class.php');
					$me_manager = new MessageManager($db);

					include_once 'views/v_msg_envoyer.class.php';

					$page = new v_msg_envoyer("Mes messages envoyés");
					$page->set_html($me_manager->getList(array("id_adherent_from"=>$_SESSION['id'], "id_adherent_to"=>$_SESSION['id'])));

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

	$page->add_script('//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js');
    	$page->add_script('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&region=FR');
	$page->add_script("js/jquery.placecomplete.js");
	$page->add_script("js/app.js");
?>