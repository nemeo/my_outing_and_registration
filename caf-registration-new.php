<?php
class caf_registration_new
{
	public function new_html()
	{
		echo '<h1>'.get_admin_page_title().'</h1>';
		add_settings_section('caf_registration_new_section', 'Paramètres d\'envoi', array($this, 'section_html'), 'caf_registration_new_settings');
		add_settings_field('ID_Cal', 'ID de l\'évenement my_calendar', array($this, 'ID_Cal_html'), 'caf_registration_new_settings', 'caf_registration_new_section');
		add_settings_field('min_users', 'Nombre de participant minimum', array($this, 'min_users_html'), 'caf_registration_new_settings', 'caf_registration_new_section');
		add_settings_field('max_users', 'Nombre de participant maximum', array($this, 'max_users_html'), 'caf_registration_new_settings', 'caf_registration_new_section');
		add_settings_field('begin', 'Début des inscriptions', array($this, 'begin_html'), 'caf_registration_new_settings', 'caf_registration_new_section');
		add_settings_field('end', 'Fin des inscriptions', array($this, 'end_html'), 'caf_registration_new_settings', 'caf_registration_new_section');
		add_settings_field('contact', 'Page de contact', array($this, 'contact_html'), 'caf_registration_new_settings', 'caf_registration_new_section');
		add_settings_field('need', 'Matériel et niveau requis', array($this, 'need_html'), 'caf_registration_new_settings', 'caf_registration_new_section');

		echo '<form method="post" action="options.php">';
		settings_fields('caf_registration_new_settings');
		do_settings_sections('caf_registration_new_settings');
		submit_button('Sauvegarder');
		echo '</form>
		<form method="post" action="">
		    <input type="hidden" name="save_registration" value="1"/>';
		    submit_button('Créer');
		echo '</form>';
	}
	public function section_html()
	{
	    echo 'Renseignez les paramètres du formulaire d\'inscription à la sortie.';
	}
	public function ID_Cal_html()
	{?>
	    <input type="number" name="ID_Cal" value="<?php echo get_option('ID_Cal')?>"/>
	    <?php
	}
	public function min_users_html()
	{?>
	    <input type="number" name="min_users" value="<?php echo get_option('min_users')?>"/>
	    <?php
	}
	public function max_users_html()
	{?>
	    <input type="number" name="max_users" value="<?php echo get_option('max_users')?>"/>
	    <?php
	}
	public function begin_html()
	{?>
		<input class='sched-div datepicker' type='text' name="begin" value="<?php echo get_option('begin')?>"/>
	    <?php
	}
	public function end_html()
	{?>
		<input class='sched-div datepicker' type="text" name="end" value="<?php echo get_option('end')?>"/>
	    <?php
	}
	public function contact_html()
	{?>
	    <input type="text" name="contact" value="<?php echo get_option('contact')?>"/>
	    <?php
	}
	public function need_html()
	{?>
	    <textarea name="need"><?php echo get_option('need')?></textarea>
	    <?php
	}

	public function register_settings()
	{
	    register_setting('caf_registration_new_settings', 'ID_Cal');
	    register_setting('caf_registration_new_settings', 'min_users');
	    register_setting('caf_registration_new_settings', 'max_users');
	    register_setting('caf_registration_new_settings', 'begin');
	    register_setting('caf_registration_new_settings', 'end');
	    register_setting('caf_registration_new_settings', 'contact');
	    register_setting('caf_registration_new_settings', 'need');
	}
	public function save()
	{
		global $wpdb;
		$ID_Cal = get_option('ID_Cal', '0');
		//$wpdb->insert("{$wpdb->prefix}caf_registration_outing", array('id_cal' => $ID_Cal), array('%d'));
		$row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}caf_registration_outing WHERE id_cal = '$ID_Cal'");
		/*if (is_null($row))*/ {
			$wpdb->insert	("{$wpdb->prefix}caf_registration_outing", 
					 array(	'id_cal' => get_option('ID_Cal', '0'),
						'min_users' => get_option('min_users', '0'),
						'max_users' => get_option('max_users', '0'),
						'contact' => get_option('contact', 'pas bien!'),
						'need' => get_option('need', 'Besoin de rien!'),
						'begin_date' => get_option('begin', '0'),
						'end_date' => get_option('end', '0')));
		}
	}
	public function process_registration()
	{
	    if (isset($_POST['save_registration'])) {
		$this->save();
	    }
	}
	public function enqueue_scripts() {
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		//wp_enqueue_style ( 'jquery-ui-lightness', plugins_url( 'ui-lightness/jquery-ui-1.8.20.custom.css', __FILE__ ));
	}
	public function echo_js() { 
		?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('.datepicker').datepicker({
					dateFormat:'yy-mm-dd'
				});
			});
		</script><?php
	}
	public function __construct()
	{				
		add_action('admin_init', array($this, 'register_settings'));
		$hook_registration = add_submenu_page('caf_registration', 'Créer un nouveau formulaire', 'New', 'manage_options', 'caf_registration_new', array($this, 'new_html'));
		add_action('load-'.$hook_registration, array($this, 'process_registration'));

		//Le datepicker
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action( 'admin_print_footer_scripts', array($this, 'echo_js'));
	}
}
