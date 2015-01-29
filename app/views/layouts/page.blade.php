<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
        @yield('title')
        </title>
        <meta charset="UTF-8">
        @yield('meta')
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('assets/style.css') }}" type="text/css">
	</head>
    <body>
        <div id="container">
        	@include('layouts.header')
            @include('layouts.status')
            
        	<div class="content">
            	@yield('content')
            </div>

            @include('layouts.footer')
        </div>
    </body>
</html>