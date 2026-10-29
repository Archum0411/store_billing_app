<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <link rel="icon" href="{{ asset('admin/assets/images/icons8-shop-100.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('admin/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" />
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/header-colors.css') }}" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #fff !important;
        }



        @media (min-width: 1400px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                max-width: 100% !important;
            }
        }
    </style>
    @yield('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>Admin Dashboard Panel</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <!-- <img src="{{ asset('admin/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon" /> -->
                </div>
                <div class="small-boxhide">
                    <h4 class="text-gray font-bold">Store Billing</h4>
                </div>
                <div class="toggle-icon ms-auto">
                    <i class="fadeIn animated bx bx-arrow-from-left"></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">

                    {{-- Dashboard --}}
                    <li>    
                        <a href="{{ route('dashboard') }}">
                            <div class="parent-icon">
                                <i class="bx bx-home-alt"></i>
                            </div>
                            <div class="menu-title">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-label mt-0">User Management</li>

                    <li>
                        <a href="{{ route('user.index') }}">
                            <div class="parent-icon">
                                <i class="fadeIn animated bx bx-user"></i>
                            </div>
                            <div class="menu-title">User Management</div>
                        </a>
                    </li>

                   

                    <li class="menu-label mt-0">Customer Management</li>

                    <li>
                        <a href="{{ route('customer.index') }}">
                            <div class="parent-icon">
                                <i class="fadeIn animated bx bx-user-check"></i>
                            </div>
                            <div class="menu-title">Customers Management</div>
                        </a>
                    </li>

                    <li class="menu-label mt-0">Product Management</li>

                    <li>
                        <a href="{{ route('product.index') }}">
                            <div class="parent-icon">
                                <i class="fadeIn animated bx bx-package"></i>
                            </div>
                            <div class="menu-title">Products Management</div>
                        </a>
                    </li>

                    <li class="menu-label mt-0">Order Mangement</li>

                    <li>
                        <a href="{{ route('billing.create') }}">
                            <div class="parent-icon">
                                <i class="fadeIn animated bx bx-receipt"></i>
                            </div>
                            <div class="menu-title">Billing New Order</div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('customer.order.history.view') }}">
                            <div class="parent-icon">
                                <i class="fadeIn animated bx bx-history"></i>
                            </div>
                            <div class="menu-title">Customer Order History</div>
                        </a>
                    </li>

            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand gap-3">
                    <div class="mobile-toggle-menu"><i class="bx bx-menu"></i></div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center gap-1">
                            <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal"
                                data-bs-target="#SearchModal">
                                <a class="nav-link" href="Javascript:;"><i class="bx bx-search"></i>
                                </a>
                            </li>

                            <li class="nav-item dark-mode d-none d-sm-flex">
                                <a class="nav-link dark-mode-icon" href="javascript:;"><i
                                        class="bx bx-moon d-none"></i>
                                </a>
                            </li>

                            <li class="nav-item dropdown dropdown-large" style="display:none">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                                    href="#" data-bs-toggle="dropdown"><span class="alert-count">7</span>
                                    <i class="bx bx-bell"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="app-container p-2 my-2">
                                        <a href="javascript:;">
                                            <div class="msg-header">
                                                <p class="msg-header-title">Notifications</p>
                                                <p class="msg-header-badge">8 New</p>
                                            </div>
                                        </a>
                                        <div class="header-notifications-list">
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="user-online">
                                                        <img src="{{ asset('admin/assets/images/avatars/avatar-1.png') }}"
                                                            class="msg-avatar" alt="user avatar" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                                            Daisy Anderson<span class="msg-time float-end">5 sec
                                                                ago</span>
                                                        </h6>
                                                        <p class="msg-info">
                                                            The standard chunk of lorem
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="notify bg-light-danger text-danger">
                                                        dc
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                                            New Orders
                                                            <span class="msg-time float-end">2 min ago</span>
                                                        </h6>
                                                        <p class="msg-info">
                                                            You have received new orders
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="user-online">
                                                        <img src="{{ asset('admin/assets/images/avatars/avatar-2.png') }}"
                                                            class="msg-avatar" alt="user avatar" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                                            Althea Card
                                                            <span class="msg-time float-end">14 sec ago</span>
                                                        </h6>
                                                        <p class="msg-info">
                                                            Many desktop publishing packages
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="notify bg-light-success text-success">
                                                        <img src="{{ asset('admin/assets/images/app/outlook.png') }}"
                                                            width="25" alt="user avatar" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                                            Account Created<span class="msg-time float-end">28 min
                                                                ago</span>
                                                        </h6>
                                                        <p class="msg-info">
                                                            Successfully created new email
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="notify bg-light-info text-info">Ss</div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                                            New Product Approved
                                                            <span class="msg-time float-end">2 hrs ago</span>
                                                        </h6>
                                                        <p class="msg-info">
                                                            Your new product has approved
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="user-online">
                                                        <img src="{{ asset('admin/assets/images/avatars/avatar-4.png') }}"
                                                            class="msg-avatar" alt="user avatar" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                                            Katherine Pechon
                                                            <span class="msg-time float-end">15 min ago</span>
                                                        </h6>
                                                        <p class="msg-info">
                                                            Making this the first true generator
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="notify bg-light-success text-success">
                                                        <i class="bx bx-check-square"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                                            Your item is shipped
                                                            <span class="msg-time float-end">5 hrs ago</span>
                                                        </h6>
                                                        <p class="msg-info">
                                                            Successfully shipped your item
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="notify bg-light-primary">
                                                        <img src="{{ asset('admin/assets/images/app/github.png') }}"
                                                            width="25" alt="user avatar" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                                            New 24 authors<span class="msg-time float-end">1 day
                                                                ago</span>
                                                        </h6>
                                                        <p class="msg-info">
                                                            24 new authors joined last week
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="user-online">
                                                        <img src="{{ asset('admin/assets/images/avatars/avatar-8.png') }}"
                                                            class="msg-avatar" alt="user avatar" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                                            Peter Contango
                                                            <span class="msg-time float-end">6 hrs ago</span>
                                                        </h6>
                                                        <p class="msg-info">
                                                            It was popularized in the 1960s
                                                        </p>
                                                    </div>ee
                                                </div>
                                            </a>
                                        </div>
                                        <a href="javascript:;">
                                            <div class="text-center msg-footer">
                                                <button class="btn btn-primary w-100">
                                                    View All Notifications
                                                </button>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown px-3">
                        <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('admin/assets/images/avatars/avatar-2.png') }}" class="user-img" alt="user avatar" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-user fs-5"></i><span>{{ Auth::user()->name }}</span></a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-user fs-5"></i><span>Profile</span></a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-cog fs-5"></i><span>Settings</span></a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-home-circle fs-5"></i><span>Dashboard</span></a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-dollar-circle fs-5"></i><span>Earnings</span></a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-download fs-5"></i><span>Downloads</span></a>
                            </li> --}}
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('logout') }}"><i
                                        class="bx bx-log-out-circle"></i><span>Logout</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->

        <!--start page wrapper -->
        @yield('content')
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2025. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->

    <!-- search modal -->
    <div class="modal" id="SearchModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header gap-2">
                    <div class="position-relative popup-search w-100">
                        <input class="form-control form-control-lg ps-5 border border-3 border-primary" type="search"
                            placeholder="Search" />
                        <span
                            class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-4"><i
                                class="bx bx-search"></i></span>
                    </div>
                    <button type="button" class="btn-close d-md-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="search-list">
                        <p class="mb-1">Html Templates</p>
                        <div class="list-group">
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action active align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-angular fs-4"></i>Best Html Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-vuejs fs-4"></i>Html5 Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-magento fs-4"></i>Responsive Html5
                                Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-shopify fs-4"></i>eCommerce Html
                                Templates</a>
                        </div>
                        <p class="mb-1 mt-3">Web Designe Company</p>
                        <div class="list-group">
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-windows fs-4"></i>Best Html Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-dropbox fs-4"></i>Html5 Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-opera fs-4"></i>Responsive Html5
                                Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-wordpress fs-4"></i>eCommerce Html
                                Templates</a>
                        </div>
                        <p class="mb-1 mt-3">Software Development</p>
                        <div class="list-group">
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-mailchimp fs-4"></i>Best Html Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-zoom fs-4"></i>Html5 Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-sass fs-4"></i>Responsive Html5 Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-vk fs-4"></i>eCommerce Html Templates</a>
                        </div>
                        <p class="mb-1 mt-3">Online Shoping Portals</p>
                        <div class="list-group">
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-slack fs-4"></i>Best Html Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-skype fs-4"></i>Html5 Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-twitter fs-4"></i>Responsive Html5
                                Templates</a>
                            <a href="javascript:;"
                                class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                    class="bx bxl-vimeo fs-4"></i>eCommerce Html Templates</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end search modal -->

    <!-- Bootstrap JS -->
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script> --}}
    <script src="{{ asset('admin/assets/plugins/chartjs/js/chart.js') }}"></script>
    <script src="{{ asset('admin/assets/js/index.js') }}"></script>
    <script src="{{ asset('admin/assets/js/widgets.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/widgets.js') }}"></script> --}}
    <!--app JS-->
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    <!-- own Js -->
    <script src="{{ asset('admin/assets/js/own.js') }}"></script>
    <script>
        new PerfectScrollbar(".app-container");
    </script>

    <!-- jQuery FIRST -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Then Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('script')

    <!--DataTable-->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
</body>

</html>
