$(function(){
    function verify_tags(val){
        /* i will verify the tags 
            i will accept a string as an argument
            and i will check if it matches the 
            pattern as defined in reg ex.
        */
        return /^[a-zA-Z]+\u0020$|^$/i.test(val)?true:false;
        
    }
    /*function verify_editor_content(val){
        
        change_special_chars_to_text(val);
        return true;
    }*/
    function verify_title(val){
        return /[a-zA-Z0-9\u002c\u002e\u0020\u002d\u002a\u0026\u0027\u0022\u0021]+/ig.test(val)?true:false;
    }
    function verify_keywords(val){
        return /[a-zA-Z0-9\u002c]+/ig.test(val)?true:false;
    }
    /*function very_description(val){
        
    }

    function change_special_chars_to_text(val){
          
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }*/
    
});