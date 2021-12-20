<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        <meta name="Issa" content="Full stack dev" />
        <title>Stockify | Warehouse Management</title>
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet"
        />
        <link href="css/fontawesome-all.css" rel="stylesheet" />
        <link
        href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css"
        rel="stylesheet"
        />
        <link href="css/swiper.css" rel="stylesheet" />
        <link href="css/magnific-popup.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />

        <!-- Favicon  -->
        <link rel="icon" href="images/favicon.png" />
    </head>
    <body data-spy="scroll" data-target=".fixed-top">
        <!-- Navigation -->
        <nav class="navbar fixed-top">
            <div
            class="
                container
                sm:px-4
                lg:px-8
                flex flex-wrap
                items-center
                justify-between
                lg:flex-nowrap
            "
            >
            <a
                class="inline-block py-0.5 text-4xl text-blue-400 whitespace-nowrap"
                href="index.html"
            >
                Stockify
            </a>

            <button
                class="
                background-transparent
                rounded
                text-xl
                leading-none
                hover:no-underline
                focus:no-underline
                lg:hidden lg:text-gray-400
                "
                type="button"
                data-toggle="offcanvas"
            >
                <span
                class="navbar-toggler-icon inline-block w-8 h-8 align-middle"
                ></span>
            </button>

            <div
                class="
                navbar-collapse
                offcanvas-collapse
                lg:flex lg:flex-grow lg:items-center
                "
                id="navbarsExampleDefault"
            >
                <ul
                class="
                    pl-0
                    mt-3
                    mb-2
                    ml-auto
                    flex flex-col
                    list-none
                    lg:mt-0 lg:mb-0 lg:flex-row
                "
                >
                <li>
                    <a class="nav-link page-scroll active" href="#header"
                    >Home <span class="sr-only">(current)</span></a
                    >
                </li>
                <li>
                    <a class="nav-link page-scroll" href="#warehouses">Warehouses</a>
                </li>
            
                <li>
                    <a class="nav-link page-scroll" href="#footer">Contacts</a>
                </li>
                <li class="nav-link page-scroll bg-blue-400 rounded">
                    <a href="/login" class="text-white hover:opacity-75">
                        Login
                    </a>
                    </li>
                </ul>
            </div>
            </div>
        </nav>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
        <footer class="bg-gray-800 text-white" id="footer">
            <div class="md:flex justify-between md:text-left text-center max-w-6xl mx-auto py-4">
                <div>
                <h2 class="font-semibold text-xl text-blue-400 mb-4">CONTACTS</h2>
                <ul>
                    <li class="my-2">info@stockify.com</li>
                    <li class="my-2">+25078000000</li>
                    <li class="my-2">Kigali, Rwanda</li>
                </ul>
                </div>
                <div>
                <h2 class="font-semibold text-xl text-blue-400 mb-4">ABOUT</h2>
                <ul>
                    <li class="my-2">
                    <a href="/about" class="text-gray-300 hover:text-blue-400">
                        About us
                    </a>
                    </li>
                    <li class="my-2">
                    <a href="/blog" class="text-gray-300 hover:text-blue-400">
                        Blog
                    </a>
                    </li>
                    <li class="my-2">
                    <a href="/awards" class="text-gray-300 hover:text-blue-400">
                        Awards
                    </a>
                    </li>
                    <li class="my-2">
                    <a href="/customers" class="text-gray-300 hover:text-blue-400">
                        Customers
                    </a>
                    </li>

                </ul>
                </div>
                <div>
                <h2 class="font-semibold text-xl text-blue-400 mb-4">Categories</h2>
                <ul>
                    <li class="my-2">
                    <a href="/about" class="text-gray-300 hover:text-blue-400">
                        Creals, vege, and fruits
                    </a>
                    </li>
                    <li class="my-2">
                    <a href="/contact" class="text-gray-300 hover:text-blue-400">
                        Timbers and metals
                    </a>
                    </li>
                    <li class="my-2">
                    <a href="/about" class="text-gray-300 hover:text-blue-400">
                        Chemicals and Electronics
                    </a>
                    </li>
                </ul>
                </div>
                <div>
                <h2 class="font-semibold text-xl text-blue-400 mb-4">SERVICES</h2>
                <ul>
                    <li class="my-2">
                    <a href="/about" class="text-gray-300 hover:text-blue-400">
                        Storage of goods and crops
                    </a>
                    </li>
                    <li class="my-2">
                    <a href="/contact" class="text-gray-300 hover:text-blue-400">
                        Stock management
                    </a>
                    </li>
                    <li class="my-2">
                    <a href="/blog" class="text-gray-300 hover:text-blue-400">
                        Transfer of goods and transportation
                    </a>
                    </li>
                </ul>
                </div>
                <div>
                <h2 class="font-semibold text-xl text-blue-400 mb-4">ACCOUNT</h2>
                <ul>
                    <li class="my-2">
                    <a href="/login" class="text-gray-300 hover:text-blue-400">
                        Login
                    </a>
                    </li>
                    <li class="my-2">
                    <a href="/register" class="text-gray-300 hover:text-blue-400">
                        Register
                    </a>
                    </li>
                </ul>
                </div>
            </div>
            <div
                class="md:flex justify-between items-center border-t border-gray-500"
            >
                <div>
                <a href="#" class="flex items-center py-4 px-2">
                    <span class="font-semibold text-blue-400 text-4xl">Stockify</span>
                </a>
                </div>
                <ul class="flex justify-center">
                <li class="mx-4">
                    <a
                    href="https://github.com/mansurissa"
                    target="#blank"
                    class="hover:text-blue-400"
                    ><i class="fab fa-github" aria-hidden="true"></i
                    ></a>
                </li>
                <li class="mx-4">
                    <a
                    href="https://www.linkedin.com/in/nsabimana-issa-1411ba1b3/"
                    target="#blank"
                    class="hover:text-blue-400"
                    ><i class="fab fa-linkedin" aria-hidden="true"></i
                    ></a>
                </li>
                <li class="mx-4">
                    <a
                    href="https://twitter.com/Rwesamihigo"
                    target="#blank"
                    class="hover:text-blue-400"
                    ><i class="fab fa-twitter" aria-hidden="true"></i
                    ></a>
                </li>
                <li class="mx-4">
                    <a
                    href="https://twitter.com/Rwesamihigo"
                    target="#blank"
                    class="hover:text-blue-400"
                    ><i class="fab fa-facebook" aria-hidden="true"></i
                    ></a>
                </li>
                <li class="mx-4">
                    <a
                    href="https://twitter.com/Rwesamihigo"
                    target="#blank"
                    class="hover:text-blue-400"
                    ><i class="fab fa-youtube" aria-hidden="true"></i
                    ></a>
                </li>
                </ul>
                <p class="px-2 text-sm text-gray-300">
                &copy;Copyright 2021 Stockify. all right reserved
                </p>
            </div>
        </footer>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.easing.min.js"></script>
        <script src="js/swiper.min.js"></script>
        <script src="js/jquery.magnific-popup.js"></script>
        <script src="js/scripts.js"></script>
    </body>
    </html>
