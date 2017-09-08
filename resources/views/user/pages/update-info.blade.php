@extends('user.master')
@section('content')
    <div class="survey_container animated zoomIn wizard" novalidate="novalidate">
        <div class="top-wizard-register">
            <strong class="tag-wizard-top">
                {{ trans('user.update_info') }}
            </strong>
        </div>
        {!! Form::open([
            'action' => 'User\UserController@update',
            'method' => 'PUT',
            'enctype' => 'multipart/form-data',
            'id' => 'updateInfo',
            'transEmailError' => trans('validation.msg.email'),
            'transFileError' => trans('validation.msg.file'),
        ]) !!}
            <div id="middle-wizard" class="wizard-register wizard-branch wizard-wrapper">
                <div class="step wizard-step current">
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
                    <div class="row">
                        <h3 class="label-header col-md-10 wizard-header">
                            {{ trans('user.enter_info') }}
                        </h3>
                        <div class="col-md-6">
                            <ul class="data-list">
                                <li>
                                    <div class="container-infor">
                                        {!! Html::image(config('settings.image_system') . 'email.png', '') !!}
                                        {!! Form::email('email', cleanText($user->email), [
                                            'placeholder' => trans('user.your_email'),
                                            'id' => 'email',
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </li>
                                <li>
                                    <div class="container-infor">
                                        {!! Html::image(config('settings.image_system') . 'name.png', '') !!}
                                        {!! Form::text('name', cleanText($user->name), [
                                            'placeholder' => trans('user.your_name'),
                                            'id' => 'name',
                                            'class' => 'required form-control',
                                        ]) !!}
                                    </div>
                                </li>
                                <li>
                                    <div class="container-infor">
                                        {!! Html::image(config('settings.image_system') . 'birthday3.png', '') !!}
                                        {!! Form::text('birthday', cleanText($user->birthday), [
                                            'placeholder' => trans('user.birthday'),
                                            'class' => 'frm-datepicker form-control',
                                        ]) !!}
                                    </div>
                                </li>
                                <li>
                                    <div class="container-infor">
                                        {!! Html::image(config('settings.image_system') . 'phone.png', '') !!}
                                        {!! Form::text('phone', cleanText($user->phone), [
                                            'placeholder' => trans('user.phone'),
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </li>
                                <li>
                                    <div class="container-infor">
                                        {!! Html::image(config('settings.image_system') . 'address.png', '') !!}
                                        {!! Form::text('address', cleanText($user->address), [
                                            'placeholder' => trans('user.address'),
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="data-list">
                                <li>
                                    <div class="container-infor">
                                        {!! Html::image(config('settings.image_system') . 'lock3.png', '') !!}
                                        {!! Form::password('old-password', [
                                            'id' => 'old-password',
                                            'class' => 'form-control',
                                            'placeholder' => trans('user.old_password'),
                                        ]) !!}
                                    </div>
                                </li>
                                <li>
                                    <div class="container-infor">
                                        {!! Html::image(config('settings.image_system') . 'lock2.png', '') !!}
                                        {!! Form::password('password', [
                                            'id' => 'password',
                                            'class' => 'form-control',
                                            'placeholder' => trans('user.new_password'),
                                        ]) !!}
                                    </div>
                                </li>
                                <div class="container-infor">
                                    {!! Html::image(config('settings.image_system') . 'lock3.png', '') !!}
                                    {!! Form::password('password_confirmation', [
                                        'id' => 'password-confirm',
                                        'class' => 'form-control',
                                        'placeholder' => trans('user.retype_new_password'),
                                    ]) !!}
                                </div>
                                <li>
                                    <div class="row">
                                        <div class="avatar-img col-md-2">
                                            {{ trans('user.avatar') }}
                                        </div>
                                         <div class="col-md-2">
                                           {!! Html::image($user->image, '', [
                                                'class' => 'img-avatar',
                                           ]) !!}
                                        </div>
                                        <div class="col-md-7">
                                            {!! Form::button('<span class="glyphicon glyphicon-picture span-menu"></span>' . trans('user.chooser_new_image'), [
                                                'id' => 'image',
                                                'class' => 'choose-image',
                                            ]) !!}
                                            {!! Form::file('imageUser', [
                                                'id' => 'imageUser',
                                                'class' => 'form-control button-file-hidden',
                                            ]) !!}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="gender-option data-list floated clearfix">
                                <li>
                                    <div class="type-radio-answer row">
                                        <div class="box-radio col-md-1">
                                            {{ Form::radio('gender', config('users.gender.male'), '', [
                                                'id' => 'gender-male',
                                                'class' => 'input-radio',
                                                ($user->gender == config('users.gender.male')) ? 'checked' : null,
                                            ]) }}
                                            {{ Form::label('gender-male', ' ', [
                                                'class' => 'label-radio',
                                            ]) }}
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                        <div class="col-md-8">{{ trans('info.male') }}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="type-radio-answer row">
                                        <div class="box-radio col-md-1">
                                            {{ Form::radio('gender', config('users.gender.female'), '', [
                                                'id' => 'gender-female',
                                                'class' => 'input-radio',
                                                ($user->gender == config('users.gender.female')) ? 'checked' : null,
                                            ]) }}
                                            {{ Form::label('gender-female', ' ', [
                                                'class' => 'label-radio',
                                            ]) }}
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                        <div class="col-md-8">{{ trans('info.female') }}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="type-radio-answer row">
                                        <div class="box-radio col-md-1">
                                            {{ Form::radio('gender', config('users.gender.other_gender'), '', [
                                                'id' => 'gender-other',
                                                'class' => 'input-radio',
                                                ($user->gender == config('users.gender.other_gender')) ? 'checked' : null,
                                            ]) }}
                                            {{ Form::label('gender-other', ' ', [
                                                'class' => 'label-radio',
                                            ]) }}
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                        <div class="col-md-8">{{ trans('info.other_gender') }}</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                         <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                @include('user.blocks.validate')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="bottom-wizard" class="bottom-wizard-register">
                {!! Form::submit(trans('user.update'), [
                    'class' => 'bt-register forward',
                ]) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection
@section('content-info-web')
    @include('user.blocks.info-web')
@endsection
