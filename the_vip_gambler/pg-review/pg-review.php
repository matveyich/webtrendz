<?php
/*
Plugin Name: PG-Review
Plugin URI:
Description: Reviews
Version: 1.0
Author: sanpalm
Author URI: http://fcpodillya.km.ua

  Copyright 2010  sanpalm  (email: sanpalm@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


define('PLUG_NAME','PG-Review');
define('PGREVIEW_VERSION',"0.1");
define('PGREVIEW_URLPATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('PGREVIEW_FOLDER', plugin_basename( dirname(__FILE__)) );

register_activation_hook(__FILE__,'pgr_install');
register_deactivation_hook(__FILE__,'pgr_uninstall');

// Set 'manage_pgr' Capabilities To Administrator
$role = get_role('administrator');
if(!$role->has_cap('manage_pgr'))
{
  $role->add_cap('manage_pgr');
  $view_level= 'administrator';
}

//==admin UI==+
if(function_exists('add_action'))
{
  // Add the admin menu
  add_action( 'admin_menu', 'add_menu');
}
//==admin UI==-

//=======================
//==integrate the menu==+
function add_menu()
{
  if ( function_exists('add_menu_page') )
  {
    add_menu_page(__('Reviews', 'pg-review'), __('Reviews', 'pg-review'), 'manage_pgr', 'pg-review/pgr-manager.php', '', plugins_url('pg-review/images/pgreview.png'));
  }

  if (function_exists('add_submenu_page'))
  {
    add_submenu_page('pg-review/pgr-manager.php', __('Manage Review', 'pg-review'), __('Manage Review', 'pg-review'), 'manage_pgr', 'pg-review/pgr-manager.php');
    add_submenu_page('pg-review/pgr-manager.php', __('Add Review', 'pg-review'), __('Add Review', 'pg-review'), 'manage_pgr', 'pg-review/pgr-add.php');
  }

}
//==integrate the menu==-

//!!!INSTALL!!!Begin!!!
//==============================================
//==Uninstall all settings and tables===========
//==Called via Setup and register_unstall hook==
function pgr_uninstall()
{
  global $wpdb;

  // first remove all tables
  $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}pgrvw");
  $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}pgrvw_right");
  $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}pgrvw_mbox");

  // then remove all options
  delete_option('pgreview_db_version');
  delete_option('pgreview_pageid');
}

//==============================================
//==Install all settings and tables=============
//==Called via Setup and register_install hook==
function pgr_install()
{
  global $wpdb;

  // Check for capability
  if ( !current_user_can('activate_plugins') )
    return;

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  // add charset & collate like wp core
  $charset_collate = '';

  if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') )
  {
    if ( ! empty($wpdb->charset) )
      $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
    if ( ! empty($wpdb->collate) )
      $charset_collate .= " COLLATE $wpdb->collate";
  }

  $pgrvw = $wpdb->prefix . 'pgrvw';
  $pgrvw_mbox = $wpdb->prefix . 'pgrvw_mbox';

  if($wpdb->get_var("show tables like '$pgrvw'") != $pgrvw)
  {
    $sql = "CREATE TABLE " . $pgrvw . " (
      id INT NOT NULL AUTO_INCREMENT,
      urllogo MEDIUMTEXT NULL ,
      title MEDIUMTEXT NULL ,
      parent_id BIGINT(20) NULL,
      review_type MEDIUMTEXT NOT NULL,
      score FLOAT NOT NULL,
      urlreview MEDIUMTEXT NULL ,
      urldownload MEDIUMTEXT NULL ,
      player MEDIUMTEXT NULL ,
      subtitle MEDIUMTEXT NULL ,
      descr MEDIUMTEXT NULL ,
      urlimg MEDIUMTEXT NULL ,
      ospc SMALLINT(1) NULL ,
      osmac SMALLINT(1) NULL ,
      offertitle MEDIUMTEXT NULL ,
      offervalue MEDIUMTEXT NULL ,
      offerbcode MEDIUMTEXT NULL ,
      offerbregular MEDIUMTEXT NULL ,
      fullhtml TEXT NULL ,
      name VARCHAR(80) NOT NULL,
      establish MEDIUMTEXT NULL ,
      country MEDIUMTEXT NULL ,
      auditor MEDIUMTEXT NULL ,
      network MEDIUMTEXT NULL ,
      size MEDIUMTEXT NULL ,
      email MEDIUMTEXT NULL ,
      tel MEDIUMTEXT NULL ,
      payvisa SMALLINT(1) NULL ,
      paymaster SMALLINT(1) NULL ,
      padeid BIGINT(20) NULL,
    PRIMARY KEY id (id)
    ) $charset_collate;";
    dbDelta($sql);
  }

  if($wpdb->get_var("show tables like '$pgrvw_mbox'") != $pgrvw_mbox)
  {
    $sql = "CREATE TABLE " . $pgrvw_mbox . " (
      id SMALLINT NOT NULL AUTO_INCREMENT,
      pid INT NOT NULL,
      title MEDIUMTEXT NULL ,
      rating FLOAT NOT NULL,
      descr MEDIUMTEXT NULL ,
    PRIMARY KEY id (id)
    ) $charset_collate;";
    dbDelta($sql);
  }
  // if all is passed , save the DBVERSION
  add_option("pgreview_db_version", PGREVIEW_VERSION);
}
//!!!INSTALL!!!End!!!

?>