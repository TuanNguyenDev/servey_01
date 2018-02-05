<div class="clear temp-other{{ $number }}"></div>
<div class="temp div-content-answer answer-other{{ $number }}">
    <div class="row">
        <div class="col-md-1 col-xs-1"><i class="fa fa-square-o"></i></div>
        <div class="col-md-9 col-xs-7">
            <div class="container-text-other div-text-answer">
                {!! Form::textarea("txt-question[answers][$number][][" . config('survey.type_other_checkbox') . "]", '', [
                    'class' => 'form-control textarea-question validate',
                    'placeholder' => trans('home.other'),
                    'readonly' => 'true',
                ]) !!}
            </div>
        </div>
        <div class="remove-answer col-md-2 col-xs-2">
            <a class="glyphicon glyphicon-remove remove-other" id-qs="{{ $number }}" num="{{ $number }}"></a>
        </div>
    </div>
</div>
