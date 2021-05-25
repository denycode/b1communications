<tr>
    <td>{!! $aAnnouncement['description'] !!}</td>
    <td>{!! \App\Helpers\Destination::getdestination($aAnnouncement['post_dest']); !!}</td>
    <td class="text-center">
        <a
                title="Edit"
                class="btn waves-effect waves-light btn-sm btn-info font-14"
                href="announcement/edit/{!! Crypt::encrypt($aAnnouncement['announcement_id']) !!}"
        >
            <i class="fa fa-edit"></i> Edit
        </a>
    </td>
</tr>
