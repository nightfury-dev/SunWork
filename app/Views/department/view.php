<div id="page-content" class="page-wrapper clearfix">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="page-title clearfix">
                    <h1><?php echo get_ticket_id($department_info->id) . " - " . $department_info->name ?></h1>
                    <div class="title-button-group p10">
                        <span class="dropdown inline-block">
                            <button class="btn btn-default dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                                <i data-feather='settings' class='icon-16'></i> <?php echo app_lang('actions'); ?>
                            </button>
                            <ul class="dropdown-menu float-end" role="menu">
                                <?php if ($department_info->status === "canceled") { ?>
                                    <li role="presentation"><?php echo ajax_anchor(get_uri("departments/save_department_status/$department_info->id/open"), "<i data-feather='check-circle' class='icon-16'></i> " . app_lang('mark_as_open'), array("class" => "dropdown-item", "title" => app_lang('mark_as_open'), "data-reload-on-success" => "1")); ?> </li>
                                <?php } else { ?>
                                    <li role="presentation"><?php echo ajax_anchor(get_uri("tickets/save_department_status/$department_info->id/closed"), "<i data-feather='check-circle' class='icon-16'></i> " . app_lang('mark_as_closed'), array("class" => "dropdown-item", "title" => app_lang('mark_as_closed'), "data-reload-on-success" => "1")); ?> </li>
                                <?php } ?>
                            </ul>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div id="department-title-section">
                        <?php echo view("department/department_sub_title"); ?>
                    </div>

                    <div id="comment-form-container" >
                        <div class="p15">
                            <div class="w-100">
                                <div id="ticket-comment-dropzone" class="post-dropzone form-group">
                                    <?php
                                    echo form_textarea(array(
                                        "id" => "description",
                                        "name" => "description",
                                        "class" => "form-control",
                                        "value" => $department_info->description,
                                        "style" => "height:150px;",
                                        "placeholder" => app_lang('description'),
                                        "data-rich-text-editor" => true
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        
    });
</script>
