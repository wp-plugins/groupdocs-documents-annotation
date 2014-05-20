<?php

/*
Plugin Name: GroupDocs Annotation Embedder
Plugin URI: http://www.groupdocs.com/
Description: GroupDocs Annotation Plugin lets you embed different types of documents and images into your website and then invite your colleagues and clients to view and annotate them online, without the need to install any document editors or browser plugins.
Author: GroupDocs Team <support@groupdocs.com>
Author URI: http://www.groupdocs.com/
Version: 1.3.11
License: GPLv2
*/

include_once('grpdocs-functions.php');


function grpdocs_annotation_getdocument($atts) {

	extract(shortcode_atts(array(
		'file' => '',
		'width' => '',
		'height' => '',
		'page' => 0,
		'version' => 1,
	), $atts));

    $signer = '';

    if(class_exists('GroupDocsRequestSigner')){
        $signer = new GroupDocsRequestSigner(get_option('annotation_userId'));
    }else{
        include_once(dirname(__FILE__) . '/tree_annotation/lib/groupdocs-php/APIClient.php');
        include_once(dirname(__FILE__) . '/tree_annotation/lib/groupdocs-php/StorageApi.php');
        include_once(dirname(__FILE__) . '/tree_annotation/lib/groupdocs-php/GroupDocsRequestSigner.php');
        include_once(dirname(__FILE__) . '/tree_annotation/lib/groupdocs-php/FileStream.php');
        $signer = new GroupDocsRequestSigner(get_option('signature_userId'));
    }

	$url = "https://apps.groupdocs.com/document-annotation2/embed/{$file}?referer=wordpress-annotation/1.3.11&use_pdf=true";

    $code_url = $signer->signUrl($url);

	$no_iframe = 'If you can see this text, your browser does not support iframes. Please enable iframe support in your browser or use the latest version of any popular web browser such as Mozilla Firefox or Google Chrome. For more help, please check our documentation Wiki: <a href="http://groupdocs.com/docs/display/annotation/GroupDocs+Annotation+Integration+with+3rd+Party+Platforms">http://groupdocs.com/docs/display/annotation/GroupDocs+Annotation+Integration+with+3rd+Party+Platforms</a>';
	$code = "<iframe src='{$code_url}' frameborder='0' width='{$width}' height='{$height}'>{$no_iframe}</iframe>";

	return $code;

}

//activate shortcode
add_shortcode('grpdocsannotation', 'grpdocs_annotation_getdocument');


// editor integration

// add quicktag
add_action( 'admin_print_scripts', 'grpdocs_annotation_admin_print_scripts' );

// add tinymce button
add_action('admin_init','grpdocs_annotation_mce_addbuttons');

// add an option page
add_action('admin_menu', 'grpdocs_annotation_option_page');

register_uninstall_hook( __FILE__, 'groupdocs_annotation_deactivate' );

function groupdocs_annotation_deactivate()
{
	delete_option('annotation_userId');
	delete_option('annotation_privateKey');	

}
function grpdocs_annotation_option_page() {
	global $grpdocs_annotation_settings_page;

	$grpdocs_annotation_settings_page = add_options_page('GroupDocs Annotation', 'GroupDocs Annotation', 'manage_options', basename(__FILE__), 'grpdocs_annotation_options');

}
function grpdocs_annotation_options() {
	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) die(t('An error occurred.'));
	if (! user_can_access_admin_page()) wp_die('You do not have sufficient permissions to access this page');

	require(ABSPATH. 'wp-content/plugins/groupdocs-documents-annotation/options.php');
}
