<div id="page-content" class="page-wrapper clearfix">    
    <div class="card rounded-0">
        <div class="page-title clearfix">
                <h1><?php echo app_lang('department'); ?></h1>
                <div class="title-button-group">
                    <?php
                    // if (isset($can_create_projects) && $can_create_projects) {
                        echo modal_anchor(get_uri("departments/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('create_department'), array("class" => "btn btn-default", "data-post-created_by" => $created_by, "title" => app_lang('create_department')));
                    // }
                    ?>
                </div>
            </div>

        <div class="table-responsive" id="client-departments-list">
            <table id="department-table" class="display" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var hideTools = "0";

        var filters = [{name: "department_label", class: "w200", options: <?php echo $department_labels_dropdown; ?>}];

        //don't show filters if hideTools is true or $project_labels_dropdown is empty
        // if (hideTools || !<?php echo $project_labels_dropdown; ?>) {
        //     filters = false;
        // }

        var optionVisibility = true;
        // if ("<?php echo get_setting("client_can_edit_projects"); ?>") {
        //     optionVisibility = true;
        // }

        $("#department-table").appTable({
            source: '<?php echo_uri("departments/departments_list_data_of_user/" . $created_by) ?>',
            order: [[0, "desc"]],
            // hideTools: hideTools,
            multiSelect: [
                {
                    name: "status",
                    text: "<?php echo app_lang('status'); ?>",
                    options: [
                        {text: '<?php echo app_lang("open") ?>', value: "open", isChecked: true},
                        {text: '<?php echo app_lang("canceled") ?>', value: "canceled"}
                    ]
                }
            ],
            // filterDropdown: filters,
            columns: [
                {title: '<?php echo app_lang("id") ?>', "class": "w50"},
                {title: '<?php echo app_lang("icon") ?>', "class": "w50"},
                {title: '<?php echo app_lang("title") ?>', "class": "w10p"},
                {title: '<?php echo app_lang("description") ?>'},
                {title: '<?php echo app_lang("start_date") ?>', "class": "w10p", "iDataSort": 4},
                {title: '<?php echo app_lang("status") ?>', "class": "w10p"},
                {title: '<?php echo app_lang("private") ?>', "class": "w15p"},
                {visible: optionVisibility, title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: combineCustomFieldsColumns([0, 1, 2, 3, 4, 5], '<?php echo $custom_field_headers; ?>'),
            xlsColumns: combineCustomFieldsColumns([0, 1, 2, 3, 4, 5], '<?php echo $custom_field_headers; ?>')
        });
    });
</script>
