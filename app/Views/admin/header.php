<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="<?= BASE_URL ?>/assets/dist/output.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/fonts.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <script src="<?= BASE_URL ?>/assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/ckeditor5/ckeditor.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/js/ckeditor5/ckeditor5.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/js/toastr/toastr.min.css">
    <script src="<?= BASE_URL ?>/assets/js/toastr/toastr.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/Sortable.min.js"></script>
    <link rel="icon" type="image/png" sizes="16x16"  href="<?= BASE_URL ?>/assets/img/default/<?= SITE_ICON ?>">
    <style>
        .sharp-radius { border-radius: 4px; }
        .input-flat { border: 1px solid #e2e8f0; background: #fcfcfc; transition: 0.2s; }
        .input-flat:focus { border-color: #4f46e5; background: #fff; outline: none; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .text-readable-menu { font-size: 0.95rem; font-weight: 700; color: #1e293b; }
        .text-url { font-family: monospace; font-size: 11px; color: #94a3b8; }
        .btn-action-box { width: 36px; height: 36px; border: 1px solid #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b; }
        .main-handle, .sub-handle { cursor: grab; color: #cbd5e1; padding: 4px; font-size: 20px; }
        .sortable-ghost { background-color: #f8fafc !important; border: 2px dashed #6366f1 !important; opacity: 0.5; }

            :root { --radius-custom: 12px; }
    .rounded-custom { border-radius: var(--radius-custom) !important; }
    .ck-editor__editable { min-height: 250px; padding: 0 20px !important; }
    [x-cloak] { display: none !important; }
    .modal-overlay { background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); }
        .sortable-ghost {
        background-color: #eef2ff !important;
        border: 2px dashed #4f46e5 !important;
        opacity: 0.8;
    }
    .sortable-chosen {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: scale(1.01);
    }
    .submenu-list.drag-over {
        background-color: #f0f9ff !important;
        border: 1px solid #0ea5e9 !important;
    }
    .connected-sortable {
        min-height: 40px;
        transition: all 0.2s ease;
    }
        :root { --radius-custom: 10px; }
    .rounded-custom { border-radius: var(--radius-custom) !important; }
    .btn-action-box {
        display: flex; align-items: center; justify-content: center;
        width: 40px; height: 40px;
        border: 1px solid #e2e8f0; border-radius: var(--radius-custom);
        background-color: #ffffff; transition: all 0.2s ease;
        color: #64748b;
    }
    .btn-action-box:hover { transform: translateY(-2px); box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.1); }
    .btn-edit:hover { border-color: #6366f1; color: #6366f1; background-color: #f5f7ff; }
    .btn-toggle:hover { border-color: #10b981; color: #10b981; background-color: #ecfdf5; }
    .btn-delete:hover { border-color: #ef4444; color: #ef4444; background-color: #fff1f2; }
    </style>
</head>
<body class="bg-[#F8FAFC] flex h-screen overflow-hidden text-slate-600">

