<div class="tab-content">
    <div class="row mt-3" style="justify-content: center;">
        <div class="col-sm-12 col-md-5 pb-5">
            <div id="profile_section" class="card">
                <div class="card-body">
                    <?php echo form_open(get_uri("workfeed/save"), array("id" => "workfeed_post_form", "class" => "general-form", "role" => "form")); ?>
                    <input type="hidden" id="department_id" name="department_id" value="<?php echo $department_id; ?>">
                    <div class="d-flex align-items-center">
                        <span class="avatar-sm avatar me-1">
                            <img alt="..." src="<?php echo get_avatar($login_user->image); ?>">
                        </span>
                        <div style="margin-left: 20px;">
                            <textarea id="post_text" name="post_text" class="publish_text" onkeyup="textAreaAdjust(this)" style="overflow:hidden" cols="85" placeholder="Start Conversation..."></textarea>
                        </div>
                    </div>
                    <div class="upload_preview d-flex align-items-center mt-4" style="padding-left: 50px; flex-wrap: wrap;"></div>
                    <div class="d-flex align-items-center justify-content-between mt-4" style="padding-left: 50px;">
                        <div class="d-flex align-items-center">
                            <span onclick="$('#post_image_file').focus().trigger('click');" style='color: black; cursor: pointer;'><i data-feather='image' class='icon-16 me-3'></i></span>
                            <span onclick="$('#post_video_file').focus().trigger('click');" style='color: black; cursor: pointer;'><i data-feather='video' class='icon-16 me-3'></i></span>
                            <span style='color: black; cursor: pointer;'><i data-feather='link' class='icon-16 me-3'></i></span>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" style="color: black; cursor: pointer;">
                                    <i data-feather='smile' class='icon-16 me-3'></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <textarea id="mytextarea">ASCII art is great, but...</textarea>
                                    </li>
                                </ul>
                            </div>
                            <!-- <span style='color: black; cursor: pointer;'><i data-feather='smile' class='icon-16 me-3'></i></span> -->
                            <span style='color: black; cursor: pointer;'><i data-feather='calendar' class='icon-16 me-3'></i></span>
                        </div>
                        <input type="file" id="post_image_file" name="post_image_files" multiple style="display:none;" accept="image/*" onchange="get_file(event)">
                        <input type="file" id="post_video_file" name="post_video_files" multiple style="display:none;" accept="video/*" onchange="get_file(event)">
                        <button type="submit" id="post_btn" class="btn btn-primary">
                            <span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('post'); ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <div id="post_wrapper" class="card">
                <div id="post_section" class="card-body" style="padding: 0;">
                    <?php for($i=0; $i<count($workfeed_data); $i++) { ?>
                    <div class="post-item" id="post_item_<?php echo $workfeed_data[$i]->id; ?>">
                        <div class="d-flex">
                            <div class="post-avatar">
                                <a href="#" class="avatar-sm avatar me-1">
                                    <img alt="..." src="<?php echo $workfeed_data[$i]->user_avatar == ''? base_url().'/assets/images/avatar.jpg': base_url() . '/files/profile_images/' . $workfeed_data[$i]->user_avatar; ?>">
                                </a>
                            </div>
                            <div class="post_content">
                                <div class="d-flex align-items-center justify-content-between" style="width:100%;">
                                    <div class="post_user_name"><?php echo $workfeed_data[$i]->user_name; ?></div>
                                    <div>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" style="color: #777;">
                                                <i data-feather='settings' class='icon-16 me-3'></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="#" class="dropdown-item" title="Delete">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="post_text">
                                    <?php echo $workfeed_data[$i]->content; ?>
                                </div>
                                <div class="file_preview_wrapper">
                                    <?php 
                                        $post_file = $workfeed_data[$i]->files;
                                    ?>
                                    <?php for($j=0; $j<count($post_file); $j++) { ?>
                                        <img src="<?php echo base_url() . '/files/workfeed_file/' . $post_file[$j]; ?>" class="file_preview"/>
                                    <?php } ?>
                                </div>
                                <div class="post_tools d-flex align-items-center justify-content-center">
                                    <span class="comment_post post_tool_item" onclick="get_comment(<?php echo $workfeed_data[$i]->id; ?>)">
                                        <i data-feather='message-circle' class='icon-16 me-1'></i>
                                        <span><?php echo $workfeed_data[$i]->comment_count; ?></span>
                                        <span>Comments</span>
                                    </span>
                                    <?php if($workfeed_data[$i]->reposted_user_flag == 1) { ?>
                                    <span class="repost_post post_tool_item active" data-flag="1" onclick="make_repost(<?php echo $workfeed_data[$i]->id; ?>, this)">
                                    <?php } else { ?>
                                    <span class="repost_post post_tool_item" onclick="make_repost(<?php echo $workfeed_data[$i]->id; ?>, this)">
                                    <?php } ?>
                                        <i data-feather='image' class='icon-16 me-1'></i>
                                        <span class="reposted_count"><?php echo $workfeed_data[$i]->reposted; ?></span>
                                        <span>Reposts</span>
                                    </span>
                                    <?php if($workfeed_data[$i]->favourte_user_flag == 1) { ?>
                                    <span class="clap_post post_tool_item active" data-flag="1" onclick="make_clap(<?php echo $workfeed_data[$i]->id; ?>, this, 0)">
                                    <?php } else { ?>
                                    <span class="clap_post post_tool_item" onclick="make_clap(<?php echo $workfeed_data[$i]->id; ?>, this, 0)">
                                    <?php } ?>
                                        <i data-feather='heart' class='icon-16 me-1'></i>
                                        <span class="clapped_count"><?php echo $workfeed_data[$i]->favourite; ?></span>
                                        <span>Claps</span>
                                    </span>
                                    <span class="share_post post_tool_item" onclick="share_link(<?php echo $workfeed_data[$i]->id; ?>)">
                                        <i data-feather='upload' class='icon-16 me-1'></i>
                                        <span>Shares</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div id="comment_section" class="card">
                <div class="card-body" style="padding: 0;">
                    <div class="d-flex justify-content-end pt-3" style="cursor: pointer;"><span class="goto_back"><i data-feather='corner-up-left' class='icon-16 me-3'></i></span></div>
                    <div id="post_preview_comment" class="comment-item"></div>
                    <div id="comment_post" class="comment-item">
                        <?php echo form_open(get_uri("workfeed/comment_save"), array("id" => "workfeed_comment_form", "class" => "general-form", "role" => "form")); ?>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="post-avatar">
                                <a href="#" class="avatar-sm avatar me-1">
                                    <img alt="..." src="<?php echo get_avatar($login_user->image); ?>">
                                </a>
                            </div>
                            <div class="post_comment_form">
                                <input type="hidden" id="post_id" name="parent_id" value="">
                                <input type="hidden" id="comment_type" name="comment_type" value="0">
                                <input type="text" id="comment_text" name="comment_text" class="publish_text" placeholder="Start Conversation..." style="background-color: #eee; width: 80%;" />
                                <span onclick="$('#comment_image_files').focus().trigger('click');" style='color: #777; cursor: pointer;'><i data-feather='image' class='icon-16 me-3'></i></span>
                                <input type="file" id="comment_image_files" name="comment_image_files" multiple style="display:none;" accept="image/*" onchange="get_comment_file(event, 0)">
                                <button type="submit" class='comment_send_btn' id="comment_send_btn"><i data-feather='send' class='icon-16 me-3'></i></button>
                            </div>
                        </div>
                        <div class="comment_upload_preview d-flex align-items-center mt-4" style="padding-left: 50px; flex-wrap: wrap;"></div>
                        <?php echo form_close(); ?>
                    </div>
                    <div id="comment_list" class="comment-item"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="reply_comment_modal" aria-hidden="true">
        <?php echo form_open(get_uri("workfeed/comment_save"), array("id" => "workfeed_reply_form", "class" => "general-form", "role" => "form")); ?>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply Comment</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="post-avatar">
                            <a href="#" class="avatar-sm avatar me-1">
                                <img alt="..." src="<?php echo get_avatar($login_user->image); ?>">
                            </a>
                        </div>
                        <div class="post_comment_form">
                            <input type="hidden" id="comment_id" name="parent_id" value="">
                            <input type="hidden" id="comment_type" name="comment_type" value="1">
                            <input type="text" id="comment_text" name="comment_text" class="publish_text" placeholder="Start Conversation..." style="background-color: #eee; width: 80%;" />
                            <span onclick="$('#reply_image_files').focus().trigger('click');" style='color: #777; cursor: pointer;'><i data-feather='image' class='icon-16 me-3'></i></span>
                            <input type="file" id="reply_image_files" name="comment_image_files" multiple style="display:none;" accept="image/*" onchange="get_comment_file(event, 1)">
                        </div>
                    </div>
                    <div class="comment_reply_preview d-flex align-items-center mt-4" style="padding-left: 50px; flex-wrap: wrap;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="hide_modal();"><i data-feather='x' class='icon-16 me-3'></i>Close</button>
                    <button type="submit" class="btn btn-primary" id="comment_reply_btn"><i data-feather='check-circle' class='icon-16 me-3'></i>Post Comment</button>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- <script src="https://cdn.tiny.cloud/1/9hxe982n6vvv79sixyw24cgqq9lfi2ofj4q3axfom6jp995f/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    function textAreaAdjust(element) {
        element.style.height = "50px";
        element.style.height = (25+element.scrollHeight)+"px";

        // if($('.upload_preview').is(':empty') && $(element).val() == '') {
        //     $("#post_btn").attr('disabled', 'disabled');
        // }
    }

    function get_file(event) {
        var files = event.target.files;

        for(var i=0; i<files.length; i++) {
            var file_name = files[i].name;
            var file_size = files[i].size;
            var file_type = files[i].type;
            
            const reader = new FileReader();
            reader.addEventListener('load', (event) => {
                var file_content = event.target.result;

                var file_flag = 1;
                if(file_type.search('image') != -1) {
                    flag_flag = 2;
                }
                
                if(file_content) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo get_uri('workfeed/upload_post_file') ?>',
                        data: {
                            'file': file_content,
                            'flag': file_flag
                        },
                        dataType: 'json',
                        success: function (result) {
                            if(result.flag == 1) {
                                console.log(result);
                            
                                if(file_type.search('image') != -1) {
                                    var img_src = 'data:' + file_type + ';base64' + file_content;
                                    var html = "<div class='upload_item'>" +
                                        "<span class='upload_item_remove' onclick='remove_upload_preview(this, "+ result.save_id +")'><i data-feather='x' class='icon-16'></i></span>"+
                                        "<img style='width: 100px; height: 100px;' src='"+ img_src +"'>" +
                                        "<input type='hidden' id='generated_hidden_"+ result.save_id +"' name='file_hidden_data[]' value='"+ result.save_id +"'>"
                                    "</div>";

                                    $(".upload_preview").append(html);
                                }
                                else {
                                    var video_src = 'data:' + file_type + ';base64' + file_content;
                                    var html = "<div class='upload_item'>" +
                                        "<span class='upload_item_remove' onclick='remove_upload_preview(this, "+ result.save_id +")'><i data-feather='x' class='icon-16'></i></span>"+
                                        "<input type='hidden' id='generated_hidden_"+ result.save_id +"' name='file_hidden_data[]' value='"+ result.save_id +"'>"
                                    "</div>";

                                    $(".upload_preview").append(html);
                                }

                                $("#post_btn").removeAttr('disabled');
                                $("#post_image_file").val('');
                                $("#post_video_file").val('');
                            }    
                        }
                    });            
                }      
            });
            reader.readAsDataURL(files[i]);
        }
    }

    function get_comment_file(event, type) {
        var files = event.target.files;

        for(var i=0; i<files.length; i++) {
            var file_name = files[i].name;
            var file_size = files[i].size;
            var file_type = files[i].type;
            
            const reader = new FileReader();
            reader.addEventListener('load', (event) => {
                var file_content = event.target.result;

                var file_flag = 1;
                if(file_type.search('image') != -1) {
                    flag_flag = 2;
                }
                
                if(file_content) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo get_uri('workfeed/upload_comment_file') ?>',
                        data: {
                            'file': file_content,
                            'flag': file_flag
                        },
                        dataType: 'json',
                        success: function (result) {
                            if(result.flag == 1) {
                                console.log(result);
                            
                                if(file_type.search('image') != -1) {
                                    var img_src = 'data:' + file_type + ';base64' + file_content;
                                    var html = "<div class='upload_item'>" +
                                        "<span class='upload_item_remove' onclick='remove_upload_preview(this, "+ result.save_id +")'><i data-feather='x' class='icon-16'></i></span>"+
                                        "<img style='width: 100px; height: 100px;' src='"+ img_src +"'>" +
                                        "<input type='hidden' id='generated_hidden_"+ result.save_id +"' name='file_hidden_data[]' value='"+ result.save_id +"'>"
                                    "</div>";

                                    if(type==0) {
                                        $(".comment_upload_preview").append(html);
                                    }
                                    else {
                                        $(".comment_reply_preview").append(html);
                                    }
                                    
                                }
                                else {
                                    var video_src = 'data:' + file_type + ';base64' + file_content;
                                    var html = "<div class='upload_item'>" +
                                        "<span class='upload_item_remove' onclick='remove_upload_preview(this, "+ result.save_id +")'><i data-feather='x' class='icon-16'></i></span>"+
                                        "<input type='hidden' id='generated_hidden_"+ result.save_id +"' name='file_hidden_data[]' value='"+ result.save_id +"'>"
                                    "</div>";

                                    if(type==0) {
                                        $(".comment_upload_preview").append(html);
                                    }
                                    else {
                                        $(".comment_reply_preview").append(html);
                                    }
                                }

                                if(type==0) {
                                    $("#comment_send_btn").removeAttr('disabled');
                                    $("#comment_image_files").val('');
                                }
                                else {
                                    $("#comment_reply_btn").removeAttr('disabled');
                                    $("#reply_image_files").val('');
                                }
                            }    
                        }
                    });            
                }      
            });
            reader.readAsDataURL(files[i]);
        }
    }

    function remove_upload_preview(obj, save_id) {
        $.ajax({
            type: "POST",
            url: '<?php echo get_uri('workfeed/delete_file') ?>',
            data: {
                id: save_id,
            },
            dataType: 'json',
            success: function (result) {
                if(result.flag == 1) {
                    var item = $(obj).parent('.upload_item');
                    $(item).remove();

                    // if($('.upload_preview').is(':empty') && $("#post_text").val() == '') {
                    //     $("#post_btn").attr('disabled', 'disabled');
                    // }
                }    
            }
        }); 
    }

    function get_comment(post_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo get_uri('workfeed/get_comments') ?>',
            data: {
                id: post_id,
            },
            dataType: 'json',
            success: function(response) {
                if(response.flag == 1) {
                    var post = response.post;

                    var user_avatar = post.user_avatar;
                    var avatar_path = '';
                    if(user_avatar == '') {
                        avatar_path = base_url +'/assets/images/avatar.jpg';
                    }
                    else {
                        avatar_path = base_url +'/files/profile_images/' + user_avatar;
                    }
                    var user_name = post.user_name;

                    var post_text = post.content;
                    var post_files = post.files;
                    var file_html = '';

                    for(var i=0; i<post_files.length; i++) {
                        var file_path = base_url + '/files/workfeed_file/' + post_files[i];
                        file_html += '<img src="'+ file_path +'" class="file_preview"/>';
                    }
                    
                    var html = '<div class="post-item">' +
                        '<div class="d-flex">' +
                            '<div class="post-avatar">' +
                                '<a href="#" class="avatar-md avatar me-1">'+
                                    '<img alt="..." src="'+ avatar_path +'">'+
                                '</a>'+
                            '</div>'+
                            '<div class="post_content">'+
                                '<div class="d-flex align-items-center justify-content-between" style="width:100%;">'+
                                    '<div class="post_user_name">'+ user_name +'</div>'+
                                '</div>'+
                                '<div class="post_text">'+
                                    post_text+
                                '</div>'+
                                '<div class="file_preview_wrapper">' +
                                    file_html +
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';

                    $("#post_preview_comment").html(html);
                    $("#post_id").val(post_id);

                    /////////
                    var comments = response.comments;
                    let html_content = ``;
                    
                    const recursiveGenerator = (comment) => {
                        var user_avatar = comment.user_avatar;
                        var avatar_path = '';
                        if(user_avatar == '') {
                            avatar_path = base_url +'/assets/images/avatar.jpg';
                        }
                        else {
                            avatar_path = base_url +'/files/profile_images/' + user_avatar;
                        }
                        var user_name = comment.user_name;

                        var comment_text = comment.comment;
                        var comment_files = comment.files;
                        var file_html = '';

                        if(comment_files) {
                            for(var k=0; k<comment_files.length; k++) {
                                var file_path = base_url + '/files/workfeed_file/' + comment_files[k];
                                file_html += '<img src="'+ file_path +'" class="file_preview"/>';
                            }
                        }

                        var fav_flag = comment.favourite_user_flag == 1? 'active': '';
                        var fav_data = comment.favourite_user_flag == 1? '1' : '0';

                        html_content += `<div class="comment-sub-item" id="comment_sub_item_${comment.id}">
                            <div class="post-avatar">
                                <a href="#" class="avatar-sm avatar me-1">
                                    <img alt="..." src="${avatar_path}">
                                </a>
                            </div>
                            <div>
                                <div class="comment-content">
                                    <div class="comment-content-wrapper">
                                        <div class="comment-content-username">${user_name}</div>
                                        <div class="comment-content-text">${comment_text}</div>
                                    </div>
                                    <div>${file_html}</div>
                                </div>
                                <div class="comment-tool">
                                    <span class="comment_post post_tool_item ${fav_flag}" data-flag="${fav_data}" onclick="make_clap(${comment.id}, this, 1)">
                                        <i data-feather='heart' class='icon-16 me-1'></i>
                                        <span class="clapped_count">${comment.favourite}</span>
                                        <span>Claps</span>
                                    </span>
                                    <span class="comment_post post_tool_item" onclick="reply_comment(${comment.id}, this)">
                                        <i data-feather='corner-up-left' class='icon-16 me-1'></i>
                                        <span>Reply</span>
                                    </span>
                                </div>
                                <div class="subcomment-wrapper">`;
                                
                                        if (comment.sub_menu) {
                                            comment.sub_menu.map((each) => {
                                                recursiveGenerator(each);
                                            })
                                        }

                        html += `</div></div></div>`;
                    }

                    for(var i=0; i<comments.length; i++) {
                        var user_avatar = comments[i].user_avatar;
                        var avatar_path = '';
                        if(user_avatar == '') {
                            avatar_path = base_url +'/assets/images/avatar.jpg';
                        }
                        else {
                            avatar_path = base_url +'/files/profile_images/' + user_avatar;
                        }
                        var user_name = comments[i].user_name;

                        var comment_text = comments[i].comment;
                        var comment_files = comments[i].files;
                        var file_html = '';

                        for(var j=0; j<comment_files.length; j++) {
                            var file_path = base_url + '/files/workfeed_file/' + comment_files[j];
                            file_html += '<img src="'+ file_path +'" class="file_preview"/>';
                        }

                        var fav_flag = comments[i].favourite_user_flag == 1? 'active': '';
                        var fav_data = comments[i].favourite_user_flag == 1? '1' : '0';
                        
                        html_content += `<div class="comment-sub-item" id="comment_sub_item_${comments[i].id}">
                            <div class="post-avatar">
                                <a href="#" class="avatar-sm avatar me-1">
                                    <img alt="..." src="${avatar_path}">
                                </a>
                            </div>
                            <div>
                                <div class="comment-content">
                                    <div class="comment-content-wrapper">
                                        <div class="comment-content-username">${user_name}</div>
                                        <div class="comment-content-text">${comment_text}</div>
                                    </div>
                                    <div>${file_html}</div>
                                </div>
                                <div class="comment-tool">
                                    <span class="comment_post post_tool_item ${fav_flag}" data-flag="${fav_data}" onclick="make_clap(${comments[i].id}, this, 1)">
                                        <i data-feather='heart' class='icon-16 me-1'></i>
                                        <span class="clapped_count">${comments[i].favourite}</span>
                                        <span>Claps</span>
                                    </span>
                                    <span class="comment_post post_tool_item" onclick="reply_comment(${comments[i].id}, this)">
                                        <i data-feather='corner-up-left' class='icon-16 me-1'></i>
                                        <span>Reply</span>
                                    </span>
                                </div>
                                <div class="subcomment-wrapper">`;
                                
                                        if (comments[i].sub_menu) {
                                            comments[i].sub_menu.map((each) => {
                                                recursiveGenerator(each);
                                            })
                                        }

                            html_content += `</div></div></div>`;
                    }

                    if(html_content == '') {
                        html_content = 'No Comment';
                    }

                    $("#comment_list").html(html_content)

                    $("#profile_section").hide();
                    $("#post_wrapper").hide();
                    $("#comment_section").show();
                }
            }
        })
    }

    function make_repost(post_id, obj) {
        var reposted_flag = $(obj).data('flag');

        if(!reposted_flag || reposted_flag == 0) {
            reposted_flag = 0;
        }
        else {
            reposted_flag = 1;
        }
        
        $.ajax({
            type: "POST",
            url: '<?php echo get_uri('workfeed/make_repost') ?>',
            data: {
                id: post_id,
                flag: reposted_flag
            },
            dataType: 'json',
            success: function (result) {
                if(reposted_flag == 0) {
                    reposted_flag = 0;
                    $(obj).data('flag', 1);
                    $(obj).addClass('active');

                    var count_obj = $(obj).find('.reposted_count');
                    var recent_count = $(count_obj).text();
                    recent_count = parseInt(recent_count);
                    recent_count ++;
                    $(count_obj).text(recent_count);
                }
                else {
                    $(obj).data('flag', 0);
                    $(obj).removeClass('active');

                    var count_obj = $(obj).find('.reposted_count');
                    var recent_count = $(count_obj).text();
                    recent_count = parseInt(recent_count);
                    recent_count--;
                    $(count_obj).text(recent_count);
                }
            }
        })
    }

    function make_clap(post_id, obj, type) {
        var clap_flag = $(obj).data('flag');
        if(!clap_flag || clap_flag == 0) {
            clap_flag = 0;
        }
        else {
            clap_flag = 1;
        }

        $.ajax({
            type: "POST",
            url: '<?php echo get_uri('workfeed/make_favoutite') ?>',
            data: {
                id: post_id,
                flag: clap_flag,
                type: type
            },
            dataType: 'json',
            success: function (result) {
                if(result.flag == 1) {
                    if(clap_flag == 0) {
                        clap_flag = 0;
                        $(obj).data('flag', 1);
                        $(obj).addClass('active');

                        var count_obj = $(obj).find('.clapped_count');
                        var recent_count = $(count_obj).text();
                        recent_count = parseInt(recent_count);
                        recent_count ++;
                        $(count_obj).text(recent_count);
                    }
                    else {
                        $(obj).data('flag', 0);
                        $(obj).removeClass('active');

                        var count_obj = $(obj).find('.clapped_count');
                        var recent_count = $(count_obj).text();
                        recent_count = parseInt(recent_count);
                        recent_count--;
                        $(count_obj).text(recent_count);
                    }
                }
            }
        })
    }

    function reply_comment(comment_id, obj) {
        $("#reply_comment_modal #comment_id").val(comment_id);
        $("#reply_comment_modal").modal('toggle');
    }

    function share_link(post_id) {

    }

    // tinymce.init({
    //     selector: "#mytextarea",
    //     plugins: "emoticons",
    //     toolbar: "emoticons",
    //     toolbar_location: "bottom",
    //     menubar: false
    // });

    function hide_modal() {
        $("#reply_comment_modal").modal('hide');

        $("#reply_comment_modal #comment_id").val('');
        $("#reply_comment_modal #comment_text").val('');
        $("#reply_comment_modal #reply_image_files").val('');
        // $("#comment_reply_btn").attr('disabled', 'disabled');
    }
    
    $(document).ready(function () {
        // $("#post_btn").attr('disabled', 'disabled');
        // $("#comment_send_btn").attr('disabled', 'disabled');
        // $("#comment_reply_btn").attr('disabled', 'disabled');

        $("#comment_section").hide();

        $(".goto_back").on('click', function() {
            $("#comment_list").empty();
            $(".comment_upload_preview").empty();
            $("#post_preview_comment").empty();
            $("#post_id").val('');
            $("#comment_text").val('');
            $("#comment_image_files").val('');

            $("#comment_section").hide();
            $("#profile_section").show();
            $("#post_wrapper").show();
        });

        $("#workfeed_post_form").appForm({
            isModal: false,
            onSuccess: function (result) {
                if(result.success == true) {    
                    var insert_id = result.id;
                    var data = result.data;

                    var user_avatar = data.user_avatar;
                    var avatar_path = '';
                    if(user_avatar == '') {
                        avatar_path = base_url +'/assets/images/avatar.jpg';
                    }
                    else {
                        avatar_path = base_url +'/files/profile_images/' + user_avatar;
                    }
                    var user_name = data.user_name;

                    var post_text = data.content;
                    var post_files = data.files;
                    var file_html = '';

                    for(var i=0; i<post_files.length; i++) {
                        var file_path = base_url + '/files/workfeed_file/' + post_files[i];
                        file_html += '<img src="'+ file_path +'" class="file_preview"/>';
                    }
                    
                    var html = '<div class="post-item" id="post_item_'+ insert_id +'">' +
                        '<div class="d-flex">' +
                            '<div class="post-avatar">' +
                                '<a href="#" class="avatar-sm avatar me-1">'+
                                    '<img alt="..." src="'+ avatar_path +'">'+
                                '</a>'+
                            '</div>'+
                            '<div class="post_content">'+
                                '<div class="d-flex align-items-center justify-content-between" style="width:100%;">'+
                                    '<div class="post_user_name">'+ user_name +'</div>'+
                                    '<div>'+
                                        '<div class="dropdown">'+
                                            '<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" style="color: #777;">'+
                                                '<i data-feather="settings" class="icon-16 me-3"></i>'+
                                            '</a>'+
                                            '<ul class="dropdown-menu dropdown-menu-end">'+
                                                '<li>'+
                                                    '<a href="#" class="dropdown-item" title="Delete">Delete</a>'+
                                                '</li>'+
                                            '</ul>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="post_text">'+
                                    post_text+
                                '</div>'+
                                '<div class="file_preview_wrapper">' +
                                    file_html +
                                '</div>'+
                                '<div class="post_tools d-flex align-items-center justify-content-center">'+
                                    '<span class="comment_post post_tool_item" onclick="get_comment('+ insert_id +')">'+
                                        '<i data-feather="message-circle" class="icon-16 me-1"></i>'+
                                        '<span>'+ data.comment_count +'</span>'+
                                        '<span>Comments</span>'+
                                    '</span>'+
                                    '<span class="repost_post post_tool_item" onclick="make_repost('+ insert_id +', this)">'+
                                        '<i data-feather="image" class="icon-16 me-1"></i>'+
                                        '<span>'+ data.reposted +'</span>'+
                                        '<span>Reposts</span>'+
                                    '</span>'+
                                    '<span class="clap_post post_tool_item" onclick="make_clap('+ insert_id +', this, 0)">'+
                                        '<i data-feather="heart" class="icon-16 me-1"></i>'+
                                        '<span>'+ data.favourite +'</span>'+
                                        '<span>Claps</span>'+
                                    '</span>'+
                                    '<span class="share_post post_tool_item" onclick="share_link('+ insert_id +')">'+
                                        '<i data-feather="upload" class="icon-16 me-1"></i>'+
                                        '<span>Shares</span>'+
                                    '</span>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                    
                    $("#post_section").append(html);
                    // $("#post_btn").attr('disabled', 'disabled');
                    $("#post_image_file").val('');
                    $("#post_video_file").val('');
                    $(".upload_preview").empty();
                    $("#post_text").val('');
                }

                appAlert.success(result.message, {duration: 10000});
            }
        });

        $("#workfeed_comment_form").appForm({
            isModal: false,
            onSuccess: function (result) {
                if(result.success == true) {    
                    var insert_id = result.id;
                    var data = result.data;

                    var user_avatar = data.user_avatar;
                    var avatar_path = '';
                    if(user_avatar == '') {
                        avatar_path = base_url +'/assets/images/avatar.jpg';
                    }
                    else {
                        avatar_path = base_url +'/files/profile_images/' + user_avatar;
                    }
                    var user_name = data.user_name;

                    var post_text = data.content;
                    var post_files = data.files;
                    var file_html = '';

                    for(var i=0; i<post_files.length; i++) {
                        var file_path = base_url + '/files/workfeed_file/' + post_files[i];
                        file_html += '<img src="'+ file_path +'" class="comment-content-file"/>';
                    }
                    
                    var html = '<div class="comment-sub-item" id="comment_sub_item_'+ insert_id +'">'+
                                    '<div class="post-avatar">'+
                                        '<a href="#" class="avatar-sm avatar me-1">'+
                                            '<img alt="..." src="'+ avatar_path +'">'+
                                        '</a>'+
                                    '</div>'+
                                    '<div>'+
                                        '<div class="comment-content">'+
                                            '<div class="comment-content-wrapper">'+
                                                '<div class="comment-content-username">'+ user_name +'</div>'+
                                                '<div class="comment-content-text">'+
                                                    data.comment + 
                                                '</div>'+
                                            '</div>'+
                                            '<div>'+
                                                file_html+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="comment-tool">'+
                                            '<span class="comment_post post_tool_item" onclick="make_clap('+ insert_id +', this, 1)">'+
                                                '<i data-feather="heart" class="icon-16 me-1"></i>'+
                                                '<span class="clapped_count">0</span>'+
                                                '<span>Claps</span>'+
                                            '</span>'+
                                            '<span class="comment_post post_tool_item" onclick="reply_comment('+ insert_id +', this)">'+
                                                '<i data-feather="corner-up-left" class="icon-16 me-1"></i>'+
                                                '<span>Reply</span>'+
                                            '</span>'+
                                        '</div>'+
                                        '<div class="subcomment-wrapper"></div>'+
                                    '</div>'+
                                '</div>';
                    
                    $("#comment_list").prepend(html);
                    // $("#comment_send_btn").attr('disabled', 'disabled');
                    $(".comment_upload_preview").empty();
                    $("#comment_image_files").val('');
                    $("#comment_text").val('');
                    $(".upload_preview").empty();
                }

                appAlert.success(result.message, {duration: 10000});
            }
        });

        $("#workfeed_reply_form").appForm({
            isModal: false,
            onSuccess: function (result) {
                if(result.success == true) {    
                    var comment_id = $("#comment_id").val();      
                    
                    var insert_id = result.id;
                    var data = result.data;

                    var user_avatar = data.user_avatar;
                    var avatar_path = '';
                    if(user_avatar == '') {
                        avatar_path = base_url +'/assets/images/avatar.jpg';
                    }
                    else {
                        avatar_path = base_url +'/files/profile_images/' + user_avatar;
                    }
                    var user_name = data.user_name;

                    var post_text = data.content;
                    var post_files = data.files;
                    var file_html = '';

                    for(var i=0; i<post_files.length; i++) {
                        var file_path = base_url + '/files/workfeed_file/' + post_files[i];
                        file_html += '<img src="'+ file_path +'" class="comment-content-file"/>';
                    }
                    
                    var html = '<div class="comment-sub-item" id="comment_sub_item_'+ insert_id +'">'+
                                    '<div class="post-avatar">'+
                                        '<a href="#" class="avatar-sm avatar me-1">'+
                                            '<img alt="..." src="'+ avatar_path +'">'+
                                        '</a>'+
                                    '</div>'+
                                    '<div>'+
                                        '<div class="comment-content">'+
                                            '<div class="comment-content-wrapper">'+
                                                '<div class="comment-content-username">'+ user_name +'</div>'+
                                                '<div class="comment-content-text">'+
                                                    data.comment + 
                                                '</div>'+
                                            '</div>'+
                                            '<div>'+
                                                file_html+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="comment-tool">'+
                                            '<span class="comment_post post_tool_item" onclick="make_clap('+ insert_id +', this, 1)">'+
                                                '<i data-feather="heart" class="icon-16 me-1"></i>'+
                                                '<span class="clapped_count">0</span>'+
                                                '<span>Claps</span>'+
                                            '</span>'+
                                            '<span class="comment_post post_tool_item" onclick="reply_comment('+ insert_id +', this)">'+
                                                '<i data-feather="corner-up-left" class="icon-16 me-1"></i>'+
                                                '<span>Reply</span>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                    
                    $("#comment_sub_item_"+ comment_id + " .subcomment-wrapper").prepend(html);


                }

                appAlert.success(result.message, {duration: 10000});
            }
        });
    });
</script>