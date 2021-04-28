<div class="bg-white p15 pt0 b-b">
    
    <?php
    if ($department_info->icon) {
        //show assign to field to team members only

        $image_url = base_url() . '/files/department_icon/' . $department_info->icon;
        $department_icon = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span>";
        ?>
        <span class="text-off ml15 mr10"><?php echo app_lang("icon") . ": "; ?></span>
        <?php
        echo $department_icon;
    }
    ?>
    <span class="text-off"><?php echo app_lang("status") . ": "; ?></span>

    <?php
    $department_status_class = "bg-danger";
    if ($department_info->status === "open") {
        $department_status_class = "bg-success";
    } else if ($department_info->status === "canceled") {
        $department_status_class = "bg-warning";
    }

    $department_status = "<span class='badge $department_status_class large'>" . app_lang($department_info->status) . "</span> ";
    echo $department_status;
    ?>

    <span class="text-off ml15"><?php echo app_lang("created") . ": "; ?></span>
    <?php echo format_to_relative_time($department_info->created_at); ?> 
</div>
<?php if($members_string !== '') { ?>
<div class="bg-white p10 ml20">
    <?php 
        echo $members_string;
    ?>
</div>
<?php } ?>