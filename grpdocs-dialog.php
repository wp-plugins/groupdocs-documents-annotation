<?php
// access wp functions externally
require_once('bootstrap.php');

ini_set('display_errors', '0');
error_reporting(E_ALL | E_STRICT);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>GroupDocs Annotation Embedder</title>
	<script type="text/javascript" src="js/jquery-1.5.min.js"></script>
	<script type="text/javascript" src="js/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/grpdocs-dialog.js"></script>
	
	<script type="text/javascript" src="tree_viewer/lib/jquery_file_tree/jquery.file_tree.js"></script>
	<script type="text/javascript" src="tree_viewer/js/tree_viewer_page.js"></script>
	<link href="tree_viewer/lib/jquery_file_tree/jquery.file_tree.css" type="text/css" rel="stylesheet" />
	
	<link href="css/grpdocs-dialog.css" type="text/css" rel="stylesheet" />

</head>
<body>
<form id='form' onsubmit="" method="post" action="" enctype="multipart/form-data">
		
<table>  
  <tr>
    <td align="right" class="gray dwl_gray"><strong>Client Id</strong><br /></td>
    <td valign="top"><input name="userId" type="text" class="opt dwl" id="userId" style="width:200px;" value="<?php echo get_option('userId'); ?>" /><br/>
	<span id="uri-note"></span></td>
  </tr>
  <tr>
    <td align="right" class="gray dwl_gray"><strong>API Key</strong><br /></td>
    <td valign="top"><input name="privateKey" type="text" class="opt dwl" id="privateKey" style="width:200px;" value="<?php echo get_option('privateKey'); ?>" /><br/>
	<span id="uri-note"></span></td>
  </tr>
  <tr>
    <td align="right" class="gray dwl_gray"><strong>Height</strong></td>
    <td valign="top" style="width:200px;"><input name="height" type="text" class="opt dwl" id="height" size="6" style="text-align:right" value="700" />px</td>
  </tr>
  <tr>
    <td align="right" class="gray dwl_gray"><strong>Width</strong></td>
    <td valign="top"><input name="width" type="text" class="opt dwl" id="width" size="6" style="text-align:right" value="600" />px</td>
  </tr>
</table>


<div class="section">
	
<ul class="tabs">
	<li class="current">Browse &amp; Embed</li>
	<li>Upload &amp; Embed</li>
	<li>Paste Link</li>
</ul>

<div class="box visible">
	<strong>Select File</strong><br />
	<span id="groupdocs_keys_error" style="display:none">WARNING: There is no user id and/or private key
		please enter them on GroupDocs Options page
		or fill marked fields and press <a href="#" onclick='loadFileTree(jQuery);return false'>reload</a>
	</span>
	
    <div id="groupdocsBrowser">
		<div id="groupdocsBrowserInner" >
		</div>
	</div>
</div>

<div class="box">
	<strong>Upload Document</strong><br />
    <input name="file" type="file" class="opt dwl" id="file" style="width:200px;" /><br/>
	<span id="uri-note"></span>	
</div>

<div class="box">
 
  <strong>Document Id (GUID)</strong><br />
  <input name="url" type="text" class="opt dwl" id="url" style="width:200px;" /><br/>
  <span id="uri-note"></span>
  
</div>
</div><!-- .section -->
	
<fieldset>
   <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
    <td colspan="2">
    <br />
    Shortcode Preview
    <textarea name="shortcode" cols="72" rows="2" id="shortcode"></textarea>
    </td>
	</tr>
   </table>
</fieldset>
	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="insert" name="insert" value="Insert" onclick="GrpdocsInsertDialog.insert();" />
			
		</div>

		<div style="float: right">
			<input type="button"  id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();"/>
		</div>
	</div>
</form>

</body>
</html>
<?php
if(!empty($_POST) && !empty($_FILES)) {

$file = $_FILES['file'];
$error_text = true; // Show text or number
define("UPLOAD_ERR_EMPTY",5);
   if($file['size'] == 0 && $file['error'] == 0){
     $file['error'] = 5;
   }
  $upload_errors = array(
    UPLOAD_ERR_OK        => "No errors.",
    UPLOAD_ERR_INI_SIZE    => "Larger than upload_max_filesize.",
    UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL    => "Partial upload.",
    UPLOAD_ERR_NO_FILE        => "No file.",
    UPLOAD_ERR_NO_TMP_DIR    => "No temporary directory.",
    UPLOAD_ERR_CANT_WRITE    => "Can't write to disk.",
    UPLOAD_ERR_EXTENSION     => "File upload stopped by extension.",
    UPLOAD_ERR_EMPTY        => "File is empty." // add this to avoid an offset
  );
   // error: report what PHP says went wrong
   $err = ($error_text) ? $upload_errors[$file['error']] : $file['error'] ;

   if($file['error'] !== 0) {
		echo "<div class='red'>" . $err . "</div>";
	} else {
	
		include_once(dirname(__FILE__) . '/tree_viewer/lib/groupdocs-php/APIClient.php');
    	include_once(dirname(__FILE__) . '/tree_viewer/lib/groupdocs-php/StorageAPI.php');
    	include_once(dirname(__FILE__) . '/tree_viewer/lib/groupdocs-php/GroupDocsRequestSigner.php');
		include_once(dirname(__FILE__) . '/tree_viewer/lib/groupdocs-php/FileStream.php');

		$uploads_dir = dirname(__FILE__);

		$tmp_name = $_FILES["file"]["tmp_name"];
		$name = $_FILES["file"]["name"];
		$fs = FileStream::fromFile($tmp_name);


		$signer = new GroupDocsRequestSigner(trim($_POST['privateKey']));
    	$apiClient = new APIClient($signer);
    	$api = new StorageApi($apiClient);

		$result = $api->Upload($_POST['userId'], $name, 'uploaded', $fs);

		echo"<script>
			tinyMCEPopup.editor.execCommand('mceInsertContent', false, '[grpdocsannotation file=\"" . @$result->result->guid . "\" height=\"{$_POST['height']}\" width=\"{$_POST['width']}\"]');
			tinyMCEPopup.close();</script>";
		die;
	}
}
