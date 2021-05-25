<table id="basic_table2" class="table table-bordered table-hover color-table lkp-table" data-message="No extensions available">
    <thead>
         <tr>
            <th>Server Name</th>
            <th>Host</th>
            <th>Database Name</th>
            <th>Password</th>
            <th>Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($oServers) > 0)
            @foreach($oServers as $oServer)
                @include('servers.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
