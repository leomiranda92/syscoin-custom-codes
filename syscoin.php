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
   <p>Caso tenha alguma dúvida, sugestão ou reclamação basta nos enviar uma mensagem através do formulário: </p>

   <style>
      .suporte input{
        width: 100%;
        padding: 5px;
      }

      .suporte textarea{
        height: 100px;
        width: 100%;
        font-weight: normal;
      }
      .suporte label{
        font-weight: bold;
      }

      .enviar{
        background-color: #ffcc00;
        widh:200px;
        border: 0;
      }

   </style>
   <form id="zFormer"  class="suporte" method="post" action="http://www.syscoin.com.br/form/former.php" name="zFormer">
       <p>
           <label for="z_name">Seu Nome</label><br>
           <input type="text" value="<?php
           global $current_user;
           if ( isset($current_user) ) {
               echo $current_user->user_login;
           }
           ?>" name="z_name" />
       </p>
       <p>
           <label for="z_requester">Seu Email</label><br>
           <input type="text" value="<?php
           global $current_user;
           if ( isset($current_user) ) {
               echo $current_user->user_email;
           }
           ?>"placeholder="Seu email" name="z_requester" />
       </p>
       <p>
           <label for="z_subject">Assunto </label><br>
           <input type="text" placeholder="Qual o assunto" name="z_subject" />
       </p>
       <p>
           <label for="z_description">Mensagem:<br>
           <textarea name="z_description" placeholder="Descreva o máximo de detalhes possível para agilizar seu atendimento. Caso seja necessário informe links da sua loja."></textarea></label>

       </p>
       <p>
          <input type="submit" value="Enviar"class="enviar"/>
       </p>
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
