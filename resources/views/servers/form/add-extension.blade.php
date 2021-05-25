<?php
$n = isset($extension) ? false : true;
$outboundNumber = ''; $outboundName = '';
if(isset($extension->outboundcid)){
    $outb = explode(' <',$extension->outboundcid);
    $outboundName = str_replace('"','',$outb[0]);
    $outboundNumber = str_replace('>','',$outb[1]);
}
?>
<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/extension/update') !!}">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Extension</label>
                <input type="text" class="form-control" id="extension" aria-describedby="emailHelp"
                       name="extension" readonly placeholder=""
                       value="{!! isset($extension->extension) ? $extension->extension : '' !!}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control"
                       aria-describedby="emailHelp"
                       name="name"
                       value="{!! !empty($extension->name) ? $extension->name : '' !!}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Outbound Number</label>
                <select name="outboundnumber" class="form-control">
                    <option value="">Select</option>
                    @foreach($pPhoneNumbers as $pPhoneNumber)
                        <option
                                {!! $pPhoneNumber->phone_number == $outboundNumber ? 'selected' : '' !!}
                                value="{!! $pPhoneNumber->phone_number !!}"
                        >
                            {!! \App\Helpers\Helper::format_phonenumber($pPhoneNumber->phone_number) !!}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Outbound Name</label>
                <input type="text" class="form-control"
                       aria-describedby="emailHelp"
                       name="outboundname"
                       value="{!! $outboundName !!}">
            </div>
        </div>
    </div>

    <div class="form-actions pull-right">
        <button type="submit" class="btn waves-effect waves-light btn-success">
            <?= !$n ? 'Update' : 'Add' ?></button>
        <a
                href="{!! route('extension.index') !!}"
                type="button"
                class="btn waves-effect waves-light btn-secondary"
        >
            Cancel
        </a>
    </div>

</form>
