# AGENTS.md — HONAMAS WordPress Platform

## 1. Purpose

This repository contains the custom WordPress block theme and supporting functionality for the HONAMAS web platform.

The platform serves two clearly separated purposes:

1. `honamas.com`
   - Public brand and history website.
   - Explains the origin, identity, development and achievements of HONAMAS.
   - Presents the 20-year anniversary of HONAMAS in 2026.
   - May serve as a concept and content proposal for the Deutscher Hockey-Bund.
   - Must not link to, mention or expose `20years.honamas.com`.

2. `20years.honamas.com`
   - Separate reunion microsite for the core group.
   - Publicly reachable only by people who know the domain.
   - Must not be linked from `honamas.com`, navigation menus, footer, sitemap, RSS feeds, XML sitemaps, structured data or public promotional content.
   - Event: HONAMAS 2006 reunion, 28–30 August 2026, Zandvoort and Amstelveen.
   - Countdown target: 28 August 2026, 18:00, timezone `Europe/Amsterdam`.

The system must remain easy to maintain through WordPress while all design and technical functionality are version-controlled in GitHub and can be developed through Codex.

---

## 2. Core architecture

Use:

- WordPress as CMS.
- A custom native WordPress block theme.
- Gutenberg/Core blocks wherever possible.
- `theme.json` as the primary design-system configuration.
- A small custom plugin named `honamas-core` for functionality that must survive a theme change.
- GitHub as the source of truth for code.
- GitHub Actions for deployment.
- Staging before production.

Do not use:

- Kubio in the new implementation.
- Elementor, Divi, WPBakery or other page builders.
- Paid plugins unless explicitly approved.
- Hard-coded editorial content in templates.
- Direct edits to WordPress Core.
- Direct database manipulation from deployment scripts.

Preferred repository structure:

```text
honamas-web/
├── wp-content/
│   ├── themes/
│   │   └── honamas/
│   │       ├── assets/
│   │       ├── parts/
│   │       ├── patterns/
│   │       ├── styles/
│   │       ├── templates/
│   │       ├── functions.php
│   │       ├── style.css
│   │       └── theme.json
│   └── plugins/
│       └── honamas-core/
├── .github/workflows/
├── scripts/
├── AGENTS.md
└── README.md
```

---

## 3. Environments and deployment

Target environments:

- `staging.honamas.com` — development and approval environment for the public website.
- `honamas.com` — public production website.
- `20years.honamas.com` — separate reunion production website.

Deployment rules:

1. Every code change must be committed to Git.
2. Changes must first be deployed to staging or a dedicated reunion preview environment.
3. Production deployment requires manual approval.
4. Never deploy uncommitted local files.
5. Never overwrite `wp-content/uploads`.
6. Never overwrite environment-specific configuration.
7. Never commit credentials, API keys, SSH keys or passwords.
8. Use GitHub Secrets for deployment credentials.
9. Create a backup before any production release.
10. Provide a rollback path to the previous release.

Recommended workflow:

```text
feature branch
→ pull request
→ automated checks
→ staging deployment
→ visual and functional approval
→ merge
→ manually approved production deployment
```

---

## 4. Editorial model

All normal content must remain editable in WordPress.

Use standard WordPress pages for:

- HONAMAS story
- Origin of the name
- 2006 World Championship
- Team identity
- The original HONAMAS squad
- Film
- Achievements
- 20 years of HONAMAS
- Contact
- Imprint
- Privacy policy

Use standard WordPress posts for:

- News
- Historical stories
- Anniversary content
- DHB-related updates
- Reunion information on `20years.honamas.com`

Suggested post categories on the reunion site:

- Ablauf
- Treffpunkte
- Zandvoort
- Amstelveen
- Anreise
- Unterkunft
- Teilnehmer
- Erinnerungen
- Updates

Avoid custom post types unless they provide a clear long-term benefit.

---

## 5. Public HONAMAS website: strategic goal

The public website must explain that HONAMAS is more than a nickname. It is a team identity created by players, made visible in 2006 and carried forward over 20 years.

