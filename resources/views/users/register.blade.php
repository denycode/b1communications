@extends('layouts.guest')
@section('content')
    <div class="login-box card">
        <div class="card-body">
            <form class="form-horizontal form-material ajax-Form" id="loginform" action="/postregister" method="post">
                {!! csrf_field() !!}
                <h3 class="text-center m-b-20">Join the Program</h3>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" name="company_name" placeholder="Company Name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" name="first_name" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" name="last_name" placeholder="Last Name">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" name="email" placeholder="Email" autocomplete="off">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password" placeholder="Password"
                               autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="confirm_password"
                               placeholder="Confirm Password">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_agree" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">I agree to all <a
                                        href="javascript:void(0)">Terms</a></label>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center p-b-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light"
                                type="submit">Sign Up
                        </button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        Already have an account? <a href="/login" class="text-info m-l-5"><b>Sign
                                In</b></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop