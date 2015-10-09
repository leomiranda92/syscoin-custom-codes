<?php
/**
* Plugin Name: SysCoin Custom Code
* Plugin URI: http://syscoin.com.br
* Description: Códigos de Personalização
* Version: 1.0
* Author: Leonardo Miranda
* Author URI: Site
* License: A "Slug" license name e.g. GPL12
*/


// GOOGLE ANALYTICS BI


add_action('wp_footer', 'custom_ga1');

function custom_ga1() {
    echo "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61110463-6', 'auto');
  ga('send', 'pageview');

</script>
";
}



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



// ADICIONAR WIDGETS PERSONALIZADOS NO DASHBOARD

function wptutsplus_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'wptutsplus_dashboard_links', 'Suporte ao Cliente', 'wptutsplus_add_links_widget' );
}

function wptutsplus_add_links_widget() { ?>
  <img src="http://syscoin.com.br/wp-content/uploads/2014/06/SysCoin_Site.png" style="float: right; margin-top: -30px;"/>

<p>Olá, <b><?php
global $current_user;
if ( isset($current_user) ) {
    echo $current_user->user_login;
}
?></b></p>

   <p>Seja bem-vindo(a) à central de suporte da SysCoin.</p>
   <p><a href="https://syscoin.zendesk.com/hc/pt-br/requests/new" target="_blank">Abrir Chamado de Suporte</a> | <a href="https://syscoin.zendesk.com/hc/pt-br" target="_blank">Base de Conhecimento</a> | <a href="http://syscoin.com.br/minha-conta/" target="_blank">Financeiro</a></p>
   <br>
   <h4>Fale Conosco</h4>
   <p><b>Email: </b>atendimento@syscoin.com.br</p>
   <p><b>WhatsApp:</b> (61) 8179-7716 | <b>Tel:</b> (61) 4042-0082</p>
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
