@extends('user.master')
@section('content')
    <div class="survey_container animated zoomIn wizard" novalidate="novalidate">
        <div class="reload-page{{ $survey->id }} reload-page row">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert warning-center animated fadeInDown">
                    <span class="glyphicon glyphicon-alert"></span>
                    {{ trans('result.reload.first') }}
                    <a href="{{ action(($survey->feature)
                        ? 'AnswerController@answerPublic'
                        : 'AnswerController@answerPrivate', $survey->token) }}">
                        {{ trans('result.reload.second') }}
                    </a>
                    {{ trans('result.reload.last') }}
                </div>
            </div>
        </div>
        <div id="top-wizard" class="top-wizard{{ $survey->id }}">
            <div class="menu-wizard{{ $survey->id }} container-menu-wizard row">
                @if (!$access[config('settings.key.hideResult')] || ($survey->user_id == auth()->id()))
                    <div class="menu-wizard col-md-5 active-answer active-menu">
                        {{ trans('result.answer') }}
                    </div>
                    <div class="menu-wizard col-md-5 active-result col-md-offset-1">
                        {{ trans('result.result') }}
                    </div>
                @else
                    <div class="menu-wizard col-md-8 col-md-offset-2 active-answer active-menu">
                        {{ trans('result.answer') }}
                    </div>
                @endif
            </div>
            <div class="shadow"></div>
        </div>
        <div class="container-list-answer">
            <div class="del-survey{{ $survey->id }} del-survey animated zoomIn">
                {!! Html::image(config('settings.image_system') . 'remove.png', '', [
                    'class' => 'img-remove-survey',
                ]) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="alert alert-danger warning-center">
                            <span class="glyphicon glyphicon-alert"></span>
                            {{ trans('result.sorry_user') }}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::open([
                'class' => 'wizard-form',
                'novalidate' => 'novalidate',
                'action' => ['ResultController@result', $survey->token],
                'method' => 'POST',
            ]) !!}
                <div class="container-answer{{ $survey->id }} container-answer wizard-branch wizard-wrapper">
                    <div class="get-title-survey">
                        {{ $survey->title }}
                    </div>
                    <div class="description-survey">
                        <h4>
                            {!! cleanText($survey->description) !!}
                        </h4>
                    </div>
                    <div class="row"></div>
                    <div class="alert alert-info save-message-success alert-message"></div>
                    <div class="alert alert-danger save-message-fail alert-message"></div>
                    @if (Session::has('message'))
                        <div class="alert alert-info alert-message">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if (Session::has('message-fail'))
                        <div class="alert alert-danger alert-message">
                            {{ Session::get('message-fail') }}
                        </div>
                    @endif
                    <div class="container-all-question step row wizard-step ">
                       <div class="container-survey" id="container-survey">
                           @include('user.component.temp-answer')
                       </div>
                    </div>
                </div>
                <div class="required-user" data-require="{{ $access[config('settings.key.tailMail')] }}">
                    <div class="row">
                        @if (in_array(config('settings.key.requireAnswer'), array_keys($access))
                            && $access[config('settings.key.requireAnswer')]
                        )
                            @switch($access[config('settings.key.requireAnswer')])
                                @case(config('settings.require.email'))
                                    <div class="div-require-info">
                                        {{ trans('survey.label.require_email') }}
                                        @if ($access[config('settings.key.tailMail')])
                                            ({{ trans('survey.label.require_tailmail') . $access[config('settings.key.tailMail')] }})
                                        @endif
                                    </div>
                                    <div class="col-md-5 col-md-offset-1">
                                        <div class="container-infor">
                                            {!! Html::image(config('settings.image_system') . 'email1.png', '') !!}
                                            {!! Form::email('email-answer', auth()->check()
                                                ? auth()->user()->email
                                                : old('email-answer'), [
                                                    'id' => 'email',
                                                    'class' => 'frm-require-answer form-control',
                                                    'placeholder' => trans('login.your_email'),
                                            ]) !!}
                                            {!! Form::label('email', trans('validation.msg.required'), [
                                                'class' => 'require-email wizard-hidden error',
                                            ]) !!}
                                            {!! Form::label('email', trans('validation.msg.email'), [
                                                'class' => 'validate-email wizard-hidden error',
                                            ]) !!}
                                        </div>
                                        @if ($errors->has('email-answer'))
                                            <div class="alert alert-danger alert-message">
                                                {{ $errors->first('email-answer') }}
                                            </div>
                                        @endif
                                    </div>
                                    @breakswitch
                                @case(config('settings.require.name'))
                                    <div class="div-require-info">
                                        {{ trans('survey.label.require_name') }}
                                    </div>
                                    <div class="col-md-5 col-md-offset-1">
                                        <div class="container-infor">
                                            {!! Html::image(config('settings.image_system') . 'name.png', '') !!}
                                            {!! Form::text('name-answer', auth()->check()
                                                ? auth()->user()->name
                                                : old('name-answer'), [
                                                    'placeholder' => trans('login.your_name'),
                                                    'id' => 'name',
                                                    'class' => 'frm-require-answer form-control',
                                                    auth()->check() ? 'readonly' : null,
                                            ]) !!}
                                            {!! Form::label('name', trans('validation.msg.required'), [
                                                'class' => 'require-name wizard-hidden error',
                                            ]) !!}
                                        </div>
                                        @if ($errors->has('name-answer'))
                                            <div class="alert alert-danger alert-message">
                                                {{ $errors->first('name-answer') }}
                                            </div>
                                        @endif
                                    </div>
                                    @breakswitch
                                @default
                                    <div class="div-require-info">
                                        {{ trans('survey.label.require_both') }}
                                        @if ($access[config('settings.key.tailMail')])
                                            ({{ trans('survey.label.require_tailmail') . $access[config('settings.key.tailMail')] }})
                                        @endif
                                    </div>
                                    <div class="col-md-5 col-md-offset-1">
                                        <div class="container-infor">
                                            {!! Html::image(config('settings.image_system') . 'email1.png', '') !!}
                                            {!! Form::email('email-answer', auth()->check()
                                                ? auth()->user()->email
                                                : old('email-answer'), [
                                                    'id' => 'email',
                                                    'class' => 'frm-require-answer form-control',
                                                    'placeholder' => trans('login.your_email'),
                                            ]) !!}
                                            {!! Form::label('email', trans('validation.msg.required'), [
                                                'class' => 'require-email wizard-hidden error',
                                            ]) !!}
                                            {!! Form::label('email', trans('validation.msg.email'), [
                                                'class' => 'validate-email wizard-hidden error',
                                            ]) !!}
                                        </div>
                                        @if ($errors->has('email-answer'))
                                            <div class="alert alert-danger alert-message">
                                                {{ $errors->first('email-answer') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="container-infor">
                                            {!! Html::image(config('settings.image_system') . 'name.png', '') !!}
                                            {!! Form::text('name-answer', auth()->check()
                                                ? auth()->user()->name
                                                : old('name-answer'), [
                                                    'placeholder' => trans('login.your_name'),
                                                    'id' => 'name',
                                                    'class' => 'frm-require-answer form-control',
                                                    auth()->check() ? 'readonly' : null,
                                            ]) !!}
                                            {!! Form::label('name', trans('validation.msg.required'), [
                                                'class' => 'require-name wizard-hidden error',
                                            ]) !!}
                                        </div>
                                        @if ($errors->has('name-answer'))
                                            <div class="alert alert-danger alert-message">
                                                {{ $errors->first('name-answer') }}
                                            </div>
                                        @endif
                                    </div>
                                    @breakswitch
                            @endswitch
                        @endif
                    </div>
                    @if (Session::has('message-validate-tailmail'))
                        <div class="row">
                            <div class="col-md-5 col-md-offset-1">
                                <div class="alert alert-danger alert-message">
                                    {{ Session::get('message-validate-tailmail') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div id="bottom-wizard" class="bot-wizard{{ $survey->id }}">
                    <div class="shadow-bottom"></div>
                    <div class="option-answer{{ $survey->id }}">
                        @php
                            $check = ($access[config('settings.key.limitAnswer')]
                                && ($access[config('settings.key.limitAnswer')])
                                || !$access[config('settings.key.limitAnswer')]);
                        @endphp
                        @if ($survey->status
                            && (Carbon\Carbon::parse($survey->deadline)->gt(Carbon\Carbon::now()) || empty($survey->deadline))
                            && $check)
                            @if (auth()->check())
                                {!! Form::button(trans('home.save'), [
                                    'class' => 'submit-answer btn btn-info save-survey',
                                    'survey-id' => $survey->id,
                                    'data-url' => action('User\SaveTempController@store'),
                                    'feature' => $survey->feature,
                                    'user-id' => $survey->user_id,
                                    'id' => 'btn-save',
                                ]) !!}
                                @if (auth()->user()->ofTemp($survey->id)->exists())
                                    {!! Form::button(trans('home.load'), [
                                        'class' => 'submit-answer btn btn-info show-survey',
                                        'survey-id' => $survey->id,
                                        'data-url' => action('User\SaveTempController@show'),
                                        'id' => 'btn-load',
                                    ]) !!}
                                @endif
                            @endif
                            {!! Form::submit(trans('home.finish'), [
                                'class' => 'submit-answer btn btn-info',
                            ]) !!}
                        @else
                            <div class="notice-expired">
                                <span class="glyphicon glyphicon-alert"></span>
                                {{ trans('result.expired') }}
                            </div>
                        @endif
                    </div>
                    <a href="{{ action('SurveyController@index') }}" class="back-home{{ $survey->id }} back-home">
                        {{ trans('result.back_home') }}
                    </a>
                </div>
            {!! Form::close() !!}
        </div>
        @include('user.pages.result')
    </div>
    <div class="modal fade" id="view-media">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
@endsection
