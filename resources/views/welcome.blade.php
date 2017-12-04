@extends('layouts.app')

@section('page-header', 'Welcome!')

@section('page-header-subtext', '')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Welcome!
                    </div>

                    <div class="panel-body">
                        Manage your products <a href="/products">HERE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
