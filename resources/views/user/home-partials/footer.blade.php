<style>
    .waves>use {
        animation: move-forever 2s -2s linear infinite;
    }

    .waves>use:nth-child(2) {
        animation-delay: -3s;
        animation-duration: 6s;
    }

    .waves>use:nth-child(3) {
        animation-delay: -4s;
        animation-duration: 3s;
    }


    @keyframes move-forever {
        0% {
            transform: translate(-90px, 0%);
        }

        100% {
            transform: translate(85px, 0%);
        }
    }

    .contact_us {
        width: 100%;
        height: auto;
    }

    .contact_us h1 {
        color: aliceblue;
        text-align: center;
        margin-top: 20px;
        font-size: 60px;
    }

    .ombak {
        width: 100%;
        height: 30vw;
        max-height: 200px;
    }

    .container-contact {
        display: flex;
        margin: 0;
        padding: 0;
    }

    .credit {
        color: #fff;
        padding-bottom: 15px;
    }

    .credit h5 {
        font-size: 15px;
    }

    .container-contact .kontak {
        list-style: none;
        margin: 0 5px;
    }

    .container-contact {
        padding-left: 0 !important;
    }

    .container-contact .kontak a .fa-brands {
        font-size: 40px;
        color: #262626;
        line-height: 80px;
        transition: .5s;
        padding-right: 14px;
    }

    .container-contact .kontak a span {
        padding: 0;
        margin: 0;
        position: absolute;
        top: 30px;
        color: #262626;
        letter-spacing: 4px;
        transition: .5s;
    }

    .container-contact .kontak a {
        text-decoration: none;
        display: absolute;
        display: block;
        width: 210px;
        height: 80px;
        background: #fff;
        text-align: left;
        padding-left: 20px;
        transform: rotate(-30deg) skew(25deg) translate(0, 0);
        transition: .5s;
        box-shadow: -20px 20px 10px rgba(0, 0, 0, .5);
    }

    .container-contact .kontak a:before {
        content: '';
        position: absolute;
        top: 10px;
        left: -20px;
        height: 100%;
        width: 20px;
        background: #b1b1b1;
        transform: .5s;
        transform: rotate(0deg) skewY(-45deg);
    }

    .container-contact .kontak a:after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: -10px;
        height: 20px;
        width: 100%;
        background: #b1b1b1;
        transform: .5s;
        transform: rotate(0deg) skewX(-45deg);
    }

    .container-contact .kontak a:hover {
        transform: rotate(-30deg) skew(25deg) translate(20px, -15px);
        box-shadow: -50px 50px 50px rgba(0, 0, 0, .5);
    }

    .container-contact .kontak:hover .fa-brands {
        color: #fff;
    }

    .container-contact .kontak:hover span {
        color: #fff;
    }

    .container-contact .kontak:hover:nth-child(1) a {
        background: #e4405f;
    }

    .container-contact .kontak:hover:nth-child(1) a:before {
        background: #d81c3f;
    }

    .container-contact .kontak:hover:nth-child(1) a:after {
        background: #e46880;
    }

    .container-contact .kontak:hover:nth-child(2) a {
        background: #2fe03e;
    }

    .container-contact .kontak:hover:nth-child(2) a:before {
        background: #1db329;
    }

    .container-contact .kontak:hover:nth-child(2) a:after {
        background: #33f544;
    }

    .container-contact .kontak:hover:nth-child(3) a {
        background: #4a4d52;
    }

    .container-contact .kontak:hover:nth-child(3) a:before {
        background: #383a3d;
    }

    .container-contact .kontak:hover:nth-child(3) a:after {
        background: #515459;
    }

    @media (max-width: 768px) {
        body {
            overflow-x: hidden;
        }

        .container-contact .kontak {
            margin: 0 8px;
        }

        .container-contact .kontak a .fa-brands {
            font-size: 20px;
            line-height: 60px;
            padding-right: 10px;
        }

        .container-contact .kontak a span {
            font-size: 12px;
            top: 20px;
            letter-spacing: 2px;
        }

        .container-contact .kontak a {
            width: 140px;
            height: 60px;
        }

        .contact_us h1 {
            font-size: 40px;
        }

        .credit h5 {
            font-size: 12px;
        }
    }

    @media (max-width: 540px) {
        .container-contact .kontak {
            margin: 0 8px;
        }

        .container-contact .kontak a .fa-brands {
            font-size: 10px;
            line-height: 30px;
            padding-right: 5px;
        }

        .container-contact .kontak a span {
            font-size: 6px;
            top: 10px;
            letter-spacing: 2px;
        }

        .container-contact .kontak a {
            width: 80px;
            height: 30px;
            padding-left: 10px;
        }

        .container-contact .kontak a:before {
            top: 5px;
            left: -10px;
            height: 100%;
            width: 10px;
        }

        .container-contact .kontak a:after {
            bottom: -10px;
            left: -5px;
            height: 10px;
            width: 100%;
        }
    }

    @media (max-width: 540px) {
        .container-contact .kontak {
            margin: 0 0.1px;
        }
    }
</style>
<div class="contact_us mt-10">
    <svg class="ombak" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28"
        preserveAspectRatio="none">
        <defs>
            <path id="gentle-wave" d="M-160 44c30 0
                    58-18 88-18s
                    58 18 88 18
                    58-18 88-18
                    58 18 88 18
                    v44h-352z" />
        </defs>
        <g class="waves">
            <use xlink:href="#gentle-wave" x="50" y="0" fill="#3a5a40" fill-opacity=".2" />
            <use xlink:href="#gentle-wave" x="50" y="3" fill="#3a5a40" fill-opacity=".5" />
            <use xlink:href="#gentle-wave" x="50" y="6" fill="#3a5a40" fill-opacity="1" />
        </g>
    </svg>
    <div id="contact_us" class="contact_us text-center text-white"
        style="background: #5c7650;
background: linear-gradient(180deg, #3a5a40 10%, #5c7650 120%);">
        <div class="col-12 m-0 p-5 mb-md-5">
            <h1>Contact Us</h1>
        </div>


        <div class="icon flex justify-center pt-5 pb-5">
            <ul class="container-contact">
                <li class="kontak">
                    <a href="" target="_blank">
                        <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        <span> Instagram</span>
                    </a>
                </li>
                <li class="kontak">
                    <a href="" target="_blank">
                        <i class="fa-brands fa-line" aria-hidden="true"></i>
                        <span> Line</span>
                    </a>
                </li>
                <li class="kontak">
                    <a href="" target="_blank">
                        <i class="fa-brands fa-tiktok" aria-hidden="true"></i>
                        <span> Tiktok</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="credit pt-5 mt-md-5">
            <h5 class="my-4" style="color: #dedfe0;">© IT x Creative capital 2025</h5>
        </div>
    </div>
</div>
