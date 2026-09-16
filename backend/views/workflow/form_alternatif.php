    <div class="page-content padding-10">
        <div class="page-sidebar">
            <nav class="navbar" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="clearfix">
                    <!-- Toggle Button -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".page-siderbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="toggle-icon">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </span> 
                    </button>
                    <!-- End Toggle Button -->
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="nav-collapse collapse navbar-collapse page-siderbar-collapse">
                    <ul class="nav navbar-nav margin-bottom-35" id="workflow-submenu">
                    <?php 
                        $menu = json_decode($data->workflow_list);

                        foreach ($menu as $dt) {
                            echo '<li><a href="javascript:;" style="font-size:10pt" data-name="'.$dt->menu.'" data-url="'.base_url().$_module.'/edit_alternatif/'.$id.'/'.$dt->flag.  '">'.$dt->menu.'</a></li>';
                        }
                    ?>
                    </ul>
                </div>                        
            </nav>
        </div>
        <!-- END PAGE SIDEBAR -->
        <div class="page-container" id="page-flow-content">

        </div>
       
      <div class="modal-footer">
        <?php
          echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', array(
                    'class' => 'btn btn-labeled btn-default margin-right-2',
                    'onclick' => 'my_global.go_back()'
                ));
        ?> 
      </div>
    
    </div>

<script type="text/javascript">

    $('ul#workflow-submenu > li a').click(function(event) {
        _this    = $(this);
        _this.parents('ul').find('li').removeClass('active');
        _this.closest('li').addClass('active');

        var url  = _this.data('url');
        var name = _this.data('name');

        get_content(url,name);
    });

    $(function(){
        var list = $('ul#workflow-submenu > li').first().addClass('active');
        var url  = list.find('a').data('url');
        var name = list.find('a').data('name');
        get_content(url,name);
        
    });

    function get_content(url,name) {        
        $.get(url, {name : name},function(data) {
            $('#page-flow-content').html(data);
        });
    }
</script>