<tr>
    <td>
        {!! $timecondition->displayname !!}
    </td>
    <td>
        {!! \App\Helpers\Destination::getdestination($timecondition->truegoto); !!}
    </td>
    <td>
        {!! \App\Helpers\Destination::getdestination($timecondition->falsegoto); !!}
    </td>
    <td class="text-center">
        <a
                title="View Details"
                class="btn waves-effect waves-light btn-sm btn-info font-14"
                href="businesshours/timeconditiondetail/{{ Crypt::encrypt($timecondition->timeconditions_id) }}"
        ><i class="fa fa-eye"></i> Details
        </a>
    </td>
</tr>

