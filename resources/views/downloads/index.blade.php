@section('styles')
    <link rel="stylesheet" href="{{asset('css/downloads.css')}}">
@endsection
@section('scripts')

@endsection
@section('description', trans('messages.app.download.description'))
@extends('layout.master')
@section('title', trans_choice('messages.words.download', 3))

@endsection
@section('content')
      
        <div class="row">
        
            <div class="large-12 columns">
                <div class="block">
                    <h1 class="title">{{trans('messages.app.downloads.title')}}</h1>
                   
                </div>
                <div class="row">
                
                    <div class="large-4 columns">
                        <div class="block">
                            <h3>Próximamente</h3>
                            <h4>{{trans('messages.app.downloads.version.android')}}</h4>
                            <h6>{{trans_choice('messages.words.requirement', 2)}}</h6>
                            <ul>
                                <li>Android OS > 4.0</li>
                                <li>512Mb RAM</li>
                            </ul>
                            <a class="button download green">
                                <div>
                                    <i class="fa fa-android"></i><span>DESCARGAR</span>
                                </div>
                                <span>version 1.0beta</span>
                            </a>                            
                        </div>
                    </div>
                    <div class="large-4 columns">
                        <div class="block">
                            <h4>{{trans('messages.app.downloads.version.windows')}}</h4>
                            <h6>{{trans_choice('messages.words.requirement', 2)}}</h6>
                            <ul>
                                <li>Windows OS >= XP</li>
                                <li><a href="{{asset('redistributables/dotNetFx40_Full_x86_x64.exe')}}">Framework 4.0</a></li>
                                <li><a href="{{asset('redistributables/Adobe Flash Player Active X 19.0.0.157.exe')}}">Adobe Flash Player Active X</a></li>
                                <li><a href="{{asset('redistributables/VC.Redist.Installer.v1.5.6.exe')}}">VC.Redist.Installer.v1.5.6</a></li>
                                <li>512Mb RAM</li>
                            </ul>
                            <a href="{{asset('redistributables/HabanaOasis(Actualizador e Instalador) v1.44a 20210827 SIN BD.exe')}}" class="button download blue">
                                <div>
                                    <i class="fa fa-windows"></i><span>DESCARGAR</span>
                                </div>
                                <span>version v1.44 27/08/2021</span>
                            </a>                           
                            
                        </div>
                    </div>
                    <div class="large-4 columns">
                        <div class="block">
                            <h4>{{trans('messages.app.downloads.update')}}</h4>
                            <h6>{{trans('messages.app.downloads.update.description')}}</h6>
                            <a href="/descargas/update.file" class="button download gray">
                                <div>
                                    <i class="fa fa-database"></i><span>DESCARGAR</span>
                                </div>
                                <span>Actualizaci&oacuten sin fotos</span>
                            </a>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
@endsection