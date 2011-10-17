<?php
/**
 * WordPress Administration Template Header
 *
 * @package WordPress
 * @subpackage Administration
 */

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
if ( ! defined( 'WP_ADMIN' ) )
	require_once( './admin.php' );

get_admin_page_title();
$title = esc_html( strip_tags( $title ) );

if ( is_network_admin() )
	$admin_title = __( 'Network Admin' );
elseif ( is_user_admin() )
	$admin_title = __( 'Global Dashboard' );
else
	$admin_title = get_bloginfo( 'name' );

if ( $admin_title == $title )
	$admin_title = sprintf( __( '%1$s &#8212; WordPress' ), $title );
else
	$admin_title = sprintf( __( '%1$s &lsaquo; %2$s &#8212; WordPress' ), $title, $admin_title );

$admin_title = apply_filters( 'admin_title', $admin_title, $title );

wp_user_settings();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php do_action('admin_xml_ns'); ?> <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<title><?php echo $admin_title; ?></title>
<?php

wp_admin_css( 'global' );
wp_admin_css();
wp_admin_css( 'colors' );
wp_admin_css( 'ie' );
if ( is_multisite() )
	wp_admin_css( 'ms' );
wp_enqueue_script('utils');

$admin_body_class = preg_replace('/[^a-z0-9_-]+/i', '-', $hook_suffix);
?>
<script type="text/javascript">
//<![CDATA[
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
var userSettings = {
		'url': '<?php echo SITECOOKIEPATH; ?>',
		'uid': '<?php if ( ! isset($current_user) ) $current_user = wp_get_current_user(); echo $current_user->ID; ?>',
		'time':'<?php echo time() ?>'
	},
	ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>',
	pagenow = '<?php echo $current_screen->id; ?>',
	typenow = '<?php if ( isset($current_screen->post_type) ) echo $current_screen->post_type; ?>',
	adminpage = '<?php echo $admin_body_class; ?>',
	thousandsSeparator = '<?php echo addslashes( $wp_locale->number_format['thousands_sep'] ); ?>',
	decimalPoint = '<?php echo addslashes( $wp_locale->number_format['decimal_point'] ); ?>',
	isRtl = <?php echo (int) is_rtl(); ?>;
//]]>
</script>
<?php

if ( in_array( $pagenow, array('post.php', 'post-new.php') ) ) {
	wp_enqueue_script('quicktags');
}

do_action('admin_enqueue_scripts', $hook_suffix);
do_action("admin_print_styles-$hook_suffix");
do_action('admin_print_styles');
do_action("admin_print_scripts-$hook_suffix");
do_action('admin_print_scripts');
do_action("admin_head-$hook_suffix");
do_action('admin_head');

if ( get_user_setting('mfold') == 'f' )
	$admin_body_class .= ' folded';

if ( is_admin_bar_showing() )
	$admin_body_class .= ' admin-bar';

if ( is_rtl() )
	$admin_body_class .= ' rtl';

$admin_body_class .= ' branch-' . str_replace( '.', '-', floatval( $wp_version ) );
$admin_body_class .= ' version-' . str_replace( '.', '-', preg_replace( '/^([.0-9]+).*/', '$1', $wp_version ) );
$admin_body_class .= ' admin-color-' . sanitize_html_class( get_user_option( 'admin_color' ), 'fresh' );

if ( $is_iphone ) { ?>
<style type="text/css">.row-actions{visibility:visible;}</style>
<?php } ?>
</head>
<body class="wp-admin no-js <?php echo apply_filters( 'admin_body_class', '' ) . " $admin_body_class"; ?>">
<script type="text/javascript">
//<![CDATA[
(function(){
var c = document.body.className;
c = c.replace(/no-js/, 'js');
document.body.className = c;
})();
//]]>
</script>

<div id="wpwrap">
<?php require(ABSPATH . 'wp-admin/menu-header.php'); ?>
<div id="wpcontent">
<div id="wphead">
<?php

if ( is_network_admin() )
	$blog_name = sprintf( __('%s Network Admin'), esc_html($current_site->site_name) );
elseif ( is_user_admin() )
	$blog_name = sprintf( __('%s Global Dashboard'), esc_html($current_site->site_name) );
else
	$blog_name = get_bloginfo('name', 'display');
