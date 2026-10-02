import { useMemo, useState } from "react";
import {
  ArrowLeft,
  ArrowRight,
  BarChart3,
  BookOpen,
  Building2,
  Check,
  ChevronDown,
  ChevronRight,
  ClipboardCheck,
  FileText,
  Folder,
  GraduationCap,
  LayoutDashboard,
  Library,
  Link2,
  Menu,
  Microscope,
  Network,
  PanelLeftClose,
  Search,
  Settings,
  ShieldCheck,
  Users,
  X,
} from "lucide-react";

const colleges = [
  {
    short: "CAL",
    name: "College of Arts and Letters",
    programs: ["Bachelor of Arts in Communication", "Bachelor of Arts in Broadcasting"],
  },
  {
    short: "CS",
    name: "College of Science",
    programs: ["Bachelor of Science in Biology", "Bachelor of Science in Computer Science"],
  },
  {
    short: "CE",
    name: "College of Education",
    programs: ["Bachelor of Elementary Education", "Bachelor of Secondary Education"],
  },
];

const areas = [
  {
    number: "I",
    title: "Vision, Mission, Goals and Objectives",
    description: "Present the approved VMGO, stakeholder dissemination, and evidence of alignment.",
    icon: BookOpen,
    completed: 5,
    total: 8,
  },
  {
    number: "II",
    title: "Faculty",
    description: "Document faculty qualifications, workload, development, and performance evaluation.",
    icon: Users,
    completed: 7,
    total: 10,
  },
  {
    number: "III",
    title: "Curriculum and Instruction",
    description: "Provide curriculum design, instructional delivery, assessment, and learning outcomes.",
    icon: GraduationCap,
    completed: 9,
    total: 12,
  },
  {
    number: "IV",
    title: "Support to Students",
    description: "Detail student services, scholarships, guidance, welfare, and development programs.",
    icon: ShieldCheck,
    completed: 3,
    total: 9,
  },
  {
    number: "V",
    title: "Research",
    description: "Present the research agenda, outputs, funding, participation, and utilization.",
    icon: Microscope,
    completed: 6,
    total: 8,
  },
  {
    number: "VI",
    title: "Extension and Community Involvement",
    description: "Document extension priorities, partnerships, implementation, and community impact.",
    icon: Network,
    completed: 4,
    total: 8,
  },
  {
    number: "VII",
    title: "Library",
    description: "Show library holdings, digital resources, services, staffing, and utilization.",
    icon: Library,
    completed: 8,
    total: 8,
  },
  {
    number: "VIII",
    title: "Physical Plant and Facilities",
    description: "Provide evidence for campus facilities, safety, accessibility, and maintenance.",
    icon: Building2,
    completed: 4,
    total: 7,
  },
  {
    number: "IX",
    title: "Laboratories",
    description: "Document laboratory equipment, safety protocols, staffing, and learning support.",
    icon: Settings,
    completed: 2,
    total: 7,
  },
  {
    number: "X",
    title: "Administration",
    description: "Present governance, organization, policy implementation, and quality assurance.",
    icon: ClipboardCheck,
    completed: 5,
    total: 9,
  },
];

const navGroups = [
  {
    label: "WORKSPACE",
    items: [
      { label: "Dashboard", icon: LayoutDashboard },
      { label: "Documents", icon: Folder, expanded: true },
    ],
  },
  {
    label: "OPERATIONS",
    items: [
      { label: "Accreditation Visits", icon: FileText },
      { label: "Task Forces", icon: Users },
      { label: "Submissions Review", icon: ShieldCheck },
      { label: "Compliance Analytics", icon: BarChart3 },
    ],
  },
  {
    label: "ADMINISTRATION",
    items: [
      { label: "Colleges & Programs", icon: Building2 },
      { label: "Master Instruments", icon: Library },
      { label: "User Accounts", icon: Users },
      { label: "Audit Trail Logs", icon: ShieldCheck },
    ],
  },
];

