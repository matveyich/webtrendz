<?php
/*
Plugin Name: WP Smart Image II
Plugin URI: http://www.lab.darioferrer.com
Description: Powerful, reliable and lightweight plugin which helps you to show post images and handle them as you wish. Essential tool specially builded for web designers and developers.
Author: Darío Ferrer (@metacortex)
Version: 0.1.5
Author URI: http://www.darioferrer.com
*/

/*  Copyright 2009 Darío Ferrer (wp@darioferrer.com)

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

if ( !defined('WP_PLUGIN_DIR') ) $wpsi_plugin_dir = str_replace( ABSPATH, '', dirname(__FILE__) );
else $wpsi_plugin_dir = dirname( plugin_basename(__FILE__) );
if ( function_exists('load_plugin_textdomain') ) {
	if ( !defined('WP_PLUGIN_DIR') ) 
		load_plugin_textdomain('wp-smart-image', str_replace( ABSPATH, '', dirname(__FILE__) ) );
	else 
		load_plugin_textdomain('wp-smart-image', false, dirname( plugin_basename(__FILE__) ) );
}
if ( isset($_POST['wpsi_agregar_datos']) ) wpsi_llenar_bd();
if ( isset($_POST['wpsi_remover_datos']) ) wpsi_vaciar_options();
if ( isset($_POST['wpsi_borrar_postmeta']) ) wpsi_vaciar_postmeta();
$wpsi_ruta = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];
$wpsi_ruta = str_replace('//' , '/' , $wpsi_ruta);
function wpsi_extension($args) {
	global $wpsi_plugin_dir, $wpsi_ruta;
	switch ($args) {
		case 'path':
			return $_SERVER['DOCUMENT_ROOT'] . PLUGINDIR . '/' . $wpsi_plugin_dir . '/';
		break;
		case 'url':
			return get_settings('siteurl') . '/' . PLUGINDIR . '/' . $wpsi_plugin_dir . '/';
		break;
		case 'dir':
			return $wpsi_plugin_dir;
		break;
		case 'file':
			return plugin_basename(__FILE__);
		break;
	}
}
$wpsi_archivo_php = dirname((__FILE__)).'/wpsi-config.php';
$wpsi_archivo_php = str_replace('\\' , '/' , $wpsi_archivo_php);
if ( file_exists($wpsi_archivo_php) ) {
	$wpsi_php = array();
	require_once $wpsi_archivo_php;
	$wpsi_configuracion = array();
}
$wpsi_config = get_option('wpsi_configuracion');
if ( $wpsi_modo_php ) {
	$wpsi_configuracion['wpsi_opcion_reemplazo'] = $wpsi_php['wpsi_opcion_reemplazo'];
	$wpsi_configuracion['wpsi_ruta_img'] = $wpsi_php['wpsi_ruta_img'];
	$wpsi_configuracion['wpsi_reemp_mini'] = $wpsi_php['wpsi_reemp_mini'];
	$wpsi_configuracion['wpsi_reemp_medio'] = $wpsi_php['wpsi_reemp_medio'];
	$wpsi_configuracion['wpsi_reemp_grande'] = $wpsi_php['wpsi_reemp_grande'];
	$wpsi_configuracion['wpsi_reemp_full'] = $wpsi_php['wpsi_reemp_full'];
	$wpsi_configuracion['wpsi_texto_alt'] = $wpsi_php['wpsi_texto_alt'];
	$wpsi_configuracion['wpsi_texto_title'] = $wpsi_php['wpsi_texto_title'];
	$wpsi_configuracion['wpsi_show_settings'] = $wpsi_php['wpsi_show_settings'];
	$wpsi_configuracion['wpsi_activar_metabox'] = $wpsi_php['wpsi_activar_metabox'];
	$wpsi_configuracion['wpsi_rss'] = $wpsi_php['wpsi_rss'];
	$wpsi_configuracion['wpsi_img_rss'] = $wpsi_php['wpsi_img_rss'];
	$wpsi_configuracion['wpsi_rdf'] = $wpsi_php['wpsi_rdf'];
	$wpsi_configuracion['wpsi_rss2'] = $wpsi_php['wpsi_rss2'];
	$wpsi_configuracion['wpsi_atom'] = $wpsi_php['wpsi_atom'];
	$wpsi_configuracion['wpsi_custom_compat'] = $wpsi_php['wpsi_custom_compat'];
	$wpsi_configuracion['wpsi_dtd'] = $wpsi_php['wpsi_dtd'];
} else {
	$wpsi_configuracion['wpsi_activar_metabox'] = ( isset($_POST['wpsi_activar_metabox'])) ? 1 : 0;
	$wpsi_configuracion['wpsi_custom_compat'] = ( isset($_POST['wpsi_custom_compat'])) ? 1 : 0;
	$wpsi_configuracion['wpsi_texto_alt_titulo'] = ( isset($_POST['wpsi_texto_alt_titulo'])) ? 1 : 0;
	$wpsi_configuracion['wpsi_texto_title_titulo'] = ( isset($_POST['wpsi_texto_title_titulo'])) ? 1 : 0;
	$wpsi_configuracion['wpsi_dtd'] = isset($_POST['wpsi_dtd']) ? $_POST['wpsi_dtd'] : $wpsi_config['wpsi_dtd'];
	$wpsi_configuracion['wpsi_rss'] = ( isset($_POST['wpsi_rss'])) ? 1 : 0;
	$wpsi_configuracion['wpsi_img_rss_cmtxt'] = isset($_POST['wpsi_img_rss_cmtxt']) ? $_POST['wpsi_img_rss_cmtxt'] : $wpsi_config['wpsi_img_rss_cmtxt'];
	if($_POST['wpsi_img_rss'] != 'custom') {
		if(isset($_POST['wpsi_img_rss_cmtxt'])) {
			$wpsi_configuracion['wpsi_img_rss_cmtxt'] = null;
		}
			$wpsi_configuracion['wpsi_img_rss'] = isset($_POST['wpsi_img_rss']) ? $_POST['wpsi_img_rss'] : $wpsi_config['wpsi_img_rss'];
	} else {
		if(!empty($_POST['wpsi_img_rss_cmtxt']))
			$wpsi_configuracion['wpsi_img_rss'] = isset($_POST['wpsi_img_rss_cmtxt']) ? $_POST['wpsi_img_rss_cmtxt'] : $wpsi_config['wpsi_img_rss_cmtxt'];
		else
			$wpsi_configuracion['wpsi_img_rss'] = 'thumbnail';
	}
	$wpsi_configuracion['wpsi_rdf'] = ( isset($_POST['wpsi_rdf']) and isset($_POST['wpsi_rss'])) ? 1 : 0;
	$wpsi_configuracion['wpsi_rss2'] = ( isset($_POST['wpsi_rss2']) and isset($_POST['wpsi_rss'])) ? 1 : 0;
	$wpsi_configuracion['wpsi_atom'] = ( isset($_POST['wpsi_atom']) and isset($_POST['wpsi_rss'])) ? 1 : 0;
	$wpsi_configuracion['wpsi_opcion_reemplazo'] = ( isset($_POST['wpsi_opcion_reemplazo'])) ? 1 : 0;
	$wpsi_configuracion['wpsi_ruta_img'] = isset($_POST['wpsi_ruta_img']) ? $_POST['wpsi_ruta_img'] : $wpsi_config['wpsi_ruta_img'];
	$wpsi_configuracion['wpsi_reemp_mini'] = isset($_POST['wpsi_reemp_mini']) ? $_POST['wpsi_reemp_mini'] : $wpsi_config['wpsi_reemp_mini'];
	$wpsi_configuracion['wpsi_reemp_medio'] = isset($_POST['wpsi_reemp_medio']) ? $_POST['wpsi_reemp_medio'] : $wpsi_config['wpsi_reemp_medio'];
	$wpsi_configuracion['wpsi_reemp_grande'] = isset($_POST['wpsi_reemp_grande']) ? $_POST['wpsi_reemp_grande'] : $wpsi_config['wpsi_reemp_grande'];
	$wpsi_configuracion['wpsi_reemp_full'] = isset($_POST['wpsi_reemp_full']) ? $_POST['wpsi_reemp_full'] : $wpsi_config['wpsi_reemp_full'];
	$wpsi_configuracion['wpsi_texto_alt'] = isset($_POST['wpsi_texto_alt']) ? $_POST['wpsi_texto_alt'] : $wpsi_config['wpsi_texto_alt'];
	$wpsi_configuracion['wpsi_texto_title'] = isset($_POST['wpsi_texto_title']) ? $_POST['wpsi_texto_title'] : $wpsi_config['wpsi_texto_title'];
	if ( isset($_POST['wp_smart_image_enviar']) ) update_option( 'wpsi_configuracion' , $wpsi_configuracion );
}
if ($wpsi_configuracion['wpsi_dtd'] == 'html') $dtdtag = '>'; else $dtdtag = ' />';
add_action('admin_menu', 'wpsi_options_page');
add_action('admin_head', 'wpsi_cargar_archivos');
add_action('wp_head', 'wpsi_cargar_header');
add_action('edit_post', 'wpsi_guardar_metabox_titulo');
activar_metabox();
wpsi_rss();

function wpsi_ruta($a) {
	$ruta = ABSPATH .'wp-admin/'. $a;
	$ruta = str_replace ('\\' , '/' , $ruta);
	return $ruta;
}

function wpsi_options_page() {
  add_options_page(__('WP Smart Image II', 'wp-smart-image'), __('WP Smart Image II', 'wp-smart-image'), 8, 'wp-smart-image-ii', 'wpsi_options');
}

function wpsi_texto_php($a) {
	global $wpsi_configuracion, $wpsi_php, $wpsi_modo_php;
	$txt = '';
	$trad = array(
		'thumbnail'  => __('Thumbnail size', 'wp-smart-image') ,
		'medium'  =>  __('Medium size', 'wp-smart-image') ,
		'large'  =>  __('Large size', 'wp-smart-image') ,
		'full'  =>  __('Full size', 'wp-smart-image') ,
		$wpsi_configuracion['wpsi_dtd'] => strtoupper($wpsi_configuracion['wpsi_dtd'])
	);
	if ( $wpsi_modo_php ) {
		if (!empty($wpsi_configuracion[$a])) {
			if($wpsi_configuracion[$a] == 1) {
				$txt .= '<span class="wpsi-fl-azul negrita">'.__('Yes', 'wp-smart-image').'</span>';
			} else {
				$txt .= strtr($wpsi_configuracion[$a] , $trad);
			}
		} else {
			$txt .= '<span class="wpsi-fl-rojo negrita">'.__('No', 'wp-smart-image').'</span>';
		}
	}
	return $txt;
}

function wpsi_options() {
	global $wpsi_ruta, $wpsi_modo_php, $wpsi_configuracion, $wpsi_plugin_dir, $wpsi_php, $wpsi_archivo_php;
	if($wpsi_modo_php) $wpsi_bd = $wpsi_php;
	else $wpsi_bd = get_option('wpsi_configuracion'); 			
	$opcion_reemplazo = $wpsi_bd['wpsi_opcion_reemplazo'];
	$custom_compat = $wpsi_bd['wpsi_custom_compat'];
	$wpsi_dtd = $wpsi_configuracion['wpsi_dtd'];
	$activar_metabox = $wpsi_bd['wpsi_activar_metabox'];
	$activar_rss = $wpsi_bd['wpsi_rss'];
	$img_rss = $wpsi_configuracion['wpsi_img_rss'];
	$custom_rss = $wpsi_configuracion['wpsi_img_rss_cmtxt'];
	$activar_rdf = $wpsi_bd['wpsi_rdf'];
	$activar_rss2 = $wpsi_bd['wpsi_rss2'];
	$activar_atom = $wpsi_bd['wpsi_atom'];
	$activar_alt_titulo = $wpsi_bd['wpsi_texto_alt_titulo'];
	$activar_title_titulo = $wpsi_bd['wpsi_texto_title_titulo'];
	$checked = ' checked="checked"';
	$disabled = ' disabled="disabled"';
	if($img_rss == $custom_rss) {
		if(empty($img_rss)) {
			$tamano_rss = 'thumbnail';
			$custom_rss_checked = '';
		} else {
			$tamano_rss = '';
			$custom_rss_checked = $checked;
		}
		$echo_rss = $img_rss;
	} else {
		$tamano_rss = $img_rss;
		$echo_rss = '';
	}
	if($activar_metabox) $metabox_checked = $checked;
	if($custom_compat) $compat_checked = $checked;
	if($opcion_reemplazo) {
		$reemplazo_checked = $checked;
		$reemplazo_clase = '';
	} else {
		$wpsi_opcion_reemplazo_disabled = $disabled;
		$reemplazo_clase = 'class="wpsi-js-gris"';
	}
	if($activar_rss) $rss_checked = $checked;
	else $rss_disabled = $disabled;
	if($activar_rdf) $rdf_checked = $checked;
	if($activar_rss2) $rss2_checked = $checked;
	if($activar_atom) $atom_checked = $checked;
	if($activar_alt_titulo) $alt_titulo_estatico_checked = $checked;
	if($activar_title_titulo) $title_titulo_estatico_checked = $checked;
?>

<div id="wpsi-contenedor">
<?php
if ( isset($_POST['wpsi_agregar_datos']) ) wpsi_aviso('restaurar');
if ( isset($_POST['wpsi_remover_datos']) ) wpsi_aviso('borrar');
if ( isset($_POST['wpsi_borrar_postmeta']) ) wpsi_aviso('postmeta');
if ( isset($_POST['wp_smart_image_enviar']) ) wpsi_aviso('guardar');
?>
	<h2><?php _e('WP Smart Image II - Settings', 'wp-smart-image') ?></h2>
	<ul id="wpsi-caja" class="wpsi-pestanas">
		<li class="wpsi-selected"><a href="#" rel="tcontent1"><?php _e('Settings', 'wp-smart-image') ?></a></li>
		<li><a href="#" rel="tcontent2"><?php _e('Help', 'wp-smart-image') ?></a></li>
	</ul>
	<div id="tcontent1" class="wpsi-contenido">
	<?php if ( $wpsi_modo_php ) { ?>
		<form action="" class="clase-wpsi-form form1">
			<fieldset>
		<div class="wpsi-phpmode">
		<p class="descripcion" style="text-align: center; margin: 0 0 10px;"><?php _e('PHP mode enabled', 'wp-smart-image') ?></p>
			<table class="wpsi-tabla">
				<tr>
					<th colspan="2"><?php _e('Where is my config file?', 'wp-smart-image') ?></th>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;">
						<p><?php _e('Your config file is here', 'wp-smart-image') ?>:</p>
						<p><span class="wpsi-fl-azul cursiva"><?php echo get_settings('siteurl') . '/' . PLUGINDIR . '/' . $wpsi_plugin_dir . '/wpsi-config.php'; ?></span></p>
						<p><?php _e('You can edit this file', 'wp-smart-image') ?> <a href="<?php echo get_settings('siteurl') ?>/wp-admin/plugin-editor.php?file=wp-smart-image-ii/wpsi-config.php&amp;plugin=wp-smart-image-ii/wpsi-config.php" target="_blank"><?php _e('directly from Wordpress interface', 'wp-smart-image') ?></a> <?php _e('or through you favorite text editor', 'wp-smart-image') ?>.</p>
						<p><span class="negrita"><?php _e('Notice', 'wp-smart-image') ?>:</span> <?php _e('Remember backup this file before updating the plugin. So you can preserve your settings', 'wp-smart-image') ?>.</p>
					</td>
				</tr>
				<tr>
					<th colspan="2"><?php _e('General settings', 'wp-smart-image') ?></th>
				</tr>

				<tr>
					<td class="param1"><?php _e('Activate editor box', 'wp-smart-image') ?>:</td>
					<td class="param2"><?php echo wpsi_texto_php('wpsi_activar_metabox') ?></td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Activate compatibility with', 'wp-smart-image') ?><br /><?php _e('Max Image Size Control plugin', 'wp-smart-image') ?>:</td>
					<td class="param2"><?php echo wpsi_texto_php('wpsi_custom_compat') ?></td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Website DTD', 'wp-smart-image') ?>:</td>
					<td class="param2"><?php echo wpsi_texto_php('wpsi_dtd') ?></td>
				</tr>
				<tr>
					<th colspan="2"><?php _e('Feed Settings', 'wp-smart-image') ?></th>
				</tr>
				<tr>
					<td class="param1"><?php _e('Enable images for feeds', 'wp-smart-image') ?>: </td>
					<td class="param2"><?php echo wpsi_texto_php('wpsi_rss') ?></td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Enabled feed engines', 'wp-smart-image') ?>:</td>
					<td class="param2">
					<?php if($wpsi_php['wpsi_rss']) { ?>
					<ul>
						<li>RSS/RDF: <?php echo wpsi_texto_php('wpsi_rdf') ?></li>
						<li>RSS2: <?php echo wpsi_texto_php('wpsi_rss2') ?></li>
						<li>Atom: <?php echo wpsi_texto_php('wpsi_atom') ?></li>
					</ul>
					<?php } else { ?>
					<span class="texto-disabled"><span class="negrita">&quot;<?php _e('Enable images for feeds', 'wp-smart-image') ?>&quot;</span> <?php _e('must be active before set this section', 'wp-smart-image') ?>.</span>
					<?php } ?>
					</td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Image size for feeds', 'wp-smart-image') ?>:</td>
					<td class="param2">
					<?php if($wpsi_php['wpsi_rss']) { ?>
						<?php echo wpsi_texto_php('wpsi_img_rss') ?>
					<?php } else { ?>
					<span class="texto-disabled"><span class="negrita">&quot;<?php _e('Enable images for feeds', 'wp-smart-image') ?>&quot;</span> <?php _e('must be active before set this section', 'wp-smart-image') ?>.</span>
					<?php } ?>
					</td>
				</tr>
				<tr>
					<th colspan="2"><?php _e('Default image settings', 'wp-smart-image') ?></th>
				</tr>
				<tr>
					<td class="param1"><?php _e('Enable Default Images', 'wp-smart-image') ?>:</td>
					<td class="param2"><?php echo wpsi_texto_php('wpsi_opcion_reemplazo') ?></td>
				</tr>
				<?php if($wpsi_php['wpsi_opcion_reemplazo']) { ?>
				<tr>
					<td class="param1"><?php _e('Default image path', 'wp-smart-image') ?>:</td>
					<td><?php echo wpsi_texto_php('wpsi_ruta_img') ?></td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Default image for thumbnail size', 'wp-smart-image') ?>:</td>
					<td><?php echo wpsi_texto_php('wpsi_reemp_mini') ?></td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Default image for medium size', 'wp-smart-image') ?>:</td>
					<td><?php echo wpsi_texto_php('wpsi_reemp_medio') ?></td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Default image for large size', 'wp-smart-image') ?>:</td>
					<td><?php echo wpsi_texto_php('wpsi_reemp_grande') ?></td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Default image for full size', 'wp-smart-image') ?>:</td>
					<td><?php echo wpsi_texto_php('wpsi_reemp_full') ?></td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Default ALT string', 'wp-smart-image') ?>:</td>
					<td><?php echo wpsi_texto_php('wpsi_texto_alt') ?></td>
				</tr>
				<tr>
					<td class="param1"><?php _e('Default TITLE string', 'wp-smart-image') ?>:</td>
					<td><?php echo wpsi_texto_php('wpsi_texto_title') ?></td>
				</tr>
				<?php } else { ?>
				<tr>
					<td class="param1"><?php _e('Default image options', 'wp-smart-image') ?>:</td>
					<td class="param2"><span class="texto-disabled"><span class="negrita">&quot;<?php _e('Enable Default Images', 'wp-smart-image') ?>&quot;</span> <?php _e('must be active before set this section', 'wp-smart-image') ?>.</span></td>
				</tr>
				<?php } ?>
			</table>
		</div>
			</fieldset>
		</form>
	<?php } else { ?>
		<form action="<?php echo attribute_escape( $_SERVER['REQUEST_URI'] ); ?>" method="post" id="wpsi-form" class="clase-wpsi-form form1" name="wpsi-form">
			<fieldset>
				<h3 class="wpsi-opciones-config"><?php _e('General settings', 'wp-smart-image') ?></h3>
				<p class="descripcion"><input type="checkbox" id="wpsi-activar-metabox" name="wpsi_activar_metabox" <?php echo $metabox_checked ?> /> <label for="wpsi-activar-metabox"><?php _e('Activate editor box', 'wp-smart-image') ?></label></p>
				<p class="explicacion"><?php _e('If checked, you don\'t need to sort images from menu anymore. You will can choose directly the image you wish from post editor through a sidebox. One little field per post will added in your DB _postmeta table. The activation of this function will not modifies any configuration you have been set before', 'wp-smart-image') ?>.</p>
				<p class="descripcion"><input type="checkbox" id="wpsi-custom-compat" name="wpsi_custom_compat" value="1" <?php echo $compat_checked ?> /> <label for="wpsi-custom-compat"><?php _e('Activate compatibility with', 'wp-smart-image') ?> <?php _e('Max Image Size Control plugin', 'wp-smart-image') ?></label></p>
				<p class="explicacion"><a href="http://wordpress.org/extend/plugins/max-image-size-control/"><?php _e('Max Image Size Control plugin', 'wp-smart-image') ?></a> <?php _e('adds the functionality to change the max image size each category and post. Even you can create extra sizes. Now you can integrate the power of both plugins', 'wp-smart-image') ?>.</p>
				<p class="descripcion"><?php _e('Select Document Type Declaration of this website (DTD)', 'wp-smart-image') ?></p>
				<p class="explicacion inputsradio">
					<input type="radio" name="wpsi_dtd" id="wpsi-dtd-xhtml" value="xhtml"<?php checked( $wpsi_dtd, 'xhtml' ); ?> />
					<label for="wpsi-dtd-xhtml">XHTML</label>
					<input type="radio" name="wpsi_dtd" id="wpsi-dtd-html" value="html"<?php checked( $wpsi_dtd, 'html' ); ?> />
					<label for="wpsi-dtd-html">HTML</label>
				</p>
				<p class="explicacion ultimo"><?php _e('You must to set the correct DTD of this site to point tags to right W3C validation. If you need more info about this topic, visit this', 'wp-smart-image') ?> <a href="http://<?php _e('en.wikipedia.org/wiki/Document_Type_Declaration', 'wp-smart-image') ?>" target="_blank"><?php _e('comprehensive Wikipedia article', 'wp-smart-image') ?></a> <?php _e('or', 'wp-smart-image') ?> <?php _e('<a href="http://wordpress.org/support/" target="_blank">ask in the Wordpress Forum</a>', 'wp-smart-image') ?>.</p>
			</fieldset>
			<fieldset>
				<h3 class="wpsi-opciones-rss"><?php _e('Feed Settings', 'wp-smart-image') ?></h3>
				<p class="descripcion"><input type="checkbox" id="wpsi-rss" name="wpsi_rss" onclick="rsschecked(this.form)" <?php echo $rss_checked ?> /> <label for="wpsi-rss"><?php _e('Show thumbnails in RSS feed', 'wp-smart-image') ?></label></p>
				<p class="explicacion"><?php _e('Check this box if you want to show thumbnails in your feeds. Otherwise leave it blank', 'wp-smart-image') ?>.</p>
				<p class="descripcion"><?php _e('Select image size', 'wp-smart-image') ?></p>
				<p class="explicacion inputsradio">
					<input type="radio" name="wpsi_img_rss" id="wpsi-img-rss-th" value="thumbnail"<?php echo $rss_disabled; checked( $tamano_rss, 'thumbnail' ); ?> />
					<label for="wpsi-img-rss-th"><?php _e('Thumbnail', 'wp-smart-image') ?></label>
					<input type="radio" name="wpsi_img_rss" id="wpsi-img-rss-md" value="medium"<?php echo $rss_disabled; checked( $tamano_rss, 'medium' ); ?> />
					<label for="wpsi-img-rss-md"><?php _e('Medium', 'wp-smart-image') ?></label>
					<input type="radio" name="wpsi_img_rss" id="wpsi-img-rss-lg" value="large"<?php echo $rss_disabled; checked( $tamano_rss, 'large' ); ?> />
					<label for="wpsi-img-rss-lg"><?php _e('Large', 'wp-smart-image') ?></label>
					<input type="radio" name="wpsi_img_rss" id="wpsi-img-rss-fl" value="full"<?php echo $rss_disabled; checked( $tamano_rss, 'full' ); ?> />
					<label for="wpsi-img-rss-fl"><?php _e('Full', 'wp-smart-image') ?></label>
				<?php if($custom_compat) { ?>
					<input type="radio" class="displaynone" name="wpsi_img_rss" id="wpsi-img-rss-cm" value="custom"<?php echo $custom_rss_checked; ?> />
					<label for="wpsi-img-rss-cmtxt"><?php _e('Custom size', 'wp-smart-image') ?>:</label>
					<input type="text" name="wpsi_img_rss_cmtxt" id="wpsi-img-rss-cmtxt" value="<?php echo $echo_rss; ?>"<?php echo $rss_disabled; ?> onclick="form.wpsi_img_rss[4].checked=true;" />
				<?php } ?></p>
				<p class="explicacion"><?php _e('Choose the image size for the feeds', 'wp-smart-image') ?>.</p>
				<p class="descripcion">
					<?php _e('Enable images for the following RSS engines', 'wp-smart-image') ?>: 
					<span class="chiquita">
						<input type="checkbox" id="wpsi-rdf" name="wpsi_rdf"<?php echo $rdf_checked.$rss_disabled ?> /> <label for="wpsi-rdf">RSS/RDF</label> - 
						<input type="checkbox" id="wpsi-rss2" name="wpsi_rss2"<?php echo $rss2_checked.$rss_disabled ?> /> <label for="wpsi-rss2">RSS2</label> - 
						<input type="checkbox" id="wpsi-atom" name="wpsi_atom"<?php echo $atom_checked.$rss_disabled ?> /> <label for="wpsi-atom">Atom</label>
					</span>
				</p>
				<p class="explicacion ultimo"><?php _e('Here you can apply the WP Smart Image function for one or several RSS environment', 'wp-smart-image') ?>.</p>
			</fieldset>
			<fieldset>
				<h3 class="wpsi-opciones-img"><?php _e('Default image settings', 'wp-smart-image') ?></h3>
				<p class="descripcion"><label for="wpsi-opcion-reemplazo"><?php _e('Enable Default Images', 'wp-smart-image') ?>:</label> <input type="checkbox" name="wpsi_opcion_reemplazo" id="wpsi-opcion-reemplazo" onclick="reemplazochecked(this.form)" <?php echo $reemplazo_checked; ?> /></p>
				<p class="explicacion"><?php _e('If checked, imageless posts will show, by default, the images you have been set below', 'wp-smart-image') ?>.</p>
				<p class="descripcion"><label for="wpsi_ruta_img"><?php _e('Default image path', 'wp-smart-image') ?></label></p>
				<p class="formulario"><input type="text" name="wpsi_ruta_img" id="wpsi_ruta_img"<?php echo $reemplazo_clase; ?> value="<?php echo $wpsi_configuracion['wpsi_ruta_img'] ?>"<?php echo $wpsi_opcion_reemplazo_disabled ?> /></p>
				<p class="explicacion"><?php _e('Change this path if you like to custom image folder location.', 'wp-smart-image') ?></p>
				<div class="wpsi-separador wpsi-linea"></div>
				<div class="wpsi-izquierda linea-abajo">
					<p class="descripcion"><label for="wpsi_reemp_mini"><?php _e('Default image for thumbnail size', 'wp-smart-image') ?></label></p>
					<p class="formulario"><input type="text" name="wpsi_reemp_mini" id="wpsi_reemp_mini"<?php echo $reemplazo_clase; ?> value="<?php echo $wpsi_configuracion['wpsi_reemp_mini'] ?>"<?php echo $wpsi_opcion_reemplazo_disabled ?> /></p>
					<p class="explicacion"><?php _e('Set thumbnail filename to show in case it not exists one on your post.', 'wp-smart-image') ?></p>
				</div>
				<div class="wpsi-derecha linea-abajo">
					<p class="descripcion"><label for="wpsi_reemp_medio"><?php _e('Default image for medium size', 'wp-smart-image') ?></label></p>
					<p class="formulario"><input type="text" name="wpsi_reemp_medio" id="wpsi_reemp_medio"<?php echo $reemplazo_clase; ?> value="<?php echo $wpsi_configuracion['wpsi_reemp_medio'] ?>"<?php echo $wpsi_opcion_reemplazo_disabled ?> /></p>
					<p class="explicacion"><?php _e('Set medium size filename to show in case it not exists one on your post.', 'wp-smart-image') ?></p>
				</div>
				<div class="wpsi-separador"></div>
				<div class="wpsi-izquierda linea-arriba">
					<p class="descripcion"><label for="wpsi_reemp_grande"><?php _e('Default image for large size', 'wp-smart-image') ?></label></p>
					<p class="formulario"><input type="text" name="wpsi_reemp_grande" id="wpsi_reemp_grande"<?php echo $reemplazo_clase; ?> value="<?php echo $wpsi_configuracion['wpsi_reemp_grande'] ?>"<?php echo $wpsi_opcion_reemplazo_disabled ?> /></p>
					<p class="explicacion ultimo"><?php _e('Set large size filename to show in case it not exists one on your post.', 'wp-smart-image') ?></p>
				</div>
					<div class="wpsi-derecha linea-arriba">
					<p class="descripcion"><label for="wpsi_reemp_full"><?php _e('Default image for full size', 'wp-smart-image') ?></label></p>
					<p class="formulario"><input type="text" name="wpsi_reemp_full" id="wpsi_reemp_full"<?php echo $reemplazo_clase; ?> value="<?php echo $wpsi_configuracion['wpsi_reemp_full'] ?>"<?php echo $wpsi_opcion_reemplazo_disabled ?> /></p>
					<p class="explicacion ultimo"><?php _e('Set full size filename to show in case it not exists one on your post.', 'wp-smart-image') ?></p>
				</div>
				<div class="wpsi-separador"></div>
			</fieldset>
			<fieldset>
				<h3 class="wpsi-opciones-texto"><?php _e('Default Alt &amp; Title settings', 'wp-smart-image') ?></h3>
				<p class="descripcion"><label for="wpsi_texto_alt"><?php _e('Default ALT string:', 'wp-smart-image') ?></label></p>
				<p class="formulario">
					<input type="text" class="seiscientos" name="wpsi_texto_alt" id="wpsi_texto_alt"<?php echo $reemplazo_clase; ?> value="<?php echo $wpsi_configuracion['wpsi_texto_alt'] ?>"<?php echo $wpsi_opcion_reemplazo_disabled ?> />
					<label for="wpsi-texto-alt-titulo" class="chiquita negrita" style="margin-left: 4px;"><?php _e('Use post title as', 'wp-smart-image') ?> ALT</label> <input type="checkbox" style="margin-left: 4px;" name="wpsi_texto_alt_titulo" id="wpsi-texto-alt-titulo" <?php echo $alt_titulo_estatico_checked; ?> />
				</p>
				<p class="explicacion"><?php _e('Enter some text to define ALT attribute for default images.', 'wp-smart-image') ?></p>
				<p class="descripcion"><label for="wpsi_texto_title"><?php _e('Default TITLE string:', 'wp-smart-image') ?></label></p>
				<p class="formulario">
					<input type="text" name="wpsi_texto_title" class="seiscientos" id="wpsi_texto_title"<?php echo $reemplazo_clase; ?> value="<?php echo $wpsi_configuracion['wpsi_texto_title'] ?>"<?php echo $wpsi_opcion_reemplazo_disabled ?> />
					<label for="wpsi-texto-title-titulo" class="chiquita negrita" style="margin-left: 4px;"><?php _e('Use post title as', 'wp-smart-image') ?> TITLE</label> <input type="checkbox" style="margin-left: 4px;" name="wpsi_texto_title_titulo" id="wpsi-texto-title-titulo" <?php echo $title_titulo_estatico_checked; ?> />
				</p>
				<p class="explicacion ultimo"><?php _e('Enter some text to define TITLE attribute for default images.', 'wp-smart-image') ?></p>
			</fieldset>
			<p class="enviar"><input type="submit" name="wp_smart_image_enviar" value="<?php _e('Update options &raquo;', 'wp-smart-image') ?>" class="button-primary" /></p>
		</form>
		<form action="<?php echo attribute_escape( $_SERVER['REQUEST_URI'] ); ?>" method="post" id="wpsi-remover-datos" class="clase-wpsi-form form3" name="wpsi-remover-datos">
			<fieldset>
				<h3 class="wpsi-opciones-eliminar"><?php _e('Restoring / Destroying data', 'wp-smart-image') ?></h3>
				<p><span class="aviso"><?php _e('Warning!', 'wp-smart-image') ?></span> <?php _e('If you click the wrong button, you will loose all you have been set manually', 'wp-smart-image') ?></p>
				<p class="submit">
				<input type="submit" title="<?php _e('Remove plugin database info', 'wp-smart-image') ?>" name="wpsi_remover_datos" OnClick="return confirm('<?php _e('Sure you want remove plugin database entry?', 'wp-smart-image') ?>');" value="<?php _e('Remove data', 'wp-smart-image') ?>" />
				<input type="submit" title="<?php _e('Populate/Restore plugin database info', 'wp-smart-image') ?>" name="wpsi_agregar_datos" OnClick="return confirm('<?php _e('Sure you want populate plugin database entry with default data?', 'wp-smart-image') ?>');" value="<?php _e('Populate/Restore data', 'wp-smart-image') ?>" />
				<input type="submit" title="<?php _e('Delete post_meta info', 'wp-smart-image') ?>" name="wpsi_borrar_postmeta" OnClick="return confirm('<?php _e('Sure you want delete post_meta info? This will delete all configurations you have been set through editor! Better think twice buddy!', 'wp-smart-image') ?>');" value="<?php _e('Delete post_meta info', 'wp-smart-image') ?>" />
				</p>
				<p class="explicacion" style="margin-top: 10px;"><span class="negrita rojo"><?php _e('Remove data', 'wp-smart-image') ?>:</span> <?php _e('Use it to remove the "wpsi_configuracion" field from the "_options" table of your DB. All default settings will be deleted', 'wp-smart-image') ?>.</p>
				<p class="explicacion"><span class="negrita"><?php _e('Populate/Restore plugin database info', 'wp-smart-image') ?>:</span> <?php _e('This button loads some default data to your DB. Use it as start guide to place your own data', 'wp-smart-image') ?>.</p>
				<p class="explicacion"><span class="negrita wpsi-fl-rojo"><?php _e('Delete post_meta info', 'wp-smart-image') ?>:</span> <?php _e('Be careful with this button, because if you press it, all your WP Smart Image postmeta fields will be deleted. Postmeta fields are all the custom setting generated from your editor box, as post image shown', 'wp-smart-image') ?>.</p>
			</fieldset>
		</form>
	<?php } ?>
	</div>
	<div id="tcontent2" class="wpsi-contenido">
		<div id="wpsi-logo"><?php _e('WP Smart Image', 'wp-smart-image') ?> - <?php _e('Essential resource for web designers', 'wp-smart-image') ?></div>
			<h3><?php _e('Get support!', 'wp-smart-image') ?></h3>
			<ul>
				<li><a class="negrita" href="http://www.lab.darioferrer.com/" target="_blank"><?php _e('WP Smart Image II - Main support site', 'wp-smart-image') ?></a>: <?php _e('A growing plugin codex', 'wp-smart-image') ?>.</li>
				<li><a class="negrita" href="<?php _e('http://www.lab.darioferrer.com/doc/index.php?title=WPSI_II_-_Parameters_Table', 'wp-smart-image') ?>" target="_blank"><?php _e('Parameters table', 'wp-smart-image') ?></a>: <?php _e('A complete index of parameters, well detailed and explained', 'wp-smart-image') ?>.</li>
				<li><a class="negrita" href="<?php _e('http://www.lab.darioferrer.com/doc/index.php?title=WPSI_II_-_Examples,_tricks_and_hacks', 'wp-smart-image') ?>" target="_blank"><?php _e('Examples, tricks and hacks', 'wp-smart-image') ?></a>: <?php _e('Discover more than one way to exploit all power from WP Smart Image II', 'wp-smart-image') ?>.</li>
				<li><a class="negrita" href="<?php _e('http://www.lab.darioferrer.com/doc/index.php?title=WPSI_II_-_Working_on_PHP_Mode', 'wp-smart-image') ?>" target="_blank"><?php _e('Working on PHP Mode:', 'wp-smart-image') ?></a>: <?php _e('All you need to know to activate the PHP Mode on WP Smart Image II', 'wp-smart-image') ?>.</li>
				<li><a class="negrita" href="http://www.darioferrer.com/que/" target="_blank"><?php _e('Direct support', 'wp-smart-image') ?></a>: <?php _e('Get help from the Forum Board', 'wp-smart-image') ?>.</li>
				<li><a class="negrita" href="http://www.lab.darioferrer.com/trac" target="_blank"><?php _e('WP Smart Image II Trac', 'wp-smart-image') ?></a>: <?php _e('Here you can report bugs and request new features', 'wp-smart-image') ?>.</li>
			</ul>
		</div>
		<div class="wpsi-separador"></div>
</div>
<script type="text/javascript">initializetabcontent("wpsi-caja")</script>

<?php }
function wpsi_cargar_archivos() {
	global $wpsi_ruta, $wpsi_plugin_dir;
// Css y javascripts para el panel
// Css and javascript for panel
	echo '
<script type="text/javascript" src="' . get_settings('siteurl') . '/' . PLUGINDIR . '/' . $wpsi_plugin_dir . '/js/tabcontent.js"></script>
<link rel="stylesheet" type="text/css" href="' . get_settings('siteurl') . '/' . PLUGINDIR . '/' . $wpsi_plugin_dir . '/css/estilos.css" />
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" href="' . get_settings('siteurl') . '/' . PLUGINDIR . '/' . $wpsi_plugin_dir . '/css/ie.css" />
<![endif]-->
<script type="text/javascript">
function wpsiCheck(obj,idcheckbox){
	if (obj.checked==false) {
        document.getElementById(idcheckbox).disabled=true;
		document.getElementById(idcheckbox).style.background=\'#f5f5f5\';
		document.getElementById(idcheckbox).style.cursor=\'default\';
		document.getElementById(idcheckbox).style.color=\'#999\';
		} else {
        document.getElementById(idcheckbox).disabled=false;
		document.getElementById(idcheckbox).style.background=\'#ffffff\';
		document.getElementById(idcheckbox).style.cursor=\'text\';
		document.getElementById(idcheckbox).style.color=\'#555555\';
	}
}
</script>';
	if( $wpsi_ruta == wpsi_ruta('options-general.php?page=wp-smart-image-ii') ) {
		echo '
<style type="text/css">
#wpsi-contenedor h3.wpsi-logo {';
if( WPLANG == es_ES)
echo 'background: url(' . get_settings('siteurl') . '/' . PLUGINDIR . '/' . $wpsi_plugin_dir . '/img/logo-es_ES.gif) no-repeat;
width: 354px;';
if( WPLANG == fr_FR)
echo 'background: url(' . get_settings('siteurl') . '/' . PLUGINDIR . '/' . $wpsi_plugin_dir . '/img/logo-fr_FR.gif) no-repeat;
width: 345px;';
else echo 'background: url(' . get_settings('siteurl') . '/' . PLUGINDIR . '/' . $wpsi_plugin_dir . '/img/logo-en_US.gif) no-repeat;
width: 321px;';
echo '}
</style>
<script type="text/javascript">
<!-- 
document.write(\'<style type="text/css">.wpsi-contenido{display:none;}<\/style>\');
 -->
</script>
<script type="text/javascript">
	function rsschecked(form) {
		if (form.wpsi_rss.checked == true) {
			form.wpsi_img_rss[0].disabled = false;
			form.wpsi_img_rss[1].disabled = false;
			form.wpsi_img_rss[2].disabled = false;
			form.wpsi_img_rss[3].disabled = false;
			form.wpsi_img_rss[4].disabled = false;
			form.wpsi_img_rss_cmtxt.disabled = false;
			form.wpsi_rdf.disabled = false;
			form.wpsi_rss2.disabled = false;
			form.wpsi_atom.disabled = false;
		} else {
			form.wpsi_img_rss[0].disabled = true;
			form.wpsi_img_rss[1].disabled = true;
			form.wpsi_img_rss[2].disabled = true;
			form.wpsi_img_rss[3].disabled = true;
			form.wpsi_img_rss[4].disabled = true;
			form.wpsi_img_rss_cmtxt.disabled = true;
			form.wpsi_rdf.disabled = true;
			form.wpsi_rss2.disabled = true;
			form.wpsi_atom.disabled = true;
		}
	}';
$wpsi_estilos_js2 = array('wpsi_ruta_img' , 'wpsi_reemp_mini' , 'wpsi_reemp_medio' , 'wpsi_reemp_grande' , 'wpsi_reemp_full' , 'wpsi_texto_alt' , 'wpsi_texto_title');
echo'
function reemplazochecked(form) {
	if (form.wpsi_opcion_reemplazo.checked == true) {';
foreach ($wpsi_estilos_js2 as $wejs2) {
echo'
		form.'.$wejs2.'.disabled = false;
		form.'.$wejs2.'.style.background=\'#ffffff\';
		form.'.$wejs2.'.style.cursor=\'text\';
		form.'.$wejs2.'.style.color=\'#555555\';';
}
echo'
	} else {';
foreach ($wpsi_estilos_js2 as $wejs2) {
echo'
		form.'.$wejs2.'.disabled = true;
		form.'.$wejs2.'.style.background=\'#f5f5f5\';
		form.'.$wejs2.'.style.cursor=\'default\';
		form.'.$wejs2.'.style.color=\'#999999\';';
}
echo'
		}
	}
</script>
';
	}
}

function wpsi_aviso($a) {
	switch ($a) {
		case 'borrar':
			$txt = __('The field "wpsi_configuracion" are removed from database', 'wp-smart-image');
		break;
		case 'restaurar':
			$txt = __('All default settings are loaded', 'wp-smart-image');
		break;
		case 'postmeta':
			$txt = __('All WP Smart Image postmeta fields are removed from database', 'wp-smart-image');
		break;
		case 'guardar':
			$txt = __('All settings are saved', 'wp-smart-image');
		break;
	}
	echo '<div id="message" class="updated fade"><p>'.__($txt, 'wp-smart-image').'</p></div>';
}

function wpsi_llenar_bd() {
	global $wpsi_plugin_dir;
	$wpsi_config_predet = array(
		'wpsi_ruta_img'		=> get_settings('siteurl') . '/' . PLUGINDIR . '/' . $wpsi_plugin_dir .'/img/',
		'wpsi_reemp_mini'	=> 'noimg-mini.jpg',
		'wpsi_reemp_medio'	=> 'noimg-med.jpg',
		'wpsi_reemp_grande' => 'noimg-big.jpg',
		'wpsi_reemp_full'	=> 'noimg-full.jpg',
		'wpsi_texto_alt'	=> __('Article image', 'wp-smart-image'),
		'wpsi_texto_title'	=> __('Go to article', 'wp-smart-image'),
		'wpsi_opcion_reemplazo'	=> 1,
		'wpsi_custom_compat'	=> 0,
		'wpsi_activar_metabox'	=> 1,
		'wpsi_rss'	=> 1,
		'wpsi_img_rss'	=> 'thumbnail',
		'wpsi_rdf'	=> 1,
		'wpsi_rss2'	=> 1,
		'wpsi_dtd'	=> 'xhtml'
	);
	update_option( 'wpsi_configuracion' , $wpsi_config_predet );
}	

function wpsi_vaciar_options() {
	delete_option( 'wpsi_configuracion' );
}

function wpsi_vaciar_postmeta() {
	global $wpdb;
	$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_wpsi_foto_lista'" );
}

function wpsi_img_rss() {
	global $post, $wpsi_modo_php, $wpsi_php;
	if($wpsi_modo_php) $wpsi_bd = $wpsi_php;
	else $wpsi_bd = get_option('wpsi_configuracion');
	$img_rss = $wpsi_bd['wpsi_img_rss'];
	$wpsi_postmeta_valor = get_post_meta( $post->ID, '_wpsi_foto_lista', true );
	if(!is_array($wpsi_postmeta_valor)) $wpsi_postmeta = $wpsi_postmeta_valor;
	else $wpsi_postmeta = $wpsi_postmeta_valor[0];
	$wpsiext = get_post($wpsi_postmeta);
	$wpsiext_ruta = wp_get_attachment_image_src( $wpsiext->ID, $img_rss );
	$img ='';
	$images = get_children(array(
		'post_parent'    => $post->ID,
		'post_type'      => 'attachment',
		'numberposts'    => 1,
		'post_mime_type'  => 'image',
		'orderby'      => 'menu_order',
		'order'        => 'ASC'
	));
	if($images) {
		if($wpsi_bd['wpsi_rss']) {
			foreach( $images as $image ) {
				if ( !wp_attachment_is_image( $image->ID ) ) $image = false;
				$wpsi_metabox = $wpsi_bd['wpsi_activar_metabox'];
				$ruta = '';
				if($wpsi_metabox and $wpsi_postmeta) {
					$ruta = $wpsiext_ruta;
				} else {
					$ruta = wp_get_attachment_image_src( $image->ID, $img_rss );
				}
				$img .='<enclosure url="'.$ruta[0].'" type="image/jpg" />';
			}
		}
	}
	echo $img;
}

function wpsi_rss() {
	global $wpsi_modo_php, $wpsi_php;
	if($wpsi_modo_php) $wpsi_bd = $wpsi_php;
	else $wpsi_bd = get_option('wpsi_configuracion');
	$activar_rss = $wpsi_bd['wpsi_rss'];
	$activar_rdf = $wpsi_bd['wpsi_rdf'];
	$activar_rss2 = $wpsi_bd['wpsi_rss2'];
	$activar_atom = $wpsi_bd['wpsi_atom'];
	if($activar_rss) {
		if($activar_rdf) {
			add_action('rss_item', 'wpsi_img_rss');
			add_action('rdf_item', 'wpsi_img_rss');
		}
		if($activar_rss2) add_action('rss2_item', 'wpsi_img_rss');
		if($activar_atom) add_action('atom_entry', 'wpsi_img_rss');
	}
}

function wpsi_cargar_header() { 
// Pequeño javascript agregado para el target_blank
// A little javascript added for target_blank	
echo 
'<script type="text/javascript"><!--//--><![CDATA[//><!--
function prepareTargetBlank() {
	var className = \'wpsi-blank\';
	var as = document.getElementsByTagName(\'a\');
	for(i=0;i<as.length;i++) {
		var a = as[i];
		r=new RegExp("(^| )"+className+"($| )");
		if(r.test(a.className)) {
			a.onclick = function() {
				window.open(this.href);
				return false;
			}
		}
	}
}
window.onload = prepareTargetBlank;
//--><!]]>
</script>';
}

function wpsi_metabox() {
	global $post;
	$imagenes = get_children( array( 
		'post_parent' => $post->ID, 
		'post_type' => 'attachment', 
		'post_mime_type' => 'image',
		'orderby' => 'menu_order', 
		'order' => 'ASC'
	));
	$wpsi_postmeta = get_post_meta( $post->ID, '_wpsi_foto_lista', true );
	if(is_array($wpsi_postmeta)) $wpsi_img_externa = isset($_POST['wpsi_img_externa']) ? $_POST['wpsi_img_externa'] : $wpsi_postmeta[0];
	if( $wpsi_img_externa )
		$externo_checked = ' checked="ckecked"';
	$wpsiext = get_post($wpsi_img_externa);
	if ( !wp_attachment_is_image( $wpsiext->ID ) )
		$wpsiext = false;
	if ( $item_ext = wp_get_attachment_image_src( $wpsi_img_externa, 'thumbnail' ) )
	$grande_ext = wp_get_attachment_image_src( $wpsi_img_externa, 'full' );
	$wpsi_parent_ext = get_post($wpsiext->post_parent);
	$resultado = wp_nonce_field( 'wpsi_metabox_args', '_wpsi_nonce', false, true );
	$resultado .= '
	<div id="wpsi-box-contenedor" class="wpsi-fl-contenedor">
		<table class="wpsi-fl-tabla">';
			if( !empty($imagenes) and !empty($post->ID) ) {
				$keys = array_keys($imagenes);
				$num = $keys[0];
				foreach ( $imagenes as $imagen ) {
					$ident = $imagen->ID;
					$wpsi_inputbox_ident_disabled = '';
					$wpsi_inputbox_ident = $_POST['wpsi_inputbox_'.$ident];
					if ( !$wpsi_inputbox_ident ) $wpsi_inputbox_ident_disabled = ' disabled ="disabled"';
					$wpsi_fotobox_titulo = $imagen->post_title;
					if ( $item = wp_get_attachment_image_src($imagen->ID, 'thumbnail') )
						$grande = wp_get_attachment_image_src($imagen->ID, 'full');
					$columna_id = ' id="wpsi-col-'.$ident.'"';
					$listabox = ' id="wpsi-col-'.$wpsi_postmeta.'"';
					if($listabox == $columna_id)
						$columna_id = str_replace( $columna_id , ' id="wpsi-gris"' , $columna_id );
					if ( $wpsi_postmeta ) {
						$foto_lista_checked = $ident == $wpsi_postmeta ? ' checked="ckecked"' : '';
						$aleatorio_checked = 'aleatorio' == $wpsi_postmeta ? ' checked="ckecked"' : '';
					} else { 
						$foto_lista_checked = $ident == $num ? 'checked="ckecked" ' : ''; 
					}	
					$resultado .= '
					<tr class="wpsibox-titulo">
						<th colspan="3">
							'.__('Title', 'wp-smart-image').': 
							<input type="text" id="wpsi-fotobox-title-'.$ident.'" name="wpsi_fotobox_title_'.$ident.'" value="'.$wpsi_fotobox_titulo.'"'. $wpsi_inputbox_ident_disabled .' class="wpsi-input-fotobox" autocomplete="off" />
							<input type="checkbox" name="wpsi_inputbox[]"  value="'.$ident.'" id="wpsi-inputbox-'.$ident.'" onclick="wpsiCheck(this,\'wpsi-fotobox-title-'.$ident.'\')" />
							<label for="wpsi-inputbox-'.$ident.'">'.__('Edit', 'wp-smart-image').'</label>
						</th>
					</tr>
					<tr'.$columna_id.' class="wpsi-col" onmouseover="this.style.cursor=\'pointer\';" onclick="getElementById(\'boton_'.$ident.'\').checked = true;">
						<td class="wpsi-fl-input">
							<input type="radio" name="wpsi_foto_lista" id="boton_'.$ident.'" value="'.$ident.'" '.$foto_lista_checked.'/>
						</td>
						<td class="wpsi-fl-img">
							<a href="'.$grande[0].'" target="_blank" title="'.__('View original in new window', 'wp-smart-image').'"><img src="'.$item[0].'" width="48" height="48" /></a>
						</td>
						<td class="wpsi-fl-datos">
							<p><span class="negrita">'.__('Image ID', 'wp-smart-image').':</span> '.$imagen->ID.'</p>
							<p><span class="negrita">'.__('Type', 'wp-smart-image').':</span> '.$imagen->post_mime_type.'</p>
							<p><span class="negrita">'.__('W:', 'wp-smart-image').'</span> '.$grande[1].'px | <span class="negrita">'.__('H:', 'wp-smart-image').'</span> '.$grande[2].'px</p>
						</td>
					</tr>
					';
				} // endforeach
				$resultado .= '
				<tr>
					<th colspan="3">'.__('Random images', 'wp-smart-image').'</th>
				</tr>
				<tr id="wpsi-col-aleatorio" class="wpsi-col" onmouseover="this.style.cursor=\'pointer\';" onclick="getElementById(\'boton_aleatorio\').checked = true;">
					<td class="wpsi-fl-input">
						<input type="radio" name="wpsi_foto_lista" id="boton_aleatorio" value="aleatorio" '.$aleatorio_checked.'/>
					</td>
					<td colspan="3">
						<p>'.__('If checked, the images will shown randomly. Very useful in some cases, as dynamic headers, backgrounds or widgets', 'wp-smart-image').'</p>
					</td>
				</tr>
				<tr>
					<th colspan="3">'.__('Load image from Media Library', 'wp-smart-image').'</th>
				</tr>';
					if($wpsi_img_externa) {
						if($wpsiext->ID != '') {
						$resultado .='
				<tr id="wpsi-col-aleatorio" class="wpsi-col" onmouseover="this.style.cursor=\'pointer\';" onclick="getElementById(\'boton_externo\').checked = true;">
					<td class="wpsi-fl-input">
						<input type="radio" name="wpsi_foto_lista" id="boton_externo" autocomplete="off" value="externo"'.$externo_checked.' />
					</td>
						<td class="wpsi-fl-img">
							<a href="'.$grande_ext[0].'" target="_blank" title="'.__('View original in new window', 'wp-smart-image').'"><img src="'.$item_ext[0].'" width="48" height="48" /></a>
						</td>
						<td class="wpsi-fl-datos">
							<p><span class="negrita">'.__('Image ID', 'wp-smart-image').':</span>
							<input type="text" name="wpsi_img_externa[]" id="wpsi_img_externa" autocomplete="off" value="'. $wpsi_img_externa .'" class="wpsi-input-externo" /></p><p><span class="negrita">'.__('Attached to post', 'wp-smart-image').':</span> ';	
							if($wpsi_parent_ext->ID == $wpsiext->post_parent)
								$resultado .= '<a href="post.php?action=edit&amp;post='.$wpsi_parent_ext->ID.'" title="'.$wpsi_parent_ext->post_title.'" target="_blank">'.$wpsi_parent_ext->ID.'</a></p>';
							else
								$resultado .= 'None</p>';
							$resultado .= '
							<p><span class="negrita">'.__('Type', 'wp-smart-image').':</span> '.$wpsiext->post_mime_type.'</p>
							<p><span class="negrita">'.__('W:', 'wp-smart-image').'</span> '.$grande_ext[1].'px | <span class="negrita">'.__('H:', 'wp-smart-image').'</span> '.$grande_ext[2].'px</p>
							<p><a href="media.php?action=edit&attachment_id='.$wpsiext->ID.'" target="_blank">Edit image</a></p>
						</td>
					</tr>';
						} else {
							$resultado .='
							<tr id="wpsi-fotolista-externo" class="wpsi-col" onmouseover="this.style.cursor=\'pointer\';" onclick="getElementById(\'boton_externo\').checked = true;">
								<td colspan="3">
									<p class="negrita"><span class="wpsi-fl-rojo">'.__('Error', 'wp-smart-image').':</span> '.__('Thid ID is not assigned to any image. Try again', 'wp-smart-image').'.</p>
									<p><span class="negrita">'.__('Image ID', 'wp-smart-image').':</span>
									<input type="radio" name="wpsi_foto_lista" id="boton_externo" autocomplete="off" value="externo"'.$externo_checked.' style="display: none" />
									<input type="text" name="wpsi_img_externa[]" id="wpsi_img_externa" autocomplete="off" value="'. $wpsi_img_externa .'" class="wpsi-input-externo" /></p>	
								</td>
							</tr>';
						}
					$resultado .= '
							<tr>
								<td colspan="3">
									<p>'.__('Always you can choose and publish any image stored on your ', 'wp-smart-image').' <a href="upload.php" target="_blank">'.__('Media Library', 'wp-smart-image').'</a>.</p>
								</td>
							</tr>';
				} else {
					$resultado .='
				<tr id="wpsi-fotolista-externo" class="wpsi-col">
					<td colspan="3">
						<p>'.__('Visit your', 'wp-smart-image').' <a href="upload.php" target="_blank">'.__('Media Library', 'wp-smart-image').'</a>, '.__('find the image ID and enter it in the field below:', 'wp-smart-image').'</p>
					</td>
				</tr>
				<tr onmouseover="this.style.cursor=\'pointer\';" onclick="getElementById(\'boton_externo\').checked = true;">
					<td class="wpsi-fl-input">
						<input type="radio" name="wpsi_foto_lista" id="boton_externo" value="externo"'.$externo_checked.' />
					</td>
					<td colspan="2">
						<input type="text" name="wpsi_img_externa[]" id="wpsi_img_externa" value="'. $wpsi_img_externa .'" autocomplete="off" />
					</td>
				</tr>';
				}
			} else {
				if( empty($post->ID) ) {
					$resultado .= '
					<tr id="wpsi-fotolista-no">
						<td>
							<p>'.__('Save this post to gain access to WP Smart Image functions', 'wp-smart-image').'</p>
						</td>
					</tr>';
				} else {
					$resultado .= '
					<tr>
						<th colspan="2">'.__('Upload an image for this entry', 'wp-smart-image').'</th>
					</tr>
					<tr class="wpsi-col" id="wpsi-fotolista-no">
						<td colspan="2">
							<p>'.__('You have not been uploaded an image yet', 'wp-smart-image').' ¿<a href="media-upload.php?post_id='.$post->ID.'&amp;type=image&amp;TB_iframe=true" id="add_image" class="thickbox" title="Add an Image" onclick="return false;">'.__('Do you want to upload one now', 'wp-smart-image').'</a>? '.__('Thumbnail will show here next time you refresh this screen', 'wp-smart-image').'</p>
						</td>
					</tr>';
					if($wpsi_img_externa) {
						if($wpsiext->ID != '') {
							$resultado .='
							<tr>
								<th colspan="2">'.__('External image uploaded', 'wp-smart-image').'</th>
							</tr>
							<tr class="wpsi-col" id="wpsi-fotolista-externo">
								<td class="wpsi-fl-img-ext">
									<a href="'.$grande_ext[0].'" target="_blank" title="'.__('View original in new window', 'wp-smart-image').'"><img src="'.$item_ext[0].'" width="48" height="48" /></a>
								</td>
								<td class="wpsi-fl-datos">
									<p><span class="negrita">'.__('Image ID', 'wp-smart-image').':</span>
									<input type="radio" name="wpsi_foto_lista" id="boton_externo" autocomplete="off" value="externo"'.$externo_checked.' style="display: none" />
									<input type="text" name="wpsi_img_externa[]" id="wpsi_img_externa" autocomplete="off" value="'. $wpsi_img_externa .'" class="wpsi-input-externo" /></p>
									<p><span class="negrita">'.__('Attached to post', 'wp-smart-image').':</span> ';	
									if($wpsi_parent_ext->ID == $wpsiext->post_parent)
										$resultado .= '<a href="post.php?action=edit&amp;post='.$wpsi_parent_ext->ID.'" title="'.$wpsi_parent_ext->post_title.'" target="_blank">'.$wpsi_parent_ext->ID.'</a></p>';
									else
										$resultado .= 'None</p>';
									$resultado .= '
									<p><span class="negrita">'.__('Type', 'wp-smart-image').':</span> '.$wpsiext->post_mime_type.'</p>
									<p><span class="negrita">'.__('W:', 'wp-smart-image').'</span> '.$grande_ext[1].'px | <span class="negrita">'.__('H:', 'wp-smart-image').'</span> '.$grande_ext[2].'px</p>
									<p><a title="'.__('These modifications are globals', 'wp-smart-image').'" href="media.php?action=edit&attachment_id='.$wpsiext->ID.'" target="_blank">'.__('Edit image', 'wp-smart-image').'</a></p>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<p>'.__('Always you can choose and publish any image stored on your ', 'wp-smart-image').' <a href="upload.php" target="_blank">'.__('Media Library', 'wp-smart-image').'</a>.</p>
								</td>
							</tr>';
						} else {
							$resultado .='
							<tr>
								<th colspan="2">'.__('External image uploaded', 'wp-smart-image').'</th>
							</tr>
							<tr class="wpsi-col" id="wpsi-fotolista-externo">
								<td colspan="2">
									<p class="negrita"><span class="wpsi-fl-rojo">'.__('Error', 'wp-smart-image').':</span> '.__('Thid ID is not assigned to any image. Try again', 'wp-smart-image').'.</p>
									<p><span class="negrita">'.__('Image ID', 'wp-smart-image').':</span>
									<input type="radio" name="wpsi_foto_lista" id="boton_externo" autocomplete="off" value="externo"'.$externo_checked.' style="display: none" />
									<input type="text" name="wpsi_img_externa[]" id="wpsi_img_externa" autocomplete="off" value="'. $wpsi_img_externa .'" class="wpsi-input-externo" /></p>
									
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p>'.__('Always you can choose and publish any image stored on your ', 'wp-smart-image').' <a href="upload.php" target="_blank">'.__('Media Library', 'wp-smart-image').'</a>.</p>
								</td>
							</tr>';
						}
					} else {
						$resultado .='
						<tr>
							<th>'.__('... Or load it from Media Library', 'wp-smart-image').'</th>
						</tr>
						<tr class="wpsi-col" id="wpsi-fotolista-externo">
							<td>
								<p>'.__('First, visit your', 'wp-smart-image').' <a href="upload.php" target="_blank">'.__('Media Library', 'wp-smart-image').'</a>, '.__('grab the image ID and enter it in the field below:', 'wp-smart-image').'</p>
								<p><span class="negrita">'.__('Image ID', 'wp-smart-image').':</span>
								<input type="radio" name="wpsi_foto_lista" id="boton_externo" checked="checked" value="externo"'.$externo_checked.' style="display: none" />
								<input type="text" name="wpsi_img_externa[]" id="wpsi_img_externa" autocomplete="off" value="'. $wpsi_img_externa .'" class="wpsi-input-externo" /></p>
							</td>
						</tr>';
					}
				}
			}
			$resultado .='
			</table>
		</div>';
	return $resultado;
}

function wpsi_box() {
	echo wpsi_metabox();
}

function activar_metabox() {
	global $wpsi_modo_php, $wpsi_php;
	if($wpsi_modo_php) $wpsi_bd = $wpsi_php;
	else $wpsi_bd = get_option('wpsi_configuracion');
	$activar_metabox = $wpsi_bd['wpsi_activar_metabox'];
	if($activar_metabox) {
		add_action( 'do_meta_boxes' , 'wpsi_agregar_metabox' , 10, 2 );
		add_action( 'save_post', 'wpsi_guardar_metabox' );
	}
}

function wpsi_agregar_metabox() {
	add_meta_box('wpsi-metabox', __('Image to show', 'wp-smart-image'), 'wpsi_box', 'post', 'side', 'core');
	add_meta_box('wpsi-metabox', __('Image to show', 'wp-smart-image'), 'wpsi_box', 'page', 'side', 'core');
}

function wpsi_guardar_metabox( $post_ID ) {
	if ( wp_verify_nonce( $_REQUEST['_wpsi_nonce'], 'wpsi_metabox_args' ) ) {
		if(isset($_POST['wpsi_foto_lista'])) {
			if($_POST['wpsi_foto_lista'] == 'externo' ) 
				update_post_meta( $post_ID, '_wpsi_foto_lista', $_POST['wpsi_img_externa'] );
			else 
				update_post_meta( $post_ID, '_wpsi_foto_lista', $_POST['wpsi_foto_lista'] );
		}
		else delete_post_meta( $post_ID, '_wpsi_foto_lista' );
	}
	return $post_ID;
}

function wpsi_guardar_metabox_titulo() {
	global $post;
	if( isset($_POST['wpsi_inputbox']) ) { 
		foreach($_POST['wpsi_inputbox']  as  $valor)  {
			$imagen = array();
			$imagen['ID'] = $valor;
			$imagen['post_title'] = $_POST['wpsi_fotobox_title_'.$valor];
			wp_update_post( $imagen );
		}
	}
}

function wp_smart_image($args = '') {
	return wpsi($args);
}

function get_wpsi($args = '') {
	return wpsi('echo=0&'.$args);
}

function wpsi($args = '') {
	global $post, $wpsi_configuracion, $wpsi_modo_php, $wpsi_php, $dtdtag, $wp_version;
	$defaults = array(
		'echo'       => 1, // 1 | 0
		'element'    => '', // id | title | alt | mimetype | width | height
		'size'       => 'mini', // mini | med | big | full | custom[value]
		'type'       => 'link', // link | single | direct | url
		'wh'         => '', // css | html
		'class'      => '',
		'alt'        => '', // Any string | el_title | el_alt
		'title'      => '', // Any string | el_title | el_alt
		'p'          => '',
		'plink'      => '',
		'atitle'     => '', // Any string | el_title | el_alt
		'cid'        => '',
		'aclass'     => '',
		'rel'        => '',
		'target'     => '',
		'targetname' => '',
		'aid'        => '',
		'showtitle'  => 1 // 1 | 0 | img | link
	);
	if($wpsi_modo_php) $wpsi_bd = $wpsi_php;
	else $wpsi_bd = get_option('wpsi_configuracion'); 			
	$opcion_reemplazo = $wpsi_bd['wpsi_opcion_reemplazo'];
	$r = wp_parse_args($args, $defaults); extract($r);
	if($p) {
		$post->ID = $p;
		$plinked = $plink == true ? $post->ID : null;
	}
	$imagen = '';
	$clase	= ' class="'.$class.'"';	
	$ident	= ' id="'.$cid.'"';	
	$aident	= ' id="'.$aid.'"';	
	$relatt	= ' rel="'.$rel.'"';
	$tname	= ' target="'.$targetname.'"';
	$class	= $class == true ? $clase : '';
	$cid	= $cid == true ? $ident : '';
	$rel	= $rel == true ? $relatt : '';
	$aid	= $aid == true ? $aident  : '';
	$targetname = $targetname == true ? $tname : '';
	$targetjs='';
	if($aclass == true) {
		if($target == 'js') {
			$aclase = ' class="wpsi-blank '. $aclass .'"';
			$targetjs ='';
		} else {
			$aclase = ' class="'. $aclass .'"';
		} 
	} else {
		$aclase ='';
		$targetjs = ' class="wpsi-blank"';
	}
	$aclass	= $aclass == true ? $aclase  : '';
	$wpsi_postmeta_valor = get_post_meta( $post->ID, '_wpsi_foto_lista', true );
	if(!is_array($wpsi_postmeta_valor)) $wpsi_postmeta = $wpsi_postmeta_valor;
	else $wpsi_postmeta = $wpsi_postmeta_valor[0];
	$orden = 'aleatorio' == $wpsi_postmeta ? 'rand' : 'menu_order';
	$images = get_children(array(
		'post_parent'		=> $post->ID,
		'post_type'			=> 'attachment',
		'numberposts'		=> 1,
		'post_mime_type'	=> 'image',
		'orderby'			=> $orden,
		'order'				=> 'ASC'
	));
	switch ($size) {
		case 'mini': 
			$tam = 'thumbnail';
			$reemp = $wpsi_configuracion['wpsi_reemp_mini'];
		break;
		case 'med': 
			$tam = 'medium';
			$reemp = $wpsi_configuracion['wpsi_reemp_medio']; 
		break;
		case 'big': 
			$tam = 'large';
			$reemp = $wpsi_configuracion['wpsi_reemp_grande']; 
		break;
		case 'full': 
			$tam = 'full';
			$reemp = $wpsi_configuracion['wpsi_reemp_full']; 
		break;
		case $size: 
			$tam = $wpsi_bd['wpsi_custom_compat'] == true ? $size : 'medium';
			$reemp = $wpsi_configuracion['wpsi_reemp_medio'];
		break;
		default: 
			$tam = 'thumbnail';
			$reemp = $wpsi_configuracion['wpsi_reemp_mini'];
		break;
	}
	switch ($target) {
		case 'blank': 
			$targetatt = ' target="_blank"';
		break;
		case 'self': 
			$targetatt = ' target="_self"'; 
		break;
		case 'parent': 
			$targetatt = ' target="_parent"'; 
		break;
		case 'top': 
			$targetatt = ' target="_top"'; 
		break;
		case 'js': 
			$targetatt = $targetjs; 
		break;
		default: 
			$targetatt = '';
		break;
	}
	if($targetname == true) $target = ''; else $target = $targetatt;
	$wpsiext = get_post($wpsi_postmeta);
	$wpsiext_ruta = wp_get_attachment_image_src( $wpsiext->ID, $tam );
	$wpsiext_ruta_full = wp_get_attachment_image_src( $wpsiext->ID, 'full' );
	if($images) {
		foreach( $images as $image ) {
			$img = $wpsi_postmeta == true ? $wpsiext : $image;
			$wpsi_metabox = $wpsi_bd['wpsi_activar_metabox'];
			$alt_img_txt = version_compare($wp_version, '2.9-RC1', '>=') ? get_post_meta($img->ID, '_wp_attachment_image_alt', true) : $img->post_excerpt;
			$alt_img_txt = empty($alt_img_txt) ? $img->post_title : $alt_img_txt;
			$reemplazo_alt = array('el_title' => $post->post_title , 'el_alt' => $alt_img_txt);
			$alt = !empty($alt) ? strtr( htmlspecialchars($alt) , $reemplazo_alt ) : $alt_img_txt;
			$ruta = wp_get_attachment_image_src($img->ID, $tam);
			$weburl_full = wp_get_attachment_image_src($img->ID, 'full');
			$title = !empty($title) ? strtr( htmlspecialchars($title) , $reemplazo_alt ) : $img->post_title;
			if($element) {
				switch ($element) {
					case 'id': 
						$imagen .= $img->ID; 
					break;
					case 'ID': 
						$imagen .= $img->ID; 
					break;
					case 'title': 
						$imagen .= $title;
					break;
					case 'alt': 
						$imagen .= $alt; 
					break;
					case 'mimetype': 
						$imagen .= $img->post_mime_type; 
					break;
					case 'width': 
						$imagen .= $ruta[1]; 
					break;
					case 'height': 
						$imagen .= $ruta[2]; 
					break;
					default: 
						$imagen .= '';
					break;
				}
			} else {
				switch ($wh) {
					case 'html': 
						$widtheight .= ' width="'.$ruta[1].'" height="'.$ruta[2].'"';
					break;
					case 'css': 
						$widtheight .= ' style="width: '.$ruta[1].'px; height: '.$ruta[2].'px;"'; 
					break;
				}
				switch ($showtitle) {
				case '0':
						$titulo_img = '';
						$titulo_link = '';
					break;
					case '1':
						$titulo_img = ' title="'. $title .'"';
						$titulo_link = ' title="'. $title .'"';
					break;
	
					case 'img':
						$titulo_img = ' title="'. $title .'"';
						$titulo_link = '';
					break;
					case 'link':
						$titulo_img = '';
						$titulo_link = ' title="'. $title .'"';
					break;
				}
				$wh	= $wh == true ? $widtheight  : '';
				$alt_img = ' alt="'. $alt .'"';
				$linklist = $rel . $target . $targetname . $aclass . $aid . $titulo_link;
				$img_list = $class . $cid . $widtheight . $alt_img . $titulo_img;
				$weburl = $ruta[0];
				$img_single = '<img src="'. $weburl .'"'. $img_list . $dtdtag;
				$weburl_img = '<a href="'. $weburl_full[0] .'"'. $linklist .'>'. $img_single .'</a>';
				$img_link = '<a'. $linklist .' href="'. get_permalink($plinked) .'">'. $img_single .'</a>';
				switch ($type) {
					case 'link': 
						$imagen .= $img_link."\n";
					break;
					case 'single': 
						$imagen .= $img_single."\n"; 
					break;
					case 'direct': 
						$imagen .= $weburl_img."\n"; 
					break;
					case 'url': 
						$imagen .= $weburl; 
					break;
					default: 
						$imagen .= $img_link."\n";
					break;
				}
			}
		}
	} else {
		if ( $opcion_reemplazo ) {
			if($wpsi_postmeta) {
			$alt_img_txt = version_compare($wp_version, '2.9-RC1', '>=') ? get_post_meta($wpsiext->ID, '_wp_attachment_image_alt', true) : $wpsiext->post_excerpt;
			$alt_img_txt = empty($alt_img_txt) ? $wpsiext->post_title : $alt_img_txt;
				if($element) {
					switch ($element) {
						case 'id': 
							$imagen .= $wpsiext->ID; 
						break;
						case 'ID': 
							$imagen .= $wpsiext->ID; 
						break;
						case 'title': 
							$imagen .= $wpsiext->post_title;
						break;
						case 'alt': 
							$imagen .= $alt_img_txt; 
						break;
						case 'mimetype': 
							$imagen .= $wpsiext->post_mime_type; 
						break;
						case 'width': 
							$imagen .= $wpsiext_ruta[1]; 
						break;
						case 'height': 
							$imagen .= $wpsiext_ruta[2]; 
						break;
						default: 
							$imagen .= '';
						break;
					}
				} else {
					$weburl = $wpsiext_ruta;
					$reemplazo_alt = array('el_title' => $post->post_title , 'el_alt' => $alt_img_txt);
					$alt = empty($alt) ? $alt_img_txt : strtr($reemplazo_alt , $alt);
					$linklist = $rel . $target . $targetname . $aclass . $aid . $titulo_link;
					$img_list = $class . $cid . $widtheight . $alt_img . $titulo_img;
					$weburl_full = $wpsiext_ruta_full;
					$img_single = '<img src="'. $weburl[0] .'"'. $img_list.$dtdtag;
					$weburl_img = '<a href="'. $weburl_full[0] .'"'. $linklist .'>'. $img_single .'</a>';
					$img_link = '<a'. $linklist .' href="'.get_permalink($plinked).'">'. $img_single .'</a>';
					switch ($wh) {
						case 'html': 
							$wh = ' width="'. $wpsiext_ruta[1] .'" height="'. $wpsiext_ruta[2] .'"';
						break;
						case 'css': 
							$wh = ' style="width: '. $wpsiext_ruta[1] .'px; height: '. $wpsiext_ruta[2] .'px;"'; 
						break;
					}
					switch ($type) {
						case 'link': 
							$imagen .= $img_link."\n";
						break;
						case 'single': 
							$imagen .= $img_single."\n"; 
						break;
						case 'direct': 
							$imagen .= $weburl_img; 
						break;
						case 'url': 
							$imagen .= $weburl[0]; 
						break;
						default: 
							$imagen .= $img_link."\n";
						break;
					}
				}
			} else {
				if($element) {
					$imagen .= __('N/A', 'wp-smart-image');
				} else {
					$alt_img_txt = $wpsi_configuracion['wpsi_texto_alt'];
					$titletxt = $wpsi_bd['wpsi_texto_title_titulo'] == true ? $post->post_title : $wpsi_configuracion['wpsi_texto_title'];
					$reemplazo_alt = array('el_title' => $post->post_title , 'el_alt' => $alt_img_txt);
					$alt = !empty($alt) ? strtr( htmlspecialchars($alt) , $reemplazo_alt ) : $alt_img_txt;
					$title = !empty($title) ? strtr( htmlspecialchars($title) , $reemplazo_alt ) : $titletxt;
					$alt_img = ' alt="'. $alt .'"';
					switch ($showtitle) {
					case '0':
							$titulo_img = '';
							$titulo_link = '';
						break;
						case '1':
							$titulo_img = ' title="'. $title .'"';
							$titulo_link = ' title="'. $title .'"';
						break;
		
						case 'img':
							$titulo_img = ' title="'. $title .'"';
							$titulo_link = '';
						break;
						case 'link':
							$titulo_img = '';
							$titulo_link = ' title="'. $title .'"';
						break;
					}
					$ubicacion = $wpsi_configuracion['wpsi_ruta_img'];
					$linklist = $rel . $target . $targetname . $aclass . $aid . $titulo_link;
					$img_def = '<img src="'. $ubicacion . $reemp .'"'. $class . $cid . $alt_img . $titulo_img . $dtdtag;
					$img_def_link = '<a'. $linklist .' href="'.get_permalink($plinked).'">'. $img_def .'</a>';
					switch ($type) {
						case 'link': 
							$imagen .= $img_def_link ."\n";
						break;
						case 'single': 
							$imagen .= $img_def ."\n"; 
						break;
						case 'direct': 
							$imagen .= '<a'. $linklist .' href="'.$ubicacion . $wpsi_configuracion['wpsi_reemp_full'] .'">'. $img_def .'</a>'."\n"; 
						break;
						case 'url': 
							$imagen .= $ubicacion . $reemp; 
						break;
						default: 
							$imagen .= $img_def_link."\n";
						break;
					}
				}
			}
		} else {
			$imagen .= false;
		}
	}
if($echo) echo $imagen; else return $imagen;
}
?>