The website should feel:

- confident
- reduced
- modern
- athletic
- historic without being nostalgic
- emotional without becoming sentimental
- unmistakably German without relying on flag decoration

The core narrative is:

> A team gave itself a name, built an identity and became world champion. Twenty years later, HONAMAS has become part of German hockey culture.

Primary audiences:

- hockey fans
- former and current national players
- Deutscher Hockey-Bund stakeholders
- media
- sponsors and partners
- people interested in team identity and high-performance culture

---

## 6. Public website information architecture

Recommended main navigation:

- Story
- 2006
- Team
- Film
- Erfolge
- 20 Jahre

Do not add a link to the reunion microsite.

Recommended homepage structure:

1. Hero
   - HONAMAS logo
   - strong anniversary statement
   - concise subline
   - primary call to action to the story or film

2. The founding idea
   - short explanation of the original question and origin

3. 2006
   - visual chapter about identity, logo, team collection and World Championship title

4. 20 years of HONAMAS
   - anniversary section connected to the 2026 World Cup context
   - suitable for sharing with the Deutscher Hockey-Bund

5. Timeline
   - 2000/2001: initial idea
   - 2006: identity becomes visible
   - 17 September 2006: world champions in Mönchengladbach
   - 2010: trademark registration
   - 2015: rediscovery and renewed storytelling
   - 2021: rights transferred to the DHB
   - 2026: 20 years of HONAMAS

6. The original HONAMAS
   - team grid

7. Film
   - strong full-width media section

8. Achievements
   - restrained, typographic presentation

9. Final statement
   - identity-driven closing message

---

## 7. Reunion microsite: strict separation

`20years.honamas.com` must be technically and editorially separate from the public site.

Mandatory rules:

- No link from `honamas.com` to `20years.honamas.com`.
- No mention of the reunion domain on the public site.
- No reunion domain in public navigation, footer, XML sitemap, RSS, Open Graph metadata or structured data.
- Add `noindex, nofollow, noarchive, nosnippet` to all reunion pages.
- Exclude the reunion site from WordPress XML sitemaps.
- Disable public author archives, tag archives and unnecessary feeds on the reunion site.
- Do not publish the reunion URL through public social channels.
- Do not use the reunion URL in public source code comments or documentation deployed to production.

Important:

`noindex` and the absence of links reduce discoverability but do not create access control. Anyone who knows or receives the URL can access the site. Do not store confidential, sensitive or security-relevant information there.

Reunion homepage structure:

1. Hero
   - `20 YEARS`
   - `WORLD CHAMPIONS 2006`
   - `28–30 AUGUST 2026`
   - `ZANDVOORT · AMSTELVEEN`

2. Countdown
   - target: `2026-08-28T18:00:00+02:00`
   - timezone: `Europe/Amsterdam`
   - accessible fallback text
   - graceful state after the countdown reaches zero

3. Latest update
   - clearly highlighted newest post

4. Current schedule
   - editable blocks, not hard-coded

5. Latest posts
   - automatic query loop

6. Key locations
   - simple cards with optional map links

7. Team / participants
   - optional, only when content is approved

8. Memories
   - selected images or quotes

9. Footer
   - minimal, private-community tone

---

## 8. Design direction

### Overall concept

The design should translate the logic of a hockey tactics board into a premium digital editorial system.

Use:

- lines, circles, movement paths and positional geometry
- cropped photography
- generous whitespace
- bold, condensed or wide sports typography for headlines
- restrained motion
- sharp hierarchy
- asymmetrical but controlled layouts

Avoid:

- literal flag backgrounds
- trophy collages
- generic stadium stock photography
- gradients without purpose
- excessive shadows
- glassmorphism
- decorative animations
- dense card grids
- overly rounded UI elements

### Colour system

The visual base should reference Germany through a sophisticated interpretation of black, red and gold. Pink is an accent inspired by the current HONAMAS alternate kit.

Use the following initial tokens. Validate them against the final logo files and photographic material before release.

