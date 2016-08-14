
    $("#contentEditor").submit(function(e){
        
        e.preventDefault();
        
        //alert("inside submit"); was used only for testing purpose to check the flow of control
        
        var formData = $(this).serializeArray();
        
        /*
        
        Defining all the flags that need to be checked before the form is submitted to prevent any kind of trickery.
        
        #1 not_title_wrong_type_error_flag --- is true if the type of the title is as defined by the regex /[a-zA-Z0-9\u0020\u003f\u002c\u0021\u002d]+/g, otherwise it will be false. The default value is false. 
        
        #2 not_title_is_empty_error_flag --- is true if the title is empty as defined by the regex /^\s+$|^$/g, otherwise it will be false. The default value is false. 
        
        #3 not_keywords_wrong_type_error_flag --- is true if the type of the keywords is as defined by the regex /[a-zA-z0-9\u002c]+/g, otherwise it will be false. The default value is false. 
        
        #4 not_keywords_is_empty_error_flag --- is true if the keywords field is empty as defined by the regex /^\s+$|^$/g, otherwise it will be false. The default value is false. 
        
        #5 not_editor_is_empty_error_flag --- is true if the editor field is empty as defined by the regex /^\s+$|^$/g, otherwise it will be false. The default value is false. 
        
        #6 not_description_wrong_type_error_flag --- is true if the type of the keywords is as defined by the regex /[a-zA-z0-9\u002c]+/g, otherwise it will be false. The default value is false. 
        
        #7 not_description_is_empty_error_flag --- is true if the editor field is empty as defined by the regex /^\s+$|^$/g, otherwise it will be false. The default value is false. 
        
        Flags #1,#2,#5 are mandatory flags meaning they will stop the post from being submitted/modified if these aren't true.
        Flags #3 and #6 are mandatory flags if #4 and #7 are true otherwise these are not mandatory flags.
        
        */
        var not_title_wrong_type_error_flag=false;
        var not_title_is_empty_error_flag = false;
        var not_keywords_wrong_type_error_flag=false;
        var not_keywords_is_empty_error_flag = false;
        var not_editor_is_empty_error_flag = false;
        var not_description_is_empty_error_flag = false;
        var not_description_wrong_type_error_flag = false;
        
        /* 
        
        var condition -  type is boolean ,will store just a true or false value.
        
        condition variable is used to implement the mandatory flags. 
        
        ** If the keywords and description fields are not empty, i.e. flags #4 and #7 are true the condition variable will look something        like this,
        
            condition = not_title_wrong_type_error_flag && not_title_is_empty_error_flag && not_keywords_wrong_type_error_flag && not_editor_is_empty_error_flag && not_description_wrong_type_error_flag 
        
            which will be true only if all the flags are true.
        
        ** Else if the keywords is empty and description is not empty, i.e. flags #4 is false and #7 is true the condition variable will look    something like this,
        
            condition = not_title_wrong_type_error_flag && not_title_is_empty_error_flag && not_editor_is_empty_error_flag && not_description_wrong_type_error_flag; 
        
            which will be true only if all the flags are true.
        
        ** Else if the keywords is not empty and description is empty, i.e. flag #4 is true and #7 is false the condition variable will look    something like this,
        
            condition = not_title_wrong_type_error_flag && not_title_is_empty_error_flag && not_editor_is_empty_error_flag && not_keywords_wrong_type_error_flag; 
        
            which will be true only if all the flags are true.
        
        ** Else if the keywords and description both are empty, i.e. flag #4 is false and #7 is false the condition variable will look          something like this,
        
            condition = not_title_wrong_type_error_flag && not_title_is_empty_error_flag && not_editor_is_empty_error_flag;
        
            which will be true only if all the flags are true.
        
        */
        
        var condition;
        
        /*
        
        The following variables are for displaying the errors upon form submission if any.
        
        */
        var title_error_html;
        var editor_error_html;
        var keywords_error_html;
        var description_error_html;
        
        
        var editor_data = CKEDITOR.instances.mytext.getData(); //getting the content from the editor. editor_data will be checked if it is empty or not ---------------------- #1
        
        var tag_result = $("#tag_result").toArray();  //retrieving the list of tags used. --------------------------- #2
        
        /* 
       
        checking if the title is empty, if the title is not empty the type of title is checked. If the title is empty a friendsly msg is displayed
        
        */
        if(!(not_title_is_empty_error_flag=/^\s+$|^$/.test(formData[0].value)?false:true)){
            title_error_html = "<small style='color:red'>Title cannot be empty</small>";
        }
        else if(!(not_title_wrong_type_error_flag = /[^a-zA-Z0-9\u0020\u003f\u002c\u0021\u002d]+/g.test(formData[0].value)?false:true)){
            title_error_html = "<small style='color:red'>Title can only contain [a-zA-Z0-9,!-?]</small>";
        }
        
        /* 
        
        checking if the keywords field is empty, if the keywords field is not empty the type of keywords are checked. If the keywords field is empty a friendly msg is displayed prompting the user to enter atleast one keyword
        
        */
        
        if(!(not_keywords_is_empty_error_flag=/^\s+$|^$/.test(formData[2].value)?false:true)){
            keywords_error_html = "<small style='color:red'>Keywords help improve page rankings in the searches please insert atleast one keyword</small>";
        }
        else if(!(not_keywords_wrong_type_error_flag = /[^a-zA-z0-9\u002c]+/g.test(formData[2].value)?false:true)){
            keywords_error_html = "<small style='color:red'>Keywords can only contain [a-zA-Z0-9,]</small>";
        }
        
        /*
        
        type and is empty checker for the editor. The rich text editor adds a linefeed character at the end of each paragraph. That needs to be taken care of while making the regular expressions for the editor. Also empty spaces with no text is converted to &nbsp; in a string format. So the regular expression needs to check for the characters "&nbsp;" instead of the ascii character 160(&nbsp, unicode- u00a0). Also the configuration settings of the editor was forcing a line feed at the end of a paragraph, that caused the the regular expression, /^<\w+>(\u0026(nbsp;))*<\/\w+>$|^$/gm, to fail because /..|^$/gm was still holding true. The solution was to change the way the editor formats the output and disabling line feed after </p>.
        
        */
        if(!(not_editor_is_empty_error_flag = /^<\w+>(\u0026(nbsp;))*<\/\w+>$|^$/gm.test(editor_data)?false:true)){
            editor_error_html = "<small style='color:red'>Editor can not be empty or just contain gibberish!</small>";  
        }
            
        /* 
        
        checking if the description is empty, if the description is not empty the type of description's content is checked. If the description is empty a friendly msg is displayed prompting the user to enter atleast a small description
        
        */
        
        if(!(not_description_is_empty_error_flag = /^$|^\s+$|[^\w](?=[^\w])/g.test(formData[3].value)?false:true)){
            description_error_html = "<small style='color:red'>Description is needed for improving the page visibility in the searches along with with the keywords. However, description isn't mandatory it is a good practice to give dedscription.</small>";
        }
        else if(!(not_description_wrong_type_error_flag = /[^a-zA-Z0-9\u0020\u002c\u002e\u002d\u003f\u005f]+/g.test(formData[3].value)?false:true)){
            description_error_html = "<small style='color:red'>Description can only contain [a-zA-Z0-9,-?._]</small>";
        }
        

        /*
            unicode characters used in regExes.
            u0020 sp
            u0021 !
            u002c ,
            u002d -
            u003f ?
            u002e .
            u005f _
            u0022 "
            u002f /
            u00a0 nbsp
            u000a line feed
            u0026 &
        */
        
        if(not_description_is_empty_error_flag && not_keywords_is_empty_error_flag){
            
            condition = not_title_wrong_type_error_flag && 
                        not_title_is_empty_error_flag && 
                        not_keywords_wrong_type_error_flag && 
                        not_editor_is_empty_error_flag && 
                        not_description_wrong_type_error_flag;
        }
        
        else if(not_description_is_empty_error_flag==false && not_keywords_is_empty_error_flag==true){
            condition = not_title_wrong_type_error_flag && 
                        not_title_is_empty_error_flag && 
                        not_keywords_wrong_type_error_flag && 
                        not_editor_is_empty_error_flag;
            
            $("#description_error").html(description_error_html); //empty field msg
        }
        else if(not_description_is_empty_error_flag==true && not_keywords_is_empty_error_flag==false){
            condition = not_title_wrong_type_error_flag && 
                        not_title_is_empty_error_flag && 
                        not_editor_is_empty_error_flag && 
                        not_description_wrong_type_error_flag;
            
            $("#keywords_error").html(keywords_error_html); //empty field msg
        }
        else{
            condition = not_title_wrong_type_error_flag &&
                        not_title_is_empty_error_flag &&
                        not_editor_is_empty_error_flag;
            
            $("#keywords_error").html(keywords_error_html); // empty field msg 
            $("#description_error").html(description_error_html); //empty field msg 
        }
        
        
        if(condition){
            
            formData[1]['value']=editor_data; // populated from ------------------- #1
            
            var tags = tag_result[0].textContent.match(/\w+/g); // serializing the contents of the tags into an array from  ------------- #2
        
            formData[4]['value'] = tags;
            
            formData[2].value = formData[2].value.match(/\w+/g); //serializing the keywords into an array
            
            $.ajax({
                url:"http://localhost/web/index.php/tmpl/editordb",
                data : $.param( formData ),
                method: "POST",
                success: function(){
                //     $("#ajaxNotice").modal('show');
                    alert("Success!")
                }
            }).fail(function(){
                //$("#ajaxNoticeFail").modal('show');
                alert("Operation failed!");
            });
        }
        else{
            
                $("#title_error").html(title_error_html);
                        
                $("#keywords_error").html(keywords_error_html);
                
                $("#editor_error").html(editor_error_html);
                
                $("#description_error").html(description_error_html);
            
                alert("Your request failed because there were errors in the form. Please resolve the errors before proceeding.");
        }
       // alert("hold here!");
    });


//this script is complete. make browser.php, upload.php and the scripts to process the inputs of the editor.
