import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import navigation from "./navigation.js";

gsap.registerPlugin(ScrollTrigger);

const media = gsap.matchMedia();
const direction = () =>
  getComputedStyle(document.documentElement).direction === "rtl" ? 1 : -1;

function animatePageIntro({ isMobile, isTablet }) {
  const header = document.querySelector(".site-header");
  const heroImage = document.querySelector(".hero-image img");
  const heroCopy = document.querySelector(".hero-copy");
  const heroMeta = gsap.utils.toArray(".hero-index, .hero-caption");

  const timeline = gsap.timeline({
    defaults: { ease: "power3.out" }
  });

  if (header) {
    timeline.fromTo(
      header,
      { autoAlpha: 0, y: -14 },
      { autoAlpha: 1, y: 0, duration: 0.7, clearProps: "transform,opacity,visibility" },
      0
    );
  }

  if (heroImage) {
    timeline.fromTo(
      heroImage,
      { scale: 1.075, autoAlpha: 0.72 },
      {
        scale: 1,
        autoAlpha: 1,
        duration: 1.45,
        ease: "power2.out",
        clearProps: "opacity,visibility"
      },
      0
    );
  }

  if (heroCopy) {
    const items = heroCopy.querySelectorAll(
      ".eyebrow, h1, .hero-description, .hero-actions"
    );

    timeline.fromTo(
      items,
      {
        autoAlpha: 0,
        x: direction() * (isMobile ? 12 : 22),
        y: isMobile ? 12 : 18
      },
      {
        autoAlpha: 1,
        x: 0,
        y: 0,
        duration: isMobile ? 0.68 : 0.78,
        stagger: isMobile ? 0.075 : 0.095,
        clearProps: "transform,opacity,visibility"
      },
      0.12
    );
  }

  if (heroMeta.length) {
    timeline.fromTo(
      heroMeta,
      { autoAlpha: 0, y: 12, x: direction() * 10 },
      {
        autoAlpha: 1,
        y: 0,
        x: 0,
        duration: 0.65,
        stagger: 0.1,
        clearProps: "transform,opacity,visibility"
      },
      isTablet ? 0.42 : 0.5
    );
  }
}

function reveal(elements, trigger, options = {}) {
  const targets = gsap.utils.toArray(elements).filter(Boolean);
  if (!targets.length || !trigger) return;

  const {
    distance = 24,
    horizontal = 0,
    stagger = 0,
    start = "top 86%",
    duration = 0.72
  } = options;

  gsap.fromTo(
    targets,
    {
      autoAlpha: 0,
      y: distance,
      x: horizontal
    },
    {
      autoAlpha: 1,
      y: 0,
      x: 0,
      duration,
      stagger,
      ease: "power3.out",
      clearProps: "transform,opacity,visibility",
      scrollTrigger: {
        trigger,
        start,
        once: true,
        invalidateOnRefresh: true
      }
    }
  );
}

function createScrollMotion({ isMobile, isTablet }) {
  const travel = isMobile ? 18 : isTablet ? 22 : 28;
  const sideTravel = direction() * (isMobile ? 8 : 14);

  gsap.utils.toArray(".section-heading").forEach((heading) => {
    const targets = [
      heading.querySelector(":scope > div"),
      heading.querySelector(":scope > .section-intro")
    ].filter(Boolean);

    reveal(targets, heading, {
      distance: travel,
      horizontal: sideTravel,
      stagger: 0.11,
      start: "top 84%"
    });
  });

  const serviceList = document.querySelector(".service-list");
  reveal(".service-item", serviceList, {
    distance: isMobile ? 18 : 26,
    stagger: isMobile ? 0.07 : 0.11,
    start: "top 82%"
  });

  const portfolio = document.querySelector(".portfolio-feature");
  reveal(portfolio, portfolio, {
    distance: isMobile ? 20 : 30,
    horizontal: sideTravel,
    start: "top 84%"
  });

  const about = document.querySelector(".about-layout");
  if (about) {
    reveal(
      [about.querySelector(".about-statement"), about.querySelector(".about-details")],
      about,
      { distance: 22, horizontal: sideTravel, stagger: 0.13, start: "top 82%" }
    );
  }

  const advantages = document.querySelector(".advantage-grid");
  reveal(".advantage-grid article", advantages, {
    distance: 22,
    stagger: 0.09,
    start: "top 84%"
  });

  const process = document.querySelector(".process-grid");
  reveal(".process-grid article", process, {
    distance: 22,
    stagger: 0.085,
    start: "top 84%"
  });

  const contact = document.querySelector(".contact-inner");
  if (contact) {
    reveal(
      [
        contact.querySelector(":scope > .eyebrow"),
        contact.querySelector(".contact-layout"),
        contact.querySelector(".contact-note")
      ],
      contact,
      { distance: 20, stagger: 0.1, start: "top 86%" }
    );
  }

  const footerMain = document.querySelector(".footer-main");
  reveal(
    [".footer-brand", ...gsap.utils.toArray(".footer-column")],
    footerMain,
    { distance: 18, stagger: 0.09, start: "top 90%" }
  );

  const footerBottom = document.querySelector(".footer-bottom");
  reveal(footerBottom, footerBottom, {
    distance: 12,
    duration: 0.55,
    start: "top 96%"
  });

  gsap.utils
    .toArray(".section-heading .eyebrow-line, .about-statement .eyebrow-line, .contact-inner .eyebrow-line")
    .forEach((line) => {
      const trigger = line.closest(".section-heading, .about-statement, .contact-inner");
      gsap.fromTo(
        line,
        { scaleX: 0, transformOrigin: direction() === 1 ? "right center" : "left center" },
        {
          scaleX: 1,
          duration: 0.58,
          ease: "power2.out",
          scrollTrigger: { trigger, start: "top 86%", once: true }
        }
      );
    });

  const hero = document.querySelector(".hero-section");
  const heroImage = document.querySelector(".hero-image img");
  if (hero && heroImage) {
    gsap.to(heroImage, {
      yPercent: isMobile ? 2 : isTablet ? 4 : 7,
      ease: "none",
      scrollTrigger: {
        trigger: hero,
        start: "top top",
        end: "bottom top",
        scrub: 0.7,
        invalidateOnRefresh: true
      }
    });
  }
}

media.add(
  {
    isMobile: "(max-width: 600px)",
    isTablet: "(min-width: 601px) and (max-width: 1009px)",
    isDesktop: "(min-width: 1010px)",
    reduceMotion: "(prefers-reduced-motion: reduce)"
  },
  (context) => {
    const { isMobile, isTablet, reduceMotion } = context.conditions;
    const cleanupNavigation = navigation({ reducedMotion });

    if (reduceMotion) {
      return cleanupNavigation;
    }

    const motionContext = gsap.context(() => {
      animatePageIntro({ isMobile, isTablet });
      createScrollMotion({ isMobile, isTablet });
    }, document.body);

    let active = true;
    const refresh = () => {
      if (active) ScrollTrigger.refresh();
    };

    window.addEventListener("load", refresh, { once: true });
    document.fonts?.ready.then(refresh);

    return () => {
      active = false;
      window.removeEventListener("load", refresh);
      motionContext.revert();
      cleanupNavigation();
    };
  }
);
