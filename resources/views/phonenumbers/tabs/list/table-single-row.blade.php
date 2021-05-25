<tr>

    <td>{!! !empty($pPhoneNumber['extension']) ? \App\Helpers\Helper::format_phonenumber($pPhoneNumber['extension']) : '' !!}</td>
    <td>{!! $pPhoneNumber['description'] !!}</td>
    <td>{!! \App\Helpers\Destination::getdestination($pPhoneNumber['destination']); !!}</td>
    <td class="text-center">
        @if(Auth::user()->IsCSR || Auth::user()->IsAdmin)
            <a
                    href="javascript:void(0);"
                    title="SMS Compatible"
                    class="btn waves-effect waves-light btn-sm @if($pPhoneNumber['extension'] == $sms_compatible_number) btn-success @else btn-info @endif font-14 ajax-Link"
                    data-href="phonenumber/smscompatible/{!! Crypt::encrypt($pPhoneNumber['extension']) !!}"
            >
                <i class="fas fa-comments"></i> SMS Compatible
            </a>
        @endif
        <a
                title="Edit"
                class="btn waves-effect waves-light btn-sm btn-info font-14"
                href="phonenumber/edit/{!! Crypt::encrypt($pPhoneNumber['extension']) !!}"
        >
            <i class="fa fa-edit"></i> Edit
        </a>
    </td>
</tr>
