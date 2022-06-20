@extends('layouts.frontend')
@section('content')

    <div class="container-fluid product-show-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card product-show-card1">
                    <div class="display-4">
                        {{ trans('global.show') }} {{ trans('cruds.product.title') }}
                    </div><hr>
                    <div class="row g-0">
                        <div class="col-md-4 col-sm-12">
                            <div class="card product-show-card2">
                                @if($product->photo)
                                @foreach($product->photo as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl() }}">
                                </a>

                                @if(isset($media)) @break
                                @endif

                                @endforeach
                                @endif
                                <div class="card-body">
                                    <p>{{ trans('cruds.product.fields.name') }} :  {{ $product->name }}</p>
                                    <p>{{ trans('cruds.product.fields.price') }} :  {{ $product->price }}</p>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn product-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Buy {{ $product->name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <div class="card-body">
                                <p class="card-title display-4">{{ trans('cruds.product.fields.description') }}</p><hr>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text">
                                    <small class="text-muted">{{ trans('cruds.product.fields.category') }}
                                        @foreach($product->categories as $key => $category)
                                            <span class="label label-info">{{ $category->name }}</span>
                                        @endforeach
                                    </small>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">{{ trans('cruds.product.fields.tag') }}
                                        @foreach($product->tags as $key => $tag)
                                            <span class="label label-info">{{ $tag->name }}</span>
                                        @endforeach
                                    </small>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">{{ trans('cruds.product.fields.id') }} :  {{ $product->slug }}</small>
                                </p>
                                <a href="{{ route('frontend.products.index') }}" class="btn product-btn">{{ trans('global.back_to_list') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><img class="avatar" src="public/trolley.jpg" alt="trolley">&nbsp; Cart(0)</h5>                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            @foreach($product->photo as $key => $media)
                            <div class="carousel-item active">
                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                <img class="carousel-img" src="{{ $media->getUrl() }}">
                            </a>
                            </div>
                            @if(isset($media))
                            @break
                            @endif
                            @endforeach

                            @foreach($product->photo as $key => $media)
                            <div class="carousel-item">
                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                <img class="carousel-img" src="{{ $media->getUrl() }}">
                            </a>                            
                            </div>
                            @endforeach
                        
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <div class="row">
                        <div class="col-6">
                            {{ trans('cruds.product.fields.price') }} :  {{ $product->price }}
                        </div>
                        <div class="col-6">
                            <form action="{{route('frontend.products.cart')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="hidden" name="price" value="{{ $product->price }}">
                                                <input type="number" name="quantity" style="width: 50px" value=">=0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="hidden" name="name" value="{{ $product->name }}">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary product-btn">Add to cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

