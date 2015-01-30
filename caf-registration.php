<?php
/*
Plugin Name: caf-registration
Plugin URI: http://cafsaintjulien.net
Description: Un plugin d'inscription aux sorties proposées sur le site avec my calendar.
Version: 0.1
Author: lagrossemiche
Author URI: http://www.lagrossemiche.fr
License: GPL2
*/



include "caf-registration-install.php";
require_once('caf-registration-new.php');

// TODO calendrier pour le choix des dates

class caf_registration
{
	public function add_admin_menu()
	{
		add_menu_page('Administration des enregistrement aux sorties', 'Registration', 'manage_options', 'caf_registration', array($this, 'menu_html'));
		$new_registration = new caf_registration_new();
		$hook_test = add_submenu_page('caf_registration', 'Contacter les utilisateurs de la liste', 'Contact', 'manage_options', 'caf_registration_contact', array($this, 'test_html'));
	}
	public function menu_html()
	{
	    echo '<h1>'.get_admin_page_title().'</h1>';
	    echo '<p>Bienvenue sur la page d\'accueil du plugin</p>';
	}

	public function test_html()
	{
		$content = '';
		$editor_id = 'mycustomeditor';
	    	echo '<h1>'.get_admin_page_title().'</h1>';?>
	    	<div class="postbox">
			<h3>Descriptif de la sortie</h3>
			<div class="inside">
				<p>
					<fieldset>
						<legend>Intitulé de la sortie <span class="required">(required)</span></legend>
					</fieldset>
					<input type="text" name="title" value=""/>
				</p>
				<p>
					<fieldset>
						<legend>Catégories <span class="required">(required)</span></legend>
					</fieldset>
					<input type="text" name="contact" value="<?php echo get_option('contact')?>"/>
				</p>
				<p>
					<fieldset>
						<legend>Niveau de la sortie <span class="required">(required)</span></legend>
					</fieldset>
					<input type="text" name="contact" value="par ex: T2(rando), PD(alpi), 6a(escalade), S3(ski) ..."/>
					<label	for="deniv">Dénivelé (m): </label>
					<input type="number" name="deniv"/>
				</p>
				<p>
					<fieldset>
						<legend>Description courte <span class="required">(required)</span></legend>
					</fieldset>
					<textarea name="short_desc"><?php echo get_option('need')?></textarea>
				</p>
				<p>
					<fieldset>
						<legend>Contact pour la sortie <span class="required">(required)</span></legend>
					</fieldset>
					<input type="text" name="contact" value="<?php echo get_option('contact')?>"/>
				</p>
				<p>
					<fieldset>
						<legend>Encadrants <span class="required">(required)</span></legend>
					</fieldset>
					<input type="text" name="contact" value="<?php echo get_option('contact')?>"/>
				</p>
				<p>
					<fieldset>
						<legend>Description exhaustive de la sortie</span></legend>
					</fieldset>
					<?php wp_editor( $content, $editor_id ); ?>
				</p>
			</div>
		</div>
	    	<div class="postbox">
			<h3>Date de la sortie</h3>
			<div class="inside">
				<fieldset>
					<legend>Dates de la sortie <span class="required">(required)</span></legend>
				</fieldset>
				<p>
					<input type="checkbox" value="1" id="e_span" name="event_day" />
					<label	for="e_span">All day event</label>
				</p>
				<p>
					<label	for="begin_date">Date de début </label>
					<input class='sched-div datepicker' type='text' name="begin_date" value="<?php echo get_option('begin')?>"/>
					<label	for="begin_time">de</label>
					<input class='sched-div datepicker' type='text' name="begin_time" value="<?php echo get_option('begin_time')?>"/>
					<label	for="end_time">à</label>
					<input class='sched-div datepicker' type='text' name="end_time" value="<?php echo get_option('end_time')?>"/>
				</p>
				<p>
					<label	for="end_date">Date de fin (YYYY-MM-DD)</label>
					<input class='sched-div datepicker' type='text' name="end_date" value="<?php echo get_option('end_date')?>"/>
				</p>
			</div>
		</div>
	    	<div class="postbox">
			<h3>Modalité d'inscription et de validation de la sortie</h3>
			<div class="inside">
				<p>
					<fieldset>
						<legend>Limite des participants <span class="required">(required)</span></legend>
					</fieldset>
					<p>
						<label	for="min_users">Nombre d'inscrit minimum: </label>
						<input type="number" name="min_users" min="1" value="<?php echo get_option('min_users')?>"/>
						<label	for="min_users"> maximum: </label>
						<input type="number" name="min_users" min="1" value="<?php echo get_option('min_users')?>"/>
					</p>
				</p>
				<p>
					<fieldset>
						<legend>Inscription par internet <span class="required">(required)</span></legend>
					</fieldset>
					<input type="checkbox" value="1" id="e_span" name="event_day" />
					<label	for="e_span">Inscriptions par internet possible</label>
				</p>
				<p>
					<label	for="begin_date">Inscriptions par internet du </label>
					<input class='sched-div datepicker' type='text' name="begin_date" value="<?php echo get_option('begin')?>"/>
					<label	for="end_date"> au </label>
					<input class='sched-div datepicker' type='text' name="end_date" value="<?php echo get_option('end_date')?>"/>
				</p>
				<p>
					<fieldset>
						<legend>À la permanence</legend>
					</fieldset>
					<input type="checkbox" value="1" id="e_span" name="event_day" />
					<label	for="e_span">Permanence au club</label>
				</p>
				<p>
					<label	for="begin_date">Date de la permanence</label>
					<input class='sched-div datepicker' type='text' name="begin_date" value="<?php echo get_option('begin')?>"/>
				</p>
			</div>
		</div>
		<?php	
	}
	public function Event_Detail_html()
	{
		$content = '';
		$editor_id = 'mycustomeditor';
		wp_editor( $content, $editor_id );
	}
	public function __construct()
	{
		$manage = new caf_registration_install();
		// il faut bien créer des des tables ...
		register_activation_hook(__FILE__, array($manage, 'install'));

		// il faut aussi savoir s'en séparer ... mais comme c'est dangereux je l'ai commenté
		//register_uninstall_hook(__FILE__, array('$manage', 'uninstall'));

		// le menu d'administration du plugin
		add_action('admin_menu', array($this, 'add_admin_menu'),20);
	}
}

new caf_registration();

