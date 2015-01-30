<?php
class caf_registration_install
{
	public static function install()
	{
	    	global $wpdb;
		// création de la table qui contiendra les formulaires d'inscription aux sorties
	    	$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}caf_registration_outing (
			id INT AUTO_INCREMENT PRIMARY KEY, 
			id_cal INT NOT NULL, 
			need VARCHAR(255) NOT NULL, 
			max_users INT NOT NULL, 
			min_users INT DEFAULT 0, 
			comments VARCHAR(255) NOT NULL, 
			contact VARCHAR(255) NOT NULL, 
			begin_date DATE NOT NULL, 
			end_date DATE NOT NULL);"
			);
		// création de la table qui contiendra la liste des participants
	    	$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}caf_registration_user (
			id INT AUTO_INCREMENT PRIMARY KEY, 
			id_caf INT NOT NULL, 
			firstname VARCHAR(32) NOT NULL, 
			lastname VARCHAR(32) NOT NULL, 
			phone VARCHAR(16) NOT NULL, 
			email VARCHAR(255) NOT NULL);"
			);
		// création de la table qui contiendra les liens entre les participants, les formulaires d'inscription aux sorties, les besoins et commentaires
	    	$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}caf_registration_outing_users (
			outing_id INT, user_id INT, 
			visible BOOLEAN DEFAULT FALSE, 
			needing VARCHAR(255) NOT NULL, 
			comments VARCHAR(255) NOT NULL);"
			);
	}
	public static function uninstall()
	{
	    	global $wpdb;
		// supression des tables
	    	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}caf_registration_outing, {$wpdb->prefix}caf_registration_user, {$wpdb->prefix}caf_registration_outing_users;");
	}

}?>
