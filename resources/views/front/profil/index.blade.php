@extends('layouts.app')
@section('title')
@endsection
@section('css')
@endsection
@section('content')

        <!-- Page Title Area -->
        <div class="row page-title clearfix">
            <div class="page-title-left">
                <h6 class="page-title-heading mr-0 mr-r-5">Profil</h6>
            </div>
            <!-- /.page-title-left -->
            <div class="page-title-right d-none d-sm-inline-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Panel</a>
                    </li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
            <!-- /.page-title-right -->
        </div>
        <!-- /.page-title -->
        <!-- =================================== -->
        <!-- Different data widgets ============ -->
        <!-- =================================== -->
        <div class="widget-list">
            <div class="row">
                <!-- User Summary -->


                <div class="col-12 col-md-12 mr-b-30">

                    <ul class="nav nav-tabs contact-details-tab">
                        <li class="nav-item"><a href="#profile-tab-bordered-1" class="nav-link active" data-toggle="tab">Profil Düzenle</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="profile-tab-bordered-1">
                            <div class="contact-details-profile">
                                <h5 class="mr-b-20">Profil</h5>
                                @if(session('status'))
                                    <div class="row mt-5">
                                        <div class="col-md-12">
                                            <div class="alert alert-success">{{ session('status') }}</div>
                                        </div>
                                    </div>
                                @endif
                                @if(session('statusDanger'))
                                    <div class="row mt-5">
                                        <div class="col-md-12">
                                            <div class="alert alert-danger">{{ session('statusDanger') }}</div>
                                        </div>
                                    </div>
                                @endif
                                <form action="{{ route('profil.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="contact-details-cell">
                                            <small class="heading-font-family fw-500">Fotoğraf</small>
                                            <input type="file" class="form-control" name="photo">
                                        </div>
                                        <!-- /.contact-details-cell -->
                                    </div>
                                    <!-- /.col-md-12 -->
                                    <div class="col-md-12">
                                        <div class="contact-details-cell">
                                            <small class="heading-font-family fw-500">Ad Soyad</small>
                                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                        </div>
                                        <!-- /.contact-details-cell -->
                                    </div>
                                    <!-- /.col-md-12 -->
                                    <div class="col-md-12">
                                        <div class="contact-details-cell">
                                            <small class="heading-font-family fw-500">E-mail Adresi</small>
                                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                                        </div>
                                        <!-- /.contact-details-cell -->
                                    </div>
                                    <!-- /.col-md-12 -->
                                    <div class="col-md-12">
                                        <div class="contact-details-cell">
                                            <small class="heading-font-family fw-500">Şifre</small>
                                            <input type="password" class="form-control" name="password" >
                                        </div>
                                        <!-- /.contact-details-cell -->
                                    </div>
                                    <!-- /.col-md-12 -->
                                    <div class="col-md-12">
                                        <button class="btn btn-success btn-rounded">Güncelle</button>
                                        <!-- /.contact-details-cell -->
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                                </form>
                                <!-- /.row -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.col-sm-8 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.widget-list -->
    <!-- /.main-wrappper -->
@endsection
@section('js')
@endsection
