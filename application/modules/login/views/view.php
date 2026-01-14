<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ePO System - Electronic Purchasing Order System</title>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>tailwindcss_login.js"></script>
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/fontawesome_640/css/'); ?>fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>css_login.css">

</head>

<body class="min-h-screen relative overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>image_login.png"
            alt="Background" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    </div>

    <!-- Decorative Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating Icons -->
        <div class="absolute top-20 left-10 animate-pulse">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <i class="fa fa-shopping-bag text-white/60 text-2xl"></i>
            </div>
        </div>

        <div class="absolute top-40 right-20 animate-pulse delay-75">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <i class="fa fa-box text-white/60 text-2xl"></i>
            </div>
        </div>

        <div class="absolute bottom-40 left-20 animate-pulse delay-150">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <i class="fa fa-truck text-white/60 text-2xl"></i>
            </div>
        </div>

        <div class="absolute bottom-20 right-10 animate-pulse delay-300">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <i class="fa fa-chart-bar text-white/60 text-2xl"></i>
            </div>
        </div>

        <div class="absolute top-60 left-1/4 animate-pulse delay-500">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <i class="fa fa-users text-white/60 text-2xl"></i>
            </div>
        </div>

        <div class="absolute top-1/3 right-1/4 animate-pulse delay-700">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <i class="fa fa-cog text-white/60 text-2xl"></i>
            </div>
        </div>

        <div class="absolute bottom-60 left-1/3 animate-pulse delay-1000">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <i class="fa fa-shield-alt text-white/60 text-2xl"></i>
            </div>
        </div>

        <!-- Floating Geometric Shapes -->
        <div class="absolute top-32 left-1/2 w-20 h-20 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-40 right-1/3 w-32 h-32 bg-gradient-to-tr from-green-400/20 to-blue-400/20 rounded-full blur-xl animate-pulse delay-300"></div>
        <div class="absolute top-1/2 left-10 w-16 h-16 bg-gradient-to-bl from-purple-400/20 to-pink-400/20 rounded-full blur-xl animate-pulse delay-500"></div>
        <div class="absolute bottom-20 left-1/2 w-24 h-24 bg-gradient-to-tl from-yellow-400/20 to-orange-400/20 rounded-full blur-xl animate-pulse delay-700"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <!-- Banner -->
        <div class="text-center mb-8">
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-2xl">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <i class="fa fa-building text-white text-3xl"></i>
                    <h1 class="text-4xl md:text-5xl font-bold text-white">
                        ePO System
                    </h1>
                </div>
                <p class="text-lg md:text-xl text-white/90 font-medium">
                    Electronic Purchasing Order System
                </p>
            </div>
        </div>

        <!-- Login Card -->
        <div class="w-full max-w-md bg-white/95 backdrop-blur-sm border-white/20 shadow-2xl rounded-2xl">
            <div class="p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Selamat Datang
                    </h2>
                    <p class="text-gray-600">
                        Masuk ke akun Anda untuk melanjutkan
                    </p>
                </div>

                <!-- form method="POST" action="login.php" class="space-y-4" -->
                <form action="<?= site_url('auth'); ?>" method="post" class="space-y-4">
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <div class="relative">
                            <i class="fa fa-envelope absolute left-3 top-3 h-4 w-4 text-gray-400"></i>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="nama@email.com"
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-sm font-medium text-gray-700">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <i class="fa fa-lock absolute left-3 top-3 h-4 w-4 text-gray-400"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan kata sandi"
                                class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required />
                            <button
                                type="button"
                                class="absolute right-0 top-0 h-full px-3 py-2 hover:bg-transparent"
                                onclick="togglePassword()">
                                <i id="eyeIcon" class="fa fa-eye h-4 w-4 text-gray-400"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">

                    </div>

                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2" style="color: red;">
                            <?php echo $status_loginku; ?>
                        </h2>
                    </div>


                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200" id="btnlogin">Login</button>

                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-white/80 text-sm">
                © 2024 ePO System. All rights reserved.
            </p>
        </div>
    </div>

    <script type="text/javascript">
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>