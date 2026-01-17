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
            <p>Mochi is a traditional Japanese sweet made from glutinous rice that's pounded into a smooth, elastic paste and molded into various shapes. It's incredibly soft and chewy, often filled with sweet red bean paste, ice cream, or fruit, making it a delightful and unique treat loved worldwide for its delicate texture and versatility.</p>
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
            <a href="{{ route('shop') }}">
                <img src="{{ asset('images/shopnow.png') }}" alt="Shop Now" class="right-img">
            </a>
        </div>
        <div class="right-div">
             <img src="{{ asset('images/storeloc.png') }}" alt="Mochi" class="right-img">
        </div>
    </div>
</section>
    </section>
@endsection
