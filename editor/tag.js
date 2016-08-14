$(function(){
    
    $("#new-tag-notification").hide();
    function maketag(val){
        var tag = "<strong>"+val+
                  "<span class='times'>&times;</span></strong>";

        $("#tag_result").append(tag);
    }
    
    $("#tags").keyup(function(e){
        var val = e.target.value;
        
        if(/^[a-zA-Z\u0020]+|^$/i.test(val)){
            $("#new-tag-notification").hide();
            
            if(val==""){
                $("#fetched_tags").hide();
            }
            
            else if(e.which!=32){
                $.ajax({
                    url:"http://localhost/web/index.php/tmpl/fetch",
                    data : {tags:val},
                    success: function(arg){
                        var arr = JSON.parse(arg);
                        var out = "<ul class='suggest'>";
                        for (x in arr){
                            out += "<li class='suggest-group'>"+arr[x]+"</li>";
                        }
                        out += "</ul>";
                        $("#fetched_tags").html(out);
                        $("#fetched_tags").show();
                    }
                });
            }
            
            else{
                maketag(val);
                $("#tags").val("");
                $("#fetched_tags").hide();
                /*$.ajax({
                    url:"http://localhost/web/index.php/tmpl/new_tag",
                    data:{tags:val},
                    success:function(){
                    $("#new-tag-notification").show().fadeOut("700");
                    }
                })*/
            }
        }
        
        else{
            $("#new-tag-notification").html("<span style='color:red'>*Must only contain alphabets</span>");
            $("#new-tag-notification").show();
        }
    });
    $("#fetched_tags").on("click",".suggest-group",function(e){
        var val = this.textContent;
        maketag(val);
        $("#tags").val("");
        $("#fetched_tags").hide();
    });
    $("#frequently-used-tags").on("click",".frequent-tags",function(e){
        var val = this.textContent;
        maketag(val);
        $(this).addClass("clicked");
    });
    $("#tag_result").on("click",".times",function(){
        $(this).parent().remove();
        $(this).remove();
    });

});

//this script is complete.