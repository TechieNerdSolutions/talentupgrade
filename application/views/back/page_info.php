<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title "><?=$page_title;?></h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                    
                        <ol class="breadcrumb">
                        <a href="<?=base_url()?>home" target="_blank" class="pull-right"> <i class="fa fa-angle-double-right "></i><?=translate('home_page')?></a>
                            <li><a href=""><?=get_settings('system_name')?></a></li>
                            <li class="active p-r-10"><?php echo date('d M, Y');?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>