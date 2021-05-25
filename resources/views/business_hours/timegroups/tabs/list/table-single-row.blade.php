<tr>
    <td>
        {!! $timeGroup->description !!}
    </td>
    <td class="text-center">
        <a
                title="View Details"
                class="btn waves-effect waves-light btn-sm btn-info font-14"
                href="businesshours/timegroupdetail/{{ Crypt::encrypt($timeGroup->id) }}"
        >
            <i class="fa fa-eye"></i> Details
        </a>
    </td>
</tr>
