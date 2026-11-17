import { gsap } from "gsap";

export default function navigation({ reducedMotion = false } = {}) {
  const button = document.querySelector(".menu-toggle");
  const menu = document.querySelector("#mobile-nav");

  if (!button || !menu) return () => {};

  const links = menu.querySelectorAll("a");
  const openLabel = button.dataset.openLabel || button.getAttribute("aria-label") || "";
  const closeLabel = button.dataset.closeLabel || openLabel;
  const origin = getComputedStyle(document.documentElement).direction === "rtl"
    ? "right top"
    : "left top";

  let timeline = null;

  const setExpanded = (expanded) => {
    button.setAttribute("aria-expanded", String(expanded));
    button.setAttribute("aria-label", expanded ? closeLabel : openLabel);
  };

  const closeMenu = (restoreFocus = false) => {
    if (button.getAttribute("aria-expanded") !== "true") return;

    setExpanded(false);

    if (timeline && !reducedMotion) {
      timeline.reverse();
    } else {
      menu.hidden = true;
    }

    if (restoreFocus) button.focus();
  };

  const openMenu = () => {
    setExpanded(true);
    menu.hidden = false;

    if (timeline && !reducedMotion) {
      timeline.play();
    }
  };

  if (!reducedMotion) {
    timeline = gsap.timeline({
      paused: true,
      onReverseComplete: () => {
        menu.hidden = true;
      }
    });

    timeline.fromTo(
      menu,
      { autoAlpha: 0, y: -10, scaleY: 0.97, transformOrigin: origin },
      {
        autoAlpha: 1,
        y: 0,
        scaleY: 1,
        duration: 0.3,
        ease: "power3.out",
        clearProps: "transform,opacity,visibility"
      }
    );

    timeline.fromTo(
      links,
      { autoAlpha: 0, y: 8 },
      {
        autoAlpha: 1,
        y: 0,
        duration: 0.22,
        stagger: 0.035,
        ease: "power2.out",
        clearProps: "transform,opacity,visibility"
      },
      "-=0.13"
    );
  }

  const handleButtonClick = () => {
    const isOpen = button.getAttribute("aria-expanded") === "true";
    if (isOpen) closeMenu();
    else openMenu();
  };

  const handleMenuClick = (event) => {
    if (event.target.closest("a")) closeMenu();
  };

  const handleDocumentClick = (event) => {
    if (
      button.getAttribute("aria-expanded") === "true" &&
      !menu.contains(event.target) &&
      !button.contains(event.target)
    ) {
      closeMenu();
    }
  };

  const handleKeydown = (event) => {
    if (event.key === "Escape" && button.getAttribute("aria-expanded") === "true") {
      closeMenu(true);
    }
  };

  button.addEventListener("click", handleButtonClick);
  menu.addEventListener("click", handleMenuClick);
  document.addEventListener("pointerdown", handleDocumentClick);
  document.addEventListener("keydown", handleKeydown);

  setExpanded(false);
  menu.hidden = true;

  return () => {
    button.removeEventListener("click", handleButtonClick);
    menu.removeEventListener("click", handleMenuClick);
    document.removeEventListener("pointerdown", handleDocumentClick);
    document.removeEventListener("keydown", handleKeydown);
    timeline?.kill();
    gsap.set([menu, ...links], { clearProps: "all" });
    menu.hidden = true;
    setExpanded(false);
  };
}
