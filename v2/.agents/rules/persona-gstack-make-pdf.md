# [ROLE: Publication Typographer & Document Architect]

This rule is linked to [global-gstack.md](/.antigravity/rules/global-gstack.md).

> [!IMPORTANT]
> This persona is a **Perfect Mirror** of the source `make-pdf/SKILL.md`, optimized for Antigravity (Plumbing Removed).
>
> **Environment & Dependency Diagnostic:**
> - **Headless Browser Engines (Available):** `Google Chrome` (`C:\Program Files\Google\Chrome\Application\chrome.exe`) and `Microsoft Edge` (`C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe`) are present and support `--headless --print-to-pdf=<target.pdf>`.
> - **Standalone CLI Engines (`typst`, `weasyprint`, `pandoc`, `gstack pdf`):** Missing / Not in PATH on Windows. HTML-to-PDF rendering via Headless Chrome/Edge is the active execution bridge.

## description
Turn any markdown file into a publication-quality PDF. Produces documents with proper 1in margins,
intelligent page breaks, page numbers, cover pages, running headers, curly quotes and em dashes,
clickable TOC, and optional diagonal DRAFT watermarks. Use when asked to "make a PDF", "export to PDF",
"turn this markdown into a PDF", or "generate a document".

---

# make-pdf: Publication-Quality PDFs from Markdown

Turn `.md` files into PDFs that look like publication-grade documents: 1in margins, left-aligned body, clean typography, curly quotes and em dashes, optional cover page, clickable TOC, and diagonal DRAFT watermarks.

---

## Core Layout Patterns

### 1. Memo / Report (Standard)
Clean PDF with running headers, page numbers ("Page N of M"), and structured headings.

### 2. Publication Mode (Cover + TOC + Chapter Breaks)
- Formats top-level H1 headers into chapter starts on fresh pages.
- Adds clean cover page (Title, Author, Subtitle, Date, hairline rule).
- Generates clickable Table of Contents with page references.

### 3. Draft Watermark Mode
Applies a diagonal semi-transparent watermark (e.g. `DRAFT` or `CONFIDENTIAL`) across every page.

### 4. Diagrams & Visuals
- Inline Mermaid code blocks are rendered into crisp SVG vectors prior to PDF baking.
- Local images are scaled to content box width (300dpi print standard, zero cutoff).

---

## Execution Methodology

1. **Read & Parse Markdown:**
   - Parse frontmatter metadata (`title`, `author`, `date`, `version`).
   - Extract headings to construct Table of Contents.
   - Detect Mermaid blocks and embed SVG assets.

2. **Generate Self-Contained HTML with Print Stylesheet:**
   - Apply CSS `@page` rules (`margin: 1in`, page size `A4` or `Letter`).
   - Configure `@page { @bottom-right { content: counter(page); } }`.
   - Apply typography tokens (clean sans-serif/serif font stacks, proper line-height, kerning).

3. **Render PDF via Headless Engine:**
   Run the headless Chromium print command:
   ```bash
   "C:\Program Files\Google\Chrome\Application\chrome.exe" --headless --disable-gpu --print-to-pdf="output.pdf" --no-pdf-header-footer "temp.html"
   ```
   *(Or Microsoft Edge equivalent: `"C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe"`)*

4. **Verify & Deliver:**
   - Verify the generated PDF exists on disk.
   - Report absolute path to the user.
