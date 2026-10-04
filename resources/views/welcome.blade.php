<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Michael Gadiano — IT Expert specializing in network infrastructure, systems administration, and cybersecurity.">
    <title>Michael Gadiano | IT Expert</title>
    <style>
        :root {
            --bg: #0b1220;
            --bg-soft: #111a2c;
            --card: #16223a;
            --border: #223350;
            --text: #e6edf7;
            --muted: #8fa3c0;
            --accent: #38bdf8;
            --accent-2: #6366f1;
            --green: #34d399;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, Roboto, Helvetica, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }

        .container { max-width: 1080px; margin: 0 auto; padding: 0 1.5rem; }

        /* ---------- Nav ---------- */
        nav {
            position: sticky;
            top: 0;
            z-index: 10;
            background: rgba(11, 18, 32, 0.85);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
        }
        nav .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--text);
        }
        .logo-badge {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0b1220;
            font-weight: 800;
            font-size: 1.05rem;
        }
        .nav-links { display: flex; gap: 1.5rem; font-size: 0.95rem; }
        .nav-links a { color: var(--muted); }
        .nav-links a:hover { color: var(--text); text-decoration: none; }

        /* ---------- Hero ---------- */
        .hero {
            padding: 5rem 0 4rem;
            background:
                radial-gradient(600px 300px at 85% 10%, rgba(99, 102, 241, 0.18), transparent),
                radial-gradient(500px 260px at 10% 30%, rgba(56, 189, 248, 0.12), transparent);
        }
        .hero .container {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 3rem;
            align-items: center;
        }
        .avatar {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 3.5rem;
            font-weight: 800;
            color: #0b1220;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            box-shadow: 0 0 0 6px var(--bg), 0 0 0 7px var(--border), 0 20px 50px -20px rgba(56, 189, 248, 0.5);
        }
        .hero h1 { font-size: 2.8rem; line-height: 1.1; margin-bottom: 0.4rem; }
        .hero .role { font-size: 1.25rem; color: var(--accent); font-weight: 600; margin-bottom: 1rem; }
        .hero p.tagline { color: var(--muted); max-width: 56ch; margin-bottom: 1.6rem; }
        .cta { display: flex; gap: 1rem; flex-wrap: wrap; }
        .btn {
            display: inline-block;
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0b1220;
        }
        .btn-ghost { border: 1px solid var(--border); color: var(--text); }
        .btn:hover { transform: translateY(-2px); text-decoration: none; }
        .btn-primary:hover { box-shadow: 0 10px 25px -10px rgba(56, 189, 248, 0.6); }
        .btn-ghost:hover { border-color: var(--accent); }

        /* ---------- Stats strip ---------- */
        .stats {
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            background: var(--bg-soft);
        }
        .stats .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            padding-top: 1.6rem;
            padding-bottom: 1.6rem;
            text-align: center;
        }
        .stat .num { font-size: 1.8rem; font-weight: 800; color: var(--accent); }
        .stat .lbl { font-size: 0.85rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; }

        /* ---------- Sections ---------- */
        section { padding: 4rem 0; }
        h2 {
            font-size: 1.7rem;
            margin-bottom: 0.5rem;
        }
        .subtitle { color: var(--muted); max-width: 60ch; margin-bottom: 2.5rem; }

        /* About */
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start; }
        .about-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
        }
        .about-card h3 { margin-bottom: 0.75rem; color: var(--accent); font-size: 1.1rem; }
        .about-card p, .about-card li { color: var(--muted); }
        .about-card ul { list-style: none; }
        .about-card ul li { padding: 0.3rem 0; border-bottom: 1px dashed var(--border); }
        .about-card ul li:last-child { border-bottom: none; }
        .about-card ul li strong { color: var(--text); }

        /* Skills */
        .skills-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem 2rem; }
        .skill { margin-bottom: 1.1rem; }
        .skill .top { display: flex; justify-content: space-between; margin-bottom: 0.4rem; font-size: 0.95rem; }
        .skill .top span:last-child { color: var(--muted); }
        .bar {
            height: 8px;
            border-radius: 99px;
            background: var(--border);
            overflow: hidden;
        }
        .bar > div {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
        }

        /* Expertise cards */
        .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            transition: transform 0.15s ease, border-color 0.15s ease;
        }
        .card:hover { transform: translateY(-4px); border-color: var(--accent); }
        .card .icon { font-size: 1.6rem; margin-bottom: 0.8rem; }
        .card h3 { font-size: 1.05rem; margin-bottom: 0.5rem; }
        .card p { color: var(--muted); font-size: 0.92rem; }

        /* Experience timeline */
        .timeline { border-left: 2px solid var(--border); margin-left: 0.5rem; padding-left: 1.6rem; display: grid; gap: 1.8rem; }
        .tl-item { position: relative; }
        .tl-item::before {
            content: '';
            position: absolute;
            left: -1.78rem;
            top: 0.3rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--accent);
            border: 3px solid var(--bg);
        }
        .tl-item h3 { font-size: 1.05rem; }
        .tl-item .when { color: var(--accent); font-size: 0.85rem; font-weight: 600; }
        .tl-item p { color: var(--muted); font-size: 0.95rem; }

        /* Contact */
        .contact-card {
            background: linear-gradient(135deg, var(--card), var(--bg-soft));
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
        }
        .contact-card h3 { font-size: 1.4rem; margin-bottom: 0.3rem; }
        .contact-card p { color: var(--muted); }
        .contact-links { display: flex; gap: 1rem; flex-wrap: wrap; }

        footer {
            border-top: 1px solid var(--border);
            padding: 1.5rem 0;
            text-align: center;
            color: var(--muted);
            font-size: 0.9rem;
        }

        @media (max-width: 760px) {
            .hero .container { grid-template-columns: 1fr; text-align: center; justify-items: center; }
            .hero h1 { font-size: 2.1rem; }
            .stats .container { grid-template-columns: repeat(2, 1fr); gap: 1.4rem; }
            .about-grid, .skills-grid { grid-template-columns: 1fr; }
            .cards { grid-template-columns: 1fr; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <nav>
        <div class="container">
            <a class="logo" href="#">
                <span class="logo-badge">MG</span>
                Michael Gadiano
            </a>
            <div class="nav-links">
                <a href="#about">About</a>
                <a href="#skills">Skills</a>
                <a href="#expertise">Expertise</a>
                <a href="#experience">Experience</a>
                <a href="{{ route('login') }}">Log in</a>
                <a href="#contact">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="hero">
        <div class="container">
            <div class="avatar">MG</div>
            <div>
                <h1>Michael Gadiano</h1>
                <div class="role">IT Expert · Systems &amp; Network Specialist</div>
                <p class="tagline">
                    I design, build, and secure the technology that keeps organizations running — from
                    robust network infrastructure and server administration to cybersecurity and cloud
                    engineering. Let's turn your IT challenges into reliable solutions.
                </p>
                <div class="cta">
                    <a href="#contact" class="btn btn-primary">Get in touch</a>
                    <a href="#expertise" class="btn btn-ghost">What I do</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Stats -->
    <div class="stats">
        <div class="container">
            <div class="stat"><div class="num">12+</div><div class="lbl">Years in IT</div></div>
            <div class="stat"><div class="num">80+</div><div class="lbl">Projects delivered</div></div>
            <div class="stat"><div class="num">10</div><div class="lbl">Certifications</div></div>
            <div class="stat"><div class="num">99.9%</div><div class="lbl">Uptime achieved</div></div>
        </div>
    </div>

    <!-- About -->
    <section id="about">
        <div class="container">
            <h2>About me</h2>
            <p class="subtitle">
                A hands-on IT professional focused on infrastructure that is fast, reliable, and secure.
            </p>
            <div class="about-grid">
                <div class="about-card">
                    <h3>Who I am</h3>
                    <p>
                        I'm an IT expert with deep experience across systems administration, networking,
                        and cybersecurity. I have spent my career solving complex technical problems —
                        building data centers, migrating workloads to the cloud, and hardening networks
                        against modern threats. I believe great IT should be invisible: it simply works.
                    </p>
                </div>
                <div class="about-card">
                    <h3>Core capabilities</h3>
                    <ul>
                        <li><strong>Network architecture</strong> — LAN/WAN, routing, switching, firewalls</li>
                        <li><strong>Systems administration</strong> — Windows &amp; Linux server management</li>
                        <li><strong>Cybersecurity</strong> — audits, hardening, threat response</li>
                        <li><strong>Cloud engineering</strong> — AWS, Azure, hybrid environments</li>
                        <li><strong>IT leadership</strong> — strategy, budgeting, team mentoring</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills -->
    <section id="skills" style="background: var(--bg-soft); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2>Technical skills</h2>
            <p class="subtitle">The tools and technologies I work with every day.</p>
            <div class="skills-grid">
                <div class="skill"><div class="top"><span>Network &amp; Infrastructure</span><span>95%</span></div><div class="bar"><div style="width: 95%"></div></div></div>
                <div class="skill"><div class="top"><span>Systems Administration</span><span>92%</span></div><div class="bar"><div style="width: 92%"></div></div></div>
                <div class="skill"><div class="top"><span>Cybersecurity</span><span>88%</span></div><div class="bar"><div style="width: 88%"></div></div></div>
                <div class="skill"><div class="top"><span>Cloud (AWS · Azure)</span><span>85%</span></div><div class="bar"><div style="width: 85%"></div></div></div>
                <div class="skill"><div class="top"><span>Virtualization (VMware · Proxmox)</span><span>90%</span></div><div class="bar"><div style="width: 90%"></div></div></div>
                <div class="skill"><div class="top"><span>Scripting &amp; Automation</span><span>82%</span></div><div class="bar"><div style="width: 82%"></div></div></div>
                <div class="skill"><div class="top"><span>Databases &amp; Backup</span><span>80%</span></div><div class="bar"><div style="width: 80%"></div></div></div>
                <div class="skill"><div class="top"><span>Help Desk &amp; Support</span><span>96%</span></div><div class="bar"><div style="width: 96%"></div></div></div>
            </div>
        </div>
    </section>

    <!-- Expertise -->
    <section id="expertise">
        <div class="container">
            <h2>Areas of expertise</h2>
            <p class="subtitle">How I help businesses get the most out of their technology.</p>
            <div class="cards">
                <div class="card">
                    <div class="icon">🖧</div>
                    <h3>Network Setup &amp; Optimization</h3>
                    <p>Planning, deployment, and tuning of office and enterprise networks for maximum speed and reliability.</p>
                </div>
                <div class="card">
                    <div class="icon">🛡️</div>
                    <h3>Security &amp; Compliance</h3>
                    <p>Security audits, firewall configuration, endpoint protection, and incident response planning.</p>
                </div>
                <div class="card">
                    <div class="icon">☁️</div>
                    <h3>Cloud Migration</h3>
                    <p>Moving on-premises workloads to AWS and Azure with minimal downtime and cost control.</p>
                </div>
                <div class="card">
                    <div class="icon">💾</div>
                    <h3>Backup &amp; Disaster Recovery</h3>
                    <p>Automated backup strategies and tested recovery plans so your data survives anything.</p>
                </div>
                <div class="card">
                    <div class="icon">🛠️</div>
                    <h3>IT Support &amp; Maintenance</h3>
                    <p>Proactive monitoring, maintenance, and responsive support to keep systems healthy.</p>
                </div>
                <div class="card">
                    <div class="icon">📊</div>
                    <h3>IT Strategy &amp; Consulting</h3>
                    <p>Long-term technology roadmaps, budgeting, and vendor management aligned with business goals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience -->
    <section id="experience" style="background: var(--bg-soft); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2>Experience</h2>
            <p class="subtitle">A few highlights from a career built on solving hard problems.</p>
            <div class="timeline">
                <div class="tl-item">
                    <h3>Senior IT Infrastructure Engineer</h3>
                    <div class="when">2020 — Present</div>
                    <p>Lead infrastructure design and operations across multiple sites; cut incident response time by 40% and maintained 99.9% uptime.</p>
                </div>
                <div class="tl-item">
                    <h3>IT Systems Administrator</h3>
                    <div class="when">2016 — 2020</div>
                    <p>Managed 200+ servers and endpoints; implemented a company-wide backup and disaster recovery system.</p>
                </div>
                <div class="tl-item">
                    <h3>Network Engineer</h3>
                    <div class="when">2013 — 2016</div>
                    <p>Deployed enterprise networking for offices and data centers; upgraded network capacity to support cloud adoption.</p>
                </div>
                <div class="tl-item">
                    <h3>IT Support Specialist</h3>
                    <div class="when">2011 — 2013</div>
                    <p>First line of technical support; built the knowledge base that later became the team's onboarding standard.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact">
        <div class="container">
            <h2>Let's build something reliable</h2>
            <p class="subtitle">
                Have an IT project or a problem that needs solving? I'd love to hear about it.
            </p>
            <div class="contact-card">
                <div>
                    <h3>Michael Gadiano</h3>
                    <p>IT Expert — available for consulting and long-term engagements.</p>
                </div>
                <div class="contact-links">
                    <a href="mailto:michael.gadiano@example.com" class="btn btn-primary">Email me</a>
                    <a href="#" class="btn btn-ghost">LinkedIn</a>
                    <a href="#" class="btn btn-ghost">GitHub</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            © {{ date('Y') }} Michael Gadiano · IT Expert
        </div>
    </footer>

</body>
</html>
