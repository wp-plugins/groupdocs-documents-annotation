(function() {
	tinymce.PluginManager.requireLangPack('grpdocs_annotation');
	tinymce.create('tinymce.plugins.GrpdocsAnnotationPlugin', {
		init : function(ed,url) {
			ed.addCommand('mceGrpdocsAnnotation', function() {
				ed.windowManager.open( {
					file : url + '/../grpdocs-dialog.php',
					width : 420 + parseInt(ed.getLang('grpdocs_annotation.delta_width',0)),
					height : 540 + parseInt(ed.getLang('grpdocs_annotation.delta_height',0)),
					inline : 1}, {
						plugin_url : url,
						some_custom_arg : 'custom arg'
					}
				)}
			);
			ed.addButton('grpdocs_annotation', {
				title : 'GroupDocs Annotation Embedder',
				cmd : 'mceGrpdocsAnnotation',
				image : url + '/../images/grpdocs-annotation-button.png'
			});
			ed.onNodeChange.add
				(function(ed,cm,n) {
					cm.setActive('grpdocs_annotation',n.nodeName=='IMG')
				})
		},
		createControl : function(n,cm) {
			return null
		},
		getInfo : function() { 
			return { 
				longname : 'GroupDocs Annotation Embedder',
				author : 'Sergiy Osypov',
				authorurl : 'http://www.groupdocs.com',
				infourl : 'http://www.groupdocs.com',
				version : "1.0"}
		}
	});
	tinymce.PluginManager.add('grpdocs_annotation',tinymce.plugins.GrpdocsAnnotationPlugin)
})();
