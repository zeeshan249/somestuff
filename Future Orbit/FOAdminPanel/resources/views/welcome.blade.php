<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no, minimal-ui">

        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('label.label_company_name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{config('customconfig.companyLogoImageUrl')  }}">
    </head>
    <body>
        <noscript>
            <strong>{{__('label.label_enable_javascript')}}</strong>
        </noscript>
        <v-app id="app">

            <app-component></app-component>
        </v-app>
        <script src="{{ asset('js/app.js') }}" ></script>
    </body>
</html>
