CKEDITOR.editorConfig = function(config){
    config.language = DRM.locale;
    config.extraPlugins = "tableresize,youtube";
    config.removePlugins = "resize";

    config.skin = 'BootstrapCK-Skin';
    config.filebrowserImageUploadUrl = 'http://' + window.location.hostname + '/upload_files/cked/';
	config.smiley_path = '/' + DRM.libraryPath + '/DRM/smiley/';

    config.toolbar_admin = [
        { name: 'document',    items : [ 'Source','Preview','Print','Templates' ] },
        { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        { name: 'editing',     items : [ 'Replace','-','SelectAll' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        '/',
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','Outdent','Indent','Blockquote','CreateDiv','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','BidiLtr','BidiRtl' ] },
        { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
        { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar' ] },
        { name: 'tools',       items : [ 'Maximize', 'ShowBlocks' ] },
        '/',
        { name: 'styles',      items : [ 'Styles','Format','Font','FontSize','Youtube' ] },
        { name: 'colors',      items : [ 'TextColor','BGColor' ] }
    ];

    config.toolbar_basic = [
        { name: 'document', items :['Bold','Italic','-','OrderedList','UnorderedList','-','Link','Unlink','-','Undo','Redo','-','Smiley','-','FontSize','Blockquote'] },
    ];

    config.smiley_images = [
        'aa.gif','ab.gif','ac.gif', 'ad.gif', 'ae.gif', 'af.gif', 'ag.gif', 'ah.gif', 'ai.gif', 'aj.gif', 'ak.gif', 'al.gif', 'am.gif', 'an.gif', 'ao.gif', 'ap.gif',
        'aq.gif', 'ar.gif', 'as.gif', 'at.gif', 'au.gif', 'av.gif', 'aw.gif', 'ax.gif', 'ay.gif', 'az.gif', 'ba.gif', 'bc.gif', 'bd.gif', 'be.gif', 'bf.gif', 'bg.gif',
        'bh.gif', 'bi.gif', 'bj.gif', 'bk.gif', 'bl.gif', 'bm.gif', 'bn.gif', 'bo.gif', 'bp.gif', 'bq.gif', 'br.gif', 'bs.gif', 'bt.gif', 'bu.gif', 'bv.gif', 'bw.gif',
        'bx.gif', 'by.gif', 'bz.gif',  'ca.gif', 'cb.gif', 'cc.gif', 'cd.gif', 'ce.gif', 'cf.gif', 'cg.gif', 'ch.gif', 'ci.gif', 'cj.gif', 'ck.gif', 'cl.gif', 'cm.gif',
        'cn.gif', 'co.gif', 'cp.gif', 'cq.gif', 'cr.gif', 'cs.gif', 'ct.gif', 'cu.gif', 'cv.gif', 'cw.gif', 'cx.gif', 'cy.gif', 'cz.gif', 'da.gif', 'db.gif', 'dc.gif'
    ];

};
