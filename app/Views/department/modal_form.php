<?php echo view("includes/cropbox"); ?>
<?php echo form_open(get_uri("departments/save"), array("id" => "department-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="department-form-explain">
                        Departments are where your team communicates. They are best when organized arround a topic -# sales, for example.
                    </label>
                </div>
            </div>
        </div>
        <hr/>
        <div class="form-group">
            <div class="row">
                <label for="department_icon" class="department-form-label"><?php echo app_lang('department_icon'); ?></label>
                <div>
                    <div class="mt10 float-start">
                        <?php 
                            $icon_path = '';
                            if($model_info->icon == '') {
                                $icon_path = base_url() . '/assets/images/avatar.jpg';
                            }
                            else {
                                $icon_path = base_url() . '/files/department_icon/' . $model_info->icon;
                            }
                        ?>


                        <div class="department_icon_wrapper">
                            <img id="profile-image-preview" class="department_icon" src="<?php echo $icon_path; ?>" alt="..."></span>
                            <span class="department_icon_content">
                                <i data-feather='camera' class="icon-14"></i>
                            </span>
                        </div>
                        
                        <input type="hidden" id="profile_image" name="profile_image" value=""  />
                        
                        <?php
                            echo form_upload(array(
                                "id" => "department_icon",
                                "name" => "department_icon",
                                "class" => "no-outline hidden-input-file",
                                "data-height" => "200", 
                                "data-width" => "200", 
                                "data-preview-container" => "#profile-image-preview",
                                "data-input-field" => "#profile_image"
                            ));
                        ?>
                    </div>
                </div>
            </div>
        </div>  
        <div class="form-group">
            <div class="row">
                <label for="name" class="department-form-label"><?php echo app_lang('name'); ?></label>
                <div>
                    <?php
                    echo form_input(array(
                        "id" => "name",
                        "name" => "name",
                        "value" => $model_info->name,
                        "class" => "form-control",
                        "placeholder" => app_lang('name'),
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div> 
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="description" class="department-form-label"><?php echo app_lang('description'); ?></label>
                <div>
                    <?php
                    echo form_textarea(array(
                        "id" => "description",
                        "name" => "description",
                        "value" => $model_info->description,
                        "class" => "form-control",
                        "placeholder" => app_lang('description'),
                        "style" => "height:150px;",
                        "data-rich-text-editor" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
                <label class="department-form-explain mt20">What is this department about?</label>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="department-form-label"><?php echo app_lang('add_people'); ?></label>
                <div>
                    <!-- <div class="member_wrapper">
                        <div class="row">
                            <div class="col-md-10">
                                <?php
                                    // echo form_input(array(
                                    //     "id" => "member_1",
                                    //     "name" => "members[]",
                                    //     "value" => '',
                                    //     "class" => "form-control",
                                    //     "placeholder" => app_lang('enter_email_or_username'),
                                    //     "data-rule-required" => true,
                                    //     "data-msg-required" => app_lang("field_required"),
                                    // ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt20 ml10" style="font-size: 12px; color: #f16f23; font-weight: 500; cursor: pointer;" id="add_people">
                        <span>
                            <i data-feather='plus-circle' class="icon-14"></i> <?php // echo app_lang("upload"); ?>
                        </span>
                    </div> -->
                    <label class="department-form-explain"># worksson office</label>
                    <?php
                         echo form_input(array(
                            "id" => "members_id",
                            "name" => "members_id",
                            "value" => $model_info->members_id,
                            "class" => "form-control",
                            "placeholder" => app_lang('members')
                        ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="department-form-label"><?php echo app_lang('private'); ?></label>
                <div class="d-flex align-items-center justify-content-between">
                    <p class="department-form-explain" style="width: 50%;">
                        When a department is set to private, it can only be viewed or joined by invitation
                    </p>
                    <label class="switch">
                        <?php
                            echo form_checkbox(
                                "private", "1", $model_info->private, "id='private' class='custom-control-input'"
                            );
                        ?>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>

        <?php if ($model_info->id) { ?>
            <div class="form-group">
                <div class="row">
                    <label for="status" class="department-form-label"><?php echo app_lang('status'); ?></label>
                    <div>
                        <?php
                        echo form_dropdown("status", array("open" => app_lang("open"), "canceled" => app_lang("canceled")), array($model_info->status), "class='select2'");
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <span>
                        <i data-feather='help-circle' class="icon-14"></i> <?php // echo app_lang("upload"); ?>
                        <span class="department-form-info">Learn More</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#department-form").appForm({
            onSuccess: function (result) {
                $("#department-table").appTable({newData: result.data, dataId: result.id});
                location.reload();
            }
        });
        setTimeout(function () {
            $("#name").focus();
        }, 200);

        $("#department-form .select2").select2();

        // setDatePicker("#start_date");
        $("#members_id").select2({
            multiple: true, 
            data: <?php echo json_encode($all_persons); ?>
        });

        $(".department_icon").on('click', function(e) {
            $("#department_icon").click();
        });

        $("#department_icon").on('change', function() {
            if (typeof FileReader == 'function') {
                showCropBox(this);
            } 
        })
    });
</script>    