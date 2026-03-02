{{-- layouts/home.blade.php --}}
{{-- Public-facing layout. Extends app.blade.php. --}}
{{-- Usage in a page view:
       @extends('layouts.home')
       @section('title', 'Page Title')
       @section('content') ... @endsection
--}}

@extends('app')

@section('title', $title ?? 'Taboc Elementary School')

@section('content')
    @yield('page_content')
@endsection