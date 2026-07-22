<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Membership - BeautyCare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
    .sidebar-toggle {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
    }

    .sidebar-toggle svg {
        width: 24px;
        height: 24px;
        color: var(--dark);
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        z-index: 90;
    }

    .sidebar-overlay.active {
        display: block;
    }

    @media (max-width: 768px) {
        .sidebar-toggle {
            display: flex;
            align-items: center;
        }
    }

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }

    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .page-header-premium {
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 79, 135, 0.08);
    }

    .page-header-premium::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.12) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 30%;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium .ph-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header-premium .ph-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-header-premium .ph-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
        flex-shrink: 0;
    }

    .page-header-premium .ph-text h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .page-header-premium .ph-text p {
        font-size: 13px;
        color: var(--gray);
        margin: 2px 0 0;
    }

    .member-status-card {
        background: linear-gradient(135deg, #FF4F87 0%, #FF7BA6 50%, #FF9CB8 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(255, 79, 135, 0.25);
    }

    .member-status-card .ms-deco {
        position: absolute;
        pointer-events: none;
    }

    .member-status-card .ms-deco:nth-child(1) {
        width: 250px; height: 250px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.1);
        top: -100px; right: -50px;
    }

    .member-status-card .ms-deco:nth-child(2) {
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        bottom: -40px; left: 30%;
    }

    .member-status-card .ms-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .member-status-card .ms-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .member-status-card .ms-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 28px;
        flex-shrink: 0;
    }

    .member-status-card .ms-text h3 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .member-status-card .ms-text p {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        margin: 4px 0 0;
    }

    .member-status-card .ms-level {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border-radius: 100px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .member-status-card .ms-level i {
        font-size: 16px;
    }

    .stats-membership {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-member-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-member-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px -8px rgba(255, 79, 135, 0.12);
    }

    .stat-member-card .sm-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin: 0 auto 12px;
    }

    .stat-member-card .sm-icon.transaksi { background: #DBEAFE; color: #2563EB; }
    .stat-member-card .sm-icon.belanja { background: #FEF3C7; color: #D97706; }
    .stat-member-card .sm-icon.diskon { background: #D1FAE5; color: #059669; }
    .stat-member-card .sm-icon.tier { background: #F3E8FF; color: #9333EA; }

    .stat-member-card .sm-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-member-card .sm-label {
        font-size: 12px;
        color: var(--gray);
        font-weight: 500;
    }

    .member-tier-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .member-tier-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .member-tier-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px -8px rgba(255, 79, 135, 0.15);
    }

    .member-tier-card .mt-banner {
        height: 120px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .member-tier-card .mt-banner.silver {
        background: linear-gradient(135deg, #94A3B8, #CBD5E1);
    }

    .member-tier-card .mt-banner.gold {
        background: linear-gradient(135deg, #F59E0B, #FBBF24);
    }

    .member-tier-card .mt-banner.platinum {
        background: linear-gradient(135deg, #6366F1, #818CF8);
    }

    .member-tier-card .mt-banner .mt-icon-big {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 24px;
    }

    .member-tier-card .mt-banner .mt-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        padding: 4px 12px;
        border-radius: 100px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .member-tier-card .mt-banner .mt-badge.active-tier {
        background: #D1FAE5;
        border-color: #A7F3D0;
        color: #059669;
    }

    .member-tier-card .mt-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .member-tier-card .mt-body .mt-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .member-tier-card .mt-body .mt-subtitle {
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 14px;
    }

    .member-tier-card .mt-body .mt-benefits {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--dark);
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item i {
        width: 18px;
        font-size: 13px;
        color: var(--primary);
        flex-shrink: 0;
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item i.fa-xmark {
        color: #ccc;
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item.disabled {
        color: #ccc;
    }

    .member-tier-card .mt-body .mt-price {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        line-height: 1.4;
    }

    .member-tier-card .mt-body .mt-price span {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--primary);
    }

    .mt-btn {
        display: block;
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        text-align: center;
        text-decoration: none;
        margin-top: auto;
    }

    .mt-btn.primary {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.2);
    }

    .mt-btn.primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    .mt-btn.current {
        background: #D1FAE5;
        color: #059669;
        box-shadow: none;
        cursor: default;
    }

    .mt-btn.outline {
        background: transparent;
        border: 1.5px solid var(--border);
        color: var(--gray);
    }

    .mt-btn.outline:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--hover);
    }

    .benefit-section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .benefit-section-title i {
        color: var(--primary);
    }

    .benefit-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .benefit-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: flex-start;
        gap: 14px;
        transition: all 0.3s ease;
    }

    .benefit-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -8px rgba(255, 79, 135, 0.1);
    }

    .benefit-card .bc-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .benefit-card .bc-icon.diskon { background: #FEF3C7; color: #D97706; }
    .benefit-card .bc-icon.prioritas { background: #DBEAFE; color: #2563EB; }
    .benefit-card .bc-icon.event { background: #F3E8FF; color: #9333EA; }
    .benefit-card .bc-icon.kado { background: #FCE7F3; color: #DB2777; }
    .benefit-card .bc-icon.produk { background: #FEF3C7; color: #D97706; }
    .benefit-card .bc-icon.gratis { background: #E0F2FE; color: #0284C7; }

    .benefit-card .bc-text h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin: 0 0 3px;
    }

    .benefit-card .bc-text p {
        font-size: 12px;
        color: var(--gray);
        line-height: 1.5;
        margin: 0;
    }

    .upgrade-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .upgrade-modal.show {
        display: flex;
    }

    .upgrade-modal .um-card {
        background: var(--white);
        border-radius: 24px;
        max-width: 420px;
        width: 100%;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: modalIn 0.3s ease;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.92) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .upgrade-modal .um-banner {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .upgrade-modal .um-banner.gold {
        background: linear-gradient(135deg, #F59E0B, #FBBF24);
    }

    .upgrade-modal .um-banner.platinum {
        background: linear-gradient(135deg, #6366F1, #818CF8);
    }

    .upgrade-modal .um-banner .um-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 24px;
    }

    .upgrade-modal .um-close {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .upgrade-modal .um-close:hover {
        background: rgba(255,255,255,0.35);
        transform: scale(1.05);
    }

    .upgrade-modal .um-body {
        padding: 24px;
    }

    .upgrade-modal .um-body .um-tier {
        font-size: 14px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 2px;
    }

    .upgrade-modal .um-body .um-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .upgrade-modal .um-body .um-desc {
        font-size: 13px;
        color: var(--gray);
        line-height: 1.5;
        margin-bottom: 20px;
    }

    .upgrade-modal .um-body .um-price-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .upgrade-modal .um-body .um-price {
        font-size: 28px;
        font-weight: 800;
        color: var(--primary);
    }

    .upgrade-modal .um-body .um-price span {
        font-size: 14px;
        font-weight: 500;
        color: var(--gray);
    }

    .upgrade-modal .um-body .um-divider {
        height: 1px;
        background: var(--border);
        margin: 20px 0;
    }

    .upgrade-modal .um-body .um-benefits-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 12px;
    }

    .upgrade-modal .um-body .um-benefits {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }

    .upgrade-modal .um-body .um-benefits .um-benefit-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--dark);
    }

    .upgrade-modal .um-body .um-benefits .um-benefit-item i {
        width: 18px;
        font-size: 13px;
        color: var(--primary);
        flex-shrink: 0;
    }

    .um-btn-upgrade {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
    }

    .um-btn-upgrade:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(255, 79, 135, 0.35);
    }

    .payment-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .payment-modal.show {
        display: flex;
    }

    .payment-modal .pm-card {
        background: var(--white);
        border-radius: 24px;
        max-width: 480px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: modalIn 0.3s ease;
    }

    .payment-modal .pm-header {
        padding: 24px 28px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .payment-modal .pm-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .payment-modal .pm-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #f1f5f9;
        color: var(--gray);
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .payment-modal .pm-close:hover {
        background: #e2e8f0;
    }

    .payment-modal .pm-info {
        padding: 16px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #FFF5F8;
        margin: 16px 28px;
        border-radius: 12px;
    }

    .payment-modal .pm-info .pmi-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray);
    }

    .payment-modal .pm-info .pmi-nominal {
        font-size: 20px;
        font-weight: 800;
        color: var(--primary);
    }

    .payment-modal .pm-divider {
        height: 1px;
        background: var(--border);
        margin: 0 28px;
    }

    .payment-modal .pm-payment {
        padding: 0 28px 24px;
    }

    .payment-modal .pm-payment .pmp-title {
        font-size: 12px;
        font-weight: 700;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .payment-modal .pmp-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .payment-modal .pmp-option {
        position: relative;
    }

    .payment-modal .pmp-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .payment-modal .pmp-option label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: #FAFAFA;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 12px;
        font-weight: 600;
        color: var(--dark);
        font-family: 'Inter', sans-serif;
    }

    .payment-modal .pmp-option label:hover {
        border-color: var(--primary);
        background: var(--hover);
    }

    .payment-modal .pmp-option input:checked + label {
        border-color: var(--primary);
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.2);
    }

    .payment-modal .pm-bayar {
        margin: 0 28px 24px;
        width: calc(100% - 56px);
        padding: 14px;
        border-radius: 12px;
        border: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .payment-modal .pm-bayar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(255, 79, 135, 0.35);
    }

    .notif-toast {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        color: #fff;
        padding: 14px 24px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        max-width: 380px;
    }

    .notif-toast.show {
        transform: translateX(0);
    }

    .notif-toast .nt-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .notif-toast.success {
        background: #166534;
    }

    .notif-toast.error {
        background: #991B1B;
    }

    @media (max-width: 768px) {
        .member-tier-grid {
            grid-template-columns: 1fr;
        }

        .member-status-card .ms-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .benefit-grid {
            grid-template-columns: 1fr;
        }

        .payment-modal .pmp-group {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Membership</h3>
                                <p>Nikmati berbagai keuntungan eksklusif sebagai member BeautyCare</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="member-status-card">
                    <div class="ms-deco"></div>
                    <div class="ms-deco"></div>
                    <div class="ms-content">
                        <div class="ms-left">
                            <div class="ms-icon">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="ms-text">
                                <h3>Status Keanggotaan</h3>
                                <p>Anda saat ini terdaftar sebagai member aktif BeautyCare</p>
                            </div>
                        </div>
                        <div class="ms-level">
                            <i class="fa-solid fa-crown"></i>
                            Silver Member
                        </div>
                    </div>
                </div>

                <div class="stats-membership">
                    <div class="stat-member-card">
                        <div class="sm-icon belanja">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div class="sm-value">Rp 2,5jt</div>
                        <div class="sm-label">Total Belanja</div>
                    </div>
                    <div class="stat-member-card">
                        <div class="sm-icon transaksi">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div class="sm-value">12</div>
                        <div class="sm-label">Total Transaksi</div>
                    </div>
                    <div class="stat-member-card">
                        <div class="sm-icon diskon">
                            <i class="fa-solid fa-percent"></i>
                        </div>
                        <div class="sm-value">5%</div>
                        <div class="sm-label">Diskon Member</div>
                    </div>
                    <div class="stat-member-card">
                        <div class="sm-icon tier">
                            <i class="fa-solid fa-arrow-up"></i>
                        </div>
                        <div class="sm-value">Gold</div>
                        <div class="sm-label">Next Tier</div>
                    </div>
                </div>

                <div class="benefit-section-title">
                    <i class="fa-solid fa-layer-group"></i> Pilih Level Membership
                </div>

                <div class="member-tier-grid">
                    <div class="member-tier-card">
                        <div class="mt-banner silver">
                            <div class="mt-icon-big">
                                <i class="fa-solid fa-medal"></i>
                            </div>
                            <span class="mt-badge active-tier">
                                <i class="fa-regular fa-circle-check"></i> Aktif
                            </span>
                        </div>
                        <div class="mt-body">
                            <div class="mt-title">Silver</div>
                            <div class="mt-subtitle">Untuk pemula yang baru bergabung</div>
                            <div class="mt-benefits">
                                <div class="mt-benefit-item">
                                    <i class="fa-regular fa-circle-check"></i> Diskon 5% semua layanan
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-regular fa-circle-check"></i> Gratis konsultasi 1x/bulan
                                </div>
                                <div class="mt-benefit-item disabled">
                                    <i class="fa-regular fa-circle-xmark"></i> Prioritas booking
                                </div>
                                <div class="mt-benefit-item disabled">
                                    <i class="fa-regular fa-circle-xmark"></i> Undangan event eksklusif
                                </div>
                            </div>
                            <div class="mt-price">Min. 1x Transaksi</div>
                            <div class="mt-price">Min. Rp 500.000 Pembelian</div>
                            <button class="mt-btn current">
                                <i class="fa-regular fa-circle-check"></i> Level Saat Ini
                            </button>
                        </div>
                    </div>

                    <div class="member-tier-card">
                        <div class="mt-banner gold">
                            <div class="mt-icon-big">
                                <i class="fa-solid fa-trophy"></i>
                            </div>
                        </div>
                        <div class="mt-body">
                            <div class="mt-title">Gold</div>
                            <div class="mt-subtitle">Untuk member setia dengan transaksi minimal 5x</div>
                            <div class="mt-benefits">
                                <div class="mt-benefit-item">
                                    <i class="fa-regular fa-circle-check"></i> Diskon 10% semua layanan
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-regular fa-circle-check"></i> Gratis konsultasi 2x/bulan
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-regular fa-circle-check"></i> Prioritas booking
                                </div>
                                <div class="mt-benefit-item disabled">
                                    <i class="fa-regular fa-circle-xmark"></i> Undangan event eksklusif
                                </div>
                            </div>
                            <div class="mt-price">Min. 5x Transaksi</div>
                            <div class="mt-price">Min. Rp 3.000.000 Pembelian</div>
                            <button class="mt-btn primary" data-tier="gold" onclick="showUpgradeModal(this)">Upgrade ke Gold</button>
                        </div>
                    </div>

                    <div class="member-tier-card">
                        <div class="mt-banner platinum">
                            <div class="mt-icon-big">
                                <i class="fa-solid fa-gem"></i>
                            </div>
                        </div>
                        <div class="mt-body">
                            <div class="mt-title">Platinum</div>
                            <div class="mt-subtitle">Untuk member VIP dengan transaksi minimal 15x</div>
                            <div class="mt-benefits">
                                <div class="mt-benefit-item">
                                    <i class="fa-regular fa-circle-check"></i> Diskon 20% semua layanan
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-regular fa-circle-check"></i> Gratis konsultasi 4x/bulan
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-regular fa-circle-check"></i> Prioritas booking
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-regular fa-circle-check"></i> Undangan event eksklusif
                                </div>
                            </div>
                            <div class="mt-price">Min. 15x Transaksi</div>
                            <div class="mt-price">Min. Rp 5.000.000 Pembelian</div>
                            <button class="mt-btn outline" data-tier="platinum" onclick="showUpgradeModal(this)">Upgrade ke Platinum</button>
                        </div>
                    </div>
                </div>

                <div class="benefit-section-title">
                    <i class="fa-solid fa-gift"></i> Keuntungan Membership
                </div>

                <div class="benefit-grid">
                    <div class="benefit-card">
                        <div class="bc-icon diskon">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Diskon Spesial</h4>
                            <p>Dapatkan diskon khusus untuk semua layanan dan produk BeautyCare sesuai level membership Anda.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon prioritas">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Prioritas Booking</h4>
                            <p>Member Gold dan Platinum mendapatkan prioritas dalam pemesanan jadwal treatment.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon produk">
                            <i class="fa-solid fa-cube"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Diskon Produk</h4>
                            <p>Nikmati potongan harga khusus untuk pembelian produk kecantikan pilihan di BeautyCare.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon event">
                            <i class="fa-solid fa-calendar-star"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Event Eksklusif</h4>
                            <p>Nikmati undangan ke event-event spesial seperti beauty class dan product launch.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon kado">
                            <i class="fa-solid fa-gift"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Hadiah Ulang Tahun</h4>
                            <p>Dapatkan hadiah spesial di bulan ulang tahun Anda sebagai bentuk apresiasi dari BeautyCare.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon gratis">
                            <i class="fa-solid fa-spa"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Treatment Gratis</h4>
                            <p>Nikmati treatment gratis secara berkala sesuai dengan ketentuan level membership Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="upgrade-modal" id="upgradeModal">
        <div class="um-card">
            <div class="um-banner" id="modalBanner">
                <div class="um-icon" id="modalIcon"></div>
                <button class="um-close" onclick="closeUpgradeModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="um-body">
                <div class="um-tier" id="modalTier"></div>
                <div class="um-title" id="modalTitle"></div>
                <div class="um-desc" id="modalDesc"></div>
                <div class="um-price-label">Harga Upgrade</div>
                <div class="um-price" id="modalPrice"></div>
                <div class="um-divider"></div>
                <div class="um-benefits-title"><i class="fa-regular fa-circle-check"></i> Benefit yang Didapatkan</div>
                <div class="um-benefits" id="modalBenefits"></div>
                <button class="um-btn-upgrade" id="modalBtn">Upgrade Sekarang</button>
            </div>
        </div>
    </div>

    <div class="payment-modal" id="paymentModal">
        <div class="pm-card">
            <div class="pm-header">
                <h3><i class="fa-solid fa-wallet"></i> Pembayaran Upgrade</h3>
                <button class="pm-close" onclick="closePaymentModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="pm-info">
                <div class="pmi-label">Total Pembayaran</div>
                <div class="pmi-nominal" id="pmTotal">Rp 600.000</div>
            </div>
            <div class="pm-divider"></div>
            <div class="pm-payment">
                <div class="pmp-title"><i class="fa-solid fa-credit-card"></i> Metode Pembayaran</div>
                <div class="pmp-group">
                    <div class="pmp-option">
                        <input type="radio" name="pm_metode" id="pm_transfer" value="Transfer" checked>
                        <label for="pm_transfer"><i class="fa-solid fa-building-columns"></i> Transfer</label>
                    </div>
                    <div class="pmp-option">
                        <input type="radio" name="pm_metode" id="pm_dana" value="Dana">
                        <label for="pm_dana"><i class="fa-solid fa-qrcode"></i> Dana</label>
                    </div>
                    <div class="pmp-option">
                        <input type="radio" name="pm_metode" id="pm_gopay" value="GoPay">
                        <label for="pm_gopay"><i class="fa-solid fa-qrcode"></i> GoPay</label>
                    </div>
                    <div class="pmp-option">
                        <input type="radio" name="pm_metode" id="pm_ovo" value="OVO">
                        <label for="pm_ovo"><i class="fa-solid fa-qrcode"></i> OVO</label>
                    </div>
                    <div class="pmp-option">
                        <input type="radio" name="pm_metode" id="pm_shopeepay" value="ShopeePay">
                        <label for="pm_shopeepay"><i class="fa-solid fa-qrcode"></i> ShopeePay</label>
                    </div>
                </div>
            </div>
            <button class="pm-bayar" onclick="prosesBayarUpgrade()">
                <i class="fa-solid fa-check-circle"></i> Bayar Sekarang
            </button>
        </div>
    </div>

    <div class="notif-toast success" id="notifToast">
        <div class="nt-icon"><i class="fa-solid fa-check"></i></div>
        <span id="notifToastMsg">Berhasil!</span>
    </div>

    <script>
    var currentUpgradeTier = '';

    const tierData = {
        gold: {
            name: 'Gold',
            bannerClass: 'gold',
            icon: '<i class="fa-solid fa-trophy"></i>',
            title: 'Gold Member',
            desc: 'Tingkatkan pengalaman Anda dengan keuntungan eksklusif sebagai Gold Member.',
            price: 'Rp 600.000 <span>/tahun</span>',
            priceNumeric: 600000,
            benefits: [
                'Diskon 10% semua layanan',
                'Gratis konsultasi 2x/bulan',
                'Prioritas booking',
            ],
            eligible: true
        },
        platinum: {
            name: 'Platinum',
            bannerClass: 'platinum',
            icon: '<i class="fa-solid fa-gem"></i>',
            title: 'Platinum Member',
            desc: 'Nikmati layanan VIP dengan benefit paling lengkap sebagai Platinum Member.',
            price: 'Rp 900.000 <span>/tahun</span>',
            priceNumeric: 900000,
            benefits: [
                'Diskon 20% semua layanan',
                'Gratis konsultasi 4x/bulan',
                'Prioritas booking',
                'Undangan event eksklusif',
            ],
            eligible: false
        }
    };

    function showUpgradeModal(btn) {
        var tier = btn.getAttribute('data-tier');
        var data = tierData[tier];
        if (!data) return;

        currentUpgradeTier = tier;

        document.getElementById('modalBanner').className = 'um-banner ' + data.bannerClass;
        document.getElementById('modalIcon').innerHTML = data.icon;
        document.getElementById('modalTier').textContent = data.name + ' Membership';
        document.getElementById('modalTitle').textContent = data.title;
        document.getElementById('modalDesc').textContent = data.desc;
        document.getElementById('modalPrice').innerHTML = data.price;

        var benefitsEl = document.getElementById('modalBenefits');
        benefitsEl.innerHTML = '';
        data.benefits.forEach(function(benefit) {
            var item = document.createElement('div');
            item.className = 'um-benefit-item';
            item.innerHTML = '<i class="fa-regular fa-circle-check"></i> ' + benefit;
            benefitsEl.appendChild(item);
        });

        document.getElementById('upgradeModal').classList.add('show');
    }

    function closeUpgradeModal() {
        document.getElementById('upgradeModal').classList.remove('show');
    }

    document.getElementById('upgradeModal').addEventListener('click', function(e) {
        if (e.target === this) closeUpgradeModal();
    });

    document.getElementById('modalBtn').addEventListener('click', function() {
        var data = tierData[currentUpgradeTier];
        if (!data) return;

        if (data.eligible) {
            closeUpgradeModal();
            document.getElementById('pmTotal').textContent = data.price.replace(/<[^>]*>/g, '');
            document.getElementById('paymentModal').classList.add('show');
        } else {
            closeUpgradeModal();
            showNotif('Anda belum memenuhi syarat untuk upgrade ke Platinum.', 'error', 5000);
        }
    });

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.remove('show');
    }

    document.getElementById('paymentModal').addEventListener('click', function(e) {
        if (e.target === this) closePaymentModal();
    });

    function prosesBayarUpgrade() {
        var metode = document.querySelector('input[name="pm_metode"]:checked');
        if (metode) {
            closePaymentModal();
            showNotif('Pembayaran via ' + metode.value + ' sedang diproses!', 'success');
        }
    }

    function showNotif(msg, type, duration) {
        var el = document.getElementById('notifToast');
        el.className = 'notif-toast ' + (type || 'success');
        document.getElementById('notifToastMsg').textContent = msg;
        el.classList.add('show');
        setTimeout(function() { el.classList.remove('show'); }, duration || 3000);
    }

    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const dateEl = document.getElementById('currentDate');
    if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
