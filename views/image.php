<!DOCTYPE html>
<html>
    <head>
        <title>Image class</title>
        <!--javascript -->
        <script src="/web/static/js/jquery-2.2.0.js" type="text/javascript"></script>
        
        <script src="/web/static/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        
        <script src="/web/static/jqueryui/jquery-ui.js" type="text/javascript"></script>
        
       
        
        <!--css-->
        <link href="/web/static/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
        
        <link href="/web/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        
        <link href="/web/static/jqueryui/jquery-ui.css" rel="stylesheet" type="text/css">
        
        <link href="/web/static/jqueryui/jquery-ui.theme.css" rel="stylesheet" type="text/css">
        
        <!-- custom css -->
        <link href="/web/static/custom/css/imagelandingpage.css" rel="stylesheet" type="text/css">
        
        <link href="/web/static/custom/css/modal.css" rel="stylesheet" type="text/css">
        
            
    </head>
    
    <body>
        <div class="site-wrapper">
            <div class="site-wrapper-inner">
                <div class="cover-container">
                    
                    <div class="masthead clearfix">
                        <div class="inner">
                            <h3 class="masthead-brand">Cover</h3>
                            <nav>
                                <ul class="masthead-nav nav">
                                    <li class="active"><a href="#">Home</a></li>
                                    <li><a href="#">Features</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                            
                    <div class="inner cover">
                        <h1 class="cover-heading">Image manipulator</h1>
                        <p class="lead">One stop solution for your image manipulation needs</p>
                        <p class="lead">
                            <button class="btn btn-lg btn-default" data-toggle="modal" data-target="#uploader">Upload Image</button>
                        </p>
                    </div>
                    
                    <div class="mastfoot">
                        <div class="inner">
                            <p>Service brought to you buy <a href="https://github.com/iniquity92">Abhishek Singh</a></p>
                        </div>
                    </div>
            
            
                
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="uploader" tabindex="-1" role="dialog" aria-labelledby="uploaderLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-lable="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                                                
                       <div class="fileupload" id="fileupload">
                            <input id="filein" type="file">
                       </div>
                       <div class="edit-btn" id="edit-btn"></div>
                       <div class="upload-another" id="upload-another"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" data-target="uploader">close</button>
                            
                    </div>
                </div>
            </div>
        </div>
        <script src="/web/static/custom/js/preview.js" type="text/javascript"></script>
        
       
    </body>
</html>