function AppButton({
  children,
  className = "",
  ...props
}: React.ButtonHTMLAttributes<HTMLButtonElement>) {
  return (
    <button className={`btn ${className}`} {...props}>
      {children}
    </button>
  );
}

function StatusBadge({ completed, total }: { completed: number; total: number }) {
  if (completed === total) {
    return (
      <span className="status status-complete">
        <Check size={12} strokeWidth={3} />
        Complete
      </span>
    );
  }
  if (completed > 0) {
    return <span className="status status-progress">In progress</span>;
  }
  return <span className="status status-pending">Pending</span>;
}

function Sidebar({ open, onClose }: { open: boolean; onClose: () => void }) {
  return (
    <>
      {open && <div className="sidebar-scrim" onClick={onClose} />}
      <aside className={`sidebar ${open ? "sidebar-open" : ""}`}>
        <div className="brand">
          <div className="seal-mark">BU</div>
          <div>
            <div className="brand-name">IQArchive</div>
            <div className="brand-subtitle">IQA OFFICE · BU</div>
          </div>
          <AppButton className="btn-ghost brand-collapse" aria-label="Close navigation" onClick={onClose}>
            <PanelLeftClose size={17} />
          </AppButton>
        </div>

        <nav className="nav-content" aria-label="Main navigation">
          {navGroups.map((group) => (
            <div className="nav-group" key={group.label}>
              <div className="nav-label">{group.label}</div>
              {group.items.map((item) => (
                <div key={item.label}>
                  <AppButton className={`nav-item ${item.expanded ? "nav-parent-active" : ""}`}>
                    <item.icon size={16} />
                    <span>{item.label}</span>
                    {item.expanded && <ChevronDown className="nav-chevron" size={14} />}
                  </AppButton>
                  {item.expanded && (
                    <div className="nav-children">
                      <AppButton className="nav-child">
                        <FileText size={14} /> Common Documents
                      </AppButton>
                      <AppButton className="nav-child nav-child-active">
                        <Folder size={14} /> Program Accreditation
                      </AppButton>
                      <AppButton className="nav-child">
                        <Building2 size={14} /> Institutional Accreditation
                      </AppButton>
                    </div>
                  )}
                </div>
              ))}
            </div>
          ))}
        </nav>

        <div className="user-block">
          <div className="avatar">IU</div>
          <div>
            <div className="user-name">IQA Staff User</div>
            <div className="user-role">IQA Staff</div>
          </div>
          <ChevronDown size={14} className="user-chevron" />
        </div>
      </aside>
    </>
  );
}

function AreaCard({
  area,
  onOpen,
}: {
  area: (typeof areas)[number];
  onOpen: () => void;
}) {
  const progress = Math.round((area.completed / area.total) * 100);
  return (
    <article className="area-card card">
      <div className="area-card-top">
        <div className="area-icon">
          <area.icon size={19} />
        </div>
        <div className="area-heading">
          <div className="area-eyebrow">AREA {area.number}</div>
          <div className="area-title">{area.title}</div>
        </div>
        <StatusBadge completed={area.completed} total={area.total} />
      </div>
      <p className="area-description">{area.description}</p>
      <div className="area-progress-row">
        <div className="area-progress-track" aria-label={`${progress}% complete`}>
          <div className="area-progress-fill" style={{ width: `${progress}%` }} />
        </div>
        <span>
          {area.completed}/{area.total} criteria
        </span>
      </div>
      <div className="area-card-footer">
        <span>{progress}% complete</span>
        <AppButton className="btn-primary btn-sm" onClick={onOpen}>
          Open profile <ArrowRight size={14} />
        </AppButton>
      </div>
    </article>
  );
}

