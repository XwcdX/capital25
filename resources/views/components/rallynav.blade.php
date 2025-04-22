<style>
    .navbar {
        width: 30%;
        z-index: 999;
        position: fixed;
        top: 0;
        left: 0;
    }

    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 62px;
        position: relative;
        padding: 0 20px;
    }

    .checkbox {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        z-index: 1001;
    }

    .hamburger-lines {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 26px;
        width: 32px;
        cursor: pointer;
        z-index: 1100;
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

    .nav-overlay {
        opacity: 0;
        visibility: hidden;
        background: rgba(0, 0, 0, 0.65);
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        z-index: 950;
    }

    .menu-items {
        background: #25362d;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        width: 60%;
        max-width: 300px;
        height: 100vh;
        transform: translateX(-150%);
        transition: transform 0.5s ease-in-out;
        list-style: none;
        padding: 20px 0;
        margin: 0;
        position: fixed;
        top: 0;
        left: 0;
        overflow-y: auto;
        z-index: 1000;
    }

    .menu-items li {
        margin: 1rem 0;
    }

    .menu-items li a {
        text-decoration: none;
        color: #ffffff;
        font-size: 1.7rem;
        padding: 10px 20px;
        display: block;
        transition: all 0.5s;
    }

    .menu-items li a:hover {
        color: #b1ce58;
    }

    .nav-container input[type="checkbox"]:checked~.menu-items {
        transform: translateX(0);
    }

    .nav-container input[type="checkbox"]:checked~.nav-overlay {
        opacity: 1;
        visibility: visible;
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

    @media (max-width: 768px) {

        .menu-items,
        .nav-overlay {
            display: none;
        }
    }

    /* mobile nav css */
    .els-wrap {
        display: flex;
        align-items: center;
        width: 25px;
        color: rgb(51, 51, 51);
        /* padding: 0 20px; */
        border-radius: 100px;
        overflow: hidden;
        text-decoration: none;
        cursor: pointer;
        background-size: 1200px;
        background-position: 100% 50%;
        background-image: radial-gradient(circle at right, #25362d, rgb(216, 216, 255));
        transition:
            width 200ms ease-in-out,
            padding 200ms ease-in-out,
            border-radius 300ms ease-in-out,
            background-position 900ms ease-in-out;
    }

    .icon-nav {
        font-size: 20px;
        margin-right: 25px;
        position: relative;
        z-index: 2;
        transition: font-size 250ms ease-out, margin-right 200ms ease-out;
    }

    .nav-label {
        font-weight: 600;
        letter-spacing: 0.1em;
        opacity: 0;
        position: relative;
        z-index: 2;
        font-size: 12px;
        transition: opacity 400ms ease-out;
        transition-delay: 130ms;
    }

    .els-wrap:hover,
    .els-wrap:focus {
        background-position: 0 50%;
        padding: 3px 13px;
        border-radius: 50px;
        width: auto;
    }

    .els-wrap:hover .icon-nav,
    .els-wrap:focus .icon-nav {
        font-size: 14px;
        margin-right: 10px;
    }

    .els-wrap:hover .nav-label,
    .els-wrap:focus .nav-label {
        opacity: 1;
    }

</style>

<div id="navbar ">
    {{-- mobile nav --}}
    <nav id="nav-mobile" class="bg-[#25362d] ">
        <div class="flex justify-center block lg:hidden font-quicksand">
                <div class="w-full h-[70px] shadow-[0_10px_40px_rgba(51,51,51,0.7)] flex items-center justify-between px-10">
                
                    <a href="javascript:void(0)" class="els-wrap el-1"
                    onclick="openStorylineModal(); document.getElementById('nav-toggle').checked = false;">
                    <div class="icon-nav">
                        <i class="fa-regular fa-newspaper text-white"></i>
                    </div>
                    <p class="nav-label">Storyline</p>
                    </a>
                    
                    <a href="#" class="els-wrap el-2"
                    onclick="openTradezoneModal(); document.getElementById('nav-toggle').checked = false;">
                    <div class="icon-nav">
                        <i class="fa-regular fa-handshake text-white"></i>
                    </div>
                    <p class="nav-label">Tradezone</p>
                    </a>

                    
                    <a href="https://capital.petra.ac.id/scanQR" class="els-wrap el-2"
                    onclick=" document.getElementById('nav-toggle').checked = false;">
                    <div class="icon-nav">
                        <i class="fa-regular fa-object-group text-white"></i>
                    </div>
                    <p class="nav-label">Scan QR</p>
                    </a>
                    
                    <a href="javascript:void(0)" class="els-wrap el-3 text-white"
                    onclick="openInventoryModal(); document.getElementById('nav-toggle').checked = false;">
                    <div class="icon-nav">
                        <i class="far fa-comment-dots text-white"></i>
                    </div>
                    <p class="nav-label">Inventory</p>
                    </a>

                    <a href="{{ route('quiz') }}" class="els-wrap el-4">
                    <div class="icon-nav">
                        <i class="far fa-bell text-white"></i>
                    </div>
                    <p class="nav-label">Final Test</p>
                    </a>
          
                </div>
        
        </div>
    </nav>

    <nav id="nav-lg" class="navbar">
        <div class="nav-container  max-lg:!hidden lg:block">
            <input class="checkbox" type="checkbox" id="nav-toggle" />
            <label for="nav-toggle" class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </label>
            <div class="nav-overlay" onclick="document.getElementById('nav-toggle').checked = false;"></div>
            <ul class="menu-items font-quicksand flex flex-col items-center justify-center">
                <li>
                    <a href="javascript:void(0)"
                        onclick="openStorylineModal(); document.getElementById('nav-toggle').checked = false;">Storyline</a>
                </li>
                <li>
                    <a href="javascript:void(0)"
                        onclick="openTradezoneModal(); document.getElementById('nav-toggle').checked = false;">Tradezone</a>
                </li>
                <li>
                    <a href="javascript:void(0)"
                        onclick="openCluezoneModal(); document.getElementById('nav-toggle').checked = false;">Clue Zone</a>
                </li>
                <li>
                    <a href="javascript:void(0)"
                        onclick="openInventoryModal(); document.getElementById('nav-toggle').checked = false;">Inventory</a>
                </li>
                <li>
                    <a href="{{ route('quiz') }}">Final Test</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<script>
    function openStorylineModal() {
        var modal = document.getElementById("storylineModal");
        if (modal) {
            modal.classList.remove("hidden");
        } else {
            console.warn("Storyline modal not found.");
        }
    }

    function openTradezoneModal() {
        var modal = document.getElementById("tradezone-modal");
        if (modal) {
            modal.classList.remove("hidden");
        } else {
            console.warn("tradezone modal not found.");
        }
    }
    function openCluezoneModal() {
        var modal = document.getElementById("cluezone-modal");
        if (modal) {
            modal.classList.remove("hidden");
        } else {
            console.warn("cluezone modal not found.");
        }
    }

    function openInventoryModal() {
        var modal = document.getElementById("inventory-modal");
        if (modal) {
            modal.classList.remove("hidden");
        } else {
            console.warn("Inventory modal not found.");
        }
    }

    function openMapModal() {
        var overlay = document.getElementById('overlay-map');
        if (overlay) {
            overlay.classList.remove("hidden");
        } else {
            console.warn("Inventory modal not found.");
        }
    }

    document.addEventListener('click', function(event) {
        var navContainer = document.querySelector('.nav-container');
        if (navContainer && !navContainer.contains(event.target)) {
            document.getElementById('nav-toggle').checked = false;
        }
    });
</script>
