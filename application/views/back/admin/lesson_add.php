<?php
    $course_details = $this->crud_model->get_course_by_id($param2)->row_array();
    $sections = $this->crud_model->get_section('course', $param2)->result_array();
?>

<div class="alert alert-default">

    <?php echo translate('lesson_type');?> : 

    <?php 
        if($param3 == 'video'){
            echo translate('video_file');
        }elseif($param3 == 'youtube' || $param3 == 'vimeo'){
            echo translate($param3) . ' ' .translate('video');
        }else{
            echo translate($param3);
        }
    ?>
    <a href="#" class="m1-1 pull-right" data-toggle="modal" data-dismiss="modal" onclick="showAjaxModal('<?php echo site_url('modal/popup/lesson_types/' . $param2 . '/' . $param3);?>', '<?php echo translate('select_another_lesson_type');?>')"><?php echo translate('change')?></a>
</div>
<hr>

<!-- For that add lesson for section -->
<form action="<?php echo site_url('admin/lessons/'.$param2.'/add'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="course_id" value="<?php echo $param2; ?>">
    <div class="form-group">
        <label><?php echo translate('title'); ?></label>
        <input type="text" name = "title" class="form-control" required>
    </div>

    <div class="form-group">
        <label><?php echo translate('section'); ?></label>
        <select class="form-control select2" data-toggle="select2" name="section_id" required>
            <?php foreach ($sections as $section): ?>
                <option value="<?php echo $section['id']; ?>"><?php echo $section['title']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php if ($param3 == 'youtube'): include('youtube_type_lesson_add.php'); endif; ?>
    <?php if ($param3 == 'vimeo'): include('vimeo_type_lesson_add.php'); endif; ?>
    <?php if ($param3 == 'document'): include('document_type_lesson_add.php'); endif; ?>
    <?php if ($param3 == 'image'): include('image_type_lesson_add.php'); endif; ?>
    <?php if ($param3 == 'iframe'): include('iframe_type_lesson_add.php'); endif; ?>

    <div class="form-group">
        <label><?php echo translate('summary'); ?></label>
        <textarea name="summary" class="form-control"></textarea>
    </div>

    <div class="text-center">
        <button class = "btn btn-success btn-rounded btn-sm btn-block" type="submit" name="button"><?php echo translate('add'); ?></button>
    </div>
</form>

<script type="text/javascript">
$(document).ready(function() {
    initSelect2(['#section_id','#lesson_type', '#lesson_provider']);
    initTimepicker();

    // Hide the select box from search box
    $('select').select2({
        minimumResultsForSearch: -1
    });
});

function ajax_get_video_details(video_url) {
    $('#perloader').show();
    if(checkURLValidity(video_url)){
        $.ajax({
            url: '<?php echo site_url('admin/ajax_get_video_details');?>',
            type : 'POST',
            data : {video_url : video_url},
            success: function(response)
            {
                jQuery('#duration').val(response);
                $('#perloader').hide();
                $('#invalid_url').hide();
            }
        });
    }else {
        $('#invalid_url').show();
        $('#perloader').hide();
        jQuery('#duration').val('');

    }
}

function checkURLValidity(video_url) {
    var youtubePregMatch = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    var vimeoPregMatch = /^(http\:\/\/|https\:\/\/)?(www\.)?(vimeo\.com\/)([0-9]+)$/;
    if (video_url.match(youtubePregMatch)) {
        return true;
    }
    else if (vimeoPregMatch.test(video_url)) {
        return true;
    }
    else {
        return false;
    }
}
</script>
