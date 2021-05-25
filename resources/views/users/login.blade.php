@extends('layouts.guest')
@section('content')
    <div class="login-box card">
        <div class="card-body">
            <form class="ajax-Form form-horizontal form-material" id="loginform" action="login" method="post">
                {{csrf_field()}}
                <h3 class="text-center m-b-20">Login</h3>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" name="email" id="email" type="text"
                               placeholder="Email" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password" id="password"
                               placeholder="Password">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkbox-signup"
                                       name="remember">
                                <label class="custom-control-label" for="customCheck1">Remember me</label>
                            </div>
                            <div class="ml-auto">
                                <a href="javascript:void(0)" id="to-recover" class="text-muted"><i
                                            class="fas fa-lock m-r-5"></i> Forgot password</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-xs-12 p-b-20">
                        <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Log In</button>

                    </div>
                </div>
                <!--
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                        <div class="social">
                            <button class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fab fa-facebook-f"></i> </button>
                            <button class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fab fa-google-plus-g"></i> </button>
                        </div>
                    </div>
                </div>
                -->
                {{--<div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        Don't have an retailer account? <a href="{{isset($is_customer) ? '/customer/enroll/'.$enc_rid.'/'.$enc_pname.'/'.$enc_pprice : '/register'}}" class="text-info m-l-5"><b>Sign Up</b></a>
                    </div>
                </div>--}}
            </form>
            <form class="form-horizontal" id="recoverform" action="index.html">
                <div class="form-group ">
                    <div class="col-xs-12">
                        <h3>Recover Password</h3>
                        <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" required="" placeholder="Email"></div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light"
                                type="submit">Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
