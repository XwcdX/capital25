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
        background: transparent;
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
</style>

<div id="navbar">
    <nav class="navbar">
        <div class="nav-container">
            <input class="checkbox" type="checkbox" id="nav-toggle" />
            <label for="nav-toggle" class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </label>
            <div class="nav-overlay" onclick="document.getElementById('nav-toggle').checked = false;"></div>
            <ul class="menu-items">
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
                        onclick="openInventoryModal(); document.getElementById('nav-toggle').checked = false;">Inventory</a>
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

    function openInventoryModal() {
        var modal = document.getElementById("inventory-modal");
        if (modal) {
            modal.classList.remove("hidden");
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
