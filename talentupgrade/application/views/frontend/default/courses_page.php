	<?php
			isset($layout) ? "": $layout = "list";
			isset($selected_category_id) ? "": $selected_category_id = "all";
			isset($selected_level) ? "": $selected_level = "all";
			isset($selected_language) ? "": $selected_language = "all";
			isset($selected_rating) ? "": $selected_rating = "all";
			isset($selected_price) ? "": $selected_price = "all";
			// echo $selected_category_id.'-'.$selected_level.'-'.$selected_language.'-'.$selected_rating.'-'.$selected_price;
			$number_of_visible_categories = 10;
			if (isset($sub_category_id)) {
				$sub_category_details = $this->crud_model->get_category_details_by_id($sub_category_id)->row_array();
				$category_details     = $this->crud_model->get_categories($sub_category_details['parent'])->row_array();
				$category_name        = $category_details['name'];
				$sub_category_name    = $sub_category_details['name'];
			}
	?>

<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?php echo translate('courses'); ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?php
                                if ($selected_category_id == "all") {
                                    echo translate('all_category');
                                }else {
                                    $category_details = $this->crud_model->get_category_details_by_id($selected_category_id)->row_array();
                                    echo $category_details['name'];
                                }
                             ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>


<section class="category-course-list-area">
    <div class="container">
        <div class="category-filter-box filter-box clearfix">
            <span><?php echo translate('showing_on_this_page'); ?> : <?php echo count($courses); ?></span>
            <a href="javascript::" onclick="toggleLayout('grid')" style="float: right; font-size: 19px; margin-left: 5px;"><i class="fas fa-th"></i></a>
            <a href="javascript::" onclick="toggleLayout('list')" style="float: right; font-size: 19px;"><i class="fas fa-th-list"></i></a>
            <a href="<?php echo site_url('home/courses'); ?>" style="float: right; font-size: 19px; margin-right: 5px;"><i class="fas fa-sync-alt"></i></a>
        </div>
        <div class="row">
            <div class="col-lg-3 filter-area">
                <div class="card">
                    <a href="javascript::"  style="color: unset;">
                        <div class="card-header filter-card-header" id="headingOne" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                            <h6 class="mb-0">
                                <?php echo translate('filter'); ?>
                                <i class="fas fa-sliders-h" style="float: right;"></i>
                            </h6>
                        </div>
                    </a>
                    <div id="collapseFilter" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body pt-0">
                            <div class="filter_type">
                                <h6><?php echo translate('categories'); ?></h6>
                                <ul>
                                    <li class="ml-2">
                                        <div class="">
                                            <input type="radio" id="category_all" name="sub_category" class="categories custom-radio" value="all" onclick="filter(this)" <?php if($selected_category_id == 'all') echo 'checked'; ?>>
                                            <label for="category_all"><?php echo translate('all_category'); ?></label>
                                        </div>
                                    </li>
                                    <?php
                                    $counter = 1;
                                    $total_number_of_categories = $this->db->get('category')->num_rows();
                                    $categories = $this->crud_model->get_categories()->result_array();
                                    foreach ($categories as $category): ?>
                                        <li class="">
                                            <div class="<?php if ($counter > $number_of_visible_categories): ?> hidden-categories hidden <?php endif; ?>">
                                                <input type="radio" id="category-<?php echo $category['id'];?>" name="sub_category" class="categories custom-radio" value="<?php echo $category['slug']; ?>" onclick="filter(this)" <?php if($selected_category_id == $category['id']) echo 'checked'; ?>>
                                                <label for="category-<?php echo $category['id'];?>"><?php echo $category['name']; ?></label>
                                            </div>
                                        </li>
                                        <?php foreach ($this->crud_model->get_sub_categories($category['id']) as $sub_category):
                                            $counter++; ?>
                                            <li class="ml-2">
                                                <div class="<?php if ($counter > $number_of_visible_categories): ?> hidden-categories hidden <?php endif; ?>">
                                                    <input type="radio" id="sub_category-<?php echo $sub_category['id'];?>" name="sub_category" class="categories custom-radio" value="<?php echo $sub_category['slug']; ?>" onclick="filter(this)" <?php if($selected_category_id == $sub_category['id']) echo 'checked'; ?>>
                                                    <label for="sub_category-<?php echo $sub_category['id'];?>"><?php echo $sub_category['name']; ?></label>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </ul>
                                <a href="javascript::" id = "city-toggle-btn" onclick="showToggle(this, 'hidden-categories')" style="font-size: 12px;"><?php echo $total_number_of_categories > $number_of_visible_categories ? translate('show_more') : ""; ?></a>
                            </div>
                            <hr>
                            <div class="filter_type">
                                <div class="form-group">
                                    <h6><?php echo translate('price'); ?></h6>
                                    <ul>
                                        <li>
                                            <div class="">
                                                <input type="radio" id="price_all" name="price" class="prices custom-radio" value="all" onclick="filter(this)" <?php if($selected_price == 'all') echo 'checked'; ?>>
                                                <label for="price_all"><?php echo translate('all'); ?></label>
                                            </div>
                                            <div class="">
                                                <input type="radio" id="price_free" name="price" class="prices custom-radio" value="free" onclick="filter(this)" <?php if($selected_price == 'free') echo 'checked'; ?>>
                                                <label for="price_free"><?php echo translate('free'); ?></label>
                                            </div>
                                            <div class="">
                                                <input type="radio" id="price_paid" name="price" class="prices custom-radio" value="paid" onclick="filter(this)" <?php if($selected_price == 'paid') echo 'checked'; ?>>
                                                <label for="price_paid"><?php echo translate('paid'); ?></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <div class="filter_type">
                                <h6><?php echo translate('level'); ?></h6>
                                <ul>
                                    <li>
                                        <div class="">
                                            <input type="radio" id="all" name="level" class="level custom-radio" value="all" onclick="filter(this)" <?php if($selected_level == 'all') echo 'checked'; ?>>
                                            <label for="all"><?php echo translate('all'); ?></label>
                                        </div>
                                        <div class="">
                                            <input type="radio" id="beginner" name="level" class="level custom-radio" value="beginner" onclick="filter(this)" <?php if($selected_level == 'beginner') echo 'checked'; ?>>
                                            <label for="beginner"><?php echo translate('beginner'); ?></label>
                                        </div>
                                        <div class="">
                                            <input type="radio" id="advanced" name="level" class="level custom-radio" value="advanced" onclick="filter(this)" <?php if($selected_level == 'advanced') echo 'checked'; ?>>
                                            <label for="advanced"><?php echo translate('advanced'); ?></label>
                                        </div>
                                        <div class="">
                                            <input type="radio" id="intermediate" name="level" class="level custom-radio" value="intermediate" onclick="filter(this)" <?php if($selected_level == 'intermediate') echo 'checked'; ?>>
                                            <label for="intermediate"><?php echo translate('intermediate'); ?></label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <div class="filter_type">
                                <h6><?php echo translate('language'); ?></h6>
                                <ul>
                                    <li>
                                        <div class="">
                                            <input type="radio" id="all_language" name="language" class="languages custom-radio" value="<?php echo 'all'; ?>" onclick="filter(this)" <?php if($selected_language == "all") echo 'checked'; ?>>
                                            <label for="<?php echo 'all_language'; ?>"><?php echo translate('all'); ?></label>
                                        </div>
                                    </li>
                                    
									
									
										<?php
										
											if($set_language = $this->session->userdata('language')){
											} else{
												$set_language = $this->db->get_where('settings', array('type' => 'language'))->row()->description;
											}
											$fields = $this->db->list_fields('language');
											foreach ($fields as $key => $field) {
											if ($field == 'phrase_id' || $field == 'phrase')
											continue;
								
										?>
                                        <li>
                                            <div class="">
                                                <input type="radio" id="language_<?=$field; ?>" name="language" class="languages custom-radio" value="<?=$field; ?>" onclick="filter(this)" <?php if ($selected_language == $field) echo 'selected'; ?>>
                                                <label for="language_<?=$field; ?>"><?=ucwords($field); ?></label>
                                            </div>
                                        </li>
                                   <?php }?>
									
									
                                </ul>
                            </div>
                            <hr>
                            <div class="filter_type">
                                <h6><?php echo translate('ratings'); ?></h6>
                                <ul>
                                    <li>
                                        <div class="">
                                            <input type="radio" id="all_rating" name="rating" class="ratings custom-radio" value="<?php echo 'all'; ?>" onclick="filter(this)" <?php if($selected_rating == "all") echo 'checked'; ?>>
                                            <label for="all_rating"><?php echo translate('all'); ?></label>
                                        </div>
                                    </li>
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <li>
                                            <div class="">
                                                <input type="radio" id="rating_<?php echo $i; ?>" name="rating" class="ratings custom-radio" value="<?php echo $i; ?>" onclick="filter(this)" <?php if($selected_rating == $i) echo 'checked'; ?>>
                                                <label for="rating_<?php echo $i; ?>">
                                                    <?php for($j = 1; $j <= $i; $j++): ?>
                                                        <i class="fas fa-star" style="color: #f4c150;"></i>
                                                    <?php endfor; ?>
                                                    <?php for($j = $i; $j < 5; $j++): ?>
                                                        <i class="far fa-star" style="color: #dedfe0;"></i>
                                                    <?php endfor; ?>
                                                </label>
                                            </div>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="category-course-list">
                    <?php include 'category_wise_course_'.$layout.'_layout.php'; ?>
                    <?php if (count($courses) == 0): ?>
                        <?php echo translate('no_result_found'); ?>
                    <?php endif; ?>
                </div>
                <nav>
                    <?php if ($selected_category_id == "all" && $selected_price == 0 && $selected_level == 'all' && $selected_language == 'all' && $selected_rating == 'all'){
                        echo $this->pagination->create_links();
                    }?>
                </nav>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