if ( '' == $blog_name ) {
	$blog_name = __( 'Visit Site' );
} else {
	$blog_name_excerpt = wp_html_excerpt($blog_name, 40);
	if ( $blog_name != $blog_name_excerpt )
		$blog_name_excerpt = trim($blog_name_excerpt) . '&hellip;';
	$blog_name = $blog_name_excerpt;
	unset($blog_name_excerpt);
}
$title_class = '';
if ( function_exists('mb_strlen') ) {
	if ( mb_strlen($blog_name, 'UTF-8') > 30 )
		$title_class = 'class="long-title"';
} else {
	if ( strlen($blog_name) > 30 )
		$title_class = 'class="long-title"';
}
?>

<img id="header-logo" src="<?php echo esc_url( includes_url( 'images/blank.gif' ) ); ?>" alt="" width="16" height="16" />
<h1 id="site-heading" <?php echo $title_class ?>>
	<a href="<?php echo trailingslashit( get_bloginfo( 'url' ) ); ?>" title="<?php esc_attr_e('Visit Site') ?>">
		<span id="site-title"><?php echo $blog_name ?></span>
	</a>
</h1>

<?php

do_action('in_admin_header');

$links = array();

// Generate user profile and info links.
$links[5] = sprintf( __('Howdy, %1$s'), $user_identity );

$links[8] = '<a href="profile.php" title="' . esc_attr__('Edit your profile') . '">' . __('Your Profile') . '</a>';

if ( is_multisite() && is_super_admin() ) {
	if ( !is_network_admin() )
		$links[10] = '<a href="' . network_admin_url() . '" title="' . ( ! empty( $update_title ) ? $update_title : esc_attr__('Network Admin') ) . '">' . __('Network Admin') . ( ! empty( $total_update_count ) ? ' (' . number_format_i18n( $total_update_count ) . ')' : '' ) . '</a>';
	else
		$links[10] = '<a href="' . get_dashboard_url( get_current_user_id() ) . '" title="' . esc_attr__('Site Admin') . '">' . __('Site Admin') . '</a>';
}

$links[15] = '<a href="' . wp_logout_url() . '" title="' . esc_attr__('Log Out') . '">' . __('Log Out') . '</a>';

$links = apply_filters( 'admin_user_info_links', $links, $current_user );
ksort( $links );

// Trim whitespace and pipes from links, then convert to list items.
$links = array_map( 'trim', $links, array_fill( 0, count( $links ), " |\n\t" ) );

$howdy = array_shift( $links );

$links_no_js = implode( ' | ', $links );
$links_js = '<li>' . implode( '</li><li>', $links ) . '</li>';

?>
<div id="wphead-info">
<div id="user_info">
	<p class="hide-if-js"><?php echo "$howdy | $links_no_js"; ?></p>

	<div class="hide-if-no-js">
<?php
  /* v2p */
?>
<style>
#basic-modal-content {display:none;}

/* Overlay */
#simplemodal-overlay {background-color:#ccc; cursor:wait;}

/* Container */
#simplemodal-container {height:200px; width:300px; background-color:#fff; border:4px solid #444; padding:12px;}
#simplemodal-container .simplemodal-data {padding:8px;}
#simplemodal-container a.modalCloseImg {background:url(/wp-admin/images/x.png) no-repeat; width:25px; height:29px; display:inline; z-index:3200; position:absolute; top:-15px; right:-16px; cursor:pointer;}

/* v2p */
#v2pMakeRequestWindow {display:none;}
#v2pImportGAWindow {display:none;}
#v2pTransactionWindow {display:none;}
#v2pRequestsWindow {display:none;}

.v2pDescription {width:283px; height: 83px;}
.v2pField {width:283px;}
.v2pSubmit {width:283px;}

