$(document).ready(function() {

$(function(){
	    $('#longtext').froalaEditor({
	    	height: 200,
	        imageInsertButtons: ['imageBack', '|', '|', 'imageByURL', '|'],
	        videoInsertButtons: ['videoBack', '|', '|', 'videoByURL', '|'],
	        quickInsertButtons: false,
	        toolbarButtons:['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 
	                           'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 
	                           'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 
	                           'embedly',  'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 
	                           'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
	                           language: 'tr'
	        });
	    $('#content').froalaEditor({
	    	height: 70,
	        imageInsertButtons: ['imageBack', '|', '|', 'imageByURL', '|'],
	        videoInsertButtons: ['videoBack', '|', '|', 'videoByURL', '|'],
	        pasteDeniedTags: ['a', 'i','b','hr'],charCounterMax: 500,
	        quickInsertButtons: false,
	        toolbarButtons:['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 
	                             'color',  'specialCharacters', 'insertHR',  
	                           'clearFormatting', '|',  'undo', 'redo'],
	                           language: 'tr'
	        });

	   
	  });
});