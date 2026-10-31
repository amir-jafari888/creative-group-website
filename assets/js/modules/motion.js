import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
const isMobile = window.matchMedia("(max-width: 600px)").matches;
const direction = document.documentElement.dir === "rtl" ? 1 : -1;

function animatePageIntro() {
  const header = document.querySelector(".site-header");
  const heroCopy = document.querySelector(".hero-copy");
  const heroMeta = document.querySelectorAll(".hero-index, .hero-caption");

  if (header) gsap.from(header, {
    x: direction * (isMobile ? 76 : 116),
    autoAlpha: 0,
    duration: 1.25,
    ease: "power4.out",
    clearProps: "transform"
  });

  if (heroCopy) {
    const items = heroCopy.querySelectorAll(".eyebrow, h1, .hero-description, .hero-actions");
    gsap.from(items, {
      x: direction * (isMobile ? 88 : 148),
      autoAlpha: 0,
      duration: 1.2,
      stagger: 0.16,
      ease: "power4.out",
      delay: 0.12,
      clearProps: "transform"
    });
  }

  if (heroMeta.length) gsap.from(heroMeta, {
    x: direction * (isMobile ? 42 : 72),
    autoAlpha: 0,
    duration: 1,
    stagger: 0.12,
    delay: 0.38,
    ease: "power3.out",
    clearProps: "transform"
  });
}

function createSectionTransitions() {
  const hero = document.querySelector(".hero-section");
  const services = document.querySelector(".services-section");
  const work = document.querySelector(".work-section");
  const sectionOffset = isMobile ? 54 : 112;

  // Keep the natural document scroll. ScrollTrigger pinning on consecutive
  // sections was creating a long, confusing scroll lock at their boundaries.
  if (hero) gsap.set(hero, { position: "relative", zIndex: 1 });

  [services, work].forEach((section, index) => {
    if (!section) return;

    gsap.set(section, {
      position: "relative",
      zIndex: index + 2
    });

    // RTL sections enter from the right; LTR sections enter from the left.
    // Scrubbing makes the same movement reverse naturally when scrolling up.
    gsap.fromTo(section, {
      x: direction * sectionOffset,
      autoAlpha: 0.94
    }, {
      x: 0,
      autoAlpha: 1,
      ease: "none",
      scrollTrigger: {
        trigger: section,
        start: "top bottom",
        end: "top 18%",
        scrub: 0.65,
        invalidateOnRefresh: true
      }
    });
  });
}

function createContentReveals() {
  const revealTargets = [
    ".services-section .section-heading", ".service-item", ".work-section .section-heading",
    ".portfolio-feature", ".about-layout", ".advantages-section .section-heading",
    ".advantage-grid article", ".process-section .section-heading", ".process-grid article",
    ".contact-inner", ".footer-brand", ".footer-column", ".footer-bottom"
  ];

  revealTargets.forEach((selector) => {
    gsap.utils.toArray(selector).forEach((element, index) => {
      gsap.fromTo(element, {
        autoAlpha: 0, y: isMobile ? 24 : 38,
        x: element.closest(".section-heading") ? direction * 16 : 0
      }, {
        autoAlpha: 1, x: 0, y: 0, duration: 0.85, ease: "power3.out",
        delay: [".service-item", ".advantage-grid article", ".process-grid article"].includes(selector) ? index * 0.07 : 0,
        scrollTrigger: { trigger: element, start: "top 88%", once: true },
        clearProps: "transform"
      });
    });
  });

  [".about-section", ".advantages-section", ".process-section"].forEach((selector) => {
    const section = document.querySelector(selector);
    const content = section?.querySelector(".container");
    if (!section || !content) return;
    gsap.fromTo(content, { scale: 0.965, transformOrigin: "50% 50%" }, {
      scale: 1, ease: "none",
      scrollTrigger: { trigger: section, start: "top 88%", end: "top 28%", scrub: 0.7 }
    });
  });
}

function createMenuMotion() {
  const button = document.querySelector(".menu-toggle");
  const menu = document.querySelector("#mobile-nav");
  if (!button || !menu) return;

  const origin = document.documentElement.dir === "rtl" ? "90% 0%" : "10% 0%";
  gsap.set(menu, { clipPath: `circle(0% at ${origin})`, autoAlpha: 0, display: "none" });

  const timeline = gsap.timeline({ paused: true, defaults: { ease: "power3.inOut" } })
    .set(menu, { display: "block", autoAlpha: 1 })
    .to(menu, { clipPath: `circle(150% at ${origin})`, duration: 0.62 })
    .from(menu.querySelectorAll("a"), {
      y: 10, autoAlpha: 0, stagger: 0.045, duration: 0.28, ease: "power2.out"
    }, 0.18);

  const closeMenu = () => {
    button.setAttribute("aria-expanded", "false");
    timeline.reverse();
    timeline.eventCallback("onReverseComplete", () => { menu.hidden = true; });
  };

  button.addEventListener("click", () => {
    const opening = button.getAttribute("aria-expanded") !== "true";
    button.setAttribute("aria-expanded", String(opening));
    if (opening) {
      menu.hidden = false;
      timeline.eventCallback("onReverseComplete", null);
      timeline.play(0);
    } else closeMenu();
  });

  menu.querySelectorAll("a").forEach((link) => link.addEventListener("click", closeMenu));
}

function createControlTransitions() {
  gsap.utils.toArray(".button, .header-cta, .language-switch, .service-link, .portfolio-feature-footer a, .footer-column a").forEach((element) => {
    element.addEventListener("mouseenter", () => gsap.to(element, { y: -2, duration: 0.22, ease: "power2.out", overwrite: true }));
    element.addEventListener("mouseleave", () => gsap.to(element, { y: 0, duration: 0.28, ease: "power2.out", overwrite: true }));
  });
}

function initMotion() {
  if (reducedMotion) return;
  animatePageIntro();
  createSectionTransitions();
  createContentReveals();
  createMenuMotion();
  createControlTransitions();
  window.addEventListener("load", () => ScrollTrigger.refresh(), { once: true });
}

if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", initMotion, { once: true });
else initMotion();
