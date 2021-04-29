<div id="page-content" class="clearfix">
    <div class="bg-dark-success clearfix">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="p20 row">
                        <div class="box" id="profile-image-section">
                            <div class="box-content w200 text-center profile-image">
                                <?php
                                    if ($department_info->icon != '') {
                                        $image_url = base_url() . '/files/department_icon/'.$department_info->icon;
                                ?>
                                    <span class="avatar avatar-lg">
                                        <img id="profile-image-preview" src="<?php echo $image_url; ?>" alt="...">
                                    </span>
                                <?php } else { 
                                    $image_url = base_url() . '/assets/images/avatar.jpg';    
                                ?>
                                    <span class="avatar avatar-lg">
                                        <img id="profile-image-preview" src="<?php echo $image_url; ?>" alt="...">
                                    </span>
                                <?php } ?>
                                <h4 class="">
                                    <?php echo get_department_id($department_info->id) . " - " . $department_info->name ?>
                                </h4>
                            </div> 

                            <div class="box-content pl15">
                                <?php if ($department_info->status === "canceled") { ?>
                                    <p class="p10 m0"><label class="badge bg-danger large"><strong> <?php echo app_lang('canceled'); ?> </strong></label></p>
                                <?php } else { ?>
                                    <p class="p10 m0"><label class="badge bg-info large"><strong> <?php echo app_lang('open'); ?> </strong></label></p>
                                <?php } ?> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p20 row">
                        <?php if($members_string !== '') { ?>
                        <p> 
                            <?php 
                                echo $members_string;
                            ?>
                        </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="w-100 mt20 pl10">
            <?php echo nl2br(link_it($department_info->description)); ?>
        </div>
    </div>
</div>