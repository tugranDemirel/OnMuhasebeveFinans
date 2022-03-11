@extends('layouts.app')
@section('title')
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.min.css" rel="stylesheet" type="text/css">
@endsection
@section('content')

    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Teklif</h6>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Panel</a>
                </li>
                <li class="breadcrumb-item active">Teklif</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Teklif Düzenle</a>
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
                        <form action="{{route('teklif.update', ['id' => $data[0]['id']])}}" method="POST">
                            @csrf



                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class=" col-form-label" for="l0">Müşteri Seçiniz</label>
                                    <select name="musteriId" class="m-b-10 form-control select2-hidden-accessible" data-placeholder="Müşteri Seçiniz" data-toggle="select2" tabindex="-1" aria-hidden="true">
                                        <option value="">Müşteri Seçiniz</option>
                                        @foreach(\App\Musteriler::all() as $k => $v)
                                            <option @if($data[0]['musteriId'] == $v['id']) selected @endif value="{{$v['id']}}"> {{ \App\Musteriler::getPublicName($v['id']) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="" class="col-form-label">Teklif Fiyatı</label>
                                    <input type="text" required name="fiyat" class="form-control" value="{{ $data[0]['fiyat'] }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-form-label">Açıklama</label>
                                    <textarea name="aciklama" id="" cols="30" rows="10" class="form-control">{{ $data[0]['aciklama']}}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-form-label">Teklif Durumu</label>
                                    <select name="status" id="" class="form-control">
                                        <option @if($data[0]['status'] == 0) selected @endif value="0">Bekleyen</option>
                                        <option @if($data[0]['status'] == 1) selected @endif value="0" value="1">Onaylanmış</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button id="add-product" class="btn btn-primary" type="button">Ürün Ekle</button>
                                <div id="product-list" style="margin-top: 10px;">
                                    @foreach($content as $k => $v)
                                        <div class="row list-item" style="margin-bottom: 5px;">
                                            <div class="col-md-5">
                                                <select class="form-control" name="urunler[{{ $k }}][urunId]">
                                                    @foreach(\App\Urun::all() as $k2 => $v2)
                                                        <option @if($v2['id'] == $v['urunId']) selected @endif value="{{ $v2['id'] }}">{{ $v2['urunAdi'] }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            <div class="col-md-5">
                                                <input type="text" name="urunler[{{ $k }}][adet]" value="{{$v['adet']}}" class="form-control" placeholder="Adet"/>
                                            </div>
                                            <div class="col-md-2">
                                                 <button type="button" class="btn btn-danger remove">X</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        var i = $('.list-item').length;
        $('#add-product').click(function (){
            var html = '<div class="row list-item" style="margin-bottom: 5px;" >' +
                '<div class="col-md-5">'+
                '<select class="form-control" name=urunler['+ i +'][urunId]>';
            @foreach(\App\Urun::all() as $k => $v)
                html += '<option value="{{ $v['id'] }}"> {{ $v['urunAdi'] }} </option>';
            @endforeach
                html += '</select></div>'+
                '<div class="col-md-5">'+
                '<input type="text" name=urunler['+ i +'][adet] class="form-control" placeholder="Adet"/>'+
                '</div>'+
                '<div class="col-md-2">'+
                ' <button type="button" class="btn btn-danger remove">X</button>' +
                '</div>'+
                '</div>';
            $('#product-list').append(html);
            i++;
        });

        $('body').on('click', '.remove', function (){
            $(this).closest('.list-item').remove();
        });
    </script>
@endsection
