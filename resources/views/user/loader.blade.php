<style>
.loader1, .loader2{
  position:absolute;
}

/*first loader*/
.loader1 {
  width: 50px;
  aspect-ratio: 1;
  display: grid;
  --b: 9px; /* Border thickness */
  border-radius: 50%;
}
.loader1::before,
.loader1::after {    
  content:"";
  grid-area: 1/1;
  --c:no-repeat radial-gradient(farthest-side,#25b09b 92%,#0000);
  background: 
    var(--c) 50%  0, 
    var(--c) 50%  100%, 
    var(--c) 100% 50%, 
    var(--c) 0    50%;
  background-size: 12px 12px;
  animation: rotateAndMove 1.5s 1 forwards,
    reverseRotateAndMove 1.5s 5.25s 1 forwards; 
}

.loader1::before {
  margin: 0;
  filter: hue-rotate(45deg);
  background-size: 8px 8px;
  animation-timing-function: linear;
}
@keyframes rotateAndMove {
  0% {
    transform: rotate(0);
    background-position: 
      50% 0, 
      50% 100%, 
      100% 50%, 
      0 50%;
    background-size: 12px 12px; /* Reduce background size */
  }
  25% {
    transform: rotate(0.5turn); 
    background-position: 
      50% 0, 
      50% 100%, 
      100% 50%, 
      0 50%; 
    background-size: 12px 12px;
  }
  50% {
    transform: rotate(0.5turn);
    background-position: 
      50% 50%, 
      50% 50%, 
      50% 50%, 
      50% 50%; 
    background-size: 8px 8px; 
  }
  100% {
    transform: rotate(0.5turn);
    background-position: 
      7% 26%,  /* right */
      93% 25%, /* left */
      51.5% 99%; /* top */
      /* x, y     */
    background-size: 8px 8px;
  }
}

@keyframes reverseRotateAndMove {
  0% {
    transform: rotate(0.5turn);
    background-position:
      7% 26%,  /* right */
      93% 25%, /* left */
      51.5% 99%; /* top */
    background-size: 8px 8px;
  }
  50% {
    transform: rotate(0.5turn);
    background-position: 
      50% 50%, 
      50% 50%, 
      50% 50%, 
      50% 50%; /* Move dots to center */
    background-size: 12px 12px;
  }
  75% {
    transform: rotate(0.5turn);
    background-position: 
      50% 0, 
      50% 100%, 
      100% 50%, 
      0 50%; /* Rotate halfway */
      background-size: 12px 12px;
  }
  100% {
    transform: rotate(0.5turn);
    background-position: 
      50% 0, 
      50% 100%, 
      100% 50%, 
      0 50%; /* Return to initial position */
    background-size: 12px 12px;
  }
}

/* second loader */
@property --my-var {
  syntax: '<integer>';
  inherits: false;
  initial-value: 0;
}

.loader2 {
  width: 50px;
  --b: 8px; /* Border thickness */
  aspect-ratio: 1;
  border-radius: 50%;
  background: conic-gradient(#56ae9c calc(var(--my-var) * 1deg), transparent calc(var(--my-var) * 1deg));  
  -webkit-mask:
    conic-gradient(#0000 0deg, #000 1deg 70deg, #0000 71deg 120deg, #000 121deg 190deg, #0000 191deg 240deg, #000 241deg 310deg, #0000 311deg 360deg), 
    radial-gradient(farthest-side, #0000 calc(100% - var(--b) - 1px), #000 calc(100% - var(--b)));
  mask-composite: intersect;
    animation: fillCircle 0.75s 1.5s linear forwards,
		unfillCircle 0.75s 4.6s linear forwards;
}

@keyframes fillCircle {
  from { --my-var: 0; }
  to { --my-var: 360; }
}

@keyframes unfillCircle {
  from { --my-var: 360; }
  to { --my-var: 0; }
}

.parent {
  position: relative;
  width: 50px; 
  height: 50px; 
  animation: l5 0.75s linear 3s 2 forwards;
}

@keyframes l5 {
  to { transform: rotate(1turn); }
}

.arrows {
  position: absolute;
  width: 0; 
  height: 0; 
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  border-bottom: 10px solid #56ae9c;
  opacity: 0;
  animation: showArrows 0.3s ease 2.25s forwards, 
    hideArrows 0.3s ease 4.5s forwards;
}

@keyframes showArrows {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes hideArrows {
  from { opacity: 1; }
  to { opacity: 0; }
}

.arrow1 {
  top: 13%;
  left: 8%;
  rotate: 50deg;
  transform: translate(-8%, -13%); 
}
.arrow2 {
  top: 35%;
  left: 56%;
  rotate: 160deg;
  transform: translate(-56%, -35%); 
}
.arrow3 {
  bottom: 1%;
  left: 23%;
  rotate: 288deg;
  transform: translate(-1%, -23%); 
}
}
</style>

<div class="parent">
  <div class="loader1"></div>
  <div class="loader2"></div>
  <div class="arrows arrow1 "></div>
  <div class="arrows arrow2 "></div>
  <div class="arrows arrow3 "></div>
</div>

<script>
  const loader1 = document.querySelector(".loader1")
  const loader2 = document.querySelector(".loader2")
  const arrows = document.querySelectorAll('.arrows')
  const parent = document.querySelector(".parent")

  loader1.addEventListener("animationend", (e) => {
    if(e.animationName == "reverseRotateAndMove") {
      //remove the classes
      loader1.classList.remove("loader1");
      loader2.classList.remove("loader2");
      parent.classList.remove("parent");
      arrows.forEach((arrow, index) => {
      arrow.classList.remove("arrows");
      });
      
      //trigger re-flow
      void document.body.offsetWidth;
      
      //re-apply classes
      loader1.classList.add("loader1");
      loader2.classList.add("loader2");
      parent.classList.add("parent");
      arrows.forEach((arrow, index) => {
      arrow.classList.add("arrows");
      });
    }
  });
</script>
  