export default function App() {
  const [collegeIndex, setCollegeIndex] = useState(0);
  const [program, setProgram] = useState(colleges[0].programs[0]);
  const [tab, setTab] = useState<"narrative" | "ppp">("ppp");
  const [query, setQuery] = useState("");
  const [selectedArea, setSelectedArea] = useState<(typeof areas)[number] | null>(null);
  const [sidebarOpen, setSidebarOpen] = useState(false);

  const college = colleges[collegeIndex];
  const filteredAreas = useMemo(
    () =>
      areas.filter((area) =>
        `${area.number} ${area.title} ${area.description}`.toLowerCase().includes(query.toLowerCase()),
      ),
    [query],
  );
  const totalCompleted = areas.reduce((sum, area) => sum + area.completed, 0);
  const totalCriteria = areas.reduce((sum, area) => sum + area.total, 0);
  const overallProgress = Math.round((totalCompleted / totalCriteria) * 100);

  function changeCollege(nextIndex: number) {
    setCollegeIndex(nextIndex);
    setProgram(colleges[nextIndex].programs[0]);
  }

  return (
    <div className="app-shell">
      <Sidebar open={sidebarOpen} onClose={() => setSidebarOpen(false)} />

      <main className="workspace">
        <header className="topbar">
          <div className="title-row">
            <div className="title-wrap">
              <AppButton className="btn-ghost mobile-menu" onClick={() => setSidebarOpen(true)}>
                <Menu size={20} />
              </AppButton>
              <div>
                <h1>Program Accreditation Documents</h1>
                <p>Prepare and monitor accreditation profiles by academic program.</p>
              </div>
            </div>
            <div className="program-id-card">
              <div className="program-seal">{college.short}</div>
              <div>
                <strong>{program}</strong>
                <span>{college.name}</span>
                <small>Level I–II Accreditation</small>
              </div>
            </div>
          </div>

          <div className="selection-bar">
            <div className="selection-step">
              <span className="step-number">1</span>
              <label htmlFor="college">Select College</label>
              <select
                id="college"
                className="select"
                value={collegeIndex}
                onChange={(event) => changeCollege(Number(event.target.value))}
              >
                {colleges.map((item, index) => (
                  <option value={index} key={item.short}>
                    {item.name}
                  </option>
                ))}
              </select>
            </div>
            <ChevronRight className="selection-arrow" size={18} />
            <div className="selection-step selection-program">
              <span className="step-number">2</span>
              <label htmlFor="program">Select Program</label>
              <select
                id="program"
                className="select"
                value={program}
                onChange={(event) => setProgram(event.target.value)}
              >
                {college.programs.map((item) => (
                  <option key={item}>{item}</option>
                ))}
              </select>
            </div>
            <ChevronRight className="selection-arrow" size={18} />
            <div className="profile-tabs" role="tablist" aria-label="Profile type">
              <AppButton
                role="tab"
                aria-selected={tab === "narrative"}
                className={tab === "narrative" ? "tab-active" : ""}
                onClick={() => setTab("narrative")}
              >
                <BookOpen size={16} /> Narrative Profile
              </AppButton>
              <AppButton
                role="tab"
                aria-selected={tab === "ppp"}
                className={tab === "ppp" ? "tab-active" : ""}
                onClick={() => setTab("ppp")}
              >
                <ClipboardCheck size={16} /> Performance Profile
              </AppButton>
            </div>
          </div>
        </header>

        <div className="content">
          <div className="breadcrumb">
            <span>Documents</span>
            <ChevronRight size={13} />
            <span>Program Accreditation</span>
            <ChevronRight size={13} />
            <span>{college.short}</span>
            <ChevronRight size={13} />
            <span>{program}</span>
            <ChevronRight size={13} />
            <strong>{tab === "ppp" ? "Program Performance Profile" : "Narrative Profile"}</strong>
          </div>

          {tab === "ppp" ? (
            <>
              <section className="profile-banner">
                <div className="profile-banner-icon">
                  <ClipboardCheck size={24} />
                </div>
                <div className="profile-banner-copy">
                  <div className="banner-title-line">
                    <h2>Program Performance Profile</h2>
                    <span>Level I–II</span>
                  </div>
                  <p>Complete the program performance profile across all ten AACCUP survey areas.</p>
                </div>
                <a
                  className="btn btn-outline template-link"
                  href="https://docs.google.com/document/d/1Pwv8MBYmYrrh8aVwEJ8uwdlQp8B4emrw/edit?usp=sharing&ouid=109544054632104586601&rtpof=true&sd=true"
                  target="_blank"
                  rel="noreferrer"
                >
                  <FileText size={16} /> Open PPP template <Link2 size={14} />
                </a>
              </section>

              <section className="overview-card card">
                <div>
                  <span className="overview-label">Overall completion</span>
                  <strong>{overallProgress}%</strong>
                  <p>
                    {totalCompleted} of {totalCriteria} criteria prepared across all areas
                  </p>
                </div>
                <div className="overview-track">
                  <div style={{ width: `${overallProgress}%` }} />
                </div>
                <div className="overview-meta">
                  <span><Check size={14} /> 1 complete</span>
                  <span>8 in progress</span>
                  <span>1 needs attention</span>
                </div>
              </section>

              <div className="section-heading-row">
                <div>
                  <h2>All accreditation areas</h2>
                  <p>Open an area to prepare narrative evidence and supporting documents.</p>
                </div>
                <label className="search-field">
                  <Search size={16} />
                  <input
                    aria-label="Search accreditation areas"
                    placeholder="Search areas"
                    value={query}
                    onChange={(event) => setQuery(event.target.value)}
                  />
                </label>
              </div>

              <div className="area-grid">
                {filteredAreas.map((area) => (
                  <AreaCard key={area.number} area={area} onOpen={() => setSelectedArea(area)} />
                ))}
              </div>
            </>
          ) : (
            <section className="narrative-empty card">
              <div className="narrative-icon"><BookOpen size={28} /></div>
              <h2>Narrative Profile Workspace</h2>
              <p>Prepare qualitative narrative evaluations and attach supporting exhibits for each required area.</p>
              <AppButton className="btn-primary" onClick={() => setTab("ppp")}>
                View Program Performance Profile <ArrowRight size={15} />
              </AppButton>
            </section>
          )}
        </div>
      </main>

      {selectedArea && (
        <div className="drawer-backdrop" role="presentation" onMouseDown={() => setSelectedArea(null)}>
          <aside className="area-drawer" role="dialog" aria-modal="true" onMouseDown={(event) => event.stopPropagation()}>
            <div className="drawer-header">
              <AppButton className="btn-ghost" onClick={() => setSelectedArea(null)}>
                <ArrowLeft size={17} />
              </AppButton>
              <div>
                <span>AREA {selectedArea.number}</span>
                <h2>{selectedArea.title}</h2>
              </div>
              <AppButton className="btn-ghost drawer-close" aria-label="Close area" onClick={() => setSelectedArea(null)}>
                <X size={18} />
              </AppButton>
            </div>
            <div className="drawer-content">
              <div className="drawer-callout">
                <selectedArea.icon size={20} />
                <p>{selectedArea.description}</p>
              </div>
              <div className="drawer-section-title">Profile requirements</div>
              {["Narrative response", "Performance indicators", "Supporting exhibits", "Area summary"].map(
                (item, index) => (
                  <div className="requirement-row" key={item}>
                    <span className={index < selectedArea.completed / 3 ? "requirement-check done" : "requirement-check"}>
                      {index < selectedArea.completed / 3 && <Check size={13} />}
                    </span>
                    <div>
                      <strong>{item}</strong>
                      <span>{index < selectedArea.completed / 3 ? "Prepared" : "Requires attention"}</span>
                    </div>
                    <ChevronRight size={16} />
                  </div>
                ),
              )}
            </div>
            <div className="drawer-footer">
              <AppButton className="btn-ghost" onClick={() => setSelectedArea(null)}>Close</AppButton>
              <AppButton className="btn-primary">Continue editing <ArrowRight size={14} /></AppButton>
            </div>
          </aside>
        </div>
      )}
    </div>
  );
}