function get_url() {
    var urlPrefix 	= '<?php echo site_url('home/courses?'); ?>'
    var urlSuffix = "";
    var slectedCategory = "";
    var selectedPrice = "";
    var selectedLevel = "";
    var selectedLanguage = "";
    var selectedRating = "";

    // Get selected category
    $('.categories:checked').each(function() {
        slectedCategory = $(this).attr('value');
    });

    // Get selected price
    $('.prices:checked').each(function() {
        selectedPrice = $(this).attr('value');
    });

    // Get selected difficulty Level
    $('.level:checked').each(function() {
        selectedLevel = $(this).attr('value');
    });

    // Get selected difficulty Level
    $('.languages:checked').each(function() {
        selectedLanguage = $(this).attr('value');
    });

    // Get selected rating
    $('.ratings:checked').each(function() {
        selectedRating = $(this).attr('value');
    });

    urlSuffix = "category="+slectedCategory+"&&price="+selectedPrice+"&&level="+selectedLevel+"&&language="+selectedLanguage+"&&rating="+selectedRating;
    var url = urlPrefix+urlSuffix;
    return url;
}
function filter() {
    var url = get_url();
    window.location.replace(url);
    //console.log(url);
}

function toggleLayout(layout) {
    $.ajax({
        type : 'POST',
        url : '<?php echo site_url('home/set_layout_to_session'); ?>',
        data : {layout : layout},
        success : function(response){
            location.reload();
        }
    });
}

function showToggle(elem, selector) {
    $('.'+selector).slideToggle(20);
    if($(elem).text() === "<?php echo translate('show_more'); ?>")
    {
        $(elem).text('<?php echo translate('show_less'); ?>');
    }
    else
    {
        $(elem).text('<?php echo translate('show_more'); ?>');
    }
}
</script>
