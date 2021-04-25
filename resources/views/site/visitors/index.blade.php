<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ mix('css/visitors.css', 'vendor/nova-launch') }}" rel="stylesheet"/>
</head>
<body>
<div id="nova-launch-visitors">
    <section class="nova-launch-visitors__section">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 my-5">
                    <div class="card h-100 shadow text-center">
                        <div class="card-header">
                            <h3 class="mb-0">{{ __('nova-launch::visitors.sign_up_heading') }}</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ __('nova-launch::visitors.sign_up_body') }}</p>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ __('nova-launch::visitors.sign_up_success') }}
                                </div>
                            @else
                                <form action="{{ route('nova-launch.visitors.store') }}" method="POST"
                                      class="p-3 rounded">
                                    @csrf

                                    <div class="form-group">
                                        <label for="email">
                                            <strong>{{ __('nova-launch::visitors.email') }}</strong>
                                        </label>
                                        <input type="email" id="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}" placeholder="john@doe.com"/>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('nova-launch::visitors.sign_up_submit') }}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>
