---
description: Turn English descriptions or code architectures into clean Mermaid diagrams, SVG/PNG assets, and editable Excalidraw scenes.
---

// turbo-all
# /diagram: Architecture & Flow Diagram Generator

Load identity: [persona-gstack-diagram.md](.antigravity/rules/persona-gstack-diagram.md)

## Phase 1: Architecture Analysis & Diagram Authoring
1. Understand the user's intent or inspect the codebase flow/architecture (data models, pipelines, service interactions).
2. Author clean, readable Mermaid syntax (`graph LR` for pipelines, `graph TD` for hierarchies, `sequenceDiagram` for API flows, `erDiagram` for data models).
3. Keep node labels concise (5-15 nodes max per diagram; split if complex).

## Phase 2: Render & Multi-Format Export
1. Save source `.mmd` file in `./docs/diagrams/` or `./diagrams/`.
2. Generate SVG / PNG renders or interactive Excalidraw scenes (`.excalidraw`).
3. If rendered via markdown or artifact, display the Mermaid diagram directly.

## Phase 3: Deliver & Presentation
1. Present the diagram inside a rich markdown artifact or documentation file.
2. Provide file paths and instructions for opening or editing in Excalidraw/Mermaid live editors.
