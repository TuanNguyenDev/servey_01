<div class="detail-survey">
    {!! Form::open([
        'class' => 'tab-save-info',
        'action' => [
            'SurveyController@updateSurvey',
            $survey->id,
        ],
        'method' => 'PUT',
    ]) !!}
        <div class="row">
            <p class="tag-detail-survey">
                {{ $survey->title }}
            </p>
        </div>
        <div class="row">
            <div class="frm-textarea container-infor">
                {!! Html::image(config('settings.image_system') . 'title1.png', '') !!}
                {!! Form::textarea('title', $survey->title, [
                    'class' => 'js-elasticArea form-control',
                    'id' => 'title',
                    'placeholder' => trans('info.title'),
                ]) !!}
            </div>
        </div>
        <div class="row">
            <div class="frm-textarea container-infor dealine-infor">
                {!! Html::image(config('settings.image_system') . 'date.png', '') !!}
                    {!! Form::text('deadline', $survey->deadline
                        ? Carbon\Carbon::parse($survey->deadline)->format(trans('temp.format_with_trans'))
                        : '', [
                            'placeholder' => trans('info.duration'),
                            'id' => 'deadline',
                            'class' => 'frm-deadline datetimepicker form-control',
                    ]) !!}
                    {!! Form::label('deadline', trans('info.date_invalid'), [
                        'class' => 'wizard-hidden validate-time error',
                    ]) !!}
            </div>
        </div>
        <div class="row">
            <div class="frm-textarea container-infor">
                {!! Html::image(config('settings.image_system') . 'description.png', '') !!}
                {!! Form::textarea('description', $survey->description, [
                    'class' => 'js-elasticArea form-control',
                    'placeholder' => trans('info.description'),
                ]) !!}
            </div>
        </div>
        <div class="note-detail-survey">
            {{ trans('survey.link') }}:
            <a href="{{ action(($survey->feature)
                ? 'AnswerController@answerPublic'
                : 'AnswerController@answerPrivate', [
                    'token' => $survey->token,
            ]) }}">
                {{ action(($survey->feature)
                    ? 'AnswerController@answerPublic'
                    : 'AnswerController@answerPrivate', [
                        'token' => $survey->token,
                ]) }}
            </a>
            (<a class="tag-send-email" data-url="{{ action('SurveyController@inviteUser', [
                    'id' => $survey->id,
                    'type' => config('settings.return.view'),
                ]) }}"
                data-type="{{ $survey->feature }}"
                data-link="{{ action('AnswerController@answerPublic', $survey->token) }}">
                <span class="glyphicon glyphicon-send"></span>
                {{ trans('survey.send') }}
            </a>)
        </div>
        <div class="note-detail-survey">
            {{ trans('survey.date_create') }}:
            {{ $survey->created_at->format(trans('info.datetime_format')) }}
        </div>
        @include('user.blocks.validate')
        <div class="container-btn-detail row">
            <div class="col-md-4">
                {!! Form::submit(trans('survey.save'),  [
                    'class' => 'btn-save-survey btn-action',
                ]) !!}
            </div>
            <div class="col-md-4">
               {!! Form::button(trans('survey.delete'),  [
                    'data-url' => action('SurveyController@delete'),
                    'id-survey' => $survey->id,
                    'redirect' => action('SurveyController@listSurveyUser'),
                    'class' => 'btn-remove-survey btn-action',
                ]) !!}
            </div>
            <div class="col-md-4">
               {!! Form::button(trans('survey.close'),  [
                    'data-url' => action('SurveyController@close', $survey->id),
                    'class' => 'btn-close-survey btn-action',
                    ($survey->status == config('survey.status.avaiable')
                        || $survey->deadline > \Carbon\Carbon::now()->toDateTimeString())
                        ? null : 'disabled',
                ]) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>
