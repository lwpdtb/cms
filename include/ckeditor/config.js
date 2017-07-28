/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.editorConfig = function( config )
{
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    config.uiColor = '#F1F5F2';
    // ÎÄ¼þä¯ÀÀ
    config.filebrowserImageBrowseUrl = "../include/dialog/select_images.php";
    config.filebrowserFlashBrowseUrl = "../include/dialog/select_media.php";
    config.filebrowserImageUploadUrl  = "../include/dialog/select_images_post.php";
	
	config.autoParagraph = false;
    config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P; 
    config.smiley_path=CKEDITOR.basePath+'plugins/smiley/images/mysmiley/';
 
    config.smiley_images=['angry_smile.gif','broken_heart.gif','confused_smile.gif','cry_smile.gif','ch_thumb.gif','thumbs_up.gif','devil_smile.gif','kiss.gif','omg_smile.gif','regular_smile.gif','sad_smile.gif','wink_smile.gif','shades_smile.gif','teeth_smile.gif','tounge_smile.gif','whatchutalkingabout_smile.gif'];
};
