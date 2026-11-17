# Repository Agent Guidance

## Project architecture is authoritative
This repository is an existing classic PHP website with Vite used only to bundle frontend assets. Preserve the current architecture and file organization.

- Do not scaffold a new Vite application or replace PHP pages/partials.
- Do not introduce React, Vue, another framework, or a new routing system.
- Keep JavaScript modules under assets/js/ and styles in the existing responsive CSS structure under assets/css/.
- Keep the three responsive ranges aligned with the existing CSS architecture: mobile (up to 600px), tablet (601px–1009px), desktop (1010px and above).
- Reuse the installed GSAP/ScrollTrigger setup where appropriate. Do not add Lenis or any dependency unless the user explicitly approves it.
- Do not rewrite existing animation behavior unrelated to the requested change.

## Motion skills
For motion-related work, consult only the skill(s) relevant to the task:
- Whole-page / section choreography: .agents/skills/motion-web-design/SKILL.md
- Animation implementation, accessibility, performance, and timing: .agents/skills/motion-design/SKILL.md
- Choosing a suitable interaction pattern: .agents/skills/motion-ref/SKILL.md

These are project-adapted guides informed by the upstream resources linked in each file; they are not verbatim copies. If a skill conflicts with this file, the current repository architecture and this file take precedence.

## Required motion QA
- Check RTL and LTR behavior; direction must follow the document language/direction.
- Check mobile, tablet, and desktop independently.
- Respect prefers-reduced-motion.
- Avoid scroll-locking pin sequences and overlapping ScrollTriggers.
- Test reverse scrolling, resize/refresh behavior, and console errors.
- Do not claim visual verification unless the browser was actually tested.
