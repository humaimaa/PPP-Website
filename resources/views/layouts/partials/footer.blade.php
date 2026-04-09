<footer class="bg-[#0D2818] text-[#DAD7CD] pt-12 pb-6 overflow-hidden w-full">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[40%_28%_28%] gap-8 mb-8 mr-8">
      <!-- Logo and About -->
      <div class="lg:col-span-1">
        <div class="flex items-center mb-4">
          <img src="{{ asset('images/logo.png') }}" alt="PPP Department KPK Logo" class="h-12 mr-3">
          <span class="text-2xl font-bold">PPP Department</span>
        </div>
        <p class="mb-4 text-sm md:text-base">The Public-Private Partnership Department of Khyber Pakhtunkhwa facilitates sustainable development through collaborative projects between government and private sector.</p>
        <div class="flex space-x-4">
          <a href="https://facebook.com" target="_blank" class="hover:opacity-80 transition-opacity duration-300">
            <img src="{{ asset('images/facebook-icon.png') }}" alt="Facebook" class="w-6 h-6 filter brightness-0 invert">
          </a>
          <a href="https://twitter.com" target="_blank" class="hover:opacity-80 transition-opacity duration-300">
            <img src="{{ asset('images/twitter-icon.png') }}" alt="Twitter" class="w-6 h-6 filter brightness-0 invert">
          </a>
          <a href="https://linkedin.com" target="_blank" class="hover:opacity-80 transition-opacity duration-300">
            <img src="{{ asset('images/linkedin-icon.png') }}" alt="LinkedIn" class="w-6 h-6 filter brightness-0 invert">
          </a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="lg:col-span-1">
        <h3 class="text-lg font-semibold mb-4 border-b border-[#0A612B] pb-2">Quick Links</h3>
        <ul class="space-y-2">
          <li><a href="{{route('home')}}" class="hover:text-[#0A612B] transition-colors duration-300 block">Home</a></li>
          <li><a href="{{ route('about', 'overview') }}" class="hover:text-[#0A612B] transition-colors duration-300 block">About Us</a></li>
          <li><a href="{{ route('projects.index', 'all') }}" class="hover:text-[#0A612B] transition-colors duration-300 block">Projects</a></li>
          <li><a href="#" class="hover:text-[#0A612B] transition-colors duration-300 block">Tenders</a></li>
          <li><a href="#" class="hover:text-[#0A612B] transition-colors duration-300 block">News & Updates</a></li>
          <li><a href="{{route('contact')}}" class="hover:text-[#0A612B] transition-colors duration-300 block">Contact Us</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="lg:col-span-1">
        <h3 class="text-lg font-semibold mb-4 border-b border-[#0A612B] pb-2">Contact Us</h3>
        <ul class="space-y-3">
          <li class="flex items-start">
            <svg class="flex-shrink-0 w-5 h-5 mr-3 mt-0.5 text-[#0A612B]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
            <span class="text-sm md:text-base">PPP Complex, Sector G-5, Peshawar, Khyber Pakhtunkhwa, Pakistan</span>
          </li>
          <li class="flex items-center">
            <svg class="flex-shrink-0 w-5 h-5 mr-3 text-[#0A612B]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
            </svg>
            <span class="text-sm md:text-base">+92 91 921 1234</span>
          </li>
          <li class="flex items-center">
            <svg class="flex-shrink-0 w-5 h-5 mr-3 text-[#0A612B]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            <span class="text-sm md:text-base">info@pppdepartmentkpk.gov.pk</span>
          </li>
          <li class="flex items-center">
            <svg class="flex-shrink-0 w-5 h-5 mr-3 text-[#0A612B]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
            </svg>
            <span class="text-sm md:text-base">Mon-Fri: 9:00 AM - 5:00 PM</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Copyright and Credits -->
    <div class="border-t border-[#0A612B] pt-6 mt-8 text-center md:text-left">
     
        <p class="text-xs md:text-sm mb-4 md:mb-0 text-center md:text-left">© {{ date('Y') }} PPP Department Khyber Pakhtunkhwa. All rights reserved.</p>

    </div>
  </div>
</footer>