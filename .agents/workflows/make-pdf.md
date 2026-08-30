---
description: Turn any markdown document into a publication-quality PDF with typography, margins, cover pages, and clickable TOC.
---

// turbo-all
# /make-pdf: Markdown to Publication PDF

Load identity: [persona-gstack-make-pdf.md](.antigravity/rules/persona-gstack-make-pdf.md)

> [!NOTE]
> **Environment Status:** Headless Chrome & Microsoft Edge are available for `--print-to-pdf` rendering. Standalone `typst`/`weasyprint` CLI tools are optional alternatives.

## Phase 1: Markdown Pre-Processing & Layout Configuration
1. Inspect the source markdown file for structure (headings, tables, images, mermaid code blocks).
2. Determine publication layout options:
   - Margins (1in default), page orientation (portrait/landscape)
   - Optional cover page (`--cover`, author, title, date)
   - Clickable Table of Contents (`--toc`)
   - Watermark (`--watermark DRAFT` or `--watermark CONFIDENTIAL`)

## Phase 2: HTML & Print CSS Generation
1. Convert Markdown to self-contained HTML with print stylesheet (typography, headers, footers, page-break rules).
2. Render diagrams (Mermaid) and local image assets directly into vector/base64 structures.

## Phase 3: PDF Generation & Verification
1. Render HTML to PDF using available headless browser engine (`chrome.exe` / `msedge.exe` `--headless --print-to-pdf=<out.pdf>`) or available PDF engine.
2. Verify output PDF exists and report absolute file path to user.
