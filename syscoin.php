<?php
/**
* Plugin Name: SysCoin Custom Code
* Plugin URI: http://syscoin.com.br
* Description: Códigos de Personalização
* Version: 3.0
* Author: Leonardo Miranda
* Author URI: Site
* License: A "Slug" license name e.g. GPL12
*/


// SCRIPTS DE SUPORTE:

add_action('admin_footer', 'my_admin_add_js');
function my_admin_add_js() {
	echo '<script data-jsd-embedded data-key="1a4120ae-0a28-410b-8465-27a8c60f239f" data-base-url="https://jsd-widget.atlassian.com" src="https://jsd-widget.atlassian.com/assets/embed.js"></script>
	<script type="text/javascript">
	(function(){ var widget_id = "MqBnPgqI6l";var d=document;var w=window;function l(){var s = document.createElement("script"); s.type = "text/javascript"; s.async = true;s.src = "//code.jivosite.com/script/widget/"+widget_id; var ss = document.getElementsByTagName("script")[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=="complete"){l();}else{if(w.attachEvent){w.attachEvent("onload",l);}else{w.addEventListener("load",l,false);}}})();
	</script>
';
}


// CSS do Chat Online

// Add inline CSS in the admin head with the style tag
function my_custom_admin_head() {
	echo '<style>#jvlabelWrap{margin-right: 50px !important;} #jsd-widget{bottom: 50px !important;}</style>';
}
add_action( 'admin_head', 'my_custom_admin_head' );






// ESCONDER ABA "AJUDA" NO PAINEL

function hide_help() {
    echo '<style type="text/css">
            #contextual-help-link-wrap { display: none !important; }
    </style>';
}
add_action('admin_head', 'hide_help');


// REMOVER WIDGETS DASHBOARD

function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


// Remove Yoast SEO Dashboard Widget
function remove_wpseo_dashboard_overview() {
remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
}

add_action('wp_dashboard_setup', 'remove_wpseo_dashboard_overview' );


// ADICIONAR WIDGETS PERSONALIZADOS NO DASHBOARD

function wptutsplus_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'wptutsplus_dashboard_links', 'Suporte ao Cliente', 'wptutsplus_add_links_widget' );
}

function wptutsplus_add_links_widget() { ?>



<p>Olá, <b><?php
global $current_user;
if ( isset($current_user) ) {
    echo $current_user->display_name;
}
?></b></p>

   <p>Seja bem-vindo(a) à central de suporte da SysCoin.</p>
   <p><a href="https://syscoin.atlassian.net/servicedesk/customer/portal/3/group/3/create/16" target="_blank"><b>Abrir Chamado de Suporte</b></a> | <a href="https://syscoin.atlassian.net/servicedesk/" target="_blank"><b>Base de Conhecimento</b></a></p>
    <br>
   <h4>Fale Conosco</h4>
   <p><b>Email: </b>atendimento@syscoin.com.br</p>
   <p><b>Tel:</b> (61) 3968-1540 | <b>Chat Online:</b> <a href="https://www.tidiochat.com/chat/otqa1xjsfzsfzz1dgalbfuyroyghijhr">Visitar</a></p>
   <br>
   <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=162964513799325";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script><div class="fb-like" data-href="https://facebook.com/syscoin.com.br" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>





<?php }
add_action( 'wp_dashboard_setup', 'wptutsplus_add_dashboard_widgets' );


// Remover Link W3TC

function remove_admin_bar_links() {
    global $wp_admin_bar,$current_user;

    $wp_admin_bar->remove_menu('w3tc');

}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

// REMOVER ÍCONE DO MULTISITE - MEUS SITES

function remove_wplogo_mysites() {
	global $wp_admin_bar;
	foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {
		$menu_id  = 'blog-' . $blog->userblog_id;
		$blogname = empty( $blog->blogname ) ? $blog->domain : $blog->blogname;
		$wp_admin_bar->add_menu( array(
			'parent' 	=> 'my-sites-list',
			'id' 	=> $menu_id,
			'title' 	=> $blogname,
			'href' 	=> get_admin_url( $blog->userblog_id ) )
		);
	}
}
add_action( 'wp_before_admin_bar_render', 'remove_wplogo_mysites' );


// Disable YOAST nag messages
add_action('admin_init', 'wpc_disable_yoast_notifications');
function wpc_disable_yoast_notifications() {
  if (is_plugin_active('wordpress-seo/wp-seo.php')) {
    remove_action('admin_notices', array(Yoast_Notification_Center::get(), 'display_notifications'));
    remove_action('all_admin_notices', array(Yoast_Notification_Center::get(), 'display_notifications'));
  }
}

// Remover Ícone Wordpress Barra

add_action('admin_bar_menu', 'remove_wp_logo', 999);
function remove_wp_logo( $wp_admin_bar ) {
$wp_admin_bar->remove_node('wp-logo');
}
