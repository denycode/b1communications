@php
    $segment = Request::segment(1);
    $segment2 = Request::segment(2);
@endphp
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @if(\App\Helpers\Helper::CheckPermission(null,'server','view') || Auth::user()->IsAdmin)
                    <li class="{!! ($segment == "server" || $segment == "servers") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/servers') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-server"></i>
                            <span class="hide-menu">
                                Servers
                            </span>
                        </a>
                    </li>
                @endif

                @if(\App\Helpers\Helper::CheckPermission(null,'organization','view') || Auth::user()->IsAdmin)
                    <li class="{!! ($segment == "organization" || $segment == "organizations") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/organizations') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-layout-media-center-alt"></i>
                            <span class="hide-menu">
                                Organizations
                            </span>
                        </a>
                    </li>
                @endif

                @if(\App\Helpers\Helper::CheckPermission('settings','users','view') || Auth::user()->IsAdmin)
                    <li class="{!! ($segment == "users" || $segment == "users") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/users') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-user"></i>
                            <span class="hide-menu">
                                Users
                            </span>
                        </a>
                    </li>
                    <hr style="border-top: 3px solid rgba(0, 0, 0, .1)">
                @endif

                <li style="background-color: #fcdbdb;">
                    <a
                            class="waves-effect waves-dark"
                            href="javascript:void(0);"
                            aria-expanded="false"
                    >
                        <span class="hide-menu">
                            <label class="font-weight-bold">Editing:</label><br>
                            {{ Auth::user()->organization->organization_name }}
                        </span>
                    </a>
                </li>

                @if(\App\Helpers\Helper::CheckPermission(null,'phonenumber','view') || Auth::user()->IsAdmin)
                    <li class="{!! ($segment == "phonenumber" || $segment == "phonenumbers") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/phonenumbers') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-mobile"></i>
                            <span class="hide-menu">
                            Phone Numbers
                        </span>
                        </a>

                    </li>
                @endif

                @if(\App\Helpers\Helper::CheckPermission(null,'extension','view') || Auth::user()->IsAdmin)
                    <li class="{!! ($segment == "extension" || $segment == "extensions") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/extensions') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-id-badge"></i>
                            <span class="hide-menu">
                                Extensions
                            </span>
                        </a>

                    </li>
                @endif

                @if(\App\Helpers\Helper::CheckPermission(null,'department','view') || Auth::user()->IsAdmin)
                    <li class="{!! ($segment == "department" || $segment == "departments") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/departments') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-layout-grid2"></i>
                            <span class="hide-menu">
                            Departments
                        </span>
                        </a>
                    </li>
                @endif

                @if(\App\Helpers\Helper::CheckPermission(null,'announcement','view') || Auth::user()->IsAdmin)
                    <li class="{!! ($segment == "announcement" || $segment == "announcement") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/announcement') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-announcement"></i>
                            <span class="hide-menu">
                                Announcements
                            </span>
                        </a>

                    </li>
                @endif
                @if(\App\Helpers\Helper::CheckPermission(null,'autoattendants','view') || Auth::user()->IsAdmin)
                <li class="{!! ($segment == "autoattendants" || $segment == "autoattendants") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/autoattendants') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-bag"></i>
                            <span class="hide-menu">
                                Auto Attendants
                            </span>
                        </a>

                    </li>
                @endif
                @if(\App\Helpers\Helper::CheckPermission(null,'businesshours','view') || Auth::user()->IsAdmin)
                <li class="{!! ($segment == "businesshours" || $segment == "timegroups" || $segment == "timecondition") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/businesshours') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-timer"></i>
                            <span class="hide-menu">
                                Business Hours
                            </span>
                        </a>

                    </li>
                @endif

                @if(\App\Helpers\Helper::CheckPermission(null,'chat','view') || Auth::user()->IsAdmin)
                    <li class="{!! ($segment == "chat") ? 'active' : '' !!}">
                        <a
                                class="waves-effect waves-dark"
                                href="{!! URL::to('/chat') !!}"
                                aria-expanded="false"
                        >
                            <i class="ti-comments"></i>
                            <span class="hide-menu">
                            Chat
                        </span>
                        </a>

                    </li>
                @endif

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
