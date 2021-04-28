<?php echo form_open(get_uri("departments/save"), array("id" => "department-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <div class="form-group">
            <div class="row">
                <label for="department_icon" class="col-md-3"><?php echo app_lang('department_icon'); ?></label>
                <div class=" col-md-9">
                    <div class="mt10 float-start">
                        <label for="department_icon" class="btn btn-default btn-sm">
                            <i data-feather='upload' class="icon-14"></i> <?php echo app_lang("upload"); ?>
                        </label>
                        <?php
                        echo form_upload(array(
                            "id" => "department_icon",
                            "name" => "department_icon",
                            "class" => "no-outline hidden-input-file",
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>  
        <div class="form-group">
            <div class="row">
                <label for="name" class=" col-md-3"><?php echo app_lang('name'); ?></label>
                <div class=" col-md-9">
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
                <label for="description" class=" col-md-3"><?php echo app_lang('description'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "description",
                        "name" => "description",
                        "value" => $model_info->description,
                        "class" => "form-control",
                        "placeholder" => app_lang('description'),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-md-3"><?php echo app_lang('add_people'); ?></label>
                <div class="col-md-9">
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
                    <?php
                         echo form_input(array(
                            "id" => "members_id",
                            "name" => "members_id",
                            "value" => $model_info->members_id,
                            "class" => "form-control",
                            "placeholder" => app_lang('Members')
                        ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="private" class="col-md-3"><?php echo app_lang('private'); ?></label>
                <div class=" col-md-9">
                    <?php
                        echo form_checkbox(
                            "private", "1", $model_info->private, "id='private' class='form-check-input'"
                        );
                    ?>
                </div>
            </div>
        </div>
        <?php if ($model_info->id) { ?>
            <div class="form-group">
                <div class="row">
                    <label for="status" class=" col-md-3"><?php echo app_lang('status'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_dropdown("status", array("open" => app_lang("open"), "canceled" => app_lang("canceled")), array($model_info->status), "class='select2'");
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
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
    });
</script>    