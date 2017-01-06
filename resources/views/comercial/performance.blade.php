@extends('welcome')

@section('content')
    <h2>Performance Comercial</h2>
    <div class="bs-component">
          <ul class="nav nav-tabs" style="margin-bottom: 15px;">
            <li class="active"><a href="#consultor" data-toggle="tab" aria-expanded="true">Por Consultor<div class="ripple-container"></div></a></li>
            <li class=""><a href="#cliente" data-toggle="tab" aria-expanded="false">Por Cliente<div class="ripple-container"></div></a></li>
          </ul>

          <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="consultor">
              @include('comercial._tab-consultor')
            </div>
            <div class="tab-pane fade" id="cliente">
              @include('comercial._tab-cliente')
            </div>
          </div>
        </div>

@stop