<div class="row border-top">
    <div class="col-md-12 mt-3 mb-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab_extensions" role="tab" aria-selected="false">
                                                    <span class="hidden-sm-up">
                                                        <i class="ti-id-badge"></i>
                                                    </span>
                    <span class="hidden-xs-down">Extensions</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_departments" role="tab" aria-selected="true">
                                                    <span class="hidden-sm-up">
                                                        <i class="ti-layout-grid2"></i>
                                                    </span>
                    <span class="hidden-xs-down">Departments</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_phonenumbers" role="tab" aria-selected="false">
                                                    <span class="hidden-sm-up">
                                                        <i class="ti-mobile"></i>
                                                    </span>
                    <span class="hidden-xs-down">Phone Numbers</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_users" role="tab" aria-selected="false">
                                                    <span class="hidden-sm-up">
                                                        <i class="ti-user"></i>
                                                    </span>
                    <span class="hidden-xs-down">Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_announcements" role="tab" aria-selected="false">
                                                    <span class="hidden-sm-up">
                                                        <i class="ti-announcement"></i>
                                                    </span>
                    <span class="hidden-xs-down">Announcements</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_autoattendant" role="tab" aria-selected="false">
                                                    <span class="hidden-sm-up">
                                                        <i class="ti-bag"></i>
                                                    </span>
                    <span class="hidden-xs-down">Auto Attendants</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_timegroup" role="tab" aria-selected="false">
                                                    <span class="hidden-sm-up">
                                                        <i class="ti-timer"></i>
                                                    </span>
                    <span class="hidden-xs-down">Time Groups</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_condition" role="tab" aria-selected="false">
                                                    <span class="hidden-sm-up">
                                                        <i class="ti-timer"></i>
                                                    </span>
                    <span class="hidden-xs-down">Time Conditions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_daynight" role="tab" aria-selected="false">
                                                    <span class="hidden-sm-up">
                                                        <i class="ti-timer"></i>
                                                    </span>
                    <span class="hidden-xs-down">Day & Night Buttons</span>
                </a>
            </li>

        </ul>
        <!-- Tab panes -->
        <div class="tab-content border border-top-0 pt-2">
            <div class="tab-pane pt-10 active" id="tab_extensions" role="tabpanel">
                <div class="col-md-12">
                    <div class="form-group" id="sortableParent">
                        <label for="exampleInputEmail1">
                            <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                    data-href="{!! URL::to('/organization/unassignedextensions/'.Crypt::encrypt($organization->id)) !!}"
                            >
                                Add
                            </button>
                        </label>

                        <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                            <ul class="list-group l-extensions">
                                @if(isset($eExtensionLists))
                                    @foreach($eExtensionLists as $eExtensionList)
                                        <li class="list-group-item">
                                            {{$eExtensionList->extension}} - {{$eExtensionList->name}}
                                            <a href="javascript:void(0);" data-effectonid="list_extensions" onclick="removeOrgElements($(this),{{$eExtensionList->extension}})" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <?php
                        //echo '<pre>'; print_r($orgExtensions); die;
                        ?>
                        <div class="input-group mb-3">
                            <input type="hidden"
                                   id="list_extensions"
                                   name="extensions"
                                   class="form-control"
                                   value="{!! (!$n) ? implode(',',$orgExtensions) : '' !!}"

                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane pt-10" id="tab_departments" role="tabpanel">
                <div class="col-md-12">
                    <div class="form-group" id="sortableParent">
                        <label for="exampleInputEmail1">
                            <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                    data-href="{!! URL::to('/organization/unassigneddepartments/'.Crypt::encrypt($organization->id)) !!}"
                            >
                                Add
                            </button>
                        </label>

                        <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                            <ul class="list-group l-departments">
                                @if(isset($dDepartmentLists))
                                    @foreach($dDepartmentLists as $dDepartmentList)
                                        <li class="list-group-item">
                                            {{$dDepartmentList->description}}
                                            <a href="javascript:void(0);" data-effectonid="list_departments"  onclick="removeOrgElements($(this),{{$dDepartmentList->grpnum}})" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <?php
                        //echo '<pre>'; print_r($orgExtensions); die;
                        ?>
                        <div class="input-group mb-3">
                            <input type="hidden"
                                   id="list_departments"
                                   name="departments"
                                   class="form-control"
                                   value="{!! (!$n) ? implode(',',$orgDepartments) : '' !!}"

                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane pt-10" id="tab_phonenumbers" role="tabpanel">
                <div class="col-md-12">
                    <div class="form-group" id="sortableParent">
                        <label for="exampleInputEmail1">
                            <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                    data-href="{!! URL::to('/organization/unassignedphonenumbers/'.Crypt::encrypt($organization->id)) !!}"
                            >
                                Add
                            </button>
                        </label>

                        <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                            <ul class="list-group l-phonenumbers">
                                @if(isset($pPhoneNumbersLists))
                                    @foreach($pPhoneNumbersLists as $pPhoneNumbersList)
                                        <li class="list-group-item">
                                            {{\App\Helpers\Helper::format_phonenumber($pPhoneNumbersList->extension) }} - {{$pPhoneNumbersList->description}}
                                            <a href="javascript:void(0);" data-effectonid="list_phonenumbers"  onclick="removeOrgElements($(this),{{$pPhoneNumbersList->extension}})" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <?php
                        //echo '<pre>'; print_r($orgExtensions); die;
                        ?>
                        <div class="input-group mb-3">
                            <input type="hidden"
                                   id="list_phonenumbers"
                                   name="phonenumbers"
                                   class="form-control"
                                   value="{!! (!$n) ? implode(',',$orgPhoneNumbers) : '' !!}"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane pt-10" id="tab_users" role="tabpanel">
                <div class="col-md-12">
                    <div class="form-group" id="sortableParent">

                        {{--<label for="exampleInputEmail1">
                            <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                    data-href="{!! URL::to('/organization/allusers') !!}"
                            >
                                Add
                            </button>
                        </label>--}}

                        <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                            <ul class="list-group l-users">
                                @php $orgUsers = []; @endphp
                                @if(isset($uUsersLists))
                                    @foreach($uUsersLists as $uUsersList)
                                        <li class="list-group-item">
                                            {{$uUsersList->FullName }}
                                            <!--<a href="javascript:void(0);" data-effectonid="list_users"  onclick="removeOrgElements($(this),{{$uUsersList->id }})" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>-->
                                        </li>
                                        @php
                                            array_push($orgUsers,$uUsersList->id)
                                        @endphp
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="input-group mb-3">
                            <input type="hidden"
                                   id="list_users"
                                   name="users"
                                   class="form-control"
                                   value="{!! (!$n) ? implode(',',$orgUsers) : '' !!}"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane pt-10" id="tab_announcements" role="tabpanel">
                <div class="col-md-12">
                    <div class="form-group" id="sortableParent">
                        <label for="exampleInputEmail1">
                            <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                    data-href="{!! URL::to('/organization/unassignedannouncements/'.Crypt::encrypt($organization->id)) !!}"
                            >
                                Add
                            </button>
                        </label>

                        <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                            <ul class="list-group l-announcements">
                                @if(isset($aAnnouncementsLists))
                                    @foreach($aAnnouncementsLists as $aAnnouncementsList)
                                        <li class="list-group-item">
                                            {{$aAnnouncementsList->description}}
                                            <a href="javascript:void(0);" data-effectonid="list_announcements"  onclick="removeOrgElements($(this),{{$aAnnouncementsList->announcement_id}})" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="input-group mb-3">
                            <input type="hidden"
                                   id="list_announcements"
                                   name="announcements"
                                   class="form-control"
                                   value="{!! (!$n) ? implode(',',$orgAnnouncements) : '' !!}"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane pt-10" id="tab_autoattendant" role="tabpanel">
                <div class="col-md-12">
                    <div class="form-group" id="sortableParent">
                        <label for="exampleInputEmail1">
                            <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                    data-href="{!! URL::to('/organization/unassignedautoattendants/'.Crypt::encrypt($organization->id)) !!}"
                            >
                                Add
                            </button>
                        </label>

                        <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                            <ul class="list-group l-autoattendants">
                                @if(isset($aAutoattendantsLists))
                                    @foreach($aAutoattendantsLists as $aAutoattendantsList)
                                        <li class="list-group-item">
                                            {{$aAutoattendantsList->name}}
                                            <a href="javascript:void(0);" data-effectonid="list_autoattendants"  onclick="removeOrgElements($(this),{{$aAutoattendantsList->id}})" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="input-group mb-3">
                            <input type="hidden"
                                   id="list_autoattendants"
                                   name="autoattendants"
                                   class="form-control"
                                   value="{!! (!$n) ? implode(',',$orgAutoattendants) : '' !!}"
                            />
                        </div>
                    </div>
                </div>
            </div>
        <div class="tab-pane pt-10" id="tab_timegroup" role="tabpanel">
                <div class="col-md-12">
                    <div class="form-group" id="sortableParent">
                        <label for="exampleInputEmail1">
                            <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                    data-href="{!! URL::to('/organization/unassignedtimegroups/'.Crypt::encrypt($organization->id)) !!}"
                            >
                                Add
                            </button>
                        </label>

                        <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                            <ul class="list-group l-timegroups">
                                @if(isset($tTimegroupsLists))
                                    @foreach($tTimegroupsLists as $tTimegroupsList)
                                        <li class="list-group-item">
                                            {{$tTimegroupsList->description}}
                                            <a href="javascript:void(0);" data-effectonid="list_timegroups"  onclick="removeOrgElements($(this),{{$tTimegroupsList->id}})" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="input-group mb-3">
                            <input type="hidden"
                                   id="list_timegroups"
                                   name="timegroups"
                                   class="form-control"
                                   value="{!! (!$n) ? implode(',',$orgTimegroupLists) : '' !!}"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane pt-10" id="tab_condition" role="tabpanel">
                <div class="col-md-12">
                    <div class="form-group" id="sortableParent">
                        <label for="exampleInputEmail1">
                            <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                    data-href="{!! URL::to('/organization/unassignedtimeconditions/'.Crypt::encrypt($organization->id)) !!}"
                            >
                                Add
                            </button>
                        </label>

                        <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                            <ul class="list-group l-timeconditions">
                                @if(isset($tTimeconditionLists))
                                    @foreach($tTimeconditionLists as $tTimeconditionList)
                                        <li class="list-group-item">
                                            {{$tTimeconditionList->displayname}}
                                            <a href="javascript:void(0);" data-effectonid="list_timeconditions"  onclick="removeOrgElements($(this),{{$tTimeconditionList->timeconditions_id}})" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="input-group mb-3">
                            <input type="hidden"
                                   id="list_timeconditions"
                                   name="timeconditions"
                                   class="form-control"
                                   value="{!! (!$n) ? implode(',',$orgTimeconditionLists) : '' !!}"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane pt-10" id="tab_daynight" role="tabpanel">
                <div class="col-md-12">
                    <div class="form-group" id="sortableParent">
                        <label for="exampleInputEmail1">
                            <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                    data-href="{!! URL::to('/organization/unassigneddaynights/'.Crypt::encrypt($organization->id)) !!}"
                            >
                                Add
                            </button>
                        </label>

                        <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                            <ul class="list-group l-daynights">
                               @if(isset($tDaynightLists))
                                    @foreach($tDaynightLists as $tDaynightList)
                                        <li class="list-group-item">
                                            {{$tDaynightList->dest}}
                                            <a href="javascript:void(0);" data-effectonid="list_daynights"  onclick="removeOrgElements($(this),{{$tDaynightList->ext}})" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="input-group mb-3">
                            <input type="hidden"
                                   id="list_daynights"
                                   name="daynights"
                                   class="form-control"
                                   value="{!! (!$n) ? implode(',',$organizationDaynights) : '' !!}"
                            />
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
