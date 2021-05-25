<tr>

    <td>{!! $dDepartment['grpnum'] !!}</td>
    <td>{!! $dDepartment['description'] !!}</td>
    <td>
        @php
            $Strategies = \App\Http\Controllers\Controller::Strategies;
            if(array_key_exists(strtolower($dDepartment['strategy']),$Strategies)){
                echo $Strategies[strtolower($dDepartment['strategy'])];
            }else{
                echo '-';
            }
        @endphp

    </td>
    <td>{!! $dDepartment['grptime'] !!}</td>
    <td>{!! \App\Helpers\Destination::getdestination($dDepartment['postdest']) !!}</td>
    <td>
        @php
        $lists = explode('-',$dDepartment['grplist']);
        @endphp
        @foreach($lists as $list)
            <span class="badge badge-pill badge-info font-14">{!! str_replace('#',' (External)',$list) !!}</span>
        @endforeach
    </td>
    <td class="text-center">

        <a
                title="Edit"
                class="btn waves-effect waves-light btn-sm btn-info font-14"
                href="department/edit/{!! Crypt::encrypt($dDepartment['grpnum']) !!}"
        >
            <i class="fa fa-edit"></i> Edit
        </a>
    </td>
</tr>
