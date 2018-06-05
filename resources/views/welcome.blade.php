@extends('layouts.app')

@section('content')
<div class="row">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            <div class="item active">
                <img src="{{asset('img/1.png')}}" alt="Los Angeles" style="width:100%;">
            </div>

            <div class="item">
                <img src="{{asset('img/2.png')}}" alt="Chicago" style="width:100%;">
            </div>

            <div class="item">
                <img src="{{asset('img/3.png')}}" alt="New York" style="width:100%;">
            </div>
            <div class="item">
                <img src="{{asset('img/4.png')}}" alt="New York" style="width:100%;">
            </div>

        </div>
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<div id="contact" class="row pt-5">
    <div class="col-md-6">
        <h4><strong>Contact Us</strong></h4>
        <form>
            <div class="form-group">
                <input type="text" class="form-control" name="" value="" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="" value="" placeholder="E-mail">
            </div>
            <div class="form-group">
                <input type="tel" class="form-control" name="" value="" placeholder="Phone">
            </div>
            <div class="form-group">
                <textarea class="form-control" name="" rows="3" placeholder="Message"></textarea>
            </div>
            <button class="btn btn-default" type="submit" name="button">
                <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Submit
            </button>
        </form>
    </div>

    <div id="map" class="col-md-6" style="height: 300px;">

    </div>
</div>

<script>
    // Initialize and add the map
    function initMap() {
        // The location of Uluru
        var uluru = {lat: 44.005352, lng: 20.901222};
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 17, center: uluru});
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({position: uluru, map: map});
    }
</script>
<!--Load the API from the specified URL
* The async attribute allows the browser to render the page while the API loads
* The key parameter will contain your own API key (which is not needed for this tutorial)
* The callback parameter executes the initMap() function
-->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALARLm-WgtNQeiopz5NojxYjhHHPtT9HI&callback=initMap">
</script>

@endsection