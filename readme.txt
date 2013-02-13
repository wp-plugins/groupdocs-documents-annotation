=== GroupDocs Word, Excel, Powerpoint, Image and PDF Annotate ===
Contributors: GroupDocs Team
Tags: annotation, doc, docx, pdf, ppt, pptx, xls, xlsx, groupdocs, powerpoint, excel, word, acrobat
Author URI: http://groupdocs.com
Requires at least: 2.8
Tested up to: 3.5.0
Stable tag: trunk
License: GPLv2

Lets you embed the GroupDocs Annotation into Wordpress to annotate your documents directly in WordPress website.

== Description ==


GroupDocs Annotation lets you embed several types of files into your WordPress pages using the GroupDocs Viewer - allowing inline viewing and annotation of the following file types, with no Flash or PDF browser plug-ins required: 

* Adobe Acrobat (PDF)
* Microsoft Word (DOC/DOCX)
* Microsoft Excel (XLS/XLSX)
* Microsoft PowerPoint (PPT/PPTX)


GroupDocs Annotation lets you view and comment on documents online. Its document annotation features makes it a powerful tool for collaboration. You and your colleagues can collaborate on a document, at the same time, to improve communication and speed up document reviews. GroupDocs Annotation lets you work with text-based documents as well as images. You can collaborate on layouts, drawings and designs just as effectively as on articles, stories and corporate documents. In short GroupDocs Annotation lets you [annotate](http://groupdocs.com/apps/annotation) on many file formats including PDF's, Word documents, Excel documents, Powerpoint documents and many other available formats.

= How Document Annotation Works =
GroupDocs Annotation has a simple document annotation workflow: upload a Microsoft Word or PDF file to the dashboard, select it and got to the GroupDocs Annotation app. Share the document with colleagues so that they too can annotate it. You can now add comments to the document. When the review is complete, save the document with Microsoft Word comments so that you can edit by simply accepting or rejecting changes.




== Installation ==

= Manual installation =

1. Upload the entire `groupdocs-documents-annotation` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress.
3. Done.

Upload the documents to your GroupDocs account. Use the GroupDocs Annotation Embedder button in the Visual editor to build the appropriate shortcode by copy&pasting the document groupdocs.com link.

The other way to embed the document is to upload it via this plugin to your groupdocs.com account then the shortcode will be automatically generated and inserted to the content of the post.

Be aware that to upload the document with this plugin to your groupdocs.com account you will have to input the  User Id and Private Key, which can be found at the bottom of the profile in the GroupDocs dashboard (click icon in the top right of the header to view the profile). It will then be stored in the Plugin Settings.

== Screenshots ==

1. Here's a screenshot of how to get your document link for insertion into the GroupDocs Annotation Embedder dialog
2. Here's a screenshot of the GroupDocs Annotation Embedder in a Wordpress blog (with Polyline annotation)
3. Here's a screenshot of the GroupDocs Annotation Embedder in a Wordpress blog (with Point annotation)
4. Here's a screenshot of the GroupDocs Annotation Embedder in a Wordpress admin panel


== Frequently Asked Questions ==

= How can I get detailed help =
For further help you may choose any of following options:

* You can also contact us by various means as mentioned on our [Contact Us](http://groupdocs.com/about/contact/) page.

= Are there any specific PHP extensions that should be enabled?  =

cURL extension is required (extension=php_curl.dll)

== Changelog ==

= 1.3.3 =
* Fixed a bug with pop-up window.

= 1.3.2 =
* Update GroupDocs SDK.
* Update tracking parameter.
* Add needed parameter to iframe src.

= 1.3.1 =
* Fixed a bug relating include error.

= 1.3.0 =
* New version with tree viewer.

= 1.2.2 =
* New tabs view.

= 1.2.1 =
* Updated compatibility, and tags

= 1.2 = 
* Fixed a bug relating to url encoding in the file variable
* Fixed issue relating to security warning in Chrome
 
= 1.1 = 
* Fixed 2 path related bugs

= 1.0 =
* Initial release
