<div class="p-0">

    <div class="table-responsive m-t-10">
        @if(\App\Helpers\Helper::CheckPermission('settings','users','add') || Auth::user()->IsAdmin)
            <a
                    class="btn waves-effect waves-light btn-rounded btn-info pull-right ajax-Link"
                    href="settings/adduser/{{Crypt::encrypt(0)}}"
            >
                <i class="fa fa-plus-circle"></i>
                New User
            </a>
        @endif
        <div class="all-pagination"></div>
        @include('settings.users.pagination')
    </div>

</div>
