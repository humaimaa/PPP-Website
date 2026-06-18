<nav class="navbar fixed top-0 w-full z-50 transition-all duration-300 py-1" 
     x-data="navbarDropdown()" 
     @click.away="closeAllDropdowns()">
    <div class="px-4">
        <div class="flex justify-between items-center">
           
            <!-- Left: Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center py-2 group outline-none">
                    <img src="{{ asset('images/logo.png') }}" alt="PPP Unit KP Logo" 
                         class="navbar-logo h-12 md:h-18 w-auto mr-2 md:mr-3 animate-continuous-rotation">
                    <div class="hidden lg:block">
                        <span class="text-text-primary font-semibold text-md block tracking-tighter leading-4">Public Private Partnership Unit</span>
                        <span class="text-text-secondary text-sm block tracking-tighter leading-4">P & D Department, KP</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="desktop-menu hidden md:flex bg-linear-to-br from-white/15 via-white/5 to-white/2 backdrop-blur-md border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.2)] rounded-2xl px-6 py-2 space-x-6 hover:bg-linear-to-br hover:from-white/20 hover:via-white/8 hover:to-white/4 hover:border-white/30 transition-all duration-300">
                
                <!-- About Us Dropdown -->
                <div class="relative group">
                    <button class="dropdown-button text-text-primary hover:text-accent-1 transition-all duration-300 focus:outline-none whitespace-nowrap flex items-center gap-1">
                        About Us
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute top-full left-0 mt-2 w-64 bg-primary border border-white/10 rounded-xl overflow-hidden z-50 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="{{ route('about.index') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">About PPP</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('about.mission-vision') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Vision & Mission</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('about.functions') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Functions</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('about.message') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Messages</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('about.team') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Team</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('about.organogram') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Organogram</a>
                    </div>
                </div>
                
                <!-- Projects Dropdown -->
                <div class="relative group">
                    <button class="dropdown-button text-text-primary hover:text-accent-1 transition-all duration-300 focus:outline-none whitespace-nowrap flex items-center gap-1">
                        Projects
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Main Projects Dropdown -->
                    <div class="absolute top-full left-0 mt-2 w-56 bg-primary border border-white/10 rounded-xl z-50 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        
                        <!-- Pipeline -->
                        <a href="{{ route('projects.index', ['category' => 'pipeline', 'status' => 'all']) }}" 
                           class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">
                            Pipeline
                        </a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        
                        <!-- Ongoing with Sub-dropdown -->
                        <div class="relative sub-dropdown-container">
                            <a href="{{ route('projects.index', ['category' => 'ongoing', 'status' => 'all']) }}" 
                               class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300 flex items-center justify-between">
                                <span>Ongoing</span>
                                <svg class="w-4 h-4 text-text-secondary sub-dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            <!-- Ongoing Sub-dropdown -->
                            <div class="sub-dropdown-menu absolute top-0 left-full ml-1 w-64">
                                <a href="{{ route('projects.index', ['category' => 'ongoing', 'status' => 'private-partner']) }}" 
                                   class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">
                                    Private Partner Selection
                                </a>
                                <div class="h-px bg-white/10 mx-4"></div>
                                <a href="{{ route('projects.index', ['category' => 'ongoing', 'status' => 'transaction-advisory']) }}" 
                                   class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">
                                    Transaction Advisory
                                </a>
                            </div>
                        </div>
                        
                        <div class="h-px bg-white/10 mx-4"></div>
                        
                        <!-- Completed with Sub-dropdown -->
                        <div class="relative sub-dropdown-container">
                            <a href="{{ route('projects.index', ['category' => 'completed', 'status' => 'all']) }}" 
                               class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300 flex items-center justify-between">
                                <span>Completed</span>
                                <svg class="w-4 h-4 text-text-secondary sub-dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            <!-- Completed Sub-dropdown -->
                            <div class="sub-dropdown-menu absolute top-0 left-full ml-1 w-56">
                                <a href="{{ route('projects.index', ['category' => 'completed', 'status' => 'construction']) }}" 
                                   class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">
                                    Construction
                                </a>
                                <div class="h-px bg-white/10 mx-4"></div>
                                <a href="{{ route('projects.index', ['category' => 'completed', 'status' => 'operational']) }}" 
                                   class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">
                                    Operational
                                </a>
                            </div>
                        </div>
                        
                        <div class="h-px bg-white/10 mx-4"></div>
                        
                        <!-- All Projects -->
                        <a href="{{ route('projects.index', ['category' => 'all', 'status' => 'all']) }}" 
                           class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">
                            All Projects
                        </a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        
                        <!-- Projects Statistics -->
                        <a href="{{ route('projects.projectStats') }}" 
                           class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">
                            Projects Statistics
                        </a>
                    </div>
                </div>

                <!-- Resource Center Dropdown -->
                <div class="relative group">
                    <button class="dropdown-button text-text-primary hover:text-accent-1 transition-all duration-300 focus:outline-none whitespace-nowrap flex items-center gap-1">
                        Resource Center
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute top-full left-0 mt-2 w-72 bg-primary border border-white/10 rounded-xl overflow-hidden z-50 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="{{ route('resource.center', 'legal-framework') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Legal Framework</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('resource.center', 'pre-qualified-advisors') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Pre-qualified Transaction Advisory</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('resource.center', 'policies-regulations') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Policies, Regulators & Guidelines</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('resource.center', 'knowledge-hub') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Knowledge Hub</a>
                    </div>
                </div>
                
                <!-- Media Room Dropdown -->
                <div class="relative group">
                    <button class="dropdown-button text-text-primary hover:text-accent-1 transition-all duration-300 focus:outline-none whitespace-nowrap flex items-center gap-1">
                        Media Room
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute top-full left-0 mt-2 w-56 bg-primary border border-white/10 rounded-xl overflow-hidden z-50 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="{{ route('media.room.events') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Events</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('media.room.updates') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Updates</a>
                    </div>
                </div>
                
                <!-- Tenders Dropdown -->
                <div class="relative group">
                    <button class="dropdown-button text-text-primary hover:text-accent-1 transition-all duration-300 focus:outline-none whitespace-nowrap flex items-center gap-1">
                        Tenders
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute top-full mt-2 w-80 bg-primary border border-white/10 rounded-xl overflow-hidden z-50 shadow-xl right-0 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="{{ route('tenders', 'general-procurement') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">General Procurement</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('tenders', 'transaction-advisory') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Selection of Transaction Advisory</a>
                        <div class="h-px bg-white/10 mx-4"></div>
                        <a href="{{ route('tenders', 'private-partner') }}" class="dropdown-item block px-4 py-3 text-text-primary hover:text-accent-1 transition-all duration-300">Selection of Private Partner</a>
                    </div>
                </div>
                
                <a href="{{ route('contact') }}" class="text-text-primary hover:text-accent-1 transition-all duration-300 whitespace-nowrap">Contact Us</a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden">
                <button @click="toggleMobileMenu()" 
                        class="p-2 outline-none hover:bg-white/10 rounded-lg transition-all duration-300">
                    <svg class="w-8 h-8 text-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
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
                <button @click="closeMobileMenu()" class="p-2 hover:bg-white/10 rounded-lg transition duration-300">
                    <svg class="w-8 h-8 text-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 flex items-start justify-center mt-8">
                <ul class="space-y-3 w-full max-w-md px-8">
                    <!-- About Us Mobile -->
                    <li x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:text-accent-1 rounded-lg transition-all duration-300">
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
                            <li><a href="{{ route('about.index') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">About PPP</a></li>
                            <li><a href="{{ route('about.mission-vision') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Vision & Mission</a></li>
                            <li><a href="{{ route('about.functions') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Functions</a></li>
                            <li><a href="{{ route('about.message') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Messages</a></li>
                            <li><a href="{{ route('about.team') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Team</a></li>
                            <li><a href="{{ route('about.organogram') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Organogram</a></li>
                        </ul>
                    </li>

                    <!-- Projects Mobile -->
                    <li x-data="{ open: false, ongoingOpen: false, completedOpen: false }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:text-accent-1 rounded-lg transition-all duration-300">
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
                            
                            <!-- Pipeline -->
                            <li><a href="{{ route('projects.index', ['category' => 'pipeline', 'status' => 'all']) }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Pipeline</a></li>
                            
                            <!-- Ongoing with Sub-menu -->
                            <li>
                                <button @click="ongoingOpen = !ongoingOpen" 
                                        class="flex justify-between items-center w-full text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">
                                    <span>Ongoing</span>
                                    <svg :class="{'rotate-180': ongoingOpen}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <ul x-show="ongoingOpen" 
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    class="mt-1 space-y-1 pl-6">
                                    <li><a href="{{ route('projects.index', ['category' => 'ongoing', 'status' => 'all']) }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">All Ongoing</a></li>
                                    <li><a href="{{ route('projects.index', ['category' => 'ongoing', 'status' => 'private-partner']) }}" class="block text-base md:text-lg px-6 py-2 pl-6 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Private Partner Selection</a></li>
                                    <li><a href="{{ route('projects.index', ['category' => 'ongoing', 'status' => 'transaction-advisory']) }}" class="block text-base md:text-lg px-6 py-2 pl-6 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Transaction Advisory</a></li>
                                </ul>
                            </li>
                            
                            <!-- Completed with Sub-menu -->
                            <li>
                                <button @click="completedOpen = !completedOpen" 
                                        class="flex justify-between items-center w-full text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">
                                    <span>Completed</span>
                                    <svg :class="{'rotate-180': completedOpen}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <ul x-show="completedOpen" 
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    class="mt-1 space-y-1 pl-6">
                                    <li><a href="{{ route('projects.index', ['category' => 'completed', 'status' => 'all']) }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">All Completed</a></li>
                                    <li><a href="{{ route('projects.index', ['category' => 'completed', 'status' => 'construction']) }}" class="block text-base md:text-lg px-6 py-2 pl-6 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Construction</a></li>
                                    <li><a href="{{ route('projects.index', ['category' => 'completed', 'status' => 'operational']) }}" class="block text-base md:text-lg px-6 py-2 pl-6 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Operational</a></li>
                                </ul>
                            </li>
                            
                            <!-- All Projects -->
                            <li><a href="{{ route('projects.index', ['category' => 'all', 'status' => 'all']) }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">All Projects</a></li>
                            
                            <!-- Projects Statistics -->
                            <li><a href="{{ route('projects.projectStats') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Projects Statistics</a></li>
                        </ul>
                    </li>

                    <!-- Resource Center Mobile -->
                    <li x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:text-accent-1 rounded-lg transition-all duration-300">
                            Resource Center
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="mt-2 space-y-1 pl-6">
                            <li><a href="{{ route('resource.center', 'legal-framework') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Legal Framework</a></li>
                            <li><a href="{{ route('resource.center', 'pre-qualified-advisors') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Pre-qualified Transaction Advisory</a></li>
                            <li><a href="{{ route('resource.center', 'policies-regulations') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Policies & Guidelines</a></li>
                            <li><a href="{{ route('resource.center', 'knowledge-hub') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Knowledge Hub</a></li>
                        </ul>
                    </li>

                    <!-- Media Room Mobile -->
                    <li x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:text-accent-1 rounded-lg transition-all duration-300">
                            Media Room
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="mt-2 space-y-1 pl-6">
                            <li><a href="{{ route('media.room.events') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Events</a></li>
                            <li><a href="{{ route('media.room.updates') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Updates</a></li>
                        </ul>
                    </li>

                    <!-- Tenders Mobile -->
                    <li x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:text-accent-1 rounded-lg transition-all duration-300">
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
                            <li><a href="{{ route('tenders', 'general-procurement') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">General Procurement</a></li>
                            <li><a href="{{ route('tenders', 'transaction-advisory') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Selection of Transaction Advisory</a></li>
                            <li><a href="{{ route('tenders', 'private-partner') }}" class="block text-base md:text-lg px-6 py-2 text-text-secondary hover:text-accent-1 rounded-lg transition duration-300">Selection of Private Partner</a></li>
                        </ul>
                    </li>

                    <li class="block md:hidden">
                        <a href="{{ route('contact') }}" class="flex items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-text-primary hover:text-accent-1 rounded-lg transition-all duration-300">
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
         @click="closeMobileMenu()">
    </div>
</nav>