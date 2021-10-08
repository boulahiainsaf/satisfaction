<?php
/*
Plugin Name: pluginSatisfaction
Plugin URI: http://monPlugin.com/
Description:  permettra à tous les visiteurs de dire s’ils aiment le site ou non.
Version: 1.0.0
Author: boulahia insaf
Author URI: http://monPlugin.com/

Text Domain: pluginSatisfaction
*/
/*empecher l'accer direct au fichier */
defined('ABSPATH') or die('rien à voir ');
class Satisfaction
{
    public function __construct()
    {
        add_action('widgets_init','declarerWidget');
        add_action( 'wp_enqueue_scripts', 'cssPage' );


    }
    public static function install(){
        Satisfaction::install_db();
    }
    public static function uninstall(){
        Satisfaction::uninstall_db();
    }
    public static function desactivate(){

    }
    public function install_db(){

        global $wpdb;

        $wpdb->query("CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."avis (id int(11) AUTO_INCREMENT PRIMARY KEY, nom_client varchar(50),prenom_client varchar(50),reponse varchar(14),aviscCli varchar(225));");
        
    }
    public function uninstall_db(){

        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."avis;");

    }

}

new Satisfaction();
register_activation_hook(__FILE__,array('Satisfaction','install'));
register_deactivation_hook(__FILE__,array('Satisfaction','desactivate'));
register_uninstall_hook(__FILE__,array('Satisfaction','uninstall'));


class afficheQuestion extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('idAfficheQuestion', 'Affiche Question', array('description' => 'Un formulaire pour répondre'));

    }

    public function widget($args, $instance)
    {

        echo '
        <form action="" method="post">
     <h2>' . $instance['question'] . '</h2>
     <div >
     <label>Nom :</label><br>
      <input size="50" class="sa" type ="text" name="nom" id="nom"><br>
      <p style="color: red;"  id="c1"> </p>
      <label>Prenom :</label><br>
      <input size="50" class="sa" type ="text" name="prenom" id="prenom"><br>
      <p style="color: red;"  id="c2"> </p>
      </div>
  <ul class="notes-echelle">
	<li>
	    <input size="50" type="radio" name="notesA" id="note01" value="1" />
		<label for="note01" title="Note&nbsp;: 1 sur 3">Peu satisfait</label>
		
	</li>
	<li>
	    <input  type="radio" name="notesB" id="note02" value="2" />
		<label for="note02" title="Note&nbsp;: 2 sur 3">satisfait   </label>
		
	</li>
	<li>
	    <input type="radio" name="notesC" id="note03" value="3" />
		<label for="note03" title="Note&nbsp;: 3 sur 3">très satisfait</label>
		
	</li>
</ul>
<p style="color: red;"  id="c3"> </p>
<div >
      <label>Votre avis :</label><br>
      <input size="50" class="sa" type ="text" name="disc" id="disc"><br>
      <p style="color: red;"  id="c4"> </p>
      <p></p>
      </div>
        <input id="envoyer" type="submit"/>
   </form>';
        global $wpdb;

        $table = $wpdb->prefix . 'avis';
        if (isset($_POST['notesA'])) {
            $wpdb->insert($table, array('nom_client'=>$_POST['nom'],'prenom_client'=>$_POST['prenom'], 'reponse' => 'peu satisfait', 'aviscCli' => $_POST["disc"]));
        } else if (isset($_POST['notesB'])) {
            $wpdb->insert($table, array('nom_client'=>$_POST['nom'],'prenom_client'=>$_POST['prenom'], 'reponse' => 'satisfait', 'aviscCli' => $_POST["disc"]));
        } else if (isset($_POST['notesC'])) {
            $wpdb->insert($table, array('nom_client'=>$_POST['nom'],'prenom_client'=>$_POST['prenom'], 'reponse' => 'très satisfait', 'aviscCli' => $_POST["disc"]));
        }


    }

    public function form($instance)
    {
        $question = isset($instance['question']) ? $instance['question'] : 'etses-vous satesfait de notre service  ?';
        $id = $this->get_field_id('question');
        $name = $this->get_field_name('question');
        echo "<p>Nom de la question <input type='text' id=$id name='" . $name . "' value='" . $question . "'></p>";
    }
}
    function cssPage()
    {


        wp_enqueue_style('style', plugin_dir_url( __FILE__ ). '/css/style.css');
        wp_enqueue_script('validation', plugin_dir_url( __FILE__ ). '/css/validation.js', array ( 'jquery' ), 1.1, true);

          }






function declarerWidget()
{
    register_widget('afficheQuestion');
}
