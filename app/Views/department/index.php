<div id="page-content" class="page-wrapper clearfix">    
    <div class="card rounded-0">
        <div class="page-title clearfix">
                <h1><?php echo app_lang('department'); ?></h1>
                <div class="title-button-group">
                    <?php
                    // if (isset($can_create_projects) && $can_create_projects) {
                        echo modal_anchor(get_uri("departments/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_department'), array("class" => "btn btn-default", "data-post-client_id" => $client_id, "title" => app_lang('add_department')));
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

        var filters = [{name: "project_label", class: "w200", options: "0"}];

        //don't show filters if hideTools is true or $project_labels_dropdown is empty
        // if (hideTools || !<?php echo $project_labels_dropdown; ?>) {
        //     filters = false;
        // }

        var optionVisibility = false;
        // if ("<?php echo get_setting("client_can_edit_projects"); ?>") {
        //     optionVisibility = true;
        // }

        $("#department-table").appTable({
            source: '<?php echo_uri("departments/departments_list_data_of_client/" . $client_id) ?>',
            order: [[0, "desc"]],
            // hideTools: hideTools,
            // filterDropdown: filters,
            columns: [
                {title: '<?php echo app_lang("id") ?>', "class": "w50"},
                {title: '<?php echo app_lang("title") ?>'},
                {title: '<?php echo app_lang("price") ?>', "class": "w10p"},
                {title: '<?php echo app_lang("start_date") ?>', "class": "w10p", "iDataSort": 4},
                {title: '<?php echo app_lang("status") ?>', "class": "w10p"},
                {title: '<?php echo app_lang("progress") ?>', "class": "w15p"}
            ],
            // printColumns: combineCustomFieldsColumns([0, 1, 3, 5, 7, 9], '<?php echo $custom_field_headers; ?>'),
            // xlsColumns: combineCustomFieldsColumns([0, 1, 3, 5, 7, 9], '<?php echo $custom_field_headers; ?>')
        });
    });
</script>
