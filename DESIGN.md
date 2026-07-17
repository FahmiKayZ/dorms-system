---
name: D.O.R.M.S. Design System
description: Modern, clean, and reliable light-theme design system for college room bookings.
colors:
  primary: "#009e60"
  accent: "#4eca6e"
  accent-dim: "#3aaa58"
  neutral-bg: "#f5f5f5"
  neutral-surface: "#e8e8e8"
  text-heading: "#1f1f1f"
  text-body: "#4a4a4a"
  text-muted: "#3a3131"
  border: "#d4d4d4"
  btn-primary: "#3a9147"
  btn-primary-hover: "#2d7a3a"
typography:
  display:
    fontFamily: "Inter, sans-serif"
    fontWeight: 800
  body:
    fontFamily: "Inter, sans-serif"
    fontWeight: 400
rounded:
  default: "10px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "32px"
components:
  button-primary:
    backgroundColor: "{colors.btn-primary}"
    textColor: "#ffffff"
    rounded: "{rounded.default}"
    padding: "12px 24px"
  button-primary-hover:
    backgroundColor: "{colors.btn-primary-hover}"
---

# Design System: D.O.R.M.S.

## 1. Overview

**Creative North Star: "The Modern Campus Portal"**

D.O.R.M.S. (Digital Occupancy and Room Management System) utilizes a clean, modern, and high-contrast light design system. The system prioritizes functional efficiency, structured data displays, and high readability for students and administrators. By replacing legacy academic layouts with generous spacing and distinct visual hierarchy, the system reduces cognitive load during room selection and administrative tasks.

### Key Characteristics:
- **Clean Structure**: Content is organized using soft borders and card panels, avoiding unnecessary lines.
- **Vibrant Accentuation**: Brand greens highlight actions, states, and statuses, while neutral tints carry the layout.
- **Symmetrical Spacing**: Consistent 8px grid steps govern typography margins, paddings, and card alignments.

---

## 2. Colors

The color palette centers on professional greens to evoke security and growth, balanced by soft whitesmoke and gainsboro neutrals.

### Primary
- **Shamrock Green** (`#009e60` / `oklch(60% 0.17 150)`): Primary brand color anchoring the navigation header.

### Accent
- **Mantis Green** (`#4eca6e` / `oklch(75% 0.19 140)`): Brand action color used for status badges, highlights, and icons.
- **Sea Green** (`#3aaa58` / `oklch(65% 0.16 142)`): Accent variant for hover/active state indicators.

### Neutral
- **Whitesmoke** (`#f5f5f5`): Main page background, softer than pure white.
- **Gainsboro** (`#e8e8e8`): Tonal card and section backgrounds.
- **Eerie Black** (`#1f1f1f`): Max-contrast heading and title text color.
- **Davy's Gray** (`#4a4a4a`): Primary readable body text color.
- **Light Gray** (`#d4d4d4`): Hairline dividers and border accents.

### Named Rules
**The Green Rarity Rule.** The vibrant Mantis Green accent is used on ≤10% of any screen surface to draw immediate attention to statuses, active states, or key callouts.

---

## 3. Typography

**Display Font:** Inter, sans-serif
**Body Font:** Inter, sans-serif

The typography system relies entirely on the geometric neo-grotesque font **Inter** to ensure screen readability across mobile and desktop.

### Hierarchy
- **Display** (800, `clamp(2rem, 5vw, 3.5rem)`, 1.1): Used for main hero headlines.
- **Headline** (700, `1.75rem`, 1.2): Section titles and dashboard block headings.
- **Title** (600, `1.25rem`, 1.3): Card headings and table headers.
- **Body** (400, `1rem`, 1.5): Standard readable copy, labels, and metadata. Max line length is 75ch.
- **Label** (500, `0.85rem`, 1.4): Table contents, support details, status text.

---

## 4. Elevation

The depth strategy relies primarily on tonal surfaces (Whitesmoke bg vs Gainsboro cards) and fine borders, rather than heavy multi-layered shadows.

### Shadow Vocabulary
- **Card Shadow** (`0 1px 4px rgba(0,0,0,0.1)`): Standard flat elevation shadow used to separate elements from the background.
- **Nav Shadow** (`0 2px 8px rgba(0,0,0,0.08)`): Sticky navbar elevation lift.

### Named Rules
**The Flat-By-Default Rule.** All containers and inputs are flat at rest. Depth shadows are applied only to floating cards, modals, or dropdowns to draw attention.

---

## 5. Components

### Buttons
- **Shape**: Rounded corners (`10px` radius).
- **Primary**: Background color (`#3a9147`), white text, bold font, and custom padding (`12px 24px`).
- **Hover**: Transitions background color to `#2d7a3a` over `0.2s` standard easing.
- **Ghost**: Translucent border (`1.5px solid rgba(0,0,0,0.18)`), dark text, and soft green background highlight on hover.

### Cards / Containers
- **Corner Style**: Rounded corners (`10px` radius).
- **Background**: Solid white (`#ffffff`) or Gainsboro (`#e8e8e8`).
- **Shadow**: Card Shadow (`0 1px 4px rgba(0,0,0,0.1)`).
- **Border**: Thin border (`1px solid #d4d4d4`).

### Inputs / Fields
- **Style**: Light gray border, white background, `10px` border-radius.
- **Focus**: Standard outline in Shamrock Green (`#009e60`) to guide user input.

---

## 6. Do's and Don'ts

### Do:
- **Do** maintain a consistent `10px` corner radius on all interactive components (buttons, inputs, card containers).
- **Do** ensure text overlays meet WCAG AA requirements (minimum 4.5:1 ratio).
- **Do** use `127.0.0.1` and port `3307` configuration when communicating with local MySQL.

### Don't:
- **Don't** use legacy table borders or tiny font sizes (less than 12px) that reduce legibility.
- **Don't** nest cards within card panels (depth structure should be single-level).
- **Don't** animate image scale or rotation directly on hover states.
