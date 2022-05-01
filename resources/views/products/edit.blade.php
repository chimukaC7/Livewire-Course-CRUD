@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Edit product') }}</div>

                    <div class="card-body">
                        {{--reused the same form as used in create with product as a parameter --}}
                        @livewire('products-form', ['product' => $product])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
