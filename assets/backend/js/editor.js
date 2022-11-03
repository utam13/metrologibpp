/*
tinymce.init({
	mode: "textareas",
	theme: "advanced",
	theme_advanced_buttons1: "cut,copy,paste,undo,redo,separator,fontselect,fontsizeselect,formatselect,bold,italic,underline,strikethrough,separator,sub,sup,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent,separator,forecolor,backcolor,separator,hr,table,separator,asciimath,asciimathcharmap,asciisvg",
	theme_advanced_buttons2: "",
	theme_advanced_buttons3: "",
	theme_advanced_fonts: "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
	theme_advanced_toolbar_location: "top",
	theme_advanced_toolbar_align: "left",
	theme_advanced_statusbar_location: "bottom",
	plugins: 'asciisvg,table,inlinepopups',

	content_css: "css/content.css"
});
*/

// Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
// config.toolbar = [
// 	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
// 	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
// 	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
// 	{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
// 	'/',
// 	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
// 	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
// 	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
// 	{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
// 	'/',
// 	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
// 	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
// 	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
// 	{ name: 'others', items: [ '-' ] },
// 	{ name: 'about', items: [ 'About' ] }
// ];

// Toolbar groups configuration.
// config.toolbarGroups = [
// 	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
// 	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
// 	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
// 	{ name: 'forms' },
// 	'/',
// 	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
// 	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
// 	{ name: 'links' },
// 	{ name: 'insert' },
// 	'/',
// 	{ name: 'styles' },
// 	{ name: 'colors' },
// 	{ name: 'tools' },
// 	{ name: 'others' },
// 	{ name: 'about' }
// ];

var toolbarButton = [{
		name: 'clipboard',
		groups: ['clipboard', 'undo'],
		items: ['Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo']
	},
	{
		name: 'editing',
		groups: ['find', 'selection', 'spellchecker'],
		items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']
	},
	{
		name: 'basicstyles',
		groups: ['basicstyles', 'cleanup'],
		items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
	},
	{
		name: 'paragraph',
		groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
		items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
	},
	{
		name: 'insert',
		items: ['Table', 'HorizontalRule', 'SpecialChar']
	},
	{
		name: 'styles',
		items: ['Styles', 'Format', 'Font', 'FontSize']
	},
	{
		name: 'colors',
		items: ['TextColor', 'BGColor']
	},
	/*{
		name: 'wiris',
		items: ['ckeditor_wiris_formulaEditor', 'ckeditor_wiris_formulaEditorChemistry']
	},*/
	// {
	// 	name: 'eqneditor',
	// 	items: ['EqnEditor']
	// },
	{
		name: 'tools',
		items: ['Maximize','ShowBlocks']
	}
];

var toolbarButton2 = [{
		name: 'clipboard',
		groups: ['clipboard', 'undo'],
		items: ['Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo']
	},
	{
		name: 'basicstyles',
		groups: ['basicstyles', 'cleanup'],
		items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
	},
	{
		name: 'styles',
		items: ['Styles', 'Format', 'Font', 'FontSize']
	},
	{
		name: 'colors',
		items: ['TextColor', 'BGColor']
	}
];

var plugins = ['eqneditor', 'html5validation'];

CKEDITOR.replace('singkat', {
	toolbar: toolbarButton,
	extraPlugins: plugins
});

CKEDITOR.replace('isi', {
	toolbar: toolbarButton,
	extraPlugins: plugins
});

CKEDITOR.replace('visi', {
	toolbar: toolbarButton2,
	extraPlugins: plugins
});

CKEDITOR.replace('misi', {
	toolbar: toolbarButton2,
	extraPlugins: plugins
});

CKEDITOR.replace('jawaban_4', {
	toolbar: toolbarButton,
	extraPlugins: plugins
});

CKEDITOR.replace('jawaban_5', {
	toolbar: toolbarButton,
	extraPlugins: plugins
});

CKEDITOR.replace('jawaban_6', {
	toolbar: toolbarButton,
	extraPlugins: plugins
});
