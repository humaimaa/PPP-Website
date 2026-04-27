<nav class="navbar fixed top-0 w-full z-50 transition-all duration-300 py-1" x-data="{ dropdownOpen: null, mobileMenuOpen: false }">
    <div class="px-4">
        <div class="flex justify-between items-center">
           
            <!-- Left: Logo with Continuous 3D Rotation -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center py-2 group outline-none">
                    <img src="{{ asset('images/logo.png') }}" alt="PPP Department KPK Logo" 
                         class="navbar-logo h-12 md:h-18 w-auto mr-2 md:mr-3 animate-continuous-rotation hover:animation-pause">
                    <!-- Text hidden on mobile, visible on md and up -->
                    <div class="hidden lg:block">
                        <span class="text-text-primary font-semibold text-md block tracking-tighter leading-4">Public Private Partnership Unit</span>
                        <span class="text-text-secondary text-sm block tracking-tighter leading-4">P & D Department, KP</span>
                    </div>
                </a>
            </div>

            <!-- Right: Enhanced Glassmorphism Menu Box (Desktop only) -->
            <div class="hidden md:flex bg-linear-to-br from-white/15 via-white/5 to-white/2 backdrop-blur-md border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.2)] rounded-2xl px-6 py-2 space-x-6 hover:bg-linear-to-br hover:from-white/20 hover:via-white/8 hover:to-white/4 hover:border-white/30 transition-all duration-300">
                
                <!-- About Us Dropdown - Fixed hover behavior -->
                <div class="relative" 
                     @mouseenter="dropdownOpen = 'about'"
                     @mouseleave="dropdownOpen = null">
                    <button class="text-text-primary hover:scale-105 transition-transform duration-300 focus:outline-none whitespace-nowrap">
                        About Us
                    </button>
                    <div x-show="dropdownOpen === 'about'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-[-10px]"
                         class="absolute top-full left-0 mt-2 w-56 bg-primary/95 backdrop-blur-[10px] border border-white/20 rounded-lg z-50 shadow-lg"
                         @mouseenter="dropdownOpen = 'about'"
                         @mouseleave="dropdownOpen = null">
                        <a href="{{ route('about', 'overview') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all rounded-t-lg">About PPP</a>
                        <a href="{{ route('about', 'team') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all rounded-b-lg">Team</a>
                    </div>
                </div>
                
                <!-- Projects Dropdown - Fixed hover behavior -->
                <div class="relative" 
                     @mouseenter="dropdownOpen = 'projects'"
                     @mouseleave="dropdownOpen = null">
                    <button class="text-text-primary hover:scale-105 transition-transform duration-300 focus:outline-none whitespace-nowrap">
                        Projects
                    </button>
                    <div x-show="dropdownOpen === 'projects'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-[-10px]"
                         class="absolute top-full left-0 mt-2 w-56 bg-primary/95 backdrop-blur-[10px] border border-white/20 rounded-lg z-50 shadow-lg"
                         @mouseenter="dropdownOpen = 'projects'"
                         @mouseleave="dropdownOpen = null">
                        <a href="{{ route('projects.index', 'pipeline') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all rounded-t-lg">Pipeline</a>
                        <a href="{{ route('projects.index', 'ongoing') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all">Ongoing</a>
                        <a href="{{ route('projects.index', 'operational') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all rounded-b-lg">Operational</a>
                    </div>
                </div>
                
                <!-- Tenders Dropdown - Fixed hover behavior -->
                <div class="relative" 
                     @mouseenter="dropdownOpen = 'tenders'"
                     @mouseleave="dropdownOpen = null">
                    <button class="text-text-primary hover:scale-105 transition-transform duration-300 focus:outline-none whitespace-nowrap">
                        Tenders
                    </button>
                    <div x-show="dropdownOpen === 'tenders'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-[-10px]"
                         class="absolute top-full left-0 mt-2 w-56 bg-primary/95 backdrop-blur-[10px] border border-white/20 rounded-lg z-50 shadow-lg"
                         @mouseenter="dropdownOpen = 'tenders'"
                         @mouseleave="dropdownOpen = null">
                        <a href="{{ route('tenders', 'active') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all rounded-t-lg">Active Tenders</a>
                        <a href="{{ route('tenders', 'archived') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all rounded-b-lg">Archived Tenders</a>
                    </div>
                </div>
                
                <!-- Media Dropdown - Fixed hover behavior -->
                <div class="relative" 
                     @mouseenter="dropdownOpen = 'media'"
                     @mouseleave="dropdownOpen = null">
                    <button class="text-text-primary hover:scale-105 transition-transform duration-300 focus:outline-none whitespace-nowrap">
                        Media
                    </button>
                    <div x-show="dropdownOpen === 'media'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-[-10px]"
                         class="absolute top-full left-0 mt-2 w-56 bg-primary/95 backdrop-blur-[10px] border border-white/20 rounded-lg z-50 shadow-lg"
                         @mouseenter="dropdownOpen = 'media'"
                         @mouseleave="dropdownOpen = null">
                        <a href="{{ route('updates.index') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all rounded-t-lg">News & Updates</a>
                        <a href="{{ route('gallery.index') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all">Gallery</a>
                        <a href="{{ route('media.downloads') }}" class="block px-4 py-2 text-text-primary hover:bg-accent-1/15 hover:pl-5 transition-all rounded-b-lg">Downloads</a>
                    </div>
                </div>
                
                <a href="{{ route('contact') }}" class="text-text-primary hover:scale-105 transition-transform duration-300 whitespace-nowrap">Contact Us</a>
            </div>

            <!-- Mobile: Hamburger Menu Button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = true" 
                        class="p-2 outline-none hover:bg-white/10 rounded-lg transition-all duration-300">
                    <svg class="w-8 h-8 text-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Full Screen Offcanvas Menu for Mobile -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-transform duration-300 ease-in-out"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform duration-300 ease-in-out"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-0 z-50 bg-primary overflow-y-auto"
         style="display: none;">
        <div class="min-h-screen flex flex-col">
            <div class="p-6 border-b border-white/10 flex justify-end">
                <button @click="mobileMenuOpen = false" 
                        class="p-2 hover:bg-white/10 rounded-lg transition duration-300">
                    <svg class="w-8 h-8 text-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 flex items-start justify-center mt-8">
                <ul class="space-y-3 w-full max-w-md px-8">
                    <!-- About Us Mobile Dropdown -->
                    <li x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:bg-white/10 rounded-lg transition-all duration-300">
                            About Us
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="mt-2 space-y-1 pl-6">
                            <li><a href="{{ route('about', 'overview') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">About PPP</a></li>
                            <li><a href="{{ route('about', 'team') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">Team</a></li>
                        </ul>
                    </li>

                    <!-- Projects Mobile Dropdown -->
                    <li x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:bg-white/10 rounded-lg transition-all duration-300">
                            Projects
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="mt-2 space-y-1 pl-6">
                            <li><a href="{{ route('projects.index', 'pipeline') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">Pipeline</a></li>
                            <li><a href="{{ route('projects.index', 'ongoing') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">Ongoing</a></li>
                            <li><a href="{{ route('projects.index', 'operational') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">Operational</a></li>
                        </ul>
                    </li>

                    <!-- Tenders Mobile Dropdown -->
                    <li x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:bg-white/10 rounded-lg transition-all duration-300">
                            Tenders
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="mt-2 space-y-1 pl-6">
                            <li><a href="{{ route('tenders', 'active') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">Active Tenders</a></li>
                            <li><a href="{{ route('tenders', 'archived') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">Archived Tenders</a></li>
                        </ul>
                    </li>

                    <!-- Media Mobile Dropdown -->
                    <li x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:bg-white/10 rounded-lg transition-all duration-300">
                            Media
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="mt-2 space-y-1 pl-6">
                            <li><a href="{{ route('updates.index') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">News & Updates</a></li>
                            <li><a href="{{ route('gallery.index') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">Gallery</a></li>
                            <li><a href="{{ route('media.downloads') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:bg-white/10 hover:text-text-primary rounded-lg transition duration-300">Downloads</a></li>
                        </ul>
                    </li>

                    <li class="block md:hidden">
                        <a href="{{ route('contact') }}" class="flex items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:bg-white/10 rounded-lg transition-all duration-300">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-40"
         style="display: none;"
         @click="mobileMenuOpen = false">
    </div>
</nav>