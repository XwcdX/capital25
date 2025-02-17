<style>
    .link-merged {
      color: #ffffff;
      font-size: 20px;
      text-decoration: none;
      padding: 10px 20px;
      margin: 0 5px;
      position: relative;
      display: inline-block;
      transition: all 0.5s;
      border-radius: 8px;
    }
  
    .link-merged:hover {
      color: #c8e9f0;
      text-shadow: 0 0 10px #c8e9f0, 0 0 20px #c8e9f0, 0 0 30px #c8e9f0, 0 0 40px #c8e9f0;
    }
  
    .link-merged::after {
      content: "";
      position: absolute;
      width: 0;
      background-color: rgba(255, 255, 255, 0.4);
      left: 50%;
      transform: translateX(-50%);
      bottom: -0.25em;
      height: 2px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
  
    .link-merged:hover::after {
      width: 100%;
      animation: pulse11 1s;
      box-shadow: 0 0 0 1em transparent;
    }
  
    @keyframes pulse11 {
      0% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
      }
  
      100% {
        box-shadow: 0 0 0 1em transparent;
      }
    }
  
    .navbar {
      width: 100%;
      z-index: 9999;
      position: fixed;
    }
  
    .nav-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 62px;
    }
  
    .navbar .nav-container li {
      list-style: none;
    }
  
    .navbar .nav-container a {
      text-decoration: none;
      color: #ffffff;
      /* font-weight: 500; */
      font-size: 1.7rem;
      padding: 0.7rem;
      /* text-shadow: 0 0 2px #ff8c00, 0 0 5px #ff8c00, 0 0 10px #ff8c00; */
    }
  
    .navbar .nav-container a:hover {
      color: #b1ce58;
      transition: all 0.2s;
    }
  
    .nav-container {
      display: block;
      position: relative;
      height: 60px;
    }
  
    .nav-container .checkbox {
      position: fixed;
      display: block;
      height: 32px;
      width: 32px;
      top: 20px;
      left: 20px;
      z-index: 9999;
      opacity: 0;
      cursor: pointer;
    }
  
    .nav-container .hamburger-lines {
      display: block;
      height: 26px;
      width: 32px;
      position: absolute;
      top: 17px;
      left: 20px;
      z-index: 1000;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
  
    .nav-container .hamburger-lines .line {
      display: block;
      height: 4px;
      width: 100%;
      border-radius: 10px;
      background: #ffffff;
    }
  
    .nav-container .hamburger-lines .line1 {
      transform-origin: 0% 0%;
      transition: transform 0.4s ease-in-out;
    }
  
    .nav-container .hamburger-lines .line2 {
      transition: transform 0.2s ease-in-out;
    }
  
    .nav-container .hamburger-lines .line3 {
      transform-origin: 0% 100%;
      transition: transform 0.4s ease-in-out;
    }
  
    /* General styles for the menu-items */
      .navbar .menu-items {
        /* padding-top: 120px; */
        background: #25362d;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        height: 100vh;
        width: 100%; /* Default full-width for smaller devices */
        transform: translate3d(-150%, 0, 0);
        display: flex;
        flex-direction: column;
        margin-left: -40px;
        /* padding-left: 50px; */
        transition: transform 0.5s ease-in-out;
        will-change: transform;
        text-align: center;
        backdrop-filter: blur(10px);
        z-index: 999;
        position: relative;
      }
  
      /* Adjust width for laptop devices (min-width: 1024px) */
      @media (min-width: 1024px) {
        .navbar .menu-items {
            width: 30%; /* Make the navbar width half of the screen */
            margin-left: 0; /* Remove the offset for larger devices */
            /* padding-left: 20px;  */
        }
      }
  
    .navbar .menu-items li {
      margin-bottom: 1.2rem;
      font-size: 1.5rem;
      font-weight: 500;
      z-index: 999;
    }
  
    .nav-container input[type="checkbox"]:checked~.menu-items {
      transform: translateX(0);
    }
  
    .nav-container input[type="checkbox"]:checked~.hamburger-lines .line1 {
      transform: rotate(45deg);
    }
  
    .nav-container input[type="checkbox"]:checked~.hamburger-lines .line2 {
      transform: scaleY(0);
    }
  
    .nav-container input[type="checkbox"]:checked~.hamburger-lines .line3 {
      transform: rotate(-45deg);
    }
    .nav-overlay {
      opacity: 0;
      visibility: hidden;
      background: rgba(0, 0, 0, 0.65); /* Semi-transparent black */
      position: absolute;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: 998; 
      transition: opacity 0.3s ease, visibility 0.3s ease;
  }

  .nav-container input[type="checkbox"]:checked ~ .nav-overlay {
      opacity: 1;
      visibility: visible;
  }
    /* standford breath font */
    @font-face {
        font-family: 'Hermona';
        src: url('/fonts/Hermona.otf') format('opentype');
    }
  
    .hermona {
        font-family: 'Hermona';
    }
  </style>
  
  <div id="navbar" class="">
    <nav class="navbar">
      <div class="container nav-container font-quicksand">
        <input class="checkbox" type="checkbox" name="" id="nav-toggle" />
        <div class="hamburger-lines drop-shadow-md">
          <span class="line line1"></span>
          <span class="line line2"></span>
          <span class="line line3"></span>
        </div>
        <div class="nav-overlay"></div>
        <ul class=" menu-items items-center justify-center gap-6">
          <li><a href="#aboutUs" class=" drop-shadow-lg hover:scale-110 font-extrabold">ABOUT</a></li>
          <li><a href="#timeline" class=" drop-shadow-lg hover:scale-110 font-extrabold">TIMELINE</a></li>
          <li><a href="#prizepool" class=" drop-shadow-lg hover:scale-110 font-extrabold">PRIZE POOL</a></li>
          <li><a href="#faq" class=" drop-shadow-lg hover:scale-110 font-extrabold">FAQ</a></li>
          {{-- ganti route ke regist --}}
          <li><a href="#regist" class=" drop-shadow-lg hover:scale-110 font-extrabold">REGISTRATION</a></li>
        </ul>
      </div>
    </nav>
  </div>
  
  <script>
    const checkbox = document.getElementById('nav-toggle');
    const menuItems = document.querySelector('.menu-items');
  
    document.addEventListener('click', function (event) {
      if (!menuItems.contains(event.target) && !checkbox.contains(event.target)) {
        checkbox.checked = false;
      }
    });
  
    window.addEventListener('scroll', function () {
      checkbox.checked = false;
    });
  
    const menuLinks = menuItems.querySelectorAll('a');
    menuLinks.forEach(link => {
      link.addEventListener('click', function () {
        checkbox.checked = false;
      });
    });
  </script>
  