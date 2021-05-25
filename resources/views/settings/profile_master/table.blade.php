<div class="p-0">

    <div class="table-responsive m-t-10">
        @if(\App\Helpers\Helper::CheckPermission('settings','profile','add') || Auth::user()->IsAdmin)
            <a
                    href="settings/addprofile/{{Crypt::encrypt(0)}}"
                    class="btn waves-effect waves-light btn-rounded btn-info pull-right ajax-Link"
            >
                <i class="fa fa-plus-circle"></i>
                New Profile
            </a>
        @endif
        <div class="all-pagination"></div>
        @include('settings.profile_master.pagination')
    </div>

</div>
