<link href="/web/static/custom/css/editor.css" rel="stylesheet" type="text/css">
<form id="contentEditor">
    <div class="row">
        <div class="col-sm-8">
            <!-- breakpoint @ 770px; fix that -->
            <div class="form-group">
                <label for="title">Title</label><div id="title_error"></div><br />
                <input type="text" class="form-control text_width" name="title" id="title" placeholder="Enter the articles title here">
            </div>
            <br />
            <div class="section editor"> 
                <div id="editor_error"></div><br />
                <textarea id="mytext" name="mytext" rows="50" cols="400"></textarea>
            </div><br />
            <div class="section meta-data">
                <div class="form-group">
                    <label for="keywords">Meta Keywords</label><div id="keywords_error"></div><br />
                    <input class="form-control text_width" type="text" id="keywords" name="keywords" placeholder="Keywords">
                </div>
                <br />
                <div class="form-group">
                    <label for="description">Meta Description</label><div id="description_error"></div><br />
                    <textarea id="description"  class="form-control text_width" name="description" rows="5" cols="20"></textarea>
                </div>
                    <!-- ideally submit button must be the last statement of a form but here I've placed it here
                    for the sake of formatting, the for continues beyond this as well. -->
                  
            </div>
        </div>
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-12 tags">
                    <div class="section">
                        <h4>Tags</h4>
                        <div id="new-tag-notification"><small>New Tag Created!</small></div>
                        <div class="form-group">
                            <input type="search" class="form-control" placeholder="Start typing for a hashtag or type the word and hit space to create one" id="tags" name="tags">
                            <div class="fetched" id="fetched_tags"></div>
                            <div class="tag_result" id="tag_result"></div>
                        </div>
                        <div id="frequently-used-tags" class="section">
                            <h4 class="small">Frequently used tags</h4>
                            <?php
                                foreach($frequently_used_tags as $tag){
                                    
                                    echo $tag;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 categories">
                    <div class="section">
                        <h4>Categories</h4>
                        <div class="form-group">
                            <select class="form-control" name="categories" id="categories">
                                <?php
                                    foreach($frequently_used_categories as $category){
                                        echo "<option value='".$category."'>".$category."</option>";
                                    }
                                ?>
                            </select>
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-default" id="submit" name="submit" value="Submit">
        <!-- bootstrap modal for success of request-->
        
        
</form>     
    <div class="modal fade" tabindex="-1" role="dialog" id="ajaxNotice">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>The article is updated successfully&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <!-- bootstrap modal for success of request-->
        <div class="modal fade" tabindex="-1" role="dialog" id="ajaxNoticeFail">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>There was an error while processing the request&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    
    
        

<script src="/web/static/ckeditor/ckeditor.js"></script>
<script>
            CKEDITOR.replace('mytext',
            {
                extraPlugins: 'mathjax',
			    mathJaxLib: 'http://cdn.mathjax.org/mathjax/2.6-latest/MathJax.js?config=TeX-AMS_HTML',
                height: 400,
                width: 620,
                filebrowserBrowseUrl: '../index.php/browser',
                filebrowserUploadUrl: '../index.php/upload',
                extraPlugins: 'image2',
                height: 400,
                on :
                {
                    instanceReady : function( ev )
                    {
                        // Output paragraphs as <p>Text</p>.
                        this.dataProcessor.writer.setRules( 'p',
                        {
                            indent : false,
                            breakBeforeOpen : true,
                            breakAfterOpen : false,
                            breakBeforeClose : false,
                            breakAfterClose : false
                        });
                    }
                }
            });
</script>
<!--script src="/web/static/custom/js/editor/validate.js"></script-->
<script src="/web/static/custom/js/editor/tag.js"></script>
<script src="/web/static/custom/js/editor/submit.js"></script>
    
    
    
    