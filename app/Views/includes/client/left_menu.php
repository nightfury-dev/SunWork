<div class="aside aside-left d-flex aside-fixed" id="kt_aside">
    <!--begin::Primary-->
    <div class="aside-primary d-flex flex-column align-items-center flex-row-auto">
        <!--begin::Brand-->
        <div class="aside-brand d-flex flex-column align-items-center flex-column-auto py-5 py-lg-12">
            <!--begin::Logo-->
            <?php
                $user = $login_user->id;
                $dashboard_link = get_uri("dashboard");
                $user_dashboard = get_setting("user_" . $user . "_dashboard");
                if ($user_dashboard) {
                    $dashboard_link = get_uri("dashboard/view/" . $user_dashboard);
                }
            ?>
            <a href="<?php echo $dashboard_link; ?>">
                <img alt="Logo" src="<?php base_url() ?>assets/metronic/media/logos/logo-letter-2.png" class="max-h-30px" />
            </a>
            <!--end::Logo-->
        </div>
        <!--end::Brand-->
        <!--begin::Nav Wrapper-->
        <div class="aside-nav d-flex flex-column align-items-center flex-column-fluid py-5 scroll scroll-pull">
            <!--begin::Nav-->
            <ul class="nav flex-column" role="tablist">
                <?php 
                if (!$is_preview) {
                    $sidebar_menu = get_active_menu($sidebar_menu);
                }
                
                foreach ($sidebar_menu as $main_menu) {
                    if (isset($main_menu["name"])) {
                        $active_class = isset($main_menu["is_active_menu"]) ? "active" : "";
    
                        $badge = get_array_value($main_menu, "badge");
                        $badge_class = get_array_value($main_menu, "badge_class");
                        $target = (isset($main_menu['is_custom_menu_item']) && isset($main_menu['open_in_new_tab']) && $main_menu['open_in_new_tab']) ? "target='_blank'" : "";
                        ?>
                        
                        <!--begin::Item-->
                        <li class="nav-item mb-3" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="<?php echo isset($main_menu['is_custom_menu_item']) ? $main_menu['name'] : app_lang($main_menu['name']); ?>">
                            <a href="#" class="nav-link btn btn-icon btn-clean btn-lg <?php echo $active_class ?>" data-toggle="tab" data-target="#menu_tab_<?php echo $main_menu['name']; ?>" role="tab">
                                <span class="svg-icon svg-icon-xl">
                                    <i class="fas fa-<?php echo ($main_menu['class']); ?>"></i>
                                </span>
                            </a>
                        </li>
                        <!--end::Item-->
                <?php
                    }
                }
                ?>
            </ul>
            <!--end::Nav-->
        </div>
        <!--end::Nav Wrapper-->
        <div class="aside-footer d-flex flex-column align-items-center flex-column-auto py-4 py-lg-10">
            <!--begin::Aside Toggle-->
            <span class="aside-toggle btn btn-icon btn-primary btn-hover-primary shadow-sm" id="kt_aside_toggle" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="Toggle Aside">
                <i class="ki ki-bold-arrow-back icon-sm"></i>
            </span>
            <!--end::Aside Toggle-->
            <!--begin::User-->
            <a href="#" class="btn btn-icon btn-clean btn-lg w-40px h-40px" id="kt_quick_user_toggle" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="User Profile">
                <span class="symbol symbol-30 symbol-lg-40">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <!--<span class="symbol-label font-size-h5 font-weight-bold">S</span>-->
                </span>
            </a>
            <!--end::User-->
        </div>
    </div>
    <!--end::Primary-->
    <!--begin::Secondary-->
    <div class="aside-secondary d-flex flex-row-fluid">
        <!--begin::Workspace-->
        <div class="aside-workspace scroll scroll-push my-2">
            <!--begin::Form-->
            <form class="p-2 pl-lg-9 pt-lg-9">
                <div class="d-flex">
                    <div class="input-icon h-40px">
                        <input type="text" class="form-control form-control-lg form-control-solid h-40px" placeholder="Search..." id="generalSearch" />
                        <span>
                            <span class="svg-icon svg-icon-lg">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </span>
                    </div>
                </div>
            </form>
            <!--end::Form-->
            <!--begin::Tab Content-->
            <div class="tab-content">
            <?php
            foreach ($sidebar_menu as $main_menu) {
                if (isset($main_menu["name"])) {
                    $submenu = get_array_value($main_menu, "submenu");
                    $active_class = isset($main_menu["is_active_menu"]) ? "show active" : "";

                    $submenu_open_class = "";

                    $badge = get_array_value($main_menu, "badge");
                    $badge_class = get_array_value($main_menu, "badge_class");
                    $target = (isset($main_menu['is_custom_menu_item']) && isset($main_menu['open_in_new_tab']) && $main_menu['open_in_new_tab']) ? "target='_blank'" : "";
                    ?>

                    <?php if($main_menu['name'] == 'dashboard') { ?>
                    <div class="tab-pane p-3 px-lg-7 py-lg-5 fade <?php echo $active_class?>" id="menu_tab_<?php echo $main_menu['name']; ?>">
                        <h3 class="p-2 p-lg-3 my-1 my-lg-3"><?php echo isset($main_menu['is_custom_menu_item']) ? $main_menu['name'] : app_lang($main_menu['name']); ?></h3>
                        
                    </div>
                    <?php } else if($main_menu['name'] == 'department') { ?>
                    <div class="tab-pane p-3 px-lg-7 py-lg-5 fade <?php echo $active_class?>" id="menu_tab_<?php echo $main_menu['name']; ?>">
                        <h3 class="p-2 p-lg-3 my-1 my-lg-3"><?php echo isset($main_menu['is_custom_menu_item']) ? $main_menu['name'] : app_lang($main_menu['name']); ?></h3>
                        <!--begin::List-->
                        <div class="list list-hover">
                            <!--begin::Item-->
                            <div class="list-item hoverable p-2 p-lg-3 mb-2">
                                <div class="d-flex align-items-center">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light mr-4">
                                        <span class="symbol-label bg-hover-white">
                                            <img src="<?php base_url() ?>assets/metronic/media/svg/misc/006-plurk.svg" class="h-50 align-self-center" />
                                        </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column flex-grow-1 mr-2">
                                        <span class="text-dark-75 font-size-h6 mb-0">Sample Department</span>
                                        <a href="#" class="text-muted text-hover-primary font-weight-bold">By James</a>
                                    </div>
                                    <!--begin::End-->
                                </div>
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::List-->
                    </div>
                    <?php } else { ?>
                    <!--begin::Tab Pane-->
                    <div class="tab-pane p-3 px-lg-7 py-lg-5 fade <?php echo $active_class?>" id="menu_tab_<?php echo $main_menu['name']; ?>">
                        <h3 class="p-2 p-lg-3 my-1 my-lg-3"><?php echo isset($main_menu['is_custom_menu_item']) ? $main_menu['name'] : app_lang($main_menu['name']); ?></h3>
                        <!--begin::List-->
                        <div class="list list-hover">
                            <?php
                            if ($submenu) {
                                foreach ($submenu as $s_menu) {
                                    if (isset($s_menu['name'])) {
                                        $sub_menu_target = (isset($s_menu['is_custom_menu_item']) && isset($s_menu['open_in_new_tab']) && $s_menu['open_in_new_tab']) ? "target='_blank'" : "";
                                        ?>
                            
                                        <!--begin::Item-->
                                        <div class="list-item hoverable p-2 p-lg-3 mb-2">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-40 symbol-light mr-4">
                                                    <span class="symbol-label bg-hover-white">
                                                        <img src="<?php base_url() ?>assets/metronic/media/svg/misc/006-plurk.svg" class="h-50 align-self-center" />
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Text-->
                                                <div class="d-flex flex-column flex-grow-1 mr-2">
                                                    <span class="text-dark-75 font-size-h6 mb-0"><?php echo isset($s_menu['is_custom_menu_item']) ? $s_menu['name'] : app_lang($s_menu['name']); ?></span>
                                                    <a <?php echo $sub_menu_target; ?> href="<?php echo isset($s_menu['is_custom_menu_item']) ? $s_menu['url'] : get_uri($s_menu['url']); ?>" class="text-muted text-hover-primary font-weight-bold">By James</a>
                                                </div>
                                                <!--begin::End-->
                                            </div>
                                        </div>
                                        <!--end::Item-->

                                    <?php 
                                    } 
                                }
                            }    
                            ?>
                        </div>
                        <!--end::List-->
                    </div>
                    <!--end::Tab Pane-->
                    <?php
                    }
                }
            }
            ?>
            </div>
            <!--end::Tab Content-->
        </div>
        <!--end::Workspace-->
    </div>
    <!--end::Secondary-->
</div>