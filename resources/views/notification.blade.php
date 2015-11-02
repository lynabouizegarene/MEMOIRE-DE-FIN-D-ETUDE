@extends('app')
@section('content')
<ul>
 @foreach($notifications as $notification)
   <li>{!!$notification->contenu!!}</li>
 @endforeach
 </ul>
 @endsection