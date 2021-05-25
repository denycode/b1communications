@if(count($profiles) > 0)
    <table class="table table-bordered table-striped table-hover lkp-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($profiles as $profile)
            <tr>
                <td>
                    <a
                            class="ajax-Link"
                            href="settings/permission/{{Crypt::encrypt($profile->profile_id)}}"
                    >
                        {!! $profile->profile_name !!}
                    </a>
                </td>

                <td>
                    @if(\App\Helpers\Helper::CheckPermission('settings','profile','edit') || Auth::user()->IsAdmin)
                        @if($profile->is_active)
                            <a href="settings/changeprofilestatus/{{ Crypt::encrypt($profile->profile_id) }}" class="ajax-Link"><i class="fas fa-check"></i> </a>
                        @else
                            <a href="settings/changeprofilestatus/{{ Crypt::encrypt($profile->profile_id) }}" class="ajax-Link"><i class="fas fa-times"></i> </a>
                        @endif
                    @endif
                </td>
                <td>
                    @if(\App\Helpers\Helper::CheckPermission('settings','profile','edit') || Auth::user()->IsAdmin)
                    <a
                            href="javascript:void(0);"
                            data-href="settings/addprofile/{{ Crypt::encrypt($profile->profile_id) }}"
                            class="ajax-Link btn waves-effect waves-light btn-sm btn-info font-14"
                    >
                        <i class="far fa-edit"></i>

                        Edit
                    </a>
                    @endif

                    @if(\App\Helpers\Helper::CheckPermission('settings','profile','trash') || Auth::user()->IsAdmin)
                    <a
                            href="javascript:void(0);"
                            data-title="Are you sure want to delete this profile ?"
                            data-confirm="true" href="settings/deleteprofile/{{ Crypt::encrypt($profile->profile_id) }}"
                            class="ajax-Link btn waves-effect waves-light btn-sm btn-danger"
                    >
                        <i class="fas fa-trash"></i>
                    </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else

@endif
