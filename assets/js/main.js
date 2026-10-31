import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import navigation from "./modules/navigation.js";
gsap.registerPlugin(ScrollTrigger);
if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", navigation, { once: true }); else navigation();
