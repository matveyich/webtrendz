  <!-- RIGHT COLUMN-->
        <div id="ja-right" class="column ja-cols sidebar" style="width: 30%;">
          <div class="ja-colswrap clearfix ja-r1">
            <div class="ja-col  column">
              
			  <div class="ja-moduletable moduletable_tabs  clearfix" id="Mod71">
                <div class="ja-box-ct clearfix">
                  <?php  if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('members login') ) : ?><?php  endif; ?>
                </div>
              </div>
			  
              <!--Tabbed box-->
              <div class="ja-moduletable moduletable_tabs  clearfix" id="Mod61">
                <div class="ja-box-ct clearfix">

                  <div class="ja-tabswrap seleni" style="width: 100%;">
                    <div id="myTab-1080109050" class="container">
                      
					  <div class="ja-tabs-title-top" style="height: 30px;">
                        <ul class="ja-tabs-title">
                          <li class="first active" title="Most Read"><h3><span>Articles</span></h3></li>
                          <li class="last" title="Latest News"><h3><span>Strategies</span></h3></li>
                          <li class="last" title="Latest News"><h3><span>FAQ's</span></h3></li>
                        </ul>
                      </div>
					  
                      <div style="height: 292px;" class="ja-tab-panels-top">
                        
						<div style="position: absolute; left: 0px; display: block;" class="ja-tab-content">
                          <div class="ja-tab-subcontent">
                            <?php if (!function_exists('last10_posts')) echo "last10_posts fucntions doesn't exist here"; else last10_posts("articles");?>
                          </div>
                        </div>
						
                        <div style="position: absolute; left: 0px; display: none;" class="ja-tab-content">
                          <div class="ja-tab-subcontent">
                            <ul>
                              <?php //wp_get_archives('type=postbypost&limit=10&format=html'); ?>
							  <?php if (!function_exists('last10_posts')) echo "last10_posts fucntions doesn't exist here"; else last10_posts("strategies");?>
                            </ul>
                          </div>
                        </div>
						<div style="position: absolute; left: 0px; display: block;" class="ja-tab-content">
                          <div class="ja-tab-subcontent">
                            <?php if (!function_exists('last10_posts')) echo "last10_posts fucntions doesn't exist here"; else last10_posts("faq");?>
                          </div>
                        </div>
						
                      </div>
					  
                    </div>
                  </div>
                  <script type="text/javascript" charset="utf-8">
                    window.addEvent("load", init);
                    function init()
                    {
                      myTabs1 = new JATabs("myTab-1080109050", {animType:'animNone',style:'seleni',position:'top',width:'100%',height:'auto',mouseType:'click',duration:1000,colors:10,useAjax:false,skipAnim:false});
                    }
                    //new JATabs("myTab-1080109050", {animType:'animNone',style:'seleni',position:'top',width:'100%',height:'auto',mouseType:'click',duration:1000,colors:10,useAjax:false,skipAnim:false});
                  </script>
                </div>
              </div>

              <!--block_2-->
              <div class="ja-moduletable moduletable_tabs  clearfix" id="Mod53">
                <div class="ja-box-ct clearfix">
                  <?php  if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('right panel') ) : ?><?php  endif; ?>
                </div>
              </div>
              <!--end block_2-->

            </div>
          </div>
        </div><!--30%-->
        <!-- RIGHT COLUMN-->