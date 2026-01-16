@extends('layouts.app')

@section('content')
<section class="contact-container">
    <div class="contact-box">
        <h2>Get in Touch</h2>
        <p class="contact-intro">We'd love to hear from you! Send us a message and we'll respond as soon as possible.</p>
        <p class="contact-details">Phone: 0994858383</p>
        <p class="contact-details">Email: mochi@ss.com</p>
        <div class="social-links">
            <div class="social-item">
                <span>Follow us on social media for updates!</span>
            </div>
        </div>
    </div>
    <div class="location-box">
        <h2>Visit Us</h2>
        <p class="location-text">Come visit our store at:</p>
        <p class="location-address">sjsosksaokaokaokaokoa</p>
        <div class="map-container">
            <img src="{{ asset('images/storeloc.png') }}" alt="Store Location" class="map-placeholder">
        </div>
    </div>
</section>
@endsection
