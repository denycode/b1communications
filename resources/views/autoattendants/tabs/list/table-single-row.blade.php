<tr>

    <td>{{ $autoAttendant['name'] }}</td>
    <td>{{ $autoAttendant['description'] }}</td>
    <td class="text-center">
        <a
                title="Edit"
                class="btn waves-effect waves-light btn-sm btn-info font-14 edit_autoattendant"
                
                href="javascript:void(0);"
        >
            <i class="fa fa-edit"></i> Edit
        </a>
        <!--href="autoattendants/edit/{{ Crypt::encrypt($autoAttendant['id']) }}"-->
    </td>
</tr>
