<tr>

    <td>
        {!! $oServer->username !!}

    </td>

    <td>
        {!! $oServer->host !!}
    </td>


    <td>
        {!! $oServer->dbname !!}
    </td>
     <td>
        {!! $oServer->password !!}
    </td>

    <td>
        
        @if($oServer->is_active)
            <a href="server/changestatus/{{ Crypt::encrypt($oServer->id) }}" class="ajax-Link"><i class="fas fa-check"></i> </a>
        @else
            <a href="server/changestatus/{{ Crypt::encrypt($oServer->id) }}" class="ajax-Link"><i class="fas fa-times"></i> </a>
        @endif
       
    </td>

    <td>
        <a
                title="Edit"
                class="btn waves-effect waves-light btn-sm btn-info font-14"
                href="server/edit/{{ Crypt::encrypt($oServer->id) }}"
        >
            <i class="fa fa-edit"></i> Edit
        </a>
        
    </td>
</tr>
