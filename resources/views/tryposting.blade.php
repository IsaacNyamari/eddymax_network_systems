@extends('layouts.front-end.app')
@section('title', 'Try Posting')
@section('content')
    <div class="container py-5">
        @livewire('try-events')
    </div>
@endsection