<tr>

    <td>
        {!! $oOrganization->organization_name !!}
    </td>

    <td>
        {!! $oOrganization->server->host !!}
    </td>

   {{-- <td>
        {{ $oOrganization->extension_range  }}
    </td>--}}

    <td>
        @if(\App\Helpers\Helper::CheckPermission(null,'organization','edit') || Auth::user()->IsAdmin)
            @if($oOrganization->is_active)
                <a href="organization/changestatus/{{ Crypt::encrypt($oOrganization->id) }}" class="ajax-Link"><i class="fas fa-check"></i> </a>
            @else
                <a href="organization/changestatus/{{ Crypt::encrypt($oOrganization->id) }}" class="ajax-Link"><i class="fas fa-times"></i> </a>
            @endif
        @endif
    </td>

    <td class="text-center">
        @if(\App\Helpers\Helper::CheckPermission(null,'organization','edit') || Auth::user()->IsAdmin)
        <a
                href="javascript:void(0);"
                title="Access"
                class="btn waves-effect waves-light btn-sm @if(Auth::user()->organization_id == $oOrganization->id) btn-success @else btn-info @endif font-14 ajax-Link"
                data-href="organization/access/{!! Crypt::encrypt($oOrganization->id) !!}"
        >
            <i class="fas fa-wrench"></i> Access
        </a>

        <a
                title="Edit"
                class="btn waves-effect waves-light btn-sm btn-info font-14"
                href="organization/edit/{!! Crypt::encrypt($oOrganization->id) !!}"
        >
            <i class="fa fa-edit"></i> Edit
        </a>
        @endif
    </td>

</tr>
