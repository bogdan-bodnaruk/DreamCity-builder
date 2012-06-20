$(function(){
	ie_tr_fix();
	$("a").live('click', function(){
	    href = $(this).attr("href");
	    var regexp = new RegExp(/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/);
	    var regexp_text = regexp.test(href);
    
	    if(regexp_text==false) {
		if($(this).hasClass('progress')) {
		    loading();  
		};
		
		if(href===undefined || href=='#' || href=='submit_apply/' || $(this).hasClass('fancybox')) {
		    return false;  
		};
	
		last_char = href.charAt(href.length - 1);
		if(last_char !== '/' && last_char!=='#') {
		    href = href+'/';
		};
		
		if(href=='' || href=='/') {
		    href = 'index/';
		};
		
		function onAjaxSuccess(data) {
		    if(window.history.replaceState){
			history.replaceState(null,null,href);
		    };
		    $("#content").html(data);
		    close_panel();
		    unloading(); 
		    ie_tr_fix();
		    $("select").chosen();
		}
		
		$.get(href,{ajax: "true"},onAjaxSuccess);
		return false;
	    };
	});
   
    $('#content form').live('submit', function() {
        action = $(this).attr("action");
        var options = { 
            target:         '#content',
            url:            action+'/&ajax=true',
            beforeSubmit:   loading(), 
            http:           action,
            success:        success   
        };
        $(this).ajaxSubmit(options);
		
		if(window.history.replaceState){
			history.replaceState(null,null,options['http']);
		} else {
            window.location.href = options['http'];
        };
        return false; 
    });
    
    function success() {
        $("select").chosen();
		ie_tr_fix();
        unloading();
    }

    function loading() {
        $('body').addClass('loading');
    }
    
    function unloading() {
        $('body').removeClass('loading');
    }
	
	function ie_tr_fix() {
		if($.browser.msie && $.browser.version == '8.0') {
			$(".data_table tr:nth-child(even)").css({"background-color":"#EAEAEA"});
			$(".data_table tr:nth-child(odd)").css({"background-color":"#F3F3F3"});
		};
	}
});