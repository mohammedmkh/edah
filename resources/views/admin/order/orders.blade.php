@extends('admin.master', ['title' => __('Orders')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Orders') ,
        'class' => 'col-lg-7'
    ]) 


@endsection