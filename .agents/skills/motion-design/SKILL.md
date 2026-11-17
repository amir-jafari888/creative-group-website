---
name: motion-design
description: Implement purposeful, accessible, performant UI animation with CSS and GSAP in this PHP/Vite website.
---

# Motion Design

Use this skill for individual animations, transitions, micro-interactions, entrance/exit behavior, scroll effects, easing, and motion performance.

## Principles

1. Purpose before decoration. Every animation should communicate hierarchy, causality, state, spatial continuity, or feedback. If it communicates nothing, remove it.
2. Respect user preferences. Support prefers-reduced-motion: reduce; remove nonessential movement and preserve content visibility and functionality.
3. Prefer compositor-friendly properties. Favor transform and opacity. Animate dimensions, positional layout properties, filters, and shadows only when justified and tested.
4. Use consistent timing. Small feedback should feel immediate; entrances should be brief; complex sequences should not delay access to content. Avoid arbitrary durations and excessive stagger.
5. Design for interruption. Animations should remain understandable if the user scrolls quickly, changes direction, resizes the viewport, or interacts before an animation finishes.
6. Accessibility is functional. Motion must not hide essential information, trap focus, flash rapidly, or make controls harder to use.

## Practical timing guidance

Treat these as starting ranges, not fixed laws:
- Tiny hover/press feedback: roughly 100–180ms.
- Standard UI state transitions: roughly 160–280ms.
- Content entrances: roughly 350–700ms.
- Large coordinated hero sequences: use the shortest timeline that preserves clear hierarchy.

Choose easing according to intent: ease-out for entrances, ease-in for exits, and restrained spring-like behavior for direct interaction. Avoid bounce by default on premium/editorial interfaces.

## Implementation rules

- Inspect the existing component markup and CSS before selecting animation targets.
- Reuse the project's GSAP/ScrollTrigger setup when it is the best fit; use CSS transitions for simple state changes.
- Avoid introducing a second animation library for effects already supported by the current stack.
- Avoid competing animations on the same element/property.
- Keep content visible when JavaScript is unavailable or reduced motion is requested.
- Ensure hover-only effects have an equivalent focus-visible or touch-friendly behavior.
- Use semantic controls and do not make animation the only indication of state.
- Scope selectors to the relevant component; avoid broad global selectors.
- Clean up GSAP contexts, event listeners, observers, and ScrollTriggers when lifecycle/reinitialization requires it.

## Performance and validation

- Avoid animating layout-heavy properties across many elements.
- Do not add continuous animation without a clear purpose.
- Test on a realistic mobile viewport and, where possible, a throttled CPU.
- Check reduced motion, keyboard focus, touch behavior, resize, and rapid repeated interaction.
- Watch for layout shift, text clipping, overflow, flicker, and console errors.
- Do not claim a 60fps result without measuring it.

## Project-specific constraints

- Keep the existing PHP + Vite architecture.
- Keep JavaScript in assets/js/ and respect the current modular structure.
- Preserve the responsive CSS files and their established breakpoints.
- Do not add packages or rewrite the animation architecture without explicit approval.

## Upstream inspiration

- https://github.com/ligj1706/ProSkills/tree/main/dev-skills/ui-ux-design/motion-design

This is an original project-adapted guide. It intentionally omits repository-specific response gimmicks and focuses on the useful engineering principles.
