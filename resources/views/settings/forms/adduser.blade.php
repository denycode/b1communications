<?php
$n = isset($user) && !empty($user) ? false : true;
?>

<div class="card">
    <div class="form-body">
        <div class="card-body">
            <form class="ajax-Form" enctype="multipart/form-data" method="post" action="settings/adduser">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name</label>
                            <input type="text" name="first_name" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   placeholder=""
                                   value="<?= (!$n) ? $user->first_name : ''; ?>"
                            >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Last Name</label>
                            <input type="text" name="last_name" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   placeholder=""
                                   value="<?= (!$n) ? $user->last_name : ''; ?>"
                            >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   <?= (!$n) ? 'readonly' : '' ?>
                                   placeholder=""
                                   value="<?= (!$n) ? $user->email : ''; ?>"
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone</label>
                            <input type="phone" name="phone" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   <?= (!$n) ? 'readonly' : '' ?>
                                   placeholder=""
                                   value="<?= (!$n) ? $user->phone : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   placeholder=""
                                   value="">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="control-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   placeholder=""
                                   value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="control-label">Server</label>
                            
                            <select name="servdre_id" class="form-control custom-select servdre_id"
                            <?= ( !$n && isset($user) && $user->profile->profile_name == 'CSR' ) ? 'disabled readonly' : ''; ?>>
                                <option value="">Select Server</option>
                                @if($servers)
                                    @foreach($servers as $server)
                                        <option  <?= (!$n && isset($user) && $server_id == $server->id) ? 'selected' : ''; ?> value="{{$server->id}}">{{$server->name}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="control-label">Organization</label>
                            <select name="organization_id" id="organization_id" class="form-control custom-select" <?= (!$n && isset($user) && $user->profile->profile_name == 'CSR' ) ? 'disabled readonly' : ''; ?>>
                                <option value="">Select Organization</option>
                               @if($Organizations)
                                    @foreach($Organizations as $Organization)
                                        <option  <?= (!$n && isset($user) && $user->organization_id == $Organization['id']) ? 'selected' : ''; ?> value="{{$Organization['id']}}">{{$Organization['organization_name']}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="control-label">Country</label>
                            <input type="text" name="country" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   placeholder=""
                                   value="<?= (!$n) ? $user->country : ''; ?>">
                        </div>
                    </div>

                </div>

                

                <div class="row">
                    @if(Auth::user()->IsAdmin)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="control-label">Profile</label>
                                <select name="profile_id" class="form-control custom-select">
                                    <option value="">Select Profile</option>
                                    @if($profiles)
                                        @foreach($profiles as $profile)
                                            <option  <?= (!$n && isset($user) && $user->profile_id == $profile->profile_id) ? 'selected' : ''; ?> value="{{$profile->profile_id}}">{{$profile->profile_name}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>

                        @else
                            <input type="hidden" name="profile_id" value="{!! \App\User::ENDUSER !!}">
                    @endif

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="control-label"></label>
                            <div class="custom-control custom-checkbox mr-sm-2 mt-2 mb-3">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="checkbox0" value="1" <?= (!$n && isset($user) && $user->is_active == 1) ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="checkbox0">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions pull-right">
                    <input type="hidden" name="id" value="<?= (!$n) ? $user->id : '0'; ?>">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> <?= (!$n) ? 'Update' : 'Save'; ?></button>
                    <button type="reset" class="btn waves-effect waves-light btn-secondary">Cancel</button>

                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.servdre_id').change(function(){
        var data_arr = { id :$(this).val() };
        ACFn.sendAjax('http://cp.b1communications.ca/pbx/user/getOrganization','POST',data_arr,$('#organization_id'));
        ACFn.ajax_organization_steps = function (F , R){
            F.find('option').remove();
            F.append(new Option('Select Organization', ''));
           
            $.each(R.Organization, function(key, value) {

               F.append(new Option(value.organization_name, value.id));
            });
        }
        });
    });
</script>