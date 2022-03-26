<div class="form-group">
    <label for="document_type"><?php echo translate('document_type'); ?></label>
    <select class="form-control select2" data-toggle="select2" name="lesson_type" id="lesson_type" required>
        <option value=""><?php echo translate('select_type_of_document'); ?></option>
        <option value="other-txt"><?php echo translate('text_file'); ?></option>
        <option value="other-pdf" selected><?php echo translate('pdf_file'); ?></option>
        <option value="other-doc"><?php echo translate('document_file'); ?></option>
    </select>
</div>

<div class="form-group">
    <label> <?php echo translate('attachment'); ?></label>
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="form-control" style="width:100%" id="attachment" name="attachment" onchange="changeTitleOfImageUploader(this)">
        </div>
    </div>
</div>
