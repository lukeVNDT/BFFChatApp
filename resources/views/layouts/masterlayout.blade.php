@extends('layouts.app')

@section('chatcontent')
                <!-- <master-layout> -->
                <side-chat v-bind:auth="{{Auth::user()->id}}"></side-chat>

     


<!-- </master-layout> -->



                   
@endsection

@if(auth()->check())
<script>
    window.UserAuth = {!! auth()->user()  !!}
</script>
@endif