```text
honamas-black:      #111111
honamas-charcoal:   #242424
honamas-off-white:  #F5F2EA
honamas-white:      #FFFFFF
honamas-red:        #C8102E
honamas-gold:       #D6A313
honamas-pink:       #E6007E
honamas-pink-soft:  #F7D5E8
honamas-grey:       #727272
honamas-line:       #D9D5CC
```

Usage rules:

- Black/charcoal: primary background, typography and authority.
- Off-white: editorial breathing space and historical warmth.
- Red: selective national reference and key emphasis.
- Gold: titles, milestones and championship context.
- Pink: contemporary accent, interaction and alternate-kit reference.
- Never use red, gold and pink with equal visual weight in one section.
- Maximum one dominant accent colour per section.
- Ensure WCAG AA contrast for body text and controls.

### Typography

Use local or privacy-compliant web fonts only.

For the public HONAMAS website, use Montserrat as the primary typeface. Ship the
required font files with the theme and declare them through `@font-face`; do not
load typography from a third-party runtime service. Use a restrained weight set
(400, 500, 600, 700 and 800) and preserve comfortable reading sizes on mobile.

Recommended direction:

- Headlines: strong grotesk, condensed sans or wide athletic sans.
- Body: highly legible neutral sans-serif.
- Numbers and dates: tabular numerals where useful.

Do not use more than two font families.

### Story fidelity

The HONAMAS story is factual editorial content, not campaign copy. The existing
content at `https://honamas.com/` is the canonical source until a newer approved
source is supplied.

- Preserve every essential event, attribution, chronology and context from the
  original story when restructuring or improving the language.
- Never invent motivations, people, dates, outcomes, quotes or historical
  details.
- Do not reduce the story to broad claims when the original provides material
  detail, including the Australia observation, the 2006 team process, the
  visibility at the home World Cup, the years after 2006, the 2015 retelling and
  the formal trademark handover in 2021.
- Clearly mark any new editorial text that has not yet been checked against the
  canonical source for review before publication.
- Write German with proper umlauts (`ä`, `ö`, `ü`, `ß`) rather than ASCII
  substitutions.

### Imagery

- Prefer authentic HONAMAS and 2006 photography.
- Use large editorial crops.
- Maintain a consistent image ratio system.
- Do not stretch or artificially upscale low-resolution images without review.
- Provide meaningful alt text.
- Decorative images must use empty alt attributes.

---

## 9. Block-theme implementation rules

Use `theme.json` to define:

- colour palette
- typography scale
- spacing scale
- content and wide widths
- button styles
- link styles
- block defaults
- editor controls available to editors

Prefer Core blocks:

- Group
- Cover
- Columns
- Grid
- Image
- Heading
- Paragraph
- Buttons
- Query Loop
- Post Template
- Navigation
- Site Logo
- Template Part

Create block patterns for:

- hero
- anniversary statement
- timeline section
- story chapter
- team grid
- quote
- film section
- achievement list
- reunion update card
- reunion schedule
- location card
- countdown wrapper

Patterns must remain editable and must not lock normal editorial text unless locking is required to protect layout structure.

Use custom blocks only when Core blocks cannot provide a maintainable solution.

---

## 10. `honamas-core` plugin

The plugin may contain:

- countdown block or shortcode
- reunion site indexing controls
- XML sitemap exclusions
- optional event fields
- optional location fields
- small editor enhancements
- reusable functionality independent of the theme

Countdown requirements:

- Server-provided target timestamp.
- Client-side display update.
- No dependency on a large JavaScript framework.
- Days, hours, minutes and seconds.
- Correct behaviour across daylight-saving time.
- Screen-reader-friendly text.
- No layout shift.
- After expiry, show an editable message such as `Wir sind wieder da.`

Do not place countdown logic solely inside a page builder or inline editor script.

---

## 11. Performance

Targets:

