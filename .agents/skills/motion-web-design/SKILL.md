---
name: motion-web-design
description: Plan and implement polished, choreographed motion for the existing Creative Technology Group website without changing its PHP and Vite architecture.
---

# Motion Web Design

Use this skill when a task involves a page-wide motion direction, hero choreography, scroll-linked section transitions, or coordinated animation across multiple sections.

## Project constraints — read first

This repository is an existing classic PHP site. Vite bundles the existing frontend entry point; it is not the application framework.

- Never run npm create vite, replace the project scaffold, or move the site into a new src/ structure.
- Preserve PHP routing, pages/, partials/, the existing assets/css/ responsive organization, and assets/js/main.js plus its modules.
- Reuse the installed GSAP and ScrollTrigger dependencies. Do not add Lenis or other packages unless explicitly approved.
- Inspect the current markup, selectors, animation module, and CSS before proposing changes.
- Keep the current design system and approved visual direction. Motion should support the design, not redesign it.

## Workflow

1. Audit before editing
   - Read the relevant PHP partials and CSS for the affected sections.
   - Read assets/js/main.js and the current motion module.
   - Identify existing triggers, transforms, stacking contexts, reduced-motion handling, and event listeners.
   - Confirm whether the requested motion is entrance-based, scroll-linked, state-based, or a combination.

2. Define a motion system
   - Establish a small set of durations, easings, distances, and stagger intervals.
   - Use a clear hierarchy: primary content first, supporting details second, decorative details last.
   - Keep related interactions consistent.
   - Avoid animating every element; intentional restraint is part of the visual quality.

3. Implement incrementally
   - Make one coherent change at a time.
   - Prefer GSAP timelines for coordinated sequences and ScrollTrigger for scroll-linked behavior.
   - Prefer transforms and opacity. Avoid animating layout properties unless there is a clear technical reason.
   - Use gsap.matchMedia() or equivalent responsive setup when behavior genuinely differs by breakpoint.
   - Ensure triggers are refreshed after layout-changing assets load when necessary.
   - Revert media contexts and clean up listeners/observers when modules are reinitialized or torn down.

4. Scroll choreography
   - Prefer natural document scrolling with scrubbed transforms/reveals.
   - Use pinning only when the interaction clearly requires a fixed scene and the pin duration/spacing has been deliberately designed.
   - Do not chain adjacent pinned sections casually; this can create apparent scroll locks, jumps, and difficult reverse-scroll behavior.
   - Test both forward and reverse scrolling.
   - Do not animate the same transform property on the same element from competing tweens/triggers.

5. Language direction
   - Read direction from the document (dir / computed direction), not from hard-coded assumptions.
   - RTL and LTR entrances should feel intentional and mirror correctly.
   - Avoid reversing vertical motion or unrelated interactions merely because the language is RTL.

6. Responsive behavior
   - Validate mobile, tablet, and desktop separately.
   - Reduce travel distance and stagger on smaller screens where appropriate.
   - Do not simply disable all mobile motion; preserve useful feedback while avoiding heavy or fragile effects.
   - Account for touch input and reduced viewport height.

7. Quality gate
   - Check prefers-reduced-motion: reduce; provide a meaningful static/low-motion experience.
   - Check for horizontal overflow, scroll jumps, sticky/pin conflicts, layout shifts, and console errors.
   - Verify load entrance, section entry, reverse scroll, resize, and navigation/menu interactions.
   - Keep performance focused on transform/opacity and avoid excessive simultaneous effects.
   - Report exactly what was changed and what was or was not tested.

## Definition of done

A motion change is not complete merely because the code compiles. It must preserve the site architecture, behave in both directions, respect language direction and reduced-motion preferences, and be checked at all three project breakpoints.

## Upstream inspiration

- https://github.com/motionharvest/agent-skills/tree/main/motion-web-design

This file is a project-specific guide, not a verbatim copy of the upstream skill. The upstream scaffold and dependency-install steps are intentionally not adopted because they conflict with this repository.
