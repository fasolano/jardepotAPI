@extends('pages')

@section('content')
    <div class="row" style="height: 500px;">
        <div class="col-xl-5">
            <div class="py-2" style="height: 300px;">
                <img src="{{asset('assets/images/banner/podadora.jpg')}}" style="width: 100%; height: 100%;" alt="Podadora">
            </div>
            <div class="py-2" style="height: 200px;">
                <img src="{{asset('assets/images/banner/motocultor.jpg')}}" style="width: 100%; height: 100%;" alt="Motocultor">
            </div>
        </div>
        <div class="col-xl-7 p-2">
            <img src="{{asset('assets/images/banner/aspersora.jpg')}}" style="width: 100%; height: 100%;" alt="Aspersora">
        </div>
    </div>
@endsection
