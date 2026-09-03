<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Gav Forrest">

        <title>@yield('title', 'Fpk Dev Blog')</title>
        <meta name="description" content="@yield('description', 'Notes on .NET, Laravel, and the things that don\'t have clean answers online.')">

        @yield('meta')

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        @vite('resources/css/app.css')
    </head>
<body>