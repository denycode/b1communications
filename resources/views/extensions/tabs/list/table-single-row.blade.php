<tr>

    <td>{{ $eExtension['extension'] }}</td>
    <td>{{ ucfirst($eExtension['name']) }}</td>
    <td class="text-center">
        <a
                title="Edit"
                class="btn waves-effect waves-light btn-sm btn-info font-14"
                href="extension/edit/{{ Crypt::encrypt($eExtension['extension']) }}"
        >
            <i class="fa fa-edit"></i> Edit
        </a>
    </td>
</tr>