- Mobile-first.
- No unnecessary JavaScript.
- No jQuery unless WordPress Core or an approved dependency requires it.
- Lazy-load non-critical images.
- Use responsive images generated by WordPress.
- Use modern formats where supported.
- Preload only truly critical assets.
- Minimise third-party requests.
- Avoid autoplay video with audio.
- Aim for strong Core Web Vitals.

---

## 12. Accessibility

Minimum requirements:

- WCAG 2.2 AA as the target standard.
- Keyboard-accessible navigation.
- Visible focus states.
- Correct heading hierarchy.
- Sufficient colour contrast.
- Alt text for meaningful images.
- Reduced-motion support.
- Accessible labels for countdown values.
- No information conveyed by colour alone.

---

## 13. Security and privacy

- Escape all dynamic output.
- Sanitize all inputs.
- Use WordPress nonces and capability checks for admin actions.
- Do not expose environment details.
- Do not commit secrets.
- Keep dependencies minimal.
- Do not create unauthenticated write endpoints.
- Disable XML-RPC when not required by the hosting setup.
- Use privacy-friendly embeds or click-to-load solutions for external video and maps.

---

## 14. Migration from Kubio

Treat the current Kubio website as a content source, not as the technical base for the new theme.

Migration procedure:

1. Back up files and database.
2. Clone production to `staging.honamas.com`.
3. Install and activate the new block theme on staging only.
4. Rebuild each page with Core blocks and HONAMAS patterns.
5. Preserve approved text, media and URLs where appropriate.
6. Replace Kubio-specific blocks.
7. Test all breakpoints.
8. Test SEO metadata and redirects.
9. Remove Kubio only after no page depends on Kubio blocks.
10. Deploy after approval.

Do not attempt a blind database-level conversion of Kubio markup.

---

## 15. Coding standards

- Follow WordPress Coding Standards.
- Use semantic HTML.
- Keep PHP compatible with the hosting environment.
- Use CSS custom properties generated from theme tokens.
- Keep JavaScript modular and dependency-light.
- Document non-obvious decisions.
- Keep functions small and purpose-specific.
- Prefix global PHP functions, handles and options with `honamas_`.
- Use translation functions for user-facing strings.
- Use German as the initial editorial language.

---

## 16. Definition of done

A task is complete only when:

- code is committed
- linting and basic validation pass
- there are no PHP or browser-console errors
- desktop, tablet and mobile have been checked
- keyboard navigation works
- content remains editable in WordPress
- no paid dependency was introduced
- the reunion site remains unlinked and excluded from indexing
- staging has been tested
- production deployment is manually approved
- rollback instructions are available

---

## 17. Codex operating behaviour

Before changing code, Codex must:

1. Read this file and the repository README.
2. Inspect the current structure before creating new files.
3. Explain briefly which files will be changed.
4. Reuse existing tokens, patterns and components.
5. Avoid broad rewrites when a focused change is sufficient.

After changing code, Codex must report:

- files changed
- functional effect
- test steps
- known limitations
- deployment impact

Codex must never:

- deploy directly to production without approval
- delete uploads
- alter production data
- expose the reunion domain publicly
- add a link from `honamas.com` to `20years.honamas.com`
- introduce Kubio or another page builder
- hard-code passwords or secrets
- claim that `noindex` makes a website private

---

## 18. First implementation milestones

### Milestone 1 — Foundation

- Create block-theme skeleton.
- Create `theme.json` design tokens.
- Create header and footer.
- Create core patterns.
- Create staging deployment workflow.

### Milestone 2 — Reunion microsite

- Build reunion homepage.
- Build countdown.
- Configure posts and categories.
- Add noindex and sitemap exclusion.
- Test on mobile.
- Deploy to `20years.honamas.com` after approval.

### Milestone 3 — Public HONAMAS redesign

- Rebuild homepage on staging.
- Create story, 2006, team, film, achievements and anniversary templates.
- Create timeline.
- Migrate Kubio content.
- Conduct quality assurance.

### Milestone 4 — Production launch

- Backup current production.
- Confirm redirects and SEO settings.
- Deploy approved theme.
- Verify production.
- Remove Kubio only when safe.
