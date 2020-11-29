@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: #3490dc;color:white">{{ config('app.name') }}</div>
                <div class="card-body">
                    <div id="app">
                    <chat-component></chat-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
