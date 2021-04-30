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

                                <div class="p10"><?php echo nl2br(link_it($department_info->description)); ?></div>
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
    <ul id="client-contact-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs b-b rounded-0" role="tablist">
        <li><a  role="presentation" href="<?php echo_uri("departments/work_feed_tab/" . $department_info->id); ?>" data-bs-target="#tab-workfeed"> <?php echo app_lang('work_feed'); ?></a></li>
        <li><a  role="presentation" href="<?php echo_uri("departments/people_tab/" . $department_info->id); ?>" data-bs-target="#tab-people"> <?php echo app_lang('people'); ?></a></li>
        <li><a  role="presentation" href="<?php echo_uri("departments/todo_tab/" . $department_info->id); ?>" data-bs-target="#tab-todo"> <?php echo app_lang('todo'); ?></a></li>
        <li><a  role="presentation" href="<?php echo_uri("departments/project_tab/" . $department_info->id); ?>" data-bs-target="#tab-project"> <?php echo app_lang('project'); ?></a></li>
        <li><a  role="presentation" href="<?php echo_uri("departments/job_tab/" . $department_info->id); ?>" data-bs-target="#tab-job"> <?php echo app_lang('job'); ?></a></li>
        <li><a  role="presentation" href="<?php echo_uri("departments/event_tab/" . $department_info->id); ?>" data-bs-target="#tab-event"> <?php echo app_lang('event'); ?></a></li>
        <li><a  role="presentation" href="<?php echo_uri("departments/more_tab/" . $department_info->id); ?>" data-bs-target="#tab-more"> <?php echo app_lang('more'); ?></a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade" id="tab-workfeed"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-people"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-todo"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-project"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-job"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-event"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-more"></div>
    </div>
</div>