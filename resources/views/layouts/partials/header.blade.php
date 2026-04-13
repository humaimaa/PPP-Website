<nav class="bg-[#0D2818] text-[#DAD7CD] shadow-lg sticky top-0 z-50">
  <div class="px-4">
    <div class="flex justify-between items-center">
      <!-- Left: Hamburger Menu Button (visible on all screens) -->
      <div class="flex items-center">
        <button class="mobile-menu-button outline-none hover:bg-[#DAD7CD]/10 rounded-lg transition duration-300"
          id="mobileMenuBtn">
          <svg class="w-8 h-8 text-[#DAD7CD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>

      <!-- Center: Logo with Name -->
      <div>
        <a href="{{ route('home') }}" class="flex items-center py-4 group">
          <img src="{{ asset('images/logo.png') }}" alt="PPP Department KPK Logo" class="h-16 md:h-12 w-auto mr-3">
          <div class="hidden md:block">
            <span class="text-[#DAD7CD] font-semibold text-lg tracking-wide block">Public Private Partnership Unit</span>
            <span class="text-[#DAD7CD] text-sm tracking-wide block">P & D Department, KP</span>
          </div>
        </a>
      </div>

      <!-- Right: Contact Icon (hidden on mobile, visible on md and up) -->
      <div class="flex items-center hidden md:block">
        <a href="{{ route('contact') }}" class="p-2 hover:bg-[#DAD7CD]/10 bg-[#DAD7CD]/10 rounded-lg transition duration-300"
          aria-label="Contact">
          <svg class="w-8 h-8 text-[#DAD7CD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
            </path>
          </svg>
        </a>
      </div>
    </div>
  </div>

  <!-- Full Screen Offcanvas Menu -->
  <div
    class="fixed inset-0 transform -translate-x-full transition-transform duration-300 ease-in-out z-50 bg-[#DAD7CD] overflow-y-auto"
    id="mobileMenu">
    <div class="min-h-screen flex flex-col">
      <!-- Menu Header -->
      <div class="p-6 border-b border-[#0D2818]/10 flex justify-end">
        <button class="close-menu-btn p-2 hover:bg-[#0D2818]/10 rounded-lg transition duration-300" id="closeMenuBtn">
          <svg class="w-8 h-8 text-[#0D2818]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Centered Menu Items -->
      <div class="flex-1 flex items-start justify-center mt-8">
        <ul class="space-y-3 w-full max-w-md px-8">
          <!-- About Us Dropdown -->
          <li class="mobile-dropdown">
            <button
              class="mobile-dropdown-toggle flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition-all duration-300">
              About Us
              <svg class="mobile-dropdown-arrow w-5 h-5 transition-transform duration-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <ul class="mobile-dropdown-menu hidden mt-2 space-y-1 pl-6">
              <li><a href="{{ route('about', 'overview') }}"
                  class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">About
                  PPP</a></li>
              <li><a href="{{ route('about', 'team') }}"
                  class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">Team</a>
              </li>
            </ul>
          </li>

          <!-- Projects Dropdown -->
          <li class="mobile-dropdown">
            <button
              class="mobile-dropdown-toggle flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition-all duration-300">
              Projects
              <svg class="mobile-dropdown-arrow w-5 h-5 transition-transform duration-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <ul class="mobile-dropdown-menu hidden mt-2 space-y-1 pl-6">
              <li><a href="{{ route('projects.index', 'pipeline') }}"
                  class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">Pipeline</a>
              </li>
              <li><a href="{{ route('projects.index', 'ongoing') }}"
                  class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">Ongoing</a>
              </li>
              <li><a href="{{ route('projects.index', 'operational') }}"
                  class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">Operational</a>
              </li>
            </ul>
          </li>

          <!-- Tenders Dropdown -->
          <li class="mobile-dropdown">
            <button
              class="mobile-dropdown-toggle flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition-all duration-300">
              Tenders
              <svg class="mobile-dropdown-arrow w-5 h-5 transition-transform duration-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <ul class="mobile-dropdown-menu hidden mt-2 space-y-1 pl-6">
              <li><a href="{{ route('tenders', 'active') }}"
                  class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">Active
                  Tenders</a></li>
              <li><a href="{{ route('tenders', 'archived') }}"
                  class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">Archived
                  Tenders</a></li>
            </ul>
          </li>

          <!-- Media Dropdown -->
          <li class="mobile-dropdown">
            <button
              class="mobile-dropdown-toggle flex justify-between items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition-all duration-300">
              Media
              <svg class="mobile-dropdown-arrow w-5 h-5 transition-transform duration-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <ul class="mobile-dropdown-menu hidden mt-2 space-y-1 pl-6">
              <li><a href="{{ route('news.index') }}"
                  class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">News & Updates</a>
              </li>
              <li><a href="{{ route('gallery.index') }}"
            class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">Gallery</a>
        </li>
              <li><a href="{{ route('media.downloads') }}"
                  class="block text-base md:text-lg px-6 py-2 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition duration-300">Downloads</a>
              </li>
            </ul>
          </li>

          <!-- Contact Us - Mobile Menu Item (visible only on mobile) -->
          <li class="block md:hidden">
            <a href="{{ route('contact') }}"
              class="flex items-center w-full text-lg md:text-xl font-semibold px-6 py-3 text-[#0D2818] hover:bg-[#0D2818] hover:text-[#DAD7CD] rounded-lg transition-all duration-300">
              
              Contact Us
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Overlay -->
  <div class="fixed inset-0 bg-black/50 opacity-0 invisible transition-all duration-300 z-40" id="menuOverlay"></div>
</nav>