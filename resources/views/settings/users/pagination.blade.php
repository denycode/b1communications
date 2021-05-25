@if(count($users) > 0)
    <table class="table table-bordered table-striped table-hover lkp-table">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Profile</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{!! $user->first_name !!}</td>
                <td>{!! $user->last_name !!}</td>
                <td>{!! $user->email !!}</td>
                <td>{!! $user->profile->profile_name !!}</td>
                <td>
                    @if(\App\Helpers\Helper::CheckPermission('settings','users','edit') || Auth::user()->IsAdmin)
                        @if($user->is_active)
                            <a href="settings/changeuserstatus/{{ Crypt::encrypt($user->id) }}" class="ajax-Link"><i class="fas fa-check"></i> </a>
                        @else
                            <a href="settings/changeuserstatus/{{ Crypt::encrypt($user->id) }}" class="ajax-Link"><i class="fas fa-times"></i> </a>
                        @endif
                    @endif
                </td>
                <td>
                    @if(\App\Helpers\Helper::CheckPermission('settings','users','edit') || Auth::user()->IsAdmin)
                        <a
                                href="javascript:void(0);"
                                data-href="settings/adduser/{{ Crypt::encrypt($user->id) }}"
                                class="ajax-Link btn waves-effect waves-light btn-sm btn-info font-14"
                        >
                            <i class="far fa-edit"></i>
                            Edit
                        </a>
                    @endif

                    @if(\App\Helpers\Helper::CheckPermission('settings','users','trash') || Auth::user()->IsAdmin)
                        <a
                                data-title="Are you sure want to delete this user ?"
                                data-confirm="true" 
                                href="settings/deleteuser/{{ Crypt::encrypt($user->id) }}"
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
