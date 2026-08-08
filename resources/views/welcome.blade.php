<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Sweet Crumbs Bakery') }}</title>

        @fonts

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */ @layer properties{@supports (((-webkit-hyphens:none)) and (not (margin-trim:inline))) or ((-moz-orient:inline) and (not (color:rgb(from red r g b)))){*,:before,:after,::backdrop{--tw-translate-x:0;--tw-translate-y:0;--tw-translate-z:0;--tw-rotate-x:initial;--tw-rotate-y:initial;--tw-rotate-z:initial;--tw-skew-x:initial;--tw-skew-y:initial;--tw-space-x-reverse:0;--tw-border-style:solid;--tw-leading:initial;--tw-font-weight:initial;--tw-tracking:initial;--tw-shadow:0 0 #0000;--tw-shadow-color:initial;--tw-shadow-alpha:100%;--tw-inset-shadow:0 0 #0000;--tw-inset-shadow-color:initial;--tw-inset-shadow-alpha:100%;--tw-ring-color:initial;--tw-ring-shadow:0 0 #0000;--tw-inset-ring-color:initial;--tw-inset-ring-shadow:0 0 #0000;--tw-ring-inset:initial;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-offset-shadow:0 0 #0000;--tw-blur:initial;--tw-brightness:initial;--tw-contrast:initial;--tw-grayscale:initial;--tw-hue-rotate:initial;--tw-invert:initial;--tw-opacity:initial;--tw-saturate:initial;--tw-sepia:initial;--tw-drop-shadow:initial;--tw-drop-shadow-color:initial;--tw-drop-shadow-alpha:100%;--tw-drop-shadow-size:initial;--tw-duration:initial;--tw-ease:initial;--tw-content:""}}}@layer theme{:root,:host{--font-sans:"Instrument Sans", ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";--font-serif:ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;--font-mono:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;--color-red-50:oklch(97.1% .013 17.38);--color-red-100:oklch(93.6% .032 17.717);--color-red-200:oklch(88.5% .062 18.334);--color-red-300:oklch(80.8% .114 19.571);--color-red-400:oklch(70.4% .191 22.216);--color-red-500:oklch(63.7% .237 25.331);--color-red-600:oklch(57.7% .245 27.325);--color-red-700:oklch(50.5% .213 27.518);--color-red-800:oklch(44.4% .
            </style>
        @endif
        <style>
            .page-shell {
                min-height: 100vh;
                background: radial-gradient(circle at top left, rgba(254, 237, 223, 0.92), transparent 22%),
                    radial-gradient(circle at bottom right, rgba(188, 108, 37, 0.14), transparent 34%),
                    #fff7f0;
                color: #382a1f;
            }

            .glass-panel {
                background: rgba(255, 255, 255, 0.86);
                backdrop-filter: blur(14px);
                border: 1px solid rgba(255, 255, 255, 0.78);
                box-shadow: 0 28px 70px rgba(128, 77, 36, 0.12);
            }

            .hero-pill {
                display: inline-flex;
                align-items: center;
                padding: 0.75rem 1rem;
                border-radius: 999px;
                background: rgba(252, 216, 191, 0.96);
                letter-spacing: 0.24em;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                color: #9c6f44;
            }

            .modern-btn {
                transition: transform 0.18s ease, background-color 0.18s ease, box-shadow 0.18s ease;
            }

            .modern-btn:hover {
                transform: translateY(-1px);
            }

            .section-card {
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid rgba(243, 210, 186, 0.9);
                box-shadow: 0 24px 50px rgba(128, 77, 36, 0.08);
                border-radius: 2rem;
            }

            .feature-card {
                border-radius: 2rem;
                background: rgba(255, 255, 255, 0.96);
                border: 1px solid rgba(243, 210, 186, 0.92);
                box-shadow: 0 20px 45px rgba(128, 77, 36, 0.06);
            }

            .text-accent {
                color: #bc6c25;
            }

            .hero-image-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, transparent, rgba(47, 31, 19, 0.24));
            }

            body {
                font-family: var(--font-sans);
                margin: 0;
            }
        </style>
    </head>
    <body class="page-shell">
        <div class="min-h-screen flex flex-col">
            <header class="sticky top-0 z-20 mx-auto w-full max-w-7xl px-6 py-5 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between glass-panel">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-[#f4d2b1] text-2xl font-semibold text-[#7b4e2d] shadow-sm">B</div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.36em] text-[#9d7d60]">Sweet Crumbs</p>
                        <h1 class="text-xl font-semibold text-[#2f1f13]">Bakery & Cafe</h1>
                    </div>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <nav class="hidden gap-8 text-sm font-medium text-[#5a4636] sm:flex">
                        <a href="#menu" class="transition hover:text-[#c46325]">Menu</a>
                        <a href="#about" class="transition hover:text-[#c46325]">About</a>
                        <a href="#contact" class="transition hover:text-[#c46325]">Contact</a>
                    </nav>
                    <a href="#contact" class="modern-btn inline-flex items-center justify-center rounded-full bg-[#bc6c25] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-[#bc6c25]/20 hover:bg-[#a55818]">Order now</a>
                </div>
            </header>

            <main class="flex-1">
                <section class="relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(244,186,143,0.35),_transparent_35%)] pointer-events-none"></div>
                    <div class="absolute inset-y-0 right-0 w-1/2 bg-[radial-gradient(circle_at_top_right,_rgba(245,216,181,0.5),_transparent_45%)] pointer-events-none"></div>
                    <div class="mx-auto w-full max-w-7xl px-6 py-12 lg:py-24 flex flex-col gap-12 lg:flex-row lg:items-center">
                        <div class="max-w-2xl">
                            <span class="hero-pill">Fresh every morning</span>
                            <h2 class="mt-6 text-4xl font-semibold tracking-tight text-[#2f1f13] sm:text-5xl">Sweet breads, warm pastries, and smiles baked daily.</h2>
                            <p class="mt-6 text-lg leading-8 text-[#5f4a3d]">From flaky croissants to hearty sourdough, our bakery delivers handcrafted treats made with the finest ingredients and a love for every bite.</p>
                            <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:items-center">
                                <a href="#contact" class="modern-btn inline-flex items-center justify-center rounded-full bg-[#bc6c25] px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-[#bc6c25]/20 hover:bg-[#a55818]">Order today</a>
                                <a href="#menu" class="modern-btn inline-flex items-center justify-center rounded-full border border-[#bc6c25] bg-white/95 px-8 py-4 text-sm font-semibold text-[#5a3c24] hover:bg-[#fff5eb]">View menu</a>
                            </div>
                            <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div class="feature-card p-5">
                                    <p class="text-2xl font-semibold text-[#bc6c25]">120+</p>
                                    <p class="mt-1 text-sm text-[#6b5042]">Fresh pastries weekly</p>
                                </div>
                                <div class="feature-card p-5">
                                    <p class="text-2xl font-semibold text-[#bc6c25]">20+</p>
                                    <p class="mt-1 text-sm text-[#6b5042]">Artisan bread varieties</p>
                                </div>
                                <div class="feature-card p-5">
                                    <p class="text-2xl font-semibold text-[#bc6c25]">4.9/5</p>
                                    <p class="mt-1 text-sm text-[#6b5042]">Customer rating</p>
                                </div>
                            </div>
                        </div>
                        <div class="glass-panel overflow-hidden rounded-[2.5rem] border border-white/80 p-1 shadow-[0_32px_80px_rgba(141,77,33,0.14)]">
                            <div class="relative overflow-hidden rounded-[2.4rem]">
                                <img src="https://images.unsplash.com/photo-1511690743698-d9d85f2fbf38?auto=format&fit=crop&w=900&q=80" alt="Bakery goods" class="h-[380px] w-full object-cover object-center transition duration-500 hover:scale-105" />
                                <div class="hero-image-overlay"></div>
                                <div class="absolute bottom-6 left-6 rounded-full bg-white/90 px-5 py-3 text-sm font-semibold text-[#5a4231] shadow-sm">Today’s bake selection</div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="menu" class="mx-auto w-full max-w-7xl px-6 py-16">
                    <div class="grid gap-10 lg:grid-cols-[1.25fr_0.9fr] items-center">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-[#b87e4b]">Our favorites</p>
                            <h3 class="mt-3 text-3xl font-semibold text-[#2f1f13]">Something for every craving.</h3>
                            <p class="mt-4 max-w-xl text-base leading-8 text-[#5f4a3d]">Try our signature handcrafted items, baked fresh each morning and made with seasonal ingredients and care.</p>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <article class="rounded-[2rem] border border-[#f1d6c0] bg-white p-6 shadow-sm">
                                <p class="text-sm uppercase tracking-[0.2em] text-[#ba7e45]">Morning</p>
                                <h4 class="mt-3 text-xl font-semibold text-[#3a2517]">Almond croissant</h4>
                                <p class="mt-3 text-sm leading-6 text-[#6b5042]">Buttery, flaky layers with toasted almonds and vanilla glaze.</p>
                            </article>
                            <article class="rounded-[2rem] border border-[#f1d6c0] bg-white p-6 shadow-sm">
                                <p class="text-sm uppercase tracking-[0.2em] text-[#ba7e45]">Sourdough</p>
                                <h4 class="mt-3 text-xl font-semibold text-[#3a2517]">Country loaf</h4>
                                <p class="mt-3 text-sm leading-6 text-[#6b5042]">Crisp crust, chewy crumb, and a subtle tang from long fermentation.</p>
                            </article>
                            <article class="rounded-[2rem] border border-[#f1d6c0] bg-white p-6 shadow-sm">
                                <p class="text-sm uppercase tracking-[0.2em] text-[#ba7e45]">Sweet</p>
                                <h4 class="mt-3 text-xl font-semibold text-[#3a2517]">Berry tart</h4>
                                <p class="mt-3 text-sm leading-6 text-[#6b5042]">Fresh berries, lemon custard, and a crisp pastry shell.</p>
                            </article>
                            <article class="rounded-[2rem] border border-[#f1d6c0] bg-white p-6 shadow-sm">
                                <p class="text-sm uppercase tracking-[0.2em] text-[#ba7e45]">Daily</p>
                                <h4 class="mt-3 text-xl font-semibold text-[#3a2517]">Coffee cake</h4>
                                <p class="mt-3 text-sm leading-6 text-[#6b5042]">Warm cinnamon crumb topping with a rich coffee glaze.</p>
                            </article>
                        </div>
                    </div>
                </section>

                <section id="about" class="mx-auto w-full max-w-7xl px-6 py-16">
                    <div class="rounded-[2.5rem] bg-[#fff4eb] p-10 shadow-sm sm:p-16">
                        <div class="grid gap-10 lg:grid-cols-[0.9fr_1fr] items-center">
                            <div>
                                <p class="text-sm uppercase tracking-[0.3em] text-[#b87e4b]">About the bakery</p>
                                <h3 class="mt-3 text-3xl font-semibold text-[#2f1f13]">A neighborhood bakery with a warm, welcoming feel.</h3>
                                <p class="mt-6 text-base leading-8 text-[#5f4a3d]">Established to share good bread and good company, our bakery uses recipes passed down through friends, a wood-fired oven spirit, and fresh local ingredients.</p>
                                <ul class="mt-8 space-y-4 text-[#5f4a3d]">
                                    <li class="flex gap-3">
                                        <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#f8d0b5] text-[#9d5f35]">✓</span>
                                        <span>Daily small-batch baking with real butter.</span>
                                    </li>
                                    <li class="flex gap-3">
                                        <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#f8d0b5] text-[#9d5f35]">✓</span>
                                        <span>Seasonal pastries and artisan breads.</span>
                                    </li>
                                    <li class="flex gap-3">
                                        <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#f8d0b5] text-[#9d5f35]">✓</span>
                                        <span>Pickup, coffee, and custom orders available.</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-[2rem] bg-white p-6 shadow-sm">
                                    <p class="text-sm uppercase tracking-[0.2em] text-[#ba7e45]">Opening hours</p>
                                    <p class="mt-4 text-3xl font-semibold text-[#3a2517]">6am - 6pm</p>
                                    <p class="mt-3 text-sm text-[#6b5042]">Every day, fresh from the oven.</p>
                                </div>
                                <div class="rounded-[2rem] bg-white p-6 shadow-sm">
                                    <p class="text-sm uppercase tracking-[0.2em] text-[#ba7e45]">Location</p>
                                    <p class="mt-4 text-3xl font-semibold text-[#3a2517]">Main Street</p>
                                    <p class="mt-3 text-sm text-[#6b5042]">Cherrywood district, downtown.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <footer id="contact" class="border-t border-[#f1d6c0] bg-white">
                <div class="mx-auto w-full max-w-7xl px-6 py-12">
                    <div class="flex flex-col gap-10 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-[#b87e4b]">Reach out</p>
                            <h4 class="mt-3 text-2xl font-semibold text-[#2f1f13]">Pre-order or say hello.</h4>
                            <p class="mt-4 text-base leading-7 text-[#5f4a3d] max-w-2xl">Call us, send a message, or stop by the bakery to try today�s fresh batches.</p>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-[2rem] bg-[#fff4eb] p-6 shadow-sm">
                                <p class="text-sm uppercase tracking-[0.2em] text-[#ba7e45]">Phone</p>
                                <p class="mt-3 font-semibold text-[#3a2517]">(555) 123-4567</p>
                            </div>
                            <div class="rounded-[2rem] bg-[#fff4eb] p-6 shadow-sm">
                                <p class="text-sm uppercase tracking-[0.2em] text-[#ba7e45]">Email</p>
                                <p class="mt-3 font-semibold text-[#3a2517]">hello@sweetcrumbs.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
