---
name: motion-ref
description: Select a suitable UI motion pattern for a specific product interaction, then implement only the relevant pattern.
---

# Motion Ref

Use this skill when the requested effect is vague (for example, “make it feel more premium”), or when choosing among patterns for loading, navigation, scroll, buttons, overlays, text, icons, lists, and ambient effects.

## Workflow

1. Translate the request into a user-facing problem:
   - What is the user doing?
   - What feedback or hierarchy is missing?
   - What should the motion communicate?
2. Classify the interaction before choosing an effect:
   - Loading / waiting feedback
   - Button / action feedback
   - Text / number emphasis
   - Overlay / tooltip / drawer
   - Navigation / view transition
   - Form / input state
   - Scroll-linked reveal or progress
   - Icon / logo state
   - Carousel / list / accordion
   - General enter / exit
   - Ambient brand atmosphere
3. If the brief is ambiguous, present at most two or three distinct directions before implementing. Do not guess a complex interaction from “make it cooler.”
4. Select the smallest pattern that solves the problem. Prefer one clear effect over a stack of decorative effects.
5. Explain the user benefit, then implement it using the existing project stack.
6. Validate keyboard, touch, reduced-motion, RTL/LTR, and responsive behavior as relevant.

## Pattern selection guide

| Scenario | Candidate pattern | Main caution |
|---|---|---|
| A control was activated | Press/active state, progress, success/error feedback | Do not delay the actual action |
| Content is loading | Skeleton, progress indicator, subtle placeholder transition | Never fake progress or block usable content |
| A section enters view | Fade/translate reveal, staggered group entrance | Avoid hiding content if JS fails |
| A long page needs orientation | Reading progress or restrained sticky context | Avoid scroll hijacking |
| Navigation changes state | Underline/indicator transition or short view transition | Preserve focus and browser navigation |
| A panel opens | Fade + short translate/scale | Keep focus management and escape behavior |
| A number changes | Short count/odometer transition | Keep the final value accessible |
| An icon changes state | Morph, rotation, or swap | Preserve a non-animated state cue |
| A list changes | Animate only inserted/removed/reordered items | Avoid reanimating the whole list on every update |
| Brand atmosphere is needed | Very restrained gradient, light, or parallax movement | Avoid constant distracting motion |

## Selection rules

- Prefer familiar interaction feedback over novelty.
- Do not use scroll hijacking or forced scrolling.
- Do not use parallax or large-scale movement when it harms readability or touch usability.
- Do not add cursor-follow effects on touch devices.
- Keep motion direction consistent with spatial meaning and the document's RTL/LTR direction.
- Never use animation to conceal slow operations or errors.
- If the effect adds no meaningful feedback, hierarchy, or continuity, recommend not adding it.

## Project integration

Use the current PHP markup, existing CSS modules, and GSAP/ScrollTrigger installation. Do not scaffold a new application, install Lenis, or add a new animation dependency without explicit approval.

For a specific implementation, consult .agents/skills/motion-design/SKILL.md. For a page-wide choreography, consult .agents/skills/motion-web-design/SKILL.md.

## Upstream inspiration

- https://github.com/joepUI/motion-ref-skill

This file is a concise, project-specific decision guide, not a copy of the upstream reference catalog.
