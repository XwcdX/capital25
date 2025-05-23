<style>
    .animated-greener {
        position: relative;
        color: #ffffff;
        padding: 0 2px;
    }

    .animated-greener::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 0;
        background: #344E41;
        z-index: -1;
        transition: width 1s ease;
        animation: paintBackground 1s ease forwards;
        animation-delay: 0.5s;
    }

    @keyframes paintBackground {
        from {
            width: 0;
        }

        to {
            width: 100%;
        }
    }

    .animated-underline {
        position: relative;
    }

    .animated-underline::after {
        content: "";
        position: absolute;
        display: block;
        height: 3px;
        width: 0;
        background-color: #fff;
        top: 100%;
        left: 0;
        border-radius: 3px;
        animation: drawUnderline 1s ease forwards;
        animation-delay: 0.3s;
    }

    @keyframes drawUnderline {
        from {
            width: 0;
        }

        to {
            width: 100%;
        }
    }

    .fade-in-text span {
        opacity: 0;
        display: inline-block;
        animation: fadeIn 0.5s ease forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .welcomeP {
        color: white;
        font-size: 1.25rem;
        line-height: calc(1.75 / 1.25);
    }

    #animated-text {
        width: 70%;
    }

    @media screen and (max-width: 768px) {
        .welcomeP {
            font-size: 1.125rem;
            line-height: calc(1.75 / 1.125);
        }

        #animated-text {
            width: 80%;
        }
    }

    @media screen and (max-width: 640px) {
        .welcomeP {
            font-size: 1rem;
            line-height: calc(1.5 / 1);
        }

        #animated-text {
            width: 75%;
        }
    }

    @media screen and (max-width: 376px) {
        #animated-text {
            width: 85%;
        }
    }
</style>

<div class="w-screen h-screen bg-[var(--cap-green3)] fixed inset-0 flex flex-col justify-center items-center z-[1000] font-quicksand">
    <h1 class="welcomeH text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 md:mb-5 lg:mb-7 text-center"></h1>
    <p id="animated-text" class="text-center font-semibold text-white relative fade-in-text"></p>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo({
            top: 0
        });
    });
    window.addEventListener("load", function() {
        setTimeout(() => {
            document.body.style.overflow = "hidden";
            document.documentElement.style.overflow = "hidden";
        }, 900);
    });
    const fullText =
        `Thank you for joining us in this exciting occasion, your contribution will truly make a difference. Together, let's build a brighter and greener future!`;

    function setPlaceholderHeight(selector, text) {
        const tempElement = document.createElement("span");
        tempElement.style.visibility = "hidden";
        tempElement.style.position = "absolute";
        tempElement.style.whiteSpace = "pre-wrap";
        tempElement.style.fontSize = getComputedStyle(document.querySelector(selector)).fontSize;
        tempElement.style.fontWeight = getComputedStyle(document.querySelector(selector)).fontWeight;
        tempElement.style.lineHeight = getComputedStyle(document.querySelector(selector)).lineHeight;
        tempElement.textContent = text;
        document.body.appendChild(tempElement);

        const textHeight = tempElement.offsetHeight;
        const container = document.querySelector(selector);
        container.style.minHeight = `${textHeight}px`;

        document.body.removeChild(tempElement);
    }

    function typeText(selector, text, speed, callback, delayAfterTyping = 500) {
        document.body.style.overflow = "hidden";

        setPlaceholderHeight("#animated-text", fullText);

        let i = 0;
        const element = document.querySelector(selector);
        element.innerText = "";
        element.style.opacity = 1;

        const typingInterval = setInterval(() => {
            if (i < text.length) {
                if (text.charAt(i) === ' ' && i + 1 < text.length) {
                    element.innerText += ' ' + text.charAt(i + 1);
                    i += 2;
                } else {
                    element.innerText += text.charAt(i);
                    i++;
                }
            } else {
                clearInterval(typingInterval);
                if (callback) setTimeout(callback, delayAfterTyping);
            }
        }, speed);
    }

    function scrollToTopAndRemoveContent() {
        setTimeout(() => {
            const mainContainer = document.querySelector(".w-screen");
            mainContainer.style.transition = "height 1s ease-in-out";
            mainContainer.style.overflow = "hidden";
            mainContainer.style.height = "0";
            setTimeout(() => {
                mainContainer.remove();
                document.body.style.overflowY = "auto";
                document.documentElement.style.overflow = "auto";
            }, 1000);
        }, 500);
    }

    typeText(".welcomeH", "Welcome, Team {{ $name }}", 100, () => {
        animateText(fullText, "animated-text", () => {
            setTimeout(() => {
                scrollToTopAndRemoveContent();
            }, 1500);
        });
    }, 700);

    const animateText = (text, containerId, onComplete) => {
        const container = document.getElementById(containerId);
        const words = text.split(" ");
        const animationDelayFactor = 0.2;

        words.forEach((word, index) => {
            if (word === "brighter") {
                const brighterSpan = document.createElement("span");
                brighterSpan.textContent = word;
                brighterSpan.style.animationDelay = `${index * animationDelayFactor}s`;
                brighterSpan.classList.add("welcomeP");
                container.appendChild(brighterSpan);
                setTimeout(() => {
                    brighterSpan.classList.add("animated-underline");
                }, (index + 1) * animationDelayFactor * 1000);

                container.appendChild(document.createTextNode(" "));
            } else if (word === "greener") {
                const greenerGroup = document.createElement("span");
                greenerGroup.innerHTML = `<span style="animation-delay: ${
                        index * animationDelayFactor
                    }s;">${word}</span>&nbsp;<span style="animation-delay: ${
                        (index + 1) * animationDelayFactor
                    }s;">future!</span>`;
                greenerGroup.classList.add("welcomeP");
                container.appendChild(greenerGroup);
                setTimeout(() => {
                    greenerGroup.classList.add("animated-greener");
                }, (index + 1) * animationDelayFactor * 1000);
                container.appendChild(document.createTextNode(" "));
            } else if (word !== "future!") {
                const span = document.createElement("span");
                span.style.animationDelay = `${index * animationDelayFactor}s`;
                span.innerHTML = `${word}&nbsp;`;
                span.classList.add("welcomeP");
                container.appendChild(span);
            }
        });
        const totalDuration =
            words.length * animationDelayFactor * 1000 + 1000;
        setTimeout(() => {
            if (onComplete) onComplete();
        }, totalDuration);
    };
</script>
