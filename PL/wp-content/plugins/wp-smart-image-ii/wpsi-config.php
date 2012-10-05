<?php
/*
English:

NOTICE: Once you have edited this file, copy its content and paste
it in a new local file. When you upgrade WP Smart Image II, 
simply paste again from that new file you've created to the plugin's file, 
so you will maintain your configuration.

This is the config file to enable PHP Mode on WP Smart Image,
executing common tasks through PHP instead to be process them
through DB.

If you are developing a high traffic website, maybe you will
find more convenience on PHP Mode.

You must to set the following values as you wish, to make the plugin
works right.

-----------------------------------------------

Español:

NOTA: Una vez hayas editado este archivo, cpia su contenido y pégalo
en un nuevo archivo. Cuando posteriormente actualices WP Smart Image II,
simplemente vuelve a pegar el contenido desde ese nuevo archivo que
creaste. Así podrás mantener tu configuración.

Éste es el archivo de configuración para activar el Modo PHP 
en WP Smart Image, ejecutando las tareas más comunes con PHP 
en lugar de procesarlas mediante la base de datos.

Si estás desarrollando un sitio de alto tráfico, quizás el modo PHP
sea más conveniente para tu sitio.

Debes ajustar a tu gusto los valores de las siguientes variables
para que el plugin funcione correctamente.

*/


/*----------------- GENERAL SETTINGS -----------------*/

// Enable-disable PHP Mode. 
// If set to true, your WPSI Settings Panel
// will change to Info Screen. You can turn between PHP and DB modes
// when you wish, even if both are configured already.
$wpsi_modo_php = 0; // 1 = enabled || 0 = disabled

// Enable/disable editor box
$wpsi_php['wpsi_activar_metabox'] = 1; // 1 = enabled || 0 = disabled

// Compatibility with Max Image Size Control plugin
$wpsi_php['wpsi_custom_compat'] = 1; // 1 = enabled || 0 = disabled

// Website Doctype Declaration
$wpsi_php['wpsi_dtd'] = 'xhtml'; // xhtml | html


/*------------------ FEED SETTINGS -------------------*/

// Enable images for feeds
$wpsi_php['wpsi_rss'] = 1; // 1 = enabled || 0 = disabled

// Image size for feeds
// custom[digit] value will be only available if you have been choosed
// Compatibility with Max Image Size Control plugin in General Settings
$wpsi_php['wpsi_img_rss'] = 'thumbnail'; // thumbnail || medium || large || full || custom[digit]

// Enable images for RSS1/RDF
$wpsi_php['wpsi_rdf'] = 0; // 1 = enabled || 0 = disabled

// Enable images for RSS2
$wpsi_php['wpsi_rss2'] = 1; // 1 = enabled || 0 = disabled

// Enable images for Atom
$wpsi_php['wpsi_atom'] = 0; // 1 = enabled || 0 = disabled


/*-------------- DEFAULT IMAGE SETTINGS --------------*/

// Enable/disable default image engine.
$wpsi_php['wpsi_opcion_reemplazo'] = 1; // 1 = enabled || 0 = disabled

// Default image path
// Allowed values: URL to directory where you placed the Default Images
$wpsi_php['wpsi_ruta_img'] = '';

// Default image for thumbnail
$wpsi_php['wpsi_reemp_mini'] = 'noimg-mini.jpg'; // Allowed values: file name (e.g: my-file.png)

// Default image for medium size
$wpsi_php['wpsi_reemp_medio'] = 'noimg-med.jpg'; // Allowed values: file name (e.g: my-file.png)

// Default image for large size
$wpsi_php['wpsi_reemp_grande'] = 'noimg-big.jpg'; // Allowed values: file name (e.g: my-file.png)

// Default image for full size
$wpsi_php['wpsi_reemp_full'] = 'noimg-full.jpg'; // Allowed values: file name (e.g: my-file.png)

// Default Alt an Title attributes
$wpsi_php['wpsi_texto_alt'] = 'Article image'; // Allowed values: Any value | the_title
$wpsi_php['wpsi_texto_title'] = 'Go to article'; // Allowed values: Any value | the_title


// Do not edit below or the sky fall down on you head:
if(empty($wpsi_php['wpsi_img_rss'])) $wpsi_php['wpsi_img_rss'] = 'thumbnail';
if($wpsi_php['wpsi_dtd'] != 'html') $wpsi_php['wpsi_dtd'] = 'xhtml';
?>