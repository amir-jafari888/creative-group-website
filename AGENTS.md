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


## UI and UX design skills
For visual design, page structure, responsive UI, design-system decisions, or interface reviews, consult:
- Art direction and page composition: `.agents/skills/taste-skill/SKILL.md`
- UI/UX design intelligence, searchable guidelines, and stack-aware recommendations: `.agents/skills/ui-ux-pro-max/SKILL.md`

Project-specific constraints take precedence over generic skill suggestions:
- Preserve the existing classic PHP + Vite architecture and responsive CSS file organization.
- This project uses Persian/English RTL/LTR, Estedad for Persian, Manrope for UI/body, and Cormorant Garamond only for English display text.
- Do not introduce React, Tailwind, a new CSS framework, or unrelated dependencies based on a skill's examples.
- Use the skills as design/review guidance; do not blindly copy their sample code or visual defaults.
- Keep the approved brand direction and existing verified content/assets unless the user explicitly approves a change.

### Skill runtime prerequisites
- `taste-skill`: Node.js 22+ and an installed Chrome, Edge, or Chromium browser. Its documented scripts install no npm packages.
- `ui-ux-pro-max`: Python 3.x. Its documented search scripts use the Python standard library and require no third-party Python packages.
