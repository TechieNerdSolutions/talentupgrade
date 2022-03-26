<?php
// $param2 = lesson id and $param3 = course id
$lesson_details = $this->crud_model->get_lessons('lesson', $param2)->row_array();
$sections = $this->crud_model->get_section('course', $param3)->result_array();
?>
<!-- SHOWING THE LESSON TYPE IN AN ALERT VIEW -->
<div class="alert alert-info" role="alert">
    <?php echo translate("lesson_type"); ?> :
    <strong>
        <?php
       if ($lesson_details['lesson_type'] == 'video' && strtolower($lesson_details['video_type']) == 'youtube') {
            echo 'YouTube '.translate("video");
        }
		elseif ($lesson_details['lesson_type'] == 'video' && strtolower($lesson_details['video_type']) == 'vimeo') {
            echo 'Vimeo '.translate("video");
        }
		elseif($lesson_details['lesson_type'] == 'other' && strtolower($lesson_details['attachment_type']) == 'doc' || strtolower($lesson_details['attachment_type']) == 'pdf' || strtolower($lesson_details['attachment_type']) == 'txt'){
            echo translate('document');
        }
		elseif($lesson_details['lesson_type'] == 'other' && strtolower($lesson_details['attachment_type']) == 'img'){
            echo translate('image');
        }elseif($lesson_details['lesson_type'] == 'other' && strtolower($lesson_details['attachment_type']) == 'iframe'){
            echo translate('iframe');
        }
        ?>
    </strong>
</div>

<!-- ACTUAL LESSON ADDING FORM -->
<form action="<?php echo site_url('user/lessons/'.$param3.'/edit'.'/'.$param2); ?>" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label><?php echo translate('title'); ?></label>
        <input type="text" name = "title" class="form-control" required value="<?php echo $lesson_details['title']; ?>">
    </div>

    <input type="hidden" name="course_id" value="<?php echo $param3; ?>">

    <div class="form-group">
        <label for="section_id"><?php echo translate('section'); ?></label>
        <select class="form-control select2" data-toggle="select2" name="section_id" id="section_id" required>
            <?php foreach ($sections as $section): ?>
                <option value="<?php echo $section['id']; ?>" <?php if($lesson_details['section_id'] == $section['id']) echo 'selected'; ?>><?php echo $section['title']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php if ($lesson_details['lesson_type'] == 'video' && strtolower($lesson_details['video_type']) == 'youtube'): include('youtube_type_lesson_edit.php'); endif; ?>
    <?php if ($lesson_details['lesson_type'] == 'video' && strtolower($lesson_details['video_type']) == 'vimeo'): include('vimeo_type_lesson_edit.php'); endif; ?>
    <?php if ($lesson_details['lesson_type'] == 'other' && strtolower($lesson_details['attachment_type']) == 'doc' || strtolower($lesson_details['attachment_type']) == 'pdf' || strtolower($lesson_details['attachment_type']) == 'txt'): include('document_type_lesson_edit.php'); endif; ?>
    <?php if ($lesson_details['lesson_type'] == 'other' && strtolower($lesson_details['attachment_type']) == 'img'): include('image_type_lesson_edit.php'); endif; ?>
    <?php if ($lesson_details['lesson_type'] == 'other' && strtolower($lesson_details['attachment_type']) == 'iframe'): include('iframe_type_lesson_edit.php'); endif; ?>

    <div class="form-group">
        <label><?php echo translate('summary'); ?></label>
        <textarea name="summary" class="form-control"><?php echo $lesson_details['summary']; ?></textarea>
    </div>
	
		<div class="form-group">
			<button type="submit" name="button" class="btn btn-block btn-info btn-rounded btn-sm "><i class="fa fa-plus"></i>&nbsp;<?php echo translate('save');?></button>
		</div>

</form>

<script type="text/javascript">
$(document).ready(function() {
    initSelect2(['#section_id','#lesson_type', '#lesson_provider', '#lesson_provider_for_mobile_application']);
    initTimepicker();

    // HIDING THE SEARCHBOX FROM SELECT2
    $('select').select2({
        minimumResultsForSearch: -1
    });
});

function ajax_get_video_details(video_url) {
    $('#perloader').show();
    if(checkURLValidity(video_url)){
        $.ajax({
            url: '<?php echo site_url('user/ajax_get_video_details');?>',
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
