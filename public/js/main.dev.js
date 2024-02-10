"use strict";

var scroller = new LocomotiveScroll({
  el: document.querySelector(".smooth-scroll"),
  smooth: true,
  lerp: 0.05,
  // Linear Interpolation, 0 > 1 // Try 0.01
  multiplier: 1.4,
  // Effect Multiplier
  reloadOnContextChange: true,
  touchMultiplier: 2,
  smoothMobile: 0,
  smartphone: {
    smooth: !0,
    breakpoint: 767
  },
  tablet: {
    smooth: !1,
    breakpoint: 1024
  }
});
var target = document.querySelector('.js-animated-text');
var results = Splitting({
  target: target,
  by: 'words'
});
var tl = new TimelineMax();
tl.set(".word", {
  x: "1em",
  opacity: 0,
  ease: "power1.inOut"
});
tl.to('.word', {
  opacity: 1,
  duration: 1.3,
  stagger: {
    each: .075
  },
  x: "0em",
  transformOrigin: "0% 100%",
  ease: 'ease'
});