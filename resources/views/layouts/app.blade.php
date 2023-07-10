<!DOCTYPE html>
<!--
Template Name: Midone - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" class="dark">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="../dist2/images/msg-bubble.svg" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <title>BFFChat</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        <link rel="stylesheet" href="../dist2/css/app.css" />
        <link rel="stylesheet" href="../dist/css/custom.css" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="main">
    <div id="app">
        <!-- BEGIN: Mobile Menu -->
        <div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto">
                    <img alt="Midone Tailwind HTML Admin Template" class="w-6" src="../dist2/images/msg-bubble.svg">
                </a>
                <!-- <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a> -->
            </div>
            <ul class="border-t border-theme-29 py-5 hidden">
                
                <li>
                    <router-link to="/" class="menu menu--active">
                        <div class="menu__icon"> <i data-feather="message-square"></i> </div>
                        <div class="menu__title"> Chat </div>
                    </router-link>
                </li>
                
            </ul>
        </div>
        <!-- END: Mobile Menu -->
        <div class="flex">
            <!-- BEGIN: Simple Menu -->
            <nav class="side-nav side-nav--simple">
                <a href="" class="intro-x flex items-center pl-5 pt-4">
                    <img alt="Midone Tailwind HTML Admin Template" class="w-6" src="../dist2/images/msg-bubble.svg">
                </a>
                <div class="side-nav__devider my-6"></div>
                <ul>
                    
                    <li>
                        <router-link to="/" class="side-menu side-menu--active">
                            <div class="side-menu__icon"> <i data-feather="message-square"></i> </div>
                            <div class="side-menu__title"> Chat </div>
                        </router-link>
                    </li>
                    
                </ul>
            </nav>
            <!-- END: Simple Menu -->
            <!-- BEGIN: Content -->
            <div class="content">
                <router-view>
                    @yield('chatcontent')
                </router-view>
            </div>
            <!-- END: Content -->
        </div>
        
</div>
        <!-- BEGIN: JS Assets-->
        <script src="https://unpkg.com/moment@2.26.0/moment.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
        <script src="../dist2/js/app.js"></script>
        <script src="https://kit.fontawesome.com/bd4f972d9b.js" crossorigin="anonymous"></script>
		<script src="{{mix('js/app.js')}}"></script>
        <!-- END: JS Assets-->
    </body>
</html>