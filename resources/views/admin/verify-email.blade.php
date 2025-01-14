<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body>
    <div class="w-screen h-screen flex items-center bg-white">
        <div class="w-full md:h-[85%] h-[90%] flex flex-col items-center justify-start pb-[1%]">
            <svg width="18vh" height="18vh" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 171 171">
                <g id="Layer_2" data-name="Layer 2">
                    <g id="Layer_1-2" data-name="Layer 1">
                        <circle cx="85.5" cy="85.5" r="85.5" fill="#ebecf0" />
                        <circle cx="85.5" cy="85.5" r="85.5" fill="#fcfbe6" fill-opacity="0.4" />
                        <path d="M85.5,159A73.5,73.5,0,1,1,159,85.5,73.62,73.62,0,0,1,85.5,159Zm0-144A70.5,70.5,0,1,0,156,85.5,70.55,70.55,0,0,0,85.5,15Z" fill="#333" />
                        <path d="M49.2,53.9,78.8,87a8.94,8.94,0,0,0,6.7,3,9.1,9.1,0,0,0,6.7-3l29.1-32.6a1.56,1.56,0,0,1,.8-.6,10.57,10.57,0,0,0-4-.8H52.9a10.06,10.06,0,0,0-3.9.8A.35.35,0,0,0,49.2,53.9Z" fill="#333" />
                        <path d="M126.5,58a1.8,1.8,0,0,1-.6.9l-29,32.5a15.38,15.38,0,0,1-11.4,5.1,15.18,15.18,0,0,1-11.4-5.1l-29.5-33-.2-.2A9.75,9.75,0,0,0,43,63.3v44.8A9.94,9.94,0,0,0,53,118h65a9.94,9.94,0,0,0,10-9.9V63.3a10.27,10.27,0,0,0-1.5-5.3" fill="#333" />
                    </g>
                </g>
            </svg>
            <div class="md:w-[80%] w-[88%] h-full flex flex-col items-center justify-evenly lg:justify-center">
                <h1 class="text-[#364252] w-full font-bold leading-none text-[44px] lg:text-[52px] md:text-[48px] text-center">Please Verify Your Email</h1>
                <p class="mt-[20px] text-black lg:text-[25px] md:text-[30px] leading-10 text-[21px]">You're almost there! <br id="break" class="hidden">We sent an email to </p>
                <p class="text-[#364252] mt-[10px] font-bold leading-4 md:text-[26px] text-[22px]">{{ $email }}</p>
                <p class="text-black mt-[40px] md:text-[2rem] text-[20px] lg:text-2xl md:w-[76%] w-[76%] text-balance md:text-center ">Just click on the button in that email to complete your login. If you don't see it, you may need to <b class="text-[#364252]">check your spam </b>folder.</p>

                <button class="md:w-[270px] md:h-[70px] w-[300] my-[40px] p-4 rounded-md font-bold text-xl text-[#fdfdfd] bg-[#364252]"><a href="https://mail.google.com/mail/u/0/">Go To Your Mailbox</a></button>
            </div>
        </div>
    </div>

    <script>
        if (window.innerWidth <= 768) {
            document.getElementById('break').classList.remove('hidden');
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768) {
                document.getElementById('break').classList.remove('hidden');
            }
        });
    </script>
</body>

</html>