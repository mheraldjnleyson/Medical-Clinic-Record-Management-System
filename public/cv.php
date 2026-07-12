<?php
require_once "../config/db.php";
requireLogin();

// Render layout header and nav
include "index_layout.php";
?>

<style>
    /* ==========================================================================
       CV & PORTFOLIO STYLING (Aesthetic, Premium & Responsive)
       ========================================================================== */
    
    :root {
        --primary-color: #00ACB1;
        --primary-hover: #008e91;
        --secondary-color: #76E1E4;
        --bg-glass: rgba(255, 255, 255, 0.85);
        --border-glass: rgba(255, 255, 255, 0.3);
        --text-primary: #2d3748;
        --text-secondary: #4a5568;
        --text-muted: #718096;
        --shadow-subtle: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-premium: 0 10px 30px -5px rgba(0, 172, 177, 0.15), 0 8px 15px -5px rgba(0, 0, 0, 0.05);
        --radius-lg: 16px;
        --radius-md: 10px;
        --font-main: 'Manrope', 'Segoe UI', system-ui, sans-serif;
    }

    body.dark-mode {
        --bg-glass: rgba(30, 30, 30, 0.85);
        --border-glass: rgba(255, 255, 255, 0.08);
        --text-primary: #f7fafc;
        --text-secondary: #e2e8f0;
        --text-muted: #a0aec0;
        --shadow-premium: 0 10px 30px -5px rgba(0, 172, 177, 0.3), 0 8px 15px -5px rgba(0, 0, 0, 0.2);
    }

    /* Page container */
    .cv-wrapper {
        max-width: 1200px;
        margin: 20px auto 60px;
        padding: 0 20px;
        font-family: var(--font-main);
        color: var(--text-secondary);
        line-height: 1.6;
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* CV Control Bar */
    .cv-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        background: var(--bg-glass);
        backdrop-filter: blur(10px);
        padding: 15px 25px;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-subtle);
        border: 1px solid var(--border-glass);
        flex-wrap: wrap;
        gap: 15px;
    }

    .cv-title-section {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .cv-title-section i {
        font-size: 24px;
        color: var(--primary-color);
    }

    .cv-title-section h1 {
        font-size: 1.4rem;
        margin: 0;
        font-weight: 700;
        color: var(--text-primary);
        text-transform: none !important;
    }

    .cv-action-btns {
        display: flex;
        gap: 10px;
    }

    .cv-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .cv-btn-primary {
        background: var(--primary-color);
        color: white !important;
        box-shadow: 0 4px 10px rgba(0, 172, 177, 0.2);
    }

    .cv-btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 172, 177, 0.3);
    }

    .cv-btn-secondary {
        background: rgba(0, 172, 177, 0.1);
        color: var(--primary-color) !important;
        border: 1px solid rgba(0, 172, 177, 0.2);
    }

    .cv-btn-secondary:hover {
        background: rgba(0, 172, 177, 0.18);
        transform: translateY(-2px);
    }

    /* Layout structure */
    .cv-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 30px;
    }

    /* Left Sidebar: Profile & Quick Info */
    .cv-sidebar {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .cv-card {
        background: var(--bg-glass);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-glass);
        box-shadow: var(--shadow-subtle);
        padding: 25px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .cv-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-premium);
    }

    /* Profile Card specific details */
    .profile-card {
        text-align: center;
        background: linear-gradient(135deg, rgba(0, 172, 177, 0.05) 0%, rgba(118, 225, 228, 0.05) 100%), var(--bg-glass);
    }

    .profile-avatar-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 15px;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 52px;
        color: white;
        box-shadow: 0 8px 20px rgba(0, 172, 177, 0.2);
        border: 4px solid var(--bg-glass);
    }

    .profile-card h2 {
        font-size: 1.4rem;
        color: var(--text-primary);
        margin: 5px 0 2px;
        font-weight: 700;
        text-transform: none !important;
    }

    .profile-card p.subtitle {
        color: var(--primary-color);
        font-size: 0.95rem;
        font-weight: 600;
        margin: 0 0 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-details-list {
        text-align: left;
        margin-top: 20px;
        border-top: 1px solid var(--border-glass);
        padding-top: 15px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .profile-detail-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.88rem;
    }

    .profile-detail-item i {
        color: var(--primary-color);
        width: 16px;
        margin-top: 3px;
        text-align: center;
    }

    .profile-detail-item span {
        word-break: break-word;
        color: var(--text-secondary);
    }

    /* Section headings inside cards */
    .card-section-title {
        font-size: 1.05rem;
        color: var(--text-primary);
        font-weight: 700;
        margin: 0 0 15px 0;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card-section-title i {
        color: var(--primary-color);
    }

    /* Skills layout */
    .skills-group {
        margin-bottom: 15px;
    }

    .skills-group:last-child {
        margin-bottom: 0;
    }

    .skills-group-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 8px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .skills-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .skill-tag {
        background: rgba(0, 172, 177, 0.08);
        border: 1px solid rgba(0, 172, 177, 0.15);
        color: var(--primary-color);
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.78rem;
        font-weight: 600;
        transition: all 0.2s ease;
        text-transform: none !important;
    }

    .skill-tag:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Main Content Area */
    .cv-main {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .about-text {
        font-size: 1rem;
        color: var(--text-secondary);
        text-align: justify;
        margin: 0;
    }

    /* Timelines (Education & Work) */
    .timeline {
        position: relative;
        padding-left: 24px;
        margin-top: 10px;
    }

    .timeline::before {
        content: "";
        position: absolute;
        left: 5px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: rgba(0, 172, 177, 0.2);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -24px;
        top: 6px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: white;
        border: 3px solid var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 172, 177, 0.15);
        transition: transform 0.2s ease;
        z-index: 2;
    }

    body.dark-mode .timeline-dot {
        background: #1e1e1e;
    }

    .timeline-item:hover .timeline-dot {
        transform: scale(1.2);
        background: var(--primary-color);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 6px;
    }

    .timeline-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        text-transform: none !important;
    }

    .timeline-org {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary-color);
        margin: 2px 0 0 0;
        text-transform: none !important;
    }

    .timeline-date {
        font-size: 0.8rem;
        font-weight: 700;
        color: white;
        background: var(--primary-color);
        padding: 3px 10px;
        border-radius: 12px;
        white-space: nowrap;
    }

    .timeline-desc {
        font-size: 0.92rem;
        color: var(--text-secondary);
        text-align: justify;
    }

    /* Styled Certificate Alert / Box */
    .certificate-highlight-box {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.08) 0%, rgba(245, 158, 11, 0.08) 100%);
        border-left: 4px solid #fbbf24;
        border-radius: 8px;
        padding: 18px;
        margin-top: 15px;
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .certificate-icon-wrapper {
        font-size: 24px;
        color: #fbbf24;
        margin-top: 2px;
    }

    .certificate-text-wrapper h4 {
        margin: 0 0 6px 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .certificate-quote {
        font-style: italic;
        font-size: 0.88rem;
        color: var(--text-secondary);
        line-height: 1.5;
        margin: 0;
    }

    .certificate-issuer {
        display: block;
        margin-top: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
    }

    /* Project Cards specific styles */
    .project-item {
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border-glass);
        padding-bottom: 20px;
    }

    .project-item:last-child {
        margin-bottom: 0;
        border-bottom: none;
        padding-bottom: 0;
    }

    .project-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 8px;
    }

    .project-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        text-transform: none !important;
    }

    .project-meta {
        font-size: 0.85rem;
        font-style: italic;
        color: var(--text-muted);
        margin-bottom: 10px;
    }

    .project-desc {
        font-size: 0.92rem;
        color: var(--text-secondary);
        text-align: justify;
        margin-bottom: 12px;
    }

    .project-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .project-tag {
        background: rgba(0, 172, 177, 0.05);
        color: var(--text-secondary);
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    body.dark-mode .project-tag {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* References Layout */
    .references-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .reference-card {
        background: rgba(0, 172, 177, 0.02);
        border: 1px solid var(--border-glass);
        border-radius: var(--radius-md);
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .reference-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
        text-transform: none !important;
    }

    .reference-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 4px;
        text-transform: none !important;
    }

    .reference-org {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: none !important;
    }

    .reference-contact {
        font-size: 0.82rem;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-secondary);
    }

    .reference-contact i {
        color: var(--primary-color);
        width: 14px;
    }

    /* Tabs design for Interactive Mode */
    .cv-tabs {
        display: flex;
        background: var(--bg-glass);
        backdrop-filter: blur(10px);
        padding: 5px;
        border-radius: 30px;
        box-shadow: var(--shadow-subtle);
        border: 1px solid var(--border-glass);
        margin-bottom: 25px;
        overflow-x: auto;
        gap: 5px;
    }

    .cv-tab {
        flex: 1;
        text-align: center;
        padding: 10px 15px;
        border-radius: 25px;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        user-select: none;
    }

    .cv-tab.active {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(0, 172, 177, 0.2);
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.4s ease-out;
    }

    .tab-content.active {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* Print styling rules */
    .print-only {
        display: none;
    }

    /* Responsive adjustments */
    @media (max-width: 900px) {
        .cv-grid {
            grid-template-columns: 1fr;
        }

        .cv-sidebar {
            order: 2;
        }

        .cv-main {
            order: 1;
        }

        .references-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ==========================================================================
       PRINT STYLING (Optimized for standard A4/Letter size printing)
       ========================================================================== */
    @media print {
        /* Hide layout items and elements not needed in physical print */
        header, nav, .cv-controls, .cv-tabs, #persistentBackupReminder, .user-dropdown, .notification-icon, .dark-mode-toggle, .btn-action {
            display: none !important;
        }

        /* Reset body backgrounds */
        body, html {
            background: white !important;
            color: black !important;
            font-family: 'Segoe UI', Arial, sans-serif !important;
            font-size: 11pt !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .cv-wrapper {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 10mm 15mm !important; /* Page Margins */
        }

        /* Rearrange the grid to static flow layout */
        .cv-grid {
            display: block !important;
        }

        /* Remove borders, backgrounds, and drop shadows from cards for printing */
        .cv-card {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-bottom: 20px !important;
            transform: none !important;
        }

        /* Top Header block on CV */
        .profile-card {
            text-align: left !important;
            border-bottom: 2px solid #333 !important;
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
            background: transparent !important;
        }

        .profile-avatar-container {
            display: none !important; /* Hide circular placeholder on print */
        }

        /* Create a printable name card header */
        .print-header {
            display: block !important;
            margin-bottom: 15px;
        }

        .print-header h1 {
            font-size: 24pt !important;
            font-weight: 700;
            color: black !important;
            margin: 0 0 5px 0;
            text-transform: uppercase !important;
        }

        .print-header p.subtitle {
            font-size: 13pt !important;
            color: #555 !important;
            font-weight: 600;
            margin: 0 0 10px 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Contact Details list side-by-side on print */
        .profile-details-list {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px 15px !important;
            border-top: none !important;
            padding-top: 0 !important;
            margin-top: 10px !important;
        }

        .profile-detail-item {
            font-size: 9.5pt !important;
        }

        .profile-detail-item i {
            display: none !important; /* Hide icons in print for simplicity */
        }

        /* Sections structure in print */
        .card-section-title {
            font-size: 12pt !important;
            color: black !important;
            border-bottom: 1.5px solid #333 !important;
            margin: 20px 0 10px 0 !important;
            padding-bottom: 4px !important;
        }

        .card-section-title i {
            display: none !important;
        }

        /* Force display all elements in print (ignores active tab filters) */
        .tab-content {
            display: block !important;
            opacity: 1 !important;
        }

        .cv-sidebar {
            display: block !important;
        }

        .cv-main {
            display: block !important;
        }

        /* Skills groups side-by-side on print */
        .skills-grid-print {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 15px !important;
        }

        .skills-tags {
            display: inline !important;
        }

        .skill-tag {
            background: transparent !important;
            border: none !important;
            color: black !important;
            padding: 0 !important;
            margin-right: 8px !important;
            font-size: 9.5pt !important;
            display: inline-block !important;
        }

        .skill-tag::after {
            content: "," !important;
        }

        .skill-tag:last-child::after {
            content: "" !important;
        }

        /* Timelines formatting in print */
        .timeline {
            padding-left: 0 !important;
        }

        .timeline::before {
            display: none !important;
        }

        .timeline-dot {
            display: none !important;
        }

        .timeline-item {
            margin-bottom: 15px !important;
            page-break-inside: avoid !important;
        }

        .timeline-header {
            margin-bottom: 3px !important;
        }

        .timeline-title {
            font-size: 11pt !important;
        }

        .timeline-org {
            font-size: 10pt !important;
            color: black !important;
        }

        .timeline-date {
            background: transparent !important;
            color: black !important;
            padding: 0 !important;
            font-size: 9.5pt !important;
            font-weight: 600 !important;
        }

        .timeline-desc {
            font-size: 9.5pt !important;
        }

        /* Certificate block */
        .certificate-highlight-box {
            background: transparent !important;
            border: 1px dashed #777 !important;
            padding: 10px !important;
            margin-top: 10px !important;
            page-break-inside: avoid !important;
        }

        .certificate-icon-wrapper {
            display: none !important;
        }

        .certificate-text-wrapper h4 {
            font-size: 9.5pt !important;
        }

        .certificate-quote {
            font-size: 9pt !important;
        }

        /* Projects in print */
        .project-item {
            margin-bottom: 15px !important;
            padding-bottom: 12px !important;
            page-break-inside: avoid !important;
        }

        .project-title {
            font-size: 11pt !important;
        }

        .project-meta {
            font-size: 9pt !important;
            margin-bottom: 5px !important;
        }

        .project-desc {
            font-size: 9.5pt !important;
            margin-bottom: 5px !important;
        }

        .project-tags {
            display: none !important; /* Hide tech tags in print for a cleaner resume format */
        }

        /* References side-by-side */
        .references-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 15px !important;
            page-break-inside: avoid !important;
        }

        .reference-card {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
        }

        .reference-name {
            font-size: 10pt !important;
        }

        .reference-title {
            color: black !important;
            font-size: 9pt !important;
        }

        .reference-org {
            font-size: 9pt !important;
        }

        .reference-contact {
            font-size: 9pt !important;
        }

        .reference-contact i {
            display: none !important;
        }

        /* Prevent page-breaks in the middle of sections */
        .cv-card {
            page-break-inside: avoid !important;
        }
    }
</style>

<div class="cv-wrapper">

    <!-- CV CONTROLS (Hides in Print) -->
    <div class="cv-controls">
        <div class="cv-title-section">
            <i class="fa-solid fa-id-card-clip"></i>
            <div>
                <h1>Developer Portfolio & CV</h1>
                <span style="font-size:0.75rem; color:var(--text-muted);">Manage and print your professional profile credentials</span>
            </div>
        </div>
        
        <div class="cv-action-btns">
            <button class="cv-btn cv-btn-secondary" onclick="toggleLayoutMode(this)">
                <i class="fa-solid fa-scroll"></i> <span>Full Document View</span>
            </button>
            <button class="cv-btn cv-btn-primary" onclick="window.print()">
                <i class="fa-solid fa-print"></i> Print to PDF
            </button>
        </div>
    </div>

    <!-- INTERACTIVE SECTION TABS (Hides in Print) -->
    <div class="cv-tabs" id="cvTabs">
        <div class="cv-tab active" onclick="switchTab(event, 'tab-profile')">Profile & Skills</div>
        <div class="cv-tab" onclick="switchTab(event, 'tab-experience')">Experience & OJT</div>
        <div class="cv-tab" onclick="switchTab(event, 'tab-projects')">Projects</div>
        <div class="cv-tab" onclick="switchTab(event, 'tab-leadership')">Leadership & References</div>
    </div>

    <!-- MAIN GRID CONTAINER -->
    <div class="cv-grid">
        
        <!-- SIDEBAR (Quick Info & Skills) -->
        <div class="cv-sidebar" id="cvSidebar">
            
            <!-- Profile Card -->
            <div class="cv-card profile-card">
                <div class="print-header print-only">
                    <h1>Mark Herald John N. Leyson</h1>
                    <p class="subtitle">Web Developer | IT Professional</p>
                </div>
                
                <div class="profile-avatar-container">
                    <div class="profile-avatar">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                </div>
                
                <h2>Mark Herald John N. Leyson</h2>
                <p class="subtitle">Web Developer</p>
                
                <div class="profile-details-list">
                    <div class="profile-detail-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span>markherald3@icloud.com</span>
                    </div>
                    <div class="profile-detail-item">
                        <i class="fa-solid fa-phone"></i>
                        <span>+63 994 746 5194</span>
                    </div>
                    <div class="profile-detail-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>#27-A Upper Leyva St., Brgy. Mabayuhan, Olongapo City, Zambales, Philippines</span>
                    </div>
                </div>
            </div>

            <!-- Skills & Education Card (Shows in profile tab in interactive mode) -->
            <div class="cv-card skills-card-wrapper" id="skillsCard">
                <div class="card-section-title">
                    <i class="fa-solid fa-graduation-cap"></i> Education
                </div>
                <div class="timeline" style="padding-left: 12px; margin-bottom: 25px;">
                    <div style="margin-bottom: 12px;">
                        <strong style="color:var(--text-primary); font-size:0.9rem;">Comteq Computer & Business College</strong><br>
                        <span style="font-size:0.8rem; color:var(--primary-color); font-weight:600;">BS in Information Technology (BSIT)</span><br>
                        <span style="font-size:0.75rem; color:var(--text-muted); font-weight:600;">2020 - 2026</span>
                    </div>
                    <div>
                        <strong style="color:var(--text-primary); font-size:0.9rem;">Comteq Computer & Business College</strong><br>
                        <span style="font-size:0.8rem; color:var(--primary-color); font-weight:600;">Senior High School - ICT Strand</span><br>
                        <span style="font-size:0.75rem; color:var(--text-muted); font-weight:600;">2018 - 2020</span>
                    </div>
                </div>

                <div class="card-section-title">
                    <i class="fa-solid fa-screwdriver-wrench"></i> Skills Inventory
                </div>
                
                <div class="skills-grid-print">
                    <div class="skills-group">
                        <div class="skills-group-title">Web Development</div>
                        <div class="skills-tags">
                            <span class="skill-tag">PHP (Entry Level)</span>
                            <span class="skill-tag">HTML5 / CSS3</span>
                            <span class="skill-tag">JavaScript / TypeScript</span>
                            <span class="skill-tag">Python (Entry Level)</span>
                        </div>
                    </div>

                    <div class="skills-group">
                        <div class="skills-group-title">Database & Tools</div>
                        <div class="skills-tags">
                            <span class="skill-tag">MySQL</span>
                            <span class="skill-tag">MariaDB</span>
                            <span class="skill-tag">XAMPP / Apache</span>
                        </div>
                    </div>

                    <div class="skills-group">
                        <div class="skills-group-title">Design & UI</div>
                        <div class="skills-tags">
                            <span class="skill-tag">Figma</span>
                            <span class="skill-tag">Canva</span>
                            <span class="skill-tag">Responsive Layouts</span>
                        </div>
                    </div>

                    <div class="skills-group">
                        <div class="skills-group-title">Hardware & Systems</div>
                        <div class="skills-tags">
                            <span class="skill-tag">Hardware Troubleshooting</span>
                            <span class="skill-tag">Linux Intranet Servers</span>
                            <span class="skill-tag">LAN Deployment</span>
                        </div>
                    </div>

                    <div class="skills-group">
                        <div class="skills-group-title">Methodologies & Soft Skills</div>
                        <div class="skills-tags">
                            <span class="skill-tag">Agile Development</span>
                            <span class="skill-tag">Problem Solving</span>
                            <span class="skill-tag">Team Collaboration</span>
                            <span class="skill-tag">Adaptability</span>
                        </div>
                    </div>
                </div>

                <div class="card-section-title" style="margin-top:20px;">
                    <i class="fa-solid fa-icons"></i> Personal Interests
                </div>
                <div class="skills-tags">
                    <span class="skill-tag">Basketball</span>
                    <span class="skill-tag">Billiards</span>
                    <span class="skill-tag">Gaming</span>
                    <span class="skill-tag">Cooking</span>
                    <span class="skill-tag">Reading Manga/Manhwa</span>
                    <span class="skill-tag">Anime & Movies</span>
                </div>
            </div>

        </div>

        <!-- MAIN MAIN CONTENT (Details, Projects, Timeline) -->
        <div class="cv-main" id="cvMain">
            
            <!-- TAB: PROFILE -->
            <div class="tab-content active" id="tab-profile">
                <!-- Professional Summary -->
                <div class="cv-card">
                    <div class="card-section-title">
                        <i class="fa-solid fa-address-card"></i> Professional Summary
                    </div>
                    <p class="about-text">
                        Highly motivated Information Technology student with a solid foundation in technical skills, a passion for continuous learning, and a proven ability to solve complex technical problems effectively. Experienced in developing database-driven web applications using PHP and MySQL, designing user interfaces with Figma, and setting up secure intranet network servers. Possesses strong adaptability, communication, and collaboration skills, honed through student leadership and successful digitalization capstone projects.
                    </p>
                </div>
            </div>

            <!-- TAB: EXPERIENCE -->
            <div class="tab-content" id="tab-experience">
                <!-- Professional Background -->
                <div class="cv-card">
                    <div class="card-section-title">
                        <i class="fa-solid fa-briefcase"></i> Work & Training Experience
                    </div>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-header">
                                <div>
                                    <h3 class="timeline-title">On-the-Job Training (OJT) Developer</h3>
                                    <p class="timeline-org">Medical Unit, Olongapo City National High School</p>
                                </div>
                                <span class="timeline-date">2025 - 2026</span>
                            </div>
                            <p class="timeline-desc">
                                Served as the lead systems developer during OJT, responsible for digitalizing the health operations of the school. Successfully designed, coded, and deployed the Olongapo City National Highschool Medical Clinic Record Management System to secure electronic files and streamline day-to-day clinical procedures.
                            </p>
                            
                            <!-- Certificate Text Box -->
                            <div class="certificate-highlight-box">
                                <div class="certificate-icon-wrapper">
                                    <i class="fa-solid fa-award"></i>
                                </div>
                                <div class="certificate-text-wrapper">
                                    <h4>Certificate of Recognition Received</h4>
                                    <p class="certificate-quote">
                                        "In grateful recognition and sincere appreciation of his invaluable contribution, dedication, and technical expertise in developing the Medical System (Digitalization) of the Medical Unit of Olongapo City National High School, which greatly enhanced the efficiency, organization, and delivery of medical services to the school community."
                                    </p>
                                    <span class="certificate-issuer">Olongapo City National High School, Olongapo City</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: PROJECTS -->
            <div class="tab-content" id="tab-projects">
                <!-- Capstone & Development Projects -->
                <div class="cv-card">
                    <div class="card-section-title">
                        <i class="fa-solid fa-cubes"></i> Major Software Projects
                    </div>

                    <!-- Project 1: Clinic System -->
                    <div class="project-item">
                        <div class="project-header">
                            <h3 class="project-title">Olongapo City National Highschool Medical Clinic Record Management System</h3>
                            <span class="timeline-date">2026</span>
                        </div>
                        <div class="project-meta">
                            Leyson, M. H. J. N. (2026, May). (OJT Project & System Donation). Olongapo City, Philippines.
                        </div>
                        <p class="project-desc">
                            Designed, developed, and deployed the Olongapo City National Highschool Medical Clinic Record Management System during On-the-Job Training (OJT), which was officially donated to and adopted by the school to centralize and replace manual health record-keeping. The system is a secure, local area network (LAN) web application that manages medical records for students and personnel. It integrates touchless QR code identification for rapid patient record retrieval, automates WHO-standard nutritional monitoring (BMI/Stunting/Wasting calculations), and incorporates a machine learning engine (using Scikit-learn) for disease diagnosis suggestions and statistical outbreak forecasting. Developed using PHP, MySQL, HTML5, CSS3, and JavaScript, it ensures strict security with Role-Based Access Control (RBAC), automatic database backups, and instant generation of DepEd-compliant medical reports.
                        </p>
                        <div class="project-tags">
                            <span class="project-tag">PHP</span>
                            <span class="project-tag">MySQL</span>
                            <span class="project-tag">JavaScript</span>
                            <span class="project-tag">HTML5 / CSS3</span>
                            <span class="project-tag">QR Code API</span>
                            <span class="project-tag">Scikit-Learn</span>
                        </div>
                    </div>

                    <!-- Project 2: Inventory System -->
                    <div class="project-item">
                        <div class="project-header">
                            <h3 class="project-title">Web-based Intranet Inventory and Tracking Management System</h3>
                            <span class="timeline-date">2025</span>
                        </div>
                        <div class="project-meta">
                            Guiyab, R. B., Leyson, M. H. J. N., Pigao, J. R. L., Talua, J. P., & Avecilla, A. J. R. M. (2025, December). Old Cabalan Integrated School Capstone Project. Olongapo City, Philippines.
                        </div>
                        <p class="project-desc">
                            Collaborated in designing and implementing a web-based intranet inventory and tracking management system. Coded database queries and responsive interface designs using PHP, MySQL, HTML, CSS, and JavaScript. Developed secure role-based controls and stock ledger logs, constructed vector layouts in Figma, and deployed the final software system on a secure Linux intranet server following Agile methodology practices.
                        </p>
                        <div class="project-tags">
                            <span class="project-tag">PHP</span>
                            <span class="project-tag">MySQL</span>
                            <span class="project-tag">HTML5 / CSS3</span>
                            <span class="project-tag">Figma Design</span>
                            <span class="project-tag">Linux Server</span>
                            <span class="project-tag">Agile Scrum</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: LEADERSHIP & REFERENCES -->
            <div class="tab-content" id="tab-leadership">
                <!-- Leadership Experience -->
                <div class="cv-card">
                    <div class="card-section-title">
                        <i class="fa-solid fa-users-line"></i> Leadership Experience
                    </div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-header">
                                <div>
                                    <h3 class="timeline-title">CCS Student Council Auditor</h3>
                                    <p class="timeline-org">College of Computer Studies (CCS), Comteq Computer and Business College</p>
                                </div>
                                <span class="timeline-date">2022 - 2023</span>
                            </div>
                            <p class="timeline-desc">
                                Managed and audited financial records for college activities and student funds. Assisted in organizing school events, coordinating student relations, and planning technical seminars to foster active community collaboration within the Computer Studies department.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- References -->
                <div class="cv-card">
                    <div class="card-section-title">
                        <i class="fa-solid fa-address-book"></i> Professional References
                    </div>
                    
                    <div class="references-grid">
                        <div class="reference-card">
                            <div class="reference-name">Arthur John Rey M. Avecilla, IP-MSIT</div>
                            <div class="reference-title">IT Instructor</div>
                            <div class="reference-org">Comteq Computer & Business College Inc.</div>
                            <div class="reference-contact">
                                <i class="fa-solid fa-envelope"></i>
                                <span>avecilla.art@gmail.com</span>
                            </div>
                            <div class="reference-contact">
                                <i class="fa-solid fa-phone"></i>
                                <span>0968-323-2306</span>
                            </div>
                        </div>

                        <div class="reference-card">
                            <div class="reference-name">Noel R. Marcelino, MSCS</div>
                            <div class="reference-title">IT Coordinator</div>
                            <div class="reference-org">Comteq Computer & Business College Inc.</div>
                            <div class="reference-contact">
                                <i class="fa-solid fa-envelope"></i>
                                <span>noelminfo@gmail.com</span>
                            </div>
                            <div class="reference-contact">
                                <i class="fa-solid fa-phone"></i>
                                <span>09569422149</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    // Tab switching engine
    function switchTab(event, tabId) {
        // Toggle tabs active class
        const tabs = document.querySelectorAll('.cv-tab');
        tabs.forEach(tab => tab.classList.remove('active'));
        if (event) {
            event.currentTarget.classList.add('active');
        } else {
            // Find tab element based on ID
            const targetIndex = ['tab-profile', 'tab-experience', 'tab-projects', 'tab-leadership'].indexOf(tabId);
            if (targetIndex !== -1) {
                tabs[targetIndex].classList.add('active');
            }
        }

        // Toggle content
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => {
            content.classList.remove('active');
            if (content.id === tabId) {
                content.classList.add('active');
            }
        });
    }

    // Toggle between interactive and document scroll layout
    let isFullLayout = false;
    function toggleLayoutMode(btn) {
        isFullLayout = !isFullLayout;
        const main = document.getElementById('cvMain');
        const tabs = document.getElementById('cvTabs');
        const contents = document.querySelectorAll('.tab-content');
        
        if (isFullLayout) {
            // Document View
            tabs.style.display = 'none';
            contents.forEach(content => content.classList.add('active'));
            btn.querySelector('span').innerText = "Interactive View";
            btn.querySelector('i').className = "fa-solid fa-grip";
        } else {
            // Interactive Tabs View
            tabs.style.display = 'flex';
            btn.querySelector('span').innerText = "Full Document View";
            btn.querySelector('i').className = "fa-solid fa-scroll";
            
            // Restore active tab
            const activeTab = document.querySelector('.cv-tab.active');
            if (activeTab) {
                // Trigger click behavior simulation
                const text = activeTab.innerText;
                if (text.includes("Profile")) switchTab(null, 'tab-profile');
                else if (text.includes("Experience")) switchTab(null, 'tab-experience');
                else if (text.includes("Projects")) switchTab(null, 'tab-projects');
                else if (text.includes("Leadership")) switchTab(null, 'tab-leadership');
            }
        }
    }
</script>

<?php
// Note: We do not need a footer here, as the system layout index_layout.php closes the document.
// But we want to ensure everything is tidy and consistent.
?>
