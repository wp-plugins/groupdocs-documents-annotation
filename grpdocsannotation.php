<?php

/*
Plugin Name: GroupDocs Annotation Embedder
Plugin URI: http://www.groupdocs.com/
Description: GroupDocs Annotation Plugin lets you embed different types of documents and images into your website and then invite your colleagues and clients to view and annotate them online, without the need to install any document editors or browser plugins.
Author: GroupDocs Team <support@groupdocs.com>
Author URI: http://www.groupdocs.com/
Version: 1.3.12
License: GPLv2
*/

include_once('grpdocs-functions.php');


function grpdocs_annotation_getdocument($atts) {

	extract(shortcode_atts(array(
		'file' => '',
		'width' => '',
		'height' => '',
        'email' => '',
        'can_view' => '',
        'can_annotate' => '',
        'can_download' => '',
        'can_export' => '',
		'page' => 0,
		'version' => 1,
	), $atts));

    $signer = '';
    $clientId = get_option('annotation_userId');
    $privateKey = get_option('annotation_privateKey');
    if(class_exists('GroupDocsRequestSigner')){
        $signer = new GroupDocsRequestSigner($privateKey);
    }else{
        include_once(dirname(__FILE__) . '/tree_annotation/lib/groupdocs-php/APIClient.php');
        include_once(dirname(__FILE__) . '/tree_annotation/lib/groupdocs-php/StorageApi.php');
        include_once(dirname(__FILE__) . '/tree_annotation/lib/groupdocs-php/GroupDocsRequestSigner.php');
        include_once(dirname(__FILE__) . '/tree_annotation/lib/groupdocs-php/FileStream.php');
        $signer = new GroupDocsRequestSigner($privateKey);
    }
    include_once(dirname(__FILE__) . '/tree_annotation/lib/groupdocs-php/AntApi.php');
    $apiClient = new APIClient($signer);
    $antApi = new AntApi($apiClient);
    $antApi->setBasePath('https://api.groupdocs.com/v2.0');
    $reviewer = new ReviewerInfo();
    $reviewer->primary_email = $email;
    $can_view = $can_view == 'True'? 1 : 0;
    $can_download = $can_download =='True'? 4 : 0;
    $can_annotate = $can_annotate =='True'? 2 : 0;
    $can_export = $can_export =='True'? 8 : 0;
    $access_rights = (string)(array_sum(array($can_view,$can_download,$can_annotate,$can_export)));

    $reviewer->access_rights = $access_rights;
    $addCollaborator = $antApi->AddAnnotationCollaborator($clientId, $file, $reviewer);
    if ($addCollaborator->status == "Ok") {
        $url = "https://apps.groupdocs.com/document-annotation2/embed/{$file}?referer=wordpress-annotation/1.3.12";

        $code_url = $signer->signUrl($url);

        $no_iframe = 'If you can see this text, your browser does not support iframes. Please enable iframe support in your browser or use the latest version of any popular web browser such as Mozilla Firefox or Google Chrome. For more help, please check our documentation Wiki: <a href="http://groupdocs.com/docs/display/annotation/GroupDocs+Annotation+Integration+with+3rd+Party+Platforms">http://groupdocs.com/docs/display/annotation/GroupDocs+Annotation+Integration+with+3rd+Party+Platforms</a>';
        $code = "<iframe src='{$code_url}' frameborder='0' width='{$width}' height='{$height}'>{$no_iframe}</iframe>";

        return $code;

    } else {
        throw new Exception($addCollaborator->error_message);
    }


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
