@extends('layouts.app')

@section('content')
<section class="section section-1">
    <section class="container">
        <div class="slider-wrapper">

            <div class="slider">
                <img id="slide-1" src="{{ asset('images/homeslide1.png') }}" alt="Slide 1">
                <img id="slide-2" src="{{ asset('images/homeslide2.png') }}" alt="Slide 2">
            </div>

            <div class="slider-nav">
                <a href="#slide-1"></a>
                <a href="#slide-2"></a>
            </div>

        </div>
    </section>
</section>

    <!-- SECTION 2 -->
    <section class="section section-2">
        <section class="section section-2">
    <div class="center-div">
        <div class="left-div">
            <h1>What is Mochi?</h1><br>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt <br><br>
			ut labore et dolore magna aliqua. Ut enim ad minim veniam,ut labore et dolore magna aliqua. Ut enim ad minim veniam,ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
        </div>
        <div class="right-div">
             <img src="{{ asset('images/whatismochi.jpg') }}" alt="Mochi" class="right-img">
        </div>
    </div>
</section>
    </section>

    <!-- SECTION 3 -->
   <section class="section section-3">
    <section class="container">
        <div class="slider-wrapper">

            <div class="slider">
                <img id="slide-1" src="{{ asset('images/bestseller1.png') }}" alt="Slide 1">
                <img id="slide-2" src="{{ asset('images/bestseller2.png') }}" alt="Slide 2">
            </div>

            <div class="slider-nav">
                <a href="#slide-1"></a>
                <a href="#slide-2"></a>
            </div>

        </div>
    </section>
</section>

<!-- SECTION 2 -->
    <section class="section section-4">
        <section class="section section-4">
    <div class="center-div">
        <div class="left-div">
            <img src="{{ asset('images/shopnow.png') }}" alt="Mochi" class="right-img">
        </div>
        <div class="right-div">
             <img src="{{ asset('images/storeloc.png') }}" alt="Mochi" class="right-img">
        </div>
    </div>
</section>
    </section>
@endsection
