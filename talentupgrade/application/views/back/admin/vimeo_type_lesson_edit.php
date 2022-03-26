<input type="hidden" name="lesson_type" value="video-url">
<input type="hidden" name="lesson_provider" value="vimeo">

<div class="form-group">
    <label><?php echo translate('video_url'); ?></label>
    <input type="text" value="<?php echo $lesson_details['video_url'];?>" id = "video_url" name = "video_url" class="form-control" onblur="ajax_get_video_details(this.value)" placeholder="<?php echo translate('this_video_will_be_shown_on_web_application'); ?>">
    <label class="form-label" id = "perloader" style ="margin-top: 4px; display: none;"><i class="mdi mdi-spin mdi-loading">&nbsp;</i><?php echo translate('analyzing_the_url'); ?></label>
    <label class="form-label" id = "invalid_url" style ="margin-top: 4px; color: red; display: none;"><?php echo translate('invalid_url').'. '.translate('your_video_source_has_to_be_either_youtube_or_vimeo'); ?></label>
</div>

<div class="form-group">
    <label><?php echo translate('duration'); ?></label>
    <input type="text" value="<?php echo $lesson_details['duration'];?>" name = "duration" id = "duration" class="form-control">
</div>


