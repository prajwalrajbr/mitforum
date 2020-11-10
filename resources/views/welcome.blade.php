@extends('layouts.app')
@section('content')
    <router-link to='/'>Home</router-link>
    <router-link to='/about'>About</router-link>
    <router-view></router-view>
@endsection