@extends('layouts.app')
@section('title')
@endsection
@section('css')
@endsection
@section('content')

    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Ürün</h6>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Panel</a>
                </li>
                <li class="breadcrumb-item active">Ürün</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Yeni Ürün Düzenle</a>
            </div>
        </div>
        <!-- /.page-title-right -->
    </div>

    @if(session('status'))
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="alert alert-success">{{ session('status') }}</div>
            </div>
        </div>
    @endif
    <!-- /.page-title -->
    <!-- =================================== -->
    <!-- Different data widgets ============ -->
    <!-- =================================== -->
    <div class="widget-list">
        <div class="row">
            <div class="col-md-12 widget-holder">
                <div class="widget-bg">
                    <div class="widget-body clearfix">
                        <form action="{{route('urun.update', ['id'=>$data[0]['id']])}}" method="POST">
                            @csrf
                            <div class="form-group row firma-area">
                                <div class="col-md-12">
                                    <label class=" col-form-label" for="l0">Ürün Adı</label>
                                    <input class="form-control"  required name="urunAdi" value="{{ $data[0]['urunAdi'] }}" type="text">
                                </div>

                                <div class="form-actions">
                                    <div class="form-group row">
                                        <div class="col-md-12 ml-md-auto btn-list">
                                            <button class="btn btn-primary btn-rounded" type="submit">Kaydet</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <!-- /.widget-body -->
                </div>
                <!-- /.widget-bg -->
            </div>
            <!-- /.widget-holder -->
        </div>
        <!-- /.row -->
    </div>

@endsection
