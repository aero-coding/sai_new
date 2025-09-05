@extends('layouts.app')

@section('title', 'Project')
@section('content')
<section class="section row report-section justify-content-center">
    <div class="col-12 col-md-10 row">
        <div class="report-content col-12 col-md-9 px-0">
            <div class="report-info">



                <div class="img-container">
                    <img src="{{ asset('example.jpg') }}" alt="">
                    <div class="report-title d-flex flex-column">
                        <div class="report-title-top d-none d-md-block">
                            <div class="title-aux d-inline-block" >
                                <span class="white-span" >CAMPAIGN</span>
                                <div class="related-project d-inline-block">HELP VENEZUELAN</div>
                            </div>
                        </div>
                        <div class="report-title-bottom">
                            <h1 class="d-inline-block">Report Title - SAI volunteers with Venezuelan refugees</h1>
                        </div>
                    </div>
                </div>
                <div class="new-info d-flex align-items-start justify-content-between">
                    <div class="new-info-text   ">
                        <span>8 Feb 2025</span>
                        <span>Posted by<img src="" alt=""></span><span>John Doe</span>
                    </div>
                    <a href="">
                        <span>Share Photo</span>
                    </a>
                </div>


            </div>
            <div class="report-text p-3 d-flex flex-column">
                <div>
                    <h3>Lorem ipsum dolor</h3>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nis ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim. Qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla</p>
                </div>

                <div  class="red-box"></div>

                <div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nis ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim. Qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla</p>
                </div>

                <div>
                    <h3>Lorem ipsum do</h3>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nis ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim. Qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla</p>
                </div>
            </div>
            <div class="left-right-image w-100 row p-0 d-none d-md-flex">
                <div class="left-text col-12 col-md-7 d-flex flex-column">
                    <h3>Help people in need</h3>
                    <span>START DONATING TODAY, MAKE THE DIFFERENCE</span>
                    <a href="" class="white-btn">DONATE TO THIS PROJECT ></a>

                </div>
                <div class="right-image col-12 col-md-5 d-flex flex-column">
                    <img src="{{asset('example.jpg')}}" alt="">
                </div>
            </div>
        </div>
        <div class="report-donate d-none d-md-block col-3">

        </div>
    </div>
</section>
@endsection

@push('styles')
<style>

    .report-section{
        margin-bottom: 5rem;
        margin-top: 8rem;
    }

    /* selector for any class that starts with "col" */
    [class^="col"] {
        padding-left: 0;
        padding-right: 0;
    }

    .report-donate{
        padding: 0;
        background-color: #D94647;
    }
    
    /* selector for any class that starts with "col" */


    .section div{
        max-width: 1550px;
    }

    .img-container{
        position: relative;
        width: 100%;
    }

    .img-container img{
        width: 100%;
        height: auto;
        object-fit: cover;
        max-height: 350px;
    }

    .report-title{
        width: 100%;
        position: absolute;
        bottom: 0;
    }

    .report-title-top{
        margin: 0 2rem;
    }

    .title-aux{
        background-color: #fff;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .white-span, .related-project{
        padding: 0.2rem 1rem 0.5rem 1rem;
    }

    .title-aux .related-project{
        background-color: #D94647;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        color: #fff;
    }

    .report-title h1{
        color: #ffffff;
        background-color: #FE6668;
        padding: 1.3rem 2.3rem;
        font-size: 1.7rem;
        font-weight: 600;
        border-top-right-radius: 10px;
    }


    .new-info{
        border-bottom: 1px solid #ccc;
        font-size: 1.15rem;
        color: #7F7F7C;
        padding: 1.5rem 0.7rem;
    }

    .new-info-text span{
        margin: 0 1rem;
    }

    .report-text h3{
        margin-bottom: 1rem;
        color: #484341;
        font-size: 1.6rem;
}

    .report-text p{
        margin-bottom: 1.5rem;
        color: #8F827D;
        font-size: 1.3rem;
}

.red-box{
    background-color: #EA8383;
    width: 70%;
    height: 400px;
    margin-left: 10%;
    margin-bottom: 2rem;
    border-radius: 10px;
}

.left-right-image{
}

.left-text{
    background-color: #FC6768;
    padding: 2rem;
}


.left-text h3{
    color: #FFF0A1;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.left-text span{
    color: #fff;
    font-size: 1.8rem;
    margin-bottom: 1rem;
}

.left-right-image .white-btn{
    padding: 0.5rem 0.7rem;
    font-size: 0.8rem;
}

.left-right-image .right-image{
    padding: 0;
}

.left-right-image .right-image img{
    width: 100%;
    height: 100%;
}

/* MOBILE */

.left-right-image-mobile .left-text{
    padding: 2rem 0;
    gap: 1rem;
    background-color: #D94647;
}

.left-right-image-mobile .left-text .white-btn{
    padding: 0.5rem 2rem;

}

@media (max-width: 822px) {
    .left-text{
        padding: 1.5rem;
    }

    .report-text h3{
        font-size: 1.2rem;
    }

    .report-text p{
        font-size: 1rem;
    }

    .report-info {
        font-size: 1rem;
    }

    .report-title h1{
        padding: 0.1rem;
    }
}
</style>
@endpush