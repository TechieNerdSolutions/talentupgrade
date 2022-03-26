
		<h5><?php echo translate('select_lesson_type') ?></h5>
        <hr>
        <?php

        $selected_lesson = "youtube";
        if(isset($param2) && !empty($param2)){
            $selected_lesson = $param2;
        }

        ?>


<div class="radio radio-custom">
  <input type="radio" <?php if($selected_lesson == 'youtube') echo 'checked' ;?> name="lesson_type" id="youtube" value="youtube">
  <label for="radio2"> YouTube <?php echo translate('video'); ?> </label>
</div>

<div class="radio radio-custom">
  <input type="radio" <?php if($selected_lesson == 'vimeo') echo 'checked' ;?>  name="lesson_type" id="video" value="vimeo">
  <label for="radio2"> Vimeo <?php echo translate('video'); ?> </label>
</div>

<div class="radio radio-custom">
  <input type="radio" <?php if($selected_lesson == 'document') echo 'checked' ;?>  name="lesson_type" id="document" value="document">
  <label for="radio2"> <?php echo translate('document'); ?></label>
</div>


<div class="radio radio-custom">
  <input type="radio" <?php if($selected_lesson == 'image') echo 'checked' ;?> name="lesson_type" id="image" value="image">
  <label for="radio2"><?php echo translate('image_file'); ?></label>
</div>

<div class="radio radio-custom">
  <input type="radio" <?php if($selected_lesson == 'iframe') echo 'checked' ;?>  name="lesson_type" id="iframe" value="iframe">
  <label for="radio2"><?php echo translate('iframe_embed'); ?></label>
</div>

<div class="mt-3">
    <a href="javascript::void(0)"
    type="button"
    class="btn btn-info btn-rounded btn-sm btn-block"
    data-toggle="modal"
    data-dismiss="modal"
    id = "lesson-add-modal"
    onclick="showLessonAddModal()"><?php echo translate('next'); ?></a>
</div>


<script type="text/javascript">

        function showLessonAddModal() {
            var url = "<?php echo site_url('modal/popup/lesson_add/' . $param2);?>/"+$("input[name=lesson_type]:checked").val();
            showAjaxModal(url, '<?php echo translate('add_new_lesson')?>');

        }

</script>



