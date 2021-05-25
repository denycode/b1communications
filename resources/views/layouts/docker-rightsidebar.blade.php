<?php
$userACtiveTheme = \App\Model\UserMeta::where('user_id',Auth::id())->where('meta_key','ACTIVE_THEME')->first();
$default = true;
$themes = [
    [
        'data-skin' => 'skin-default',
        'class' => 'default-theme'
    ],
    [
        'data-skin' => 'skin-green',
        'class' => 'green-theme'
    ],
    [
        'data-skin' => 'skin-red',
        'class' => 'red-theme'
    ],
    [
        'data-skin' => 'skin-blue',
        'class' => 'blue-theme'
    ],
    [
        'data-skin' => 'skin-purple',
        'class' => 'purple-theme'
    ],
    [
        'data-skin' => 'skin-megna',
        'class' => 'megna-theme'
    ],
];

$mytheme = 'default-theme';
if($userACtiveTheme){
    $mytheme = $userACtiveTheme->meta_value;
    $default = false;
}

?>
<div class="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
        <div class="r-panel-body">
            <ul id="themecolors" class="m-t-20">
                <li><b>With Light sidebar</b></li>

                @foreach($themes as $theme)

                    <li class="ajax_theme"><a href="javascript:void(0)" data-skin="{{$theme['data-skin']}}" class="{{$theme['class']}} @if($theme['class'] == $mytheme) working @endif">1</a></li>

                @endforeach

            </ul>
        </div>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function () {
        $('.ajax_theme').on('click',function () {
            var aTheme = $(this).children('a').attr('class');
            ACFn.sendAjax(
                '{!! URL::to('/user/metadata') !!}',
                'POST',
                {
                    _token : '{{csrf_token()}}',
                    u_dataid : '{{Auth::user()->id}}',
                    meta_key : 'ACTIVE_THEME',
                    meta_value : aTheme,
                }
            )
        })
    })
</script>
