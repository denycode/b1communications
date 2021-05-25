@extends('layouts.docker')
@section('content')
    <link href="{!! URL::to('/css/pages/error-pages.css') !!}" rel="stylesheet">
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h2>404</h2>
                <h3 class="text-uppercase">Organization Not Found !</h3>
                <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
                <a href="{{ $redirectTo }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a>
            </div>

        </div>
    </section>
@stop
