@extends('layouts.frontend')

@section('content')

<div class="container-fluid testBg">
    <div class="row justify-content-center testBgopacity">
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <div class="card test-card ">
                <h5 class="card-header text-center">{{ $title ?? '' }}</h5>
                <div class="card-body">
                    <img src="{{ asset('ring1.jpg') }}" class="card-img-top" alt="ring">
                </div>
                <form action="{{ route('frontend.add.test') }}" method= "POST">
                @csrf
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            <i class="fas fa-circle yellowIcon" data-image="{{ asset('ring2.jpg') }}"></i>&nbsp;
                            <i class="fas fa-circle whiteIcon" data-image="{{ asset('ring1.jpg') }}"></i>&nbsp;
                            <i class="fas fa-circle redIcon" data-image="{{ asset('ring3.jpg') }}"></i>
                        </div>
                        <div class="col-12">
                            <!-- <input type="text" class="btnColor" value="Yellow" data-image="{{ asset('ring2.jpg') }}">
                            <input type="radio" class="btnColor" value="White" data-image="{{ asset('ring1.jpg') }}">
                            <input type="radio" class="btnColor" value="Red" data-image="{{ asset('ring3.jpg') }}"> -->

                            

                        </div>
                    </div><br>
                    <button type="button" class="btn btn-info sizeBtn">Select Size</button><br><br>
                    <div class="row">
                        <div class="col-12 sizeSelect">

                            <input type="radio" class="btn-check" name="size" id="option1" value="0.4" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option1">0.4</label>

                            <input type="radio" class="btn-check" name="size" id="option2" value="0.5" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option2">0.5</label>

                            <input type="radio" class="btn-check" name="size" id="option3" value="0.6" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option3">0.6</label>

                            <input type="radio" class="btn-check" name="size" id="option4" value="0.7" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option4">0.7</label>

                            <input type="radio" class="btn-check" name="size" id="option5" value="0.8" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option5">0.8</label>

                            <input type="radio" class="btn-check" name="size" id="option6" value="0.9" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option6">0.9</label>

                            <input type="radio" class="btn-check" name="size" id="option7" value="1.0" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option7">1.0</label>

                            <input type="radio" class="btn-check" name="size" id="option8" value="1.1" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option8">1.1</label>

                            <input type="radio" class="btn-check" name="size" id="option9" value="1.2" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option9">1.2</label>

                            <input type="radio" class="btn-check" name="size" id="option10" value="1.3" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option10">1.3</label>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-info mb-3 mt-3 sizeSelect">Submit</button>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>

<script>
    

  


$(document).ready(function(){

    $(".fa-circle").click(function(){
        $("img").attr("src",$(this).data("image"));
    });
    $(".sizeBtn").click(function(){
        $(".sizeSelect").toggle("slow");
    });
    imgSelect();
}); 

</script>

@endsection