#v2pImportGAWindowMessage {display:none; height:176px; display:table-cell; vertical-align:middle;}
#v2pImportGAWindowPreload {display:none; width:276px; text-align:center; height:176px; display:table-cell; vertical-align:middle;}
</style>
<script src="/wp-admin/js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="/wp-admin/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/wp-admin/js/jquery.form.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
  $('#v2pMakeRequest').click(function(){
    $('#basic-modal-content').modal();
    $('#v2pMakeRequestWindow').show();
    $('#v2pMakeRequestForm').ajaxForm({
      dataType:'json',
      success:function(data){
        if(data && data.status == 1) {
          alert('ok!');
        } else {
          alert('error');
        }
      }
    });
    return false;
  });
  $('#v2pImportGA').click(function(){
    $('#basic-modal-content').modal();
    $('#v2pImportGAWindow').show();
    $('#v2pImportGAWindowMessage').hide();
    $('#v2pImportGAWindowPreload').show();
    $.ajax({
      type: "POST",
      url: "../v2p/importGA.php",
      data: "start=1",
      dataType: "json",
      success: function(data) {
        if(data && data.status == 1) {
          $('#v2pImportGAWindowPreload').hide();
          $('#v2pImportGAWindowMessage').show();
        } else {
          $('#v2pImportGAWindowPreload').hide();
          alert('error');
        }
      }
    });
    return false;
  });
  $('#v2pTransaction').click(function(){
    $('#basic-modal-content').modal();
    $('#v2pTransactionWindow').show();
    $('#v2pMakeTransactionForm').ajaxForm({
      dataType:'json',
      success:function(data){
        if(data && data.status == 1) {
          alert('ok!');
        } else {
          alert('error');
        }
      }
    });
    return false;
  });
  $('#v2pRequests').click(function(){
    $('#basic-modal-content').modal();
    $('#v2pRequestsWindow').show();
    return false;
  });
});
</script>
<!-- modal content -->
<div id="basic-modal-content">
  <!-- Вывод средств -->
  <div id="v2pMakeRequestWindow">
    <form action="../v2p/request.php" method="POST" id="v2pMakeRequestForm">
      <input type="hidden" name="v2pMakeRequest" value="1" />
      <div class='wp-submenu-head'>Укажите номер кошелька WebMoney или другие реквизиты:</div>
      <p><textarea class="v2pDescription" name="description"></textarea></p>
      <p><input class="v2pSubmit" type="submit" value="Создать запрос на вывод средств"/></p>
    </form>
  </div>
  <!-- Обновление статистики -->
  <div id="v2pImportGAWindow">
    <div id="v2pImportGAWindowPreload"><img src="/wp-admin/images/preloader.png" border="0" /></div>
    <div id="v2pImportGAWindowMessage" class='wp-submenu-head'>Статистика от Google Analytics успешно обновлена.</div>
  </div>
  <!-- Распределение прибыли -->
  <div id="v2pTransactionWindow">
    <form action="../v2p/transaction.php" id="v2pMakeTransactionForm" method="POST">
      <input type="hidden" name="v2pMakeTransaction" value="1" />
      <p><div class='wp-submenu-head'><strong>Внимание! Введённая сумма будет распределена между авторами.</strong></div></p>
      <p><div class='wp-submenu-head'>Укажите сумму в рублях:</div></p>
      <p><input type="text" class="v2pField" name="profit" /></p>
      <p><input class="v2pSubmit" type="submit" value="Распределить"/></p>
    </form>
  </div>
  <!-- Запросы на оплату -->
  <div id="v2pRequestsWindow">
    <form action="" method="POST">
      <p><div class='wp-submenu-head'>Табличка с полями: Дата, Автор, Сумма, Оплачено(кнопка).</div></p>
      <!--<p><input class="v2pSubmit" type="submit" value="Оплачено"/></p>-->
    </form>
  </div>
</div>

		<!-- preload the images -->
		<div style='display:none'>
			<img src='img/basic/x.png' alt='' />
		</div>
<?php
  $links_js = '<li><a id="v2pMakeRequest" href="#">Вывести средства</a></li>'
              . '<li><a id="v2pImportGA" href="#">Обновить статистику</a></li>'
              . '<li><a id="v2pTransaction" href="#">Распределить прибыль</a></li>'
              . '<li><a id="v2pRequests" href="#">Запросы на оплату</a></li>'
              . $links_js;
?>
<p>0.00 руб | <?php echo $howdy; ?></p>

<?php
  /* /v2p */
?>
		<div id="user_info_arrow"></div>
		<div id="user_info_links_wrap"><div id="user_info_links">
			<ul><?php echo $links_js; ?></ul>
		</div></div>
	</div>
</div>
</div>

</div>

<div id="wpbody">
<?php
unset($title_class, $blog_name, $total_update_count, $update_title);

$current_screen->parent_file = $parent_file;
$current_screen->parent_base = preg_replace('/\?.*$/', '', $parent_file);
$current_screen->parent_base = str_replace('.php', '', $current_screen->parent_base);
?>

<div id="wpbody-content">
<?php
screen_meta($current_screen);

if ( is_network_admin() )
	do_action('network_admin_notices');
elseif ( is_user_admin() )
	do_action('user_admin_notices');
else
	do_action('admin_notices');

do_action('all_admin_notices');

if ( $parent_file == 'options-general.php' )
	require(ABSPATH . 'wp-admin/options-head.php');
