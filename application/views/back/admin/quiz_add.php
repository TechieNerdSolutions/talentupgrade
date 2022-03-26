<?php $sections = $this->crud_model->get_section('course', $param2)->result_array();?>

<form action="<?php echo site_url('admin/quizes/'.$param2.'/add'); ?>" method="post" enctype="multipart/form-data">
   
    <div class="form-group">
        <label><?php echo translate('title'); ?></label>
        <input type="text" name = "title" id="title" class="form-control" required>
    </div>

    <div class="form-group">
        <label><?php echo translate('section'); ?></label>
        <select class="form-control select2" data-toggle="select2" name="section_id" id="section_id" required>
            <?php foreach ($sections as $section): ?>
                <option value="<?php echo $section['id']; ?>"><?php echo $section['title']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    
    <div class="form-group">
        <label><?php echo translate('summary'); ?></label>
        <textarea name="summary" class="form-control"></textarea>
    </div>

    <div class="text-center">
        <button class = "btn btn-success btn-rounded btn-sm btn-block" type="submit" name="button"><?php echo translate('add'); ?></button>
    </div>
</form>




