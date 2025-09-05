@extends('layouts.app')

@section('title', 'Help Others')

@section('content')

    <section class="row section double-title-section justify-content-center">
        <div class="double-title-left title-container col-12 col-md-4">
            <div class="flare-div yellow-flare"></div>
            <div class="flare-div blue-flare"></div>
            <h1 class="text-uppercase">Double Your Help</h1>
            <span class="">SEE IF YOUR EMPLOYER WILL MATCH YOUR DONATION TO HELP VENEZUELA</span>
        </div>
        <div class="double-title-right col-12 col-md-5">
            <p>South American Initiative has partnered with many online donation platforms to give employees from large companies the opportunity to double their impact on the people of Venezuela through corporate matching programs. Our non-profit has been added to multiple donation platforms, including Benevity, YourCause and many more. These platforms help employees from Fortune 500 companies double donation for causes they care about. Some of these companies include Microsoft, Google, Apple, AT&T, Morgan Stanley, and many more.</p>
            <p>These platform help employees from Fortune 500 companies double donation for causes they care about. Some of these companies include Microsoft, Google, Apple, AT&T, Morgan Stanley, and many more.</p>
        </div>
    </section>

    <section class="row section check-section justify-content-center">
        <div class="check-left-text col-12 col-md-4">
            <span><span class="yellow-text">CHECK</span> if your companies can be matched <span class="yellow-text">TO DOUBLE UP YOUR DONATION</span> through Benevity:</span>
        </div>
        <div class="check-right col-12 col-md-4">
            
        </div>
    </section>

    <section class="row section check-section justify-content-center">
        <div class="check-left-text col-12 col-md-4">
            <span><span class="yellow-text">CHECK</span> if your companies can be matched <span class="yellow-text">TO DOUBLE UP YOUR DONATION</span> through Benevity:</span>
        </div>
        <div class="check-right col-12 col-md-4">
            
        </div>
    </section>

@endsection

@push('styles')
    <style>

        .section{
            margin-bottom: 3rem;
        }

        .double-title-section{
            margin-top: 8rem;
        }

        .double-title-left{
            padding: 2.8rem;
            line-height: 1.3;
            position: relative;
            overflow: hidden;
        }

        .double-title-left h1{
            color: #FFF0A1;
            font-weight: 700;
            font-size: 2.7rem;
            margin-bottom: 2rem;
        }

        .double-title-left span{
            color: #fff;
            font-weight: 700;
            font-size: 1.8rem;
            padding-right: 2.5rem;
        }

        .double-title-right{
            padding: 2rem
        }

        .double-title-right > p:first-of-type{
            margin-bottom: 2rem;

        }

        .double-title-right p{
            color: #8F827D;
        }

        .title-container{
            background-color: #F56161;
        }

        .check-section{
            background: linear-gradient(138deg,rgba(221, 72, 74, 1) 41%, rgba(252, 103, 104, 1) 98%);
            padding: 3rem;
        }

        .check-left-text{
            font-size: 2.2rem;
            font-weight: 600;
            line-height: 1;
            color: #FFFFFF;
            padding-right: 7rem;
        }

        .yellow-text{
            color: #FFF0A1;
        }

        
        .flare-div {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            z-index: 1;
            opacity: 0.6;
        }
        .yellow-flare {
            width: 300px;
            height: 300px;
            background-color: #FFF0A1;
            bottom: -150px;
            right: -150px;
        }
        .blue-flare {
            width: 250px;
            height: 250px;
            background-color: #6C63FF;
            bottom: -125px;
            left: -125px;
        }
    </style>
@endpush