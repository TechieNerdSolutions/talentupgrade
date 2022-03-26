<!-- .row -->

<div class="row">
                    <div class="col-sm-12">
				  	<div class="panel panel-info">
					<div class="panel-body table-responsive">
                           <a href="<?php echo base_url();?>user/courses" 
                     			class="btn btn-default btn-xs pull-right"><i class="fa fa-mail-reply-all"></i>&nbsp;<?=translate('list_course')?>
                    		</a>
							<hr class="sep-2">
							
							
							
							
<section>
                                <div class="sttabs tabs-style-bar">
                                    <nav>
                                        <ul>
                                            <li><a href="#section-bar-1" class="sticon ti-angle-double-right"><span><?=translate('course_intro')?></span></a></li>
                                            <li><a href="#section-bar-2" class="sticon ti-angle-double-right"><span><?=translate('basic_needs')?></span></a></li>
                                            <li><a href="#section-bar-3" class="sticon ti-angle-double-right"><span><?=translate('pricing')?></span></a></li>
                                            <li><a href="#section-bar-4" class="sticon ti-angle-double-right"><span><?=translate('media')?></span></a></li>
                                            <li><a href="#section-bar-5" class="sticon ti-angle-double-right"><span><?=translate('seo')?></span></a></li>
                                        </ul>
                                    </nav>
									<form class="required-form" action="<?php echo site_url('user/courses/add'); ?>" method="post" enctype="multipart/form-data">
                                    <div class="content-wrap">
                                        <section id="section-bar-1">
                                            <h3>Fill neccessary information for this course : </h3>
                                         
												<div class="form-group">
													<label class="col-md-12" for="example-text"><?=translate('title');?> <b>*</b></label>
													<div class="col-sm-12">
														<input type="text" class="form-control" id="course_title" name="title" value="" /required/>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12" for="example-text"><?=translate('description');?> <b>*</b></label>
													<div class="col-sm-12">
														<textarea name="short_description" id= "short_description" rows="3" class="form-control"></textarea>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12" for="example-text"><?=translate('description');?> <b>*</b></label>
													<div class="col-sm-12">
														<textarea name="description" id= "mymce" class="form-control">Full Description</textarea>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12" for="example-text"><?=translate('category');?> <b>*</b></label>
													<div class="col-sm-12">
														<select class="form-control select2" data-toggle="select2" name="sub_category_id" id="sub_category_id" required>
                                                            <option value=""><?php echo translate('select_a_category'); ?></option>
                                                            <?php foreach ($categories->result_array() as $category): ?>
                                                                <optgroup label="<?php echo $category['name']; ?>">
                                                                    <?php $sub_categories = $this->crud_model->get_sub_categories($category['id']);
                                                                    foreach ($sub_categories as $sub_category): ?>
                                                                    <option value="<?php echo $sub_category['id']; ?>"><?php echo $sub_category['name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </optgroup>
                                                        <?php endforeach; ?>
                                                    </select>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12" for="example-text"><?=translate('level');?> <b>*</b></label>
													<div class="col-sm-12">
                                                    <select class="form-control select2" data-toggle="select2" name="level" id="level">
                                                        <option value="beginner"><?php echo translate('beginner'); ?></option>
                                                        <option value="advanced"><?php echo translate('advanced'); ?></option>
                                                        <option value="intermediate"><?php echo translate('intermediate'); ?></option>
                                                    </select>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12" for="example-text"><?=translate('course_language');?> <b>*</b></label>
													<div class="col-sm-12">
														<select class="form-control" id="language_made_in" name="language_made_in" /required>
															<?php
																$fields = $this->db->list_fields('language');
																foreach ($fields as $key => $field) {
																if ($field == 'phrase_id' || $field == 'phrase')
																continue;
													
															?>
															<option value="<?php echo $field; ?>">
															<?php echo ucwords($field); ?></option>
															<?php }?>
														</select>
													</div>
												</div>
												
												
												<div class="form-group">
													<div class="col-sm-12">
														<input type="checkbox" class="js-switch" value="1" name="is_top_course"> <i></i> 
														<?=translate('check_if_this_course_is_top_course')?>
													</div>
												</div>
												
												
												
                                        </section>
                                        <section id="section-bar-2">
                                           <h3>The descriptions you write here will help students decide if your course is the one for them. :  </h3>
										   <p>What will students learn in your course?</p>
										   
										   
												<span id="designation">
													<br>
													<div class="row form-group">
													  <label class="col-sm-12" for="example-text"><?=translate('course_requirements');?> <b>*</b></label>
								
														<div class="col-sm-11">
															<input type="text" class="form-control" name="requirements[]" id="requirements" placeholder= "requirements here">
														</div>
														
														<div class="col-sm-1">
																	<button type="button" class="btn btn-success btn-circle btn-xs" onClick="add_designation()">
																	   <i class="fa fa-plus"></i>
																	</button>
														</div>
														
														
													</div>
												</span>
                								
												<span id="designation_input">
													<div class="row form-group">
															<div class="col-sm-11">
																<input type="text" class="form-control" name="requirements[]" id="requirements" placeholder= "requirements here">
															</div>
													   
														<div class="col-sm-1">
															<button type="button" class="btn btn-danger btn-circle btn-xs" onclick="deleteParentElement(this)">
																<i class="fa fa-minus"></i>
															</button>
														</div>
													</div>
												</span>
                								
										<hr class="sep-2">
										 <p>What will students learn in your course?</p>
										 
										 
										 
											<span id="designationII">
													<br>
													<div class="row form-group">
													  <label class="col-sm-12" for="example-text"><?=translate('course_objectives');?> <b>*</b></label>
								
														<div class="col-sm-11">
															<input type="text" class="form-control" name="outcomes[]" id="outcomes" placeholder= "course expected outsomes here">
														</div>
														
														<div class="col-sm-1">
																	<button type="button" class="btn btn-success btn-circle btn-xs" onClick="add_designationII()">
																	   <i class="fa fa-plus"></i>
																	</button>
														</div>
														
														
													</div>
												</span>
                								
												<span id="designation_inputII">
													<div class="row form-group">
															<div class="col-sm-11">
															   <input type="text" class="form-control" name="outcomes[]" id="outcomes" placeholder= "course expected outsomes here">
															</div>
													   
														<div class="col-sm-1">
															<button type="button" class="btn btn-danger btn-circle btn-xs" onclick="deleteParentElementII(this)">
																<i class="fa fa-minus"></i>
															</button>
														</div>
													</div>
												</span>
										   
										   
										</section>
										
										
										
                                        <section id="section-bar-3">
                                            <h2>Please enter the price student will see before purchasing the course.</h2>
											
												<div class="form-group">
													<div class="col-sm-12">
														<input type="checkbox" id="is_free_course" value="1" name="is_free_course"> <i></i> <?=translate('is_this_a_free_course')?>?
													</div>
												</div>
													
													<div id="initial">
													
														<div class="form-group">
															<label class="col-md-12" for="example-text"><?=translate('course_price');?></label>
															<div class="col-sm-12">
																<input type="number" class="form-control" id="price" name = "price" 
																placeholder="<?php echo translate('enter_course_course_price'); ?>" min="0">
															</div>
														</div>
														
														<div class="form-group">
															<div class="col-sm-12">
																<input type="checkbox"  name="discount_flag" id="discount_flag" value="1">
																<?=translate('check_if_this_course_has_discount');?>
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-md-12" for="example-text">
															<?php echo translate('discounted_price').' ('.currency_code_and_symbol().')'; ?></label>
															<div class="col-sm-12">
																<input type="number" class="form-control" name="discounted_price" 
																id="discounted_price" onkeyup="calculateDiscountPercentage(this.value)" min="0">
 																	<small class="text-muted"><?php echo translate('this_course_has'); ?> 
																		<span id = "discounted_percentage" class="text-danger">0%</span> <?php echo translate('discount'); ?>
																	</small>
															</div>
														</div>
													</div>
												
													<div id="send_sms"></div>
												
											
											
										</section>
										
										
                                        <section id="section-bar-4">
                                            <h2>Ensure you put course preview and select type of preview for the course</h2>
											
														<div class="form-group">
															<label class="col-md-12" for="example-text"><?=translate('course_overview_provider');?> <b>*</b></label>
															<div class="col-sm-12">
																<select class="form-control select2" data-toggle="select2" 
																	name="course_overview_provider" id="course_overview_provider" /required>											
																	<option value="html5"><?php echo translate('HTML5'); ?></option>
																	<option value="vimeo"><?php echo translate('vimeo'); ?></option>
																	<option value="youtube"><?php echo translate('youtube'); ?></option>
																	
																</select>
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-md-12" for="example-text"><?=translate('course_overview_url');?> <b>*</b></label>
															<div class="col-sm-12">
																<input type="text" class="form-control" name="course_overview_url" 
																id="course_overview_url" placeholder="E.g: https://www.youtube.com/watch?v=CPfCjdPXs8I" /required>
															</div>
														</div>
														
														

														<div class="form-group">
															<label class="col-md-12" for="example-text"><?=translate('course_image');?> <b>*</b></label>
															<div class="col-sm-12">
																<input id="course_thumbnail" type="file" 
																class="image-upload" onChange="readURL(this);" name="course_thumbnail" accept="image/*">
																<img id="blah"  src="<?php echo base_url();?>uploads/course_thumbnail_placeholder.png" alt="your image" height="150" width="150"/ style="border:1px dotted red">
															</div>
														</div>
											
											
										</section>
										
										
                                        <section id="section-bar-5">
                                            <h2>SEO</h2>
											
											
														<div class="form-group">
															<label class="col-md-12" for="example-text"><?=translate('meta_keywords');?></label>
															<div class="col-sm-12">
																<input type="text" class="form-control bootstrap-tag-input" id = "meta_keywords" name="meta_keywords" 
																data-role="tagsinput" placeholder="<?php echo translate('write_a_keyword_and_then_press_enter'); ?>" style="width:100%;" />
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-md-12" for="example-text"><?=translate('meta_description');?></label>
															<div class="col-sm-12">
																<textarea name="meta_description" class="form-control"></textarea>
															</div>
														</div>
											
								<hr class="sep-2">
							<button type="submit" class="btn btn-default btn-sm btn-rounded btn-block"> <i class="fa fa-plus"></i>&nbsp;<?php echo translate('save');?></button>
											
										</section>
                                    </div>
                                    <!-- /content -->
									
									<form>
                                </div>
                                <!-- /tabs -->
                            </section>
							

					

					
					
					
					

                
			</div>                
		</div>
	</div>
</div>


<script type="text/javascript">

    $('#designation_input').hide();
    
    // CREATING BLANK DESIGNATION INPUT
    var blank_designation = '';
    $(document).ready(function () {
        blank_designation = $('#designation_input').html();
    });

    function add_designation(){
        $("#designation").append(blank_designation);
    }

    // REMOVING DESIGNATION INPUT
    function deleteParentElement(n) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    }
	
	
	$('#designation_inputII').hide();
    
    // CREATING BLANK DESIGNATION INPUT
    var blank_designation = '';
    $(document).ready(function () {
        blank_designation = $('#designation_inputII').html();
    });
	
	
    function add_designationII(){
        $("#designationII").append(blank_designation);
    }
	
    function deleteParentElementII(n) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    }
	
	function priceChecked(elem){
	  if (jQuery('#discountCheckbox').is(':checked')) {
	
		jQuery('#discountCheckbox').prop( "checked", false );
	  }else {
	
		jQuery('#discountCheckbox').prop( "checked", true );
	  }
	}

	function topCourseChecked(elem){
	  if (jQuery('#isTopCourseCheckbox').is(':checked')) {
	
		jQuery('#isTopCourseCheckbox').prop( "checked", false );
	  }else {
	
		jQuery('#isTopCourseCheckbox').prop( "checked", true );
	  }
	}

	function isFreeCourseChecked(elem) {
	
	  if (jQuery('#'+elem.id).is(':checked')) {
		$('#price').prop('required',false);
	  }else {
		$('#price').prop('required',true);
	  }
	}

	function calculateDiscountPercentage(discounted_price) {
	  if (discounted_price > 0) {
		var actualPrice = jQuery('#price').val();
		if ( actualPrice > 0) {
		  var reducedPrice = actualPrice - discounted_price;
		  var discountedPercentage = (reducedPrice / actualPrice) * 100;
		  if (discountedPercentage > 0) {
			jQuery('#discounted_percentage').text(discountedPercentage.toFixed(2)+'%');
	
		  }else {
			jQuery('#discounted_percentage').text('<?php echo '0%'; ?>');
		  }
		}
	  }
	}
	
	
	
		$('#is_free_course').click(function(){

        if($('#is_free_course').is(':checked') == true){
            $("#send_sms").show(500);
            $("#initial").hide(500);
        }else{

            $("#send_sms").hide(500);
            $("#initial").show(500);
        }

    });

    $("#send_sms").hide();

</script>

<style media="screen">
body {
  overflow-x: hidden;
}
</style>


    