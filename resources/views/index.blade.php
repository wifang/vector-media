@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                 
                      <div class="panel-body">
                        
                          <b> output:</b>
                          <u>
                                @foreach($data['interest'] as $k=>$v)
                                 @foreach( $v as $k1=>$v1)
                                 @if ($v1 == reset($v )) <br> @endif
                                   <li><b>{{ ucfirst(str_replace('_', ' ',$k1)) }}</b> : {{$v1}}</li>                     
                                 @endforeach
                                @endforeach
                          </u>
                          
                      </div>
            </div>
        </div>
    </div>
</div>
@endsection