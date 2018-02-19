;(function($) {

    "use strict";

    // After main page load, go to loading iframe.
    window.onload = function() {
        setTimeout(function() {
            var s = $("#ccp-iframe").attr("data-href");
            $("#ccp-iframe").attr("src", s);
        }, 5);
    }


    // Call drawing function.
	window.ccp_main = function(){

		setTimeout(function(){
			$("#ccp-bg").hide();
		},500);

		// Ace Editor Set Up
	    ace.require("ace/ext/language_tools");
	    var editor = ace.edit("ccp-data");
	    editor.getSession().setMode("ace/mode/css");
	    editor.setTheme("ace/theme/twilight");
	    editor.getSession().setUseWrapMode(true);
	    editor.$blockScrolling = Infinity;

	    // enable autocompletion and snippets
	    editor.setOptions({
	    	fontSize: "16px",
	        enableBasicAutocompletion: false,
	        enableSnippets: false,
	        enableLiveAutocompletion: false
	    });

	    // Focus to last line in editor as default
		editor.focus();
		var session = editor.getSession();
		var count = session.getLength();
		editor.gotoLine(count, session.getLine(count-1).length);


		// Close button width is same with gutter: ready
	   	var x = $(".ace_gutter").width();
	    $(".ccp-close").width(x);


	    // Close button width is same with gutter: Keydown
	    $("#ccp-data").on("keydown",function(){
	    	var x = $(".ace_gutter").width();
	    	$(".ccp-close").width(x);
	    });


	    // Set iframe.
	    var iframe = $($('#ccp-iframe').contents().get(0));
	    var iframeHead = iframe.find("head");
		var iframeBody = iframe.find("body");


		// Update title
		var title = iframeHead.find("title").html();
		$("head title").html(title);


		// Adding <style> area to head section.
		iframeHead.append("<style id='ccp-live-css'></style>");

	    // Live CSS
	    $("#ccp-data").on("keydown keyup",function(e){

	    	// Live update
	    	var v = editor.getValue();
	    	iframe.find("#ccp-live-css").html(v);

	    	// Update "Save" button
	    	if(e.altKey == false){
		    	if (e.which <= 90 && e.which >= 48 || e.which >= 96 && e.which <= 105 || e.which == 170 || e.which == 173 || e.which == 13 || e.which == 162 || e.which == 9 || e.which == 8 || e.which == 190 || e.which == 111 || e.which == 106 || e.which == 109 || e.which == 107 || e.which == 110 || e.which == 32){
			    	if($("#ccp-save").hasClass("active") == false){
			    		$("#ccp-save").addClass("active").text("Save Changes");
			    	}
			    }
		    }

	    });

	    // Add URL?ccp-iframe query on load.
		$('#ccp-iframe').load(function(){

			// Link
			var href = $(this).get(0).contentWindow.location.href;

			// Update
			if(href.indexOf("ccp-iframe=true") == -1){
		    	var n = ccp_add_query_arg(href,"ccp-iframe","true");
		    	$(this).attr("src",n);
		    }

		});

		// Live update
	    iframe.find("#ccp-live-css").html(editor.getValue());


	    // Keys
	    $(document).add(iframe).on('keyup keydown', function(e){

			// Getting current tag name.
			var tag = e.target.tagName.toLowerCase();

			// Getting Keycode.
			var key = e.keyCode || e.which;

			// Control
			var controlKey = false;
			var isInput = false;
			var shifted = e.shiftKey

			// Stop If CTRL Keys hold.
			if ((key === true || key === true)) {
				controlKey = true;
			}

			// Stop if this target is input or textarea.
			if (tag == 'input' || tag == 'textarea') {
				isInput = true;
			}

			// Backspace
			if (key == 8 && isInput == false && controlKey == false){
				e.preventDefault();
				return false;
			}
			
		});


		// Adding link to close btn.
		var g = ccp_delete_query($("#ccp-iframe").get(0).contentWindow.location.href,"ccp-iframe");
		$(".ccp-close").attr("href", g);


		// Check close btn
		$(".ccp-close").click(function(e){

		    if($("#ccp-save").hasClass("active")){
		    	
				e.preventDefault();

		    	if(confirm("Do you want to close without saving the changes?")){
		    		window.location = $(this).data("href");
		    	}

		    }

		});


		// Save changes
		$("#ccp-save").on("click",function(){

			var t = $(this);
			var v = editor.getValue();

			// Check if has any change.
			if(t.hasClass("active") == false){
				return false;
			}
			
			// Saving
			t.text("Saving").removeClass("active");
			
		    // Post
		    $.ajax({
				type: "POST",
				url: window.ccp_ajax_url,
				data:{
					action: 'ccp_save_data',
					data: v
				}
			}).done(function(){
				t.text("Saved");
			});

		});

	}


	// Adding query to URL
	function ccp_add_query_arg(uri, key, value){
		var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
		var separator = uri.indexOf('?') !== -1 ? "&" : "?";
		if (uri.match(re)) {
			return uri.replace(re, '$1' + key + "=" + value + '$2');
		}else{
			return uri + separator + key + "=" + value;
		}
	}


	// Remove URL Parementer
	// Source: http://stackoverflow.com/questions/1634748/how-can-i-delete-a-query-string-parameter-in-javascript
	function ccp_delete_query(url, parameter) {

    //prefer to use l.search if you have a location/link object
    var urlparts= url.split('?');   
    if (urlparts.length>=2) {

        var prefix= encodeURIComponent(parameter)+'=';
        var pars= urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        url= urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
        return url;
    }else{
        return url;
    }

}


}(jQuery));