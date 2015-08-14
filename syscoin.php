<?php
/**
* Plugin Name: SysCoin Custom Code
* Plugin URI: http://syscoin.com.br
* Description: Códigos de Personalização
* Version: 1.0
* Author: Leonardo
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
    wp_add_dashboard_widget( 'wptutsplus_dashboard_welcome', 'Loja Virtual SysCoin', 'wptutsplus_add_welcome_widget' );
    wp_add_dashboard_widget( 'wptutsplus_dashboard_links', 'Suporte SysCoin 24h', 'wptutsplus_add_links_widget' );
}
function wptutsplus_add_welcome_widget(){ ?>
 
<img src="http://syscoin.com.br/wp-content/uploads/2014/06/SysCoin_Site.png"/>
<br>
<ul>
<li><a href="#">Meus Tickets</a> | <a href="#">Financeiro</a> | <a href="#">Facebook</a> | <a href="#">Blog SysCoin</a></li>
</ul>

<p>Você está utilizando o plano <b>SysCoin Express</b></p>

<p>Deseja ter +80 recursos novos em sua loja como email marketing, recuperador de carrinho abandonados, lista de desejos, comparar produtos, sistema de filiados, layout personalizado?<br><br><a href="#">Solicite seu upgrade de plano agora mesmo!</a>


 
<?php }
 
function wptutsplus_add_links_widget() { ?>
 
<p>Olá, <b><?php
global $current_user;
if ( isset($current_user) ) {
    echo $current_user->user_login;
}
?></b></p>
   <p>Caso tenha alguma dúvida, sugestão ou reclamação basta nos enviar uma mensagem através do formulário:</p>
<form action="#">
<label>
<input placeholder="Seu Nome" id="#" type="text" style="width: 100%;"/>
</label>
<label>
<input placeholder="Seu Email" id="#" type="text" style="width: 100%;"/>
</label>
<label>
<input placeholder="http://sualoja.com.br" id="#" type="text" style="width: 100%;"/>
</label>
<label>
<textarea name="comment" style="width: 100%;" placeholder="Sua mensagem..."></textarea>
</label>
<label>
<input type="submit" value="Enviar"/>
</label>

</form>



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

