<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('Sign In') ?></title>
    <link href="<?= BASE_URL ?>/assets/dist/output.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/fonts.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>/assets/img/default/favicon.png">
</head>
<body class="bg-[#f8fafc] flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-[360px] md:max-w-[720px]">
        <div class="auth-card sharp-radius shadow-sm overflow-hidden flex flex-col md:flex-row border border-slate-200">
            
            <div class="hidden md:flex md:w-5/12 bg-slate-900 p-10 flex-col justify-between">
                <div class="w-10 h-10 bg-indigo-600 sharp-radius flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-white font-bold text-xl tracking-tight leading-tight">
                        <?= __('ZLibrary') ?><br><?= __('CMS') ?>
                    </h2>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em] mt-4">
                        <?= __('v1.0 Stable') ?>
                    </p>
                </div>
            </div>

            <div class="flex-1 p-8 md:p-12 bg-white">
                <div class="mb-8">
                    <h3 class="text-slate-900 font-bold text-lg tracking-tight"><?= __('Sign In') ?></h3>
                    <p class="text-slate-400 text-xs mt-1"><?= __('Please use your administrator account.') ?></p>
                </div>

                <?php if(isset($_SESSION['error'])): ?>
                    <div class="bg-red-50 text-red-600 p-3 mb-6 sharp-radius text-[10px] font-bold uppercase border border-red-100 text-center">
                        <?= __($_SESSION['error']); unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/auth/login" method="POST" class="space-y-5">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1"><?= __('Username') ?></label>
                            <input type="text" name="username" required 
                                   placeholder="<?= __('Enter username') ?>"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 sharp-radius focus:border-indigo-600 focus:bg-white text-slate-700 text-sm outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1"><?= __('Password') ?></label>
                            <div class="relative">
                                <input type="password" id="passwordField" name="password" required 
                                       placeholder="<?= __('Enter password') ?>"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 sharp-radius focus:border-indigo-600 focus:bg-white text-slate-700 text-sm outline-none transition-all">
                                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-indigo-600 transition-colors">
                                    <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path id="eyePath" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-4 flex flex-col gap-4">
                        <button type="submit" name="login" 
                                class="w-full bg-slate-900 text-white py-3.5 sharp-radius font-bold text-[11px] uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all active:scale-[0.98]">
                            <?= __('Login to Panel') ?>
                        </button>
                        <a href="<?= BASE_URL ?>" class="text-[10px] font-bold text-slate-400 hover:text-indigo-600 text-center transition-all uppercase tracking-widest">
                            &larr; <?= __('Back to Site') ?>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const field = document.getElementById('passwordField');
            const eyePath = document.getElementById('eyePath');
            if (field.type === 'password') {
                field.type = 'text';
                eyePath.setAttribute('d', 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18');
            } else {
                field.type = 'password';
                eyePath.setAttribute('d', 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z');
            }
        }
    </script>
</body>
</html>