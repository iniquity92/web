<?php
    defined('BASEPATH') or exit('No direct script access allowed');
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image browser</title>
        <script src='<?php echo base_url("/static/js/jquery-2.2.0.js"); ?>'></script>
        <link href='<?php echo base_url("/static/bootstrap/css/bootstrap.css"); ?>' type="text/css" rel="stylesheet">
        
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                {gallery}
                    <div class="{class}">
                        <a href="{img_url}" class="thumbnail">
                            <img src="{thumb_img_url}">
                            <h5><small>{name}</small></h5>
                        </a>
                    </div>
                {/gallery}
            </div>
        </div>
    </body>
    <script src="<?php echo base_url("static/bootstrap/js/bootstrap.js"); ?>"></script>
    
    <script>
        $(function(){
            
            $("a").on("click",function(e){
                e.preventDefault();
                var url = e.currentTarget.getAttribute("href");
                var alt_text = url.match(/.*\/([\d\w]+)\.\w+/);
                //alert(url + "<br />"+ window.opener);
                window.opener.document.getElementById('cke_120_textInput').value = url;
                window.opener.document.getElementById('cke_127_textInput').value = alt_text[1];
                window.close();
            });
        });
    </script>
</html>