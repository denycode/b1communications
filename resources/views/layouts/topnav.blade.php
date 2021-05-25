<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)"
           data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
        <div class="top-left-part">
            <a class="logo" href="/">
                <b>
                    <!--<img src=""
                       alt="home"/>-->
                </b>
                <span class="hidden-xs">
                        <img
                                src="img/logo.gif" alt="home"/></span>
            </a>
        </div>
        <div class="navbar-default sidebar" role="navigation">
            <ul class="nav navbar-top-links navbar-left side-icon  navbar-collapse slimscrollsidebar" id="side-menu">
                <li>
                    <a href="/" class="waves-effect">
                        <i class="icon-home fa-fw"></i> <span class="hide-menu">Home</span>
                    </a>
                </li>
                <!--
                <li class="dropdown" id="projectdropdownmenu">
                   <a href="/WdProjects" class="waves-effectProjects">
                         class="hide-menu">Projects</span>
                   </a>
                   <ul class="dropdown-menu nav nav-second-level">
                      <li><a href="/WdProjects">Projects</a></li>
                      <li><a href="/WdProjects/mytickets">My Tickets</a></li>
                      <li><a href="/document_v1/show_project?p=1">Docs</a></li>
                      <li><a href="/WdProjects/milestones">Milestones</a></li>
                      <li><a href="/WdProjects/meetings">Meeting Notes</a></li>
                      <li><a href="/wdreports">Reports</a></li>
                   </ul>
                </li>
                <li class="dropdown" id="taskdropdownmenu">
                   <a href="/tasks/list" class="waves-effect"><i data-icon="F"
                      class="linea-icon linea-software fa-fw"></i>
                   <span class="hide-menu">Tasks<span
                      class="label label-rouded label-danger"></span></span></a>


                </li>
                <li id="meetingdropdownmenu">
                   <a href="/minutes-of-meeting" class="waves-effect">
                   <i class="ti-notepad fa-fw"></i> <span class="hide-menu">Meeting Notes</span>
                   </a>
                </li>
                <li id="notedropdownmenu">
                   <a href="/notes" class="waves-effect">
                   <i class="ti-notepad fa-fw"></i> <span class="hide-menu">Notes</span>
                   </a>
                </li>
                <li>
                    <a href="/calendar" class="waves-effect">
                        <i class="ti-calendar fa-fw"></i> <span class="hide-menu">Calendar</span>
                    </a>
                </li>
                -->
                <li>
                    <a href="/docs" class="waves-effect">
                        <i class="icon-folder-alt fa-fw"></i> <span class="hide-menu"> Docs</span>
                    </a>
                </li>


            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right add-icon">
                <!--<li><a data-href="/search/getsearchform" class="ajax-Link" title="search"><i class="ti-search"></i></a></li>

                <li class="text-nowrap dropdown user-pro-body">
                   <a title="Add"
                      href="#" class="dropdown-toggle u-dropdown"
                      data-toggle="dropdown" role="button" aria-haspopup="true"
                      aria-expanded="false"> <i class="icon-plus"></i></a>
                   <ul class="top-icon dropdown-menu animated">
                      <span class="carets"></span>
                      <li><a href="javascript:void(0)" data-href="/tasklist/edit/0" class="ajax-Link " id="addTask"><i
                         class="fa fa-plus"></i> Task</a></li>
                      <li>
                         <a href="javascript:void(0)" data-href="/WdProjects/ticket/edit?project_id=0"
                            class="ajax-Link " id="addTicketwithoutProject"><i class="fa fa-plus"></i> Ticket</a>
                      </li>
                      <li><a href="/minutes-of-meeting/add" target="_blank" data-href="" class=" "
                         id="addMettingNotes"><i class="fa fa-plus"></i> Meeting Note</a></li>
                      <li><a href="javascript:void(0)" data-href="/notes/add/0" class="ajax-Link " id="addTask"><i
                         class="fa fa-plus"></i> Note</a></li>
                      <li><a href="javascript:void(0)" data-href="/events/add/0" class="ajax-Link " id="addEvent"><i
                         class="fa fa-plus"></i> Event</a></li>
                   </ul>
                </li>
                <li>
                   <a href="http://newworkdesk.allengers.net/starred"> <i title="Favourites"
                      class="icon-star"></i></a>
                </li>

                <li class="sticky" id="top-menu"></li> -->
                <!--
                <li onclick="on()" class="right-side-toggle">
                   <a title="Notification" class="waves-effect waves-light"
                      href="javascript:void(0)"
                      onclick="autocomplete('536','notify')">
                      <i class="icon-bell"></i>
                      <div class="notify notification-icon"><span
                         class="label label-rouded label-custom pull-right point"
                         id="countzero"></span>
                      </div>
                   </a>
                </li>
                -->
                <!-- /.dropdown -->
                <!-- /.dropdown -->
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                                src="http://newworkdesk.allengers.net/attachment/user/thumbs/9dfa700c385a0e6acebfd84d13a3e77b402ed684.jpg" alt="user-img" width="36"
                                class="img-circle"><b class="hidden-xs">{{Auth::user()->first_name}}</b> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/profile"><i class="fa fa-user" title="My Profile" aria-hidden="true"></i>My
                                Profile</a>
                        </li>
                        <!--
                        <li><a href="/timeline"><i class="fa fa-line-chart" title="Activity Timeline"
                                                   aria-hidden="true"></i> Activity Timeline</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/feedback"><i title="Suggestions" class="fa fa-question" aria-hidden="true"></i>
                                Suggestions</a>
                        </li>
                        <li style="padding-bottom: 5px;"><a href="/updation"><i title="New Updates"
                                                                                class="fa fa-refresh"
                                                                                aria-hidden="true"></i>New Updates</a>
                        </li>
                        <li>
                            <a href="https://view.officeapps.live.com/op/view.aspx?src=http://workdesk.allengers.net//tutorial/workdesk_manual.docx&embedded=true"
                               target="_blank"><i title="Tutorial" class="fa fa-lightbulb-o" aria-hidden="true"></i>
                                Tutorial</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/setting"><i title="Setting" class="ti-settings"></i> Settings</a></li>
                        <li><a href="https://play.google.com/store/apps/details?id=com.allengers.workdesk"
                               target="_blank"><i title="Mobile App" class="fa fa-android"
                                                  style="color: #54ab19;font-size: 20px;"></i>Mobile
                                App</a>
                        </li>
                        <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm1"><i title="About"
                                                                                                   class="fa fa-info-circle"
                                                                                                   aria-hidden="true"></i>About</a>
                        </li>-->
                        <li><a href="/logout"><i title="Logout" class="fa fa-power-off"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                <!-- /.Megamenu
                   <li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li> -->
            </ul>
        </div>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
</nav>