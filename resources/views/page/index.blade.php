@extends('layout.app')

@section('title')URL Shortener - @endsection

@section('content')
<h1>Welcome to Tinyus</h1>
<p>Tinyus allows you to convert your long URL into shorten tiny URL.</p>

<form action="{!! route('encoder') !!}" method="POST">
    {!! csrf_field() !!}
    <div class="form form-group">
        <label for="originLink">Original URL</label>
        <input class="form form-control" type="text" name="origin_link" id="origin_link" placeholder="Enter Original URL">
    </div>
    <input class="btn btn-primary" type="submit" name="submit" id="submit" value="Tiny Now!">
</form>

@if(empty($shorten_link))
    <br><p><b>Shorten Link : </b> Shorten Link Here...</p>
@else
    <br><p><b>Shorten Link : </b> <i id="shorten" onclick="copyToClipboard('#shorten')" class="btn btn-default">{{$shorten_link}}</i></p>
@endif
@endsection