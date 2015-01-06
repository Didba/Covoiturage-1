<?php

	include_once 'v_compte.class.php';

	/**
	* Classe de la vue pour afficher les messages
	*/
	class v_mes_messages extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($elts){

			$html =''; //Initialisation de la variable de retour

			$html .= $this->get_nav('Mes messages');

			foreach ($elts as $key => $elt) {

				$html .= '<li>';
				$html .= '<b>'.$elt->date().'</br>';
				$html .= '</br> Sujet : </b>'.$elt->sujet().'</br>';
				$html .= '</br><pre>	'.$elt->message().'</pre></br>';

				$html .='<hr>';
				$html .= '</li>';

			}

			$html .= '</ul>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>