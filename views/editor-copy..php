<link href="/web/static/custom/css/editor.css" rel="stylesheet" type="text/css">
<div class="row">
 <div class="col-sm-8">
 <!-- breakpoint @ 770px; fix that -->
    <div class="section">
    <h4>Editor - Type in the editor to make changes to the document</h4>
    <form>
    <!-- form begins -->
      <textarea id="mytext" name="mytext" rows="50" cols="400"></textarea>
    </div>
    <br />
        <div class="form-group">
            <label for="keywords">Meta Keywords</label><br />
            <input type="text" id="keywords" name="keywords" size="40" placeholder="Meta Keywords">
        </div>
        <br />
        <div class="form-group">
            <label for="description">Meta Description</label><br />
            <textarea id="description" name="description" rows="5" cols="50"></textarea>
        </div>
        <!-- ideally submit button must be the last statement of a form but here I've placed it here
        for the sake of formatting, the for continues beyond this as well. -->
        <input type="submit" name="submit" id="submit" value="Submit">
  </div>
  <div class="col-sm-4">
      <div class="row">
            <div class="col-sm-12 tags">
                <div class="section">
                    <h4>Tags</h4>
                    <div id="new-tag-notification"><small>New tag created</small></div>
                        <div class="form-group">
                            <input type="search" class="form-control" placeholder="Start typing for a hashtag or type the word and hit space to create one" id="tags" name="tags">
                            <div class="fetched" id="fetched_tags"></div>
                            <div class="" id="tag_result"></div>
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
            <div class="col-sm-12 categories">
                <h4>Categories</h4>
                <!-- form continues -->
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="Categories" id="categories" name="categories">
                    </div>
                    <div id="frequently-used-categories" class="section">
                        <h4 class="small">Frequently used categories</h4>
                    </div>
               </div>
               
             </form>         
      </div>
  </div>
</div>
<script src="/web/static/ckeditor/ckeditor.js"></script>
<script>
            CKEDITOR.replace('mytext',{
              extraPlugins: 'mathjax',
			        mathJaxLib: 'http://cdn.mathjax.org/mathjax/2.6-latest/MathJax.js?config=TeX-AMS_HTML',
              height: 400,
              width: 620,
              filebrowserBrowseUrl: '../browser.php',
              filebrowserUploadUrl: '../upload.php',
              extraPlugins: 'image2',
              height: 400
            });
</script>
<script src="/web/static/js/tag.js">
</script>