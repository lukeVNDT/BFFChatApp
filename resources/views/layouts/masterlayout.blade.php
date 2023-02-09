@extends('layouts.app')

@section('chatcontent')
                <!-- <master-layout> -->
                <side-message v-bind:auth="{{Auth::user()->id}}"></side-message>

     


<!-- </master-layout> -->



                   
@endsection

@if(auth()->check())
<script>
    window.UserAuth = {!! auth()->user()  !!}
</script>
@endif


