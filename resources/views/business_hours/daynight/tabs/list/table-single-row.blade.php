<tr>
    <td>{!! $dDaynight['dest'] !!}</td>
    <td class="text-center">
        <a
                title="Edit"
                class="btn waves-effect waves-light btn-sm btn-info font-14"
                href="businesshours/daynightedit/{!! Crypt::encrypt($dDaynight['ext']) !!}"
        >
            <i class="fa fa-edit"></i> Edit
        </a>
    </td>
</tr>
