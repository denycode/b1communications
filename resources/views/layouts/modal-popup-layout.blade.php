<div id="modal-popup" class="modal " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered {{isset($size) ? $size : ''}}">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title pl-2" id="myModalLabel">{{$title}}</h6>
                <button type="button" class="close pr-3" data-dismiss="modal" aria-label="Close" style="background: transparent;"><i class="fas fa-times-circle" style="color: #d9d7d7;"></i></button>
            </div>
            <div class="modal-body" style="margin: 7px;">
                {!! $content !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
