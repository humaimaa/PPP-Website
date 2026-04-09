<footer class="bg-[#0D2818] text-[#DAD7CD] pt-12 pb-6 overflow-hidden w-full">
  <div class=" px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[40%_28%_28%] gap-8 mb-8 mr-8">
      <!-- Logo and About -->
      <div class="lg:col-span-1">
        <div class="flex items-center mb-4">
          <img src="{{ asset('images/logo.png') }}" alt="PPP Department KPK Logo" class="h-12 mr-3">
          <span class="text-2xl font-bold">PPP Department</span>
        </div>
        <p class="mb-4 text-sm md:text-base">The Public-Private Partnership Department of Khyber Pakhtunkhwa facilitates sustainable development through collaborative projects between government and private sector.</p>
        <div class="flex space-x-4">
          <a href="https://facebook.com" target="_blank" class="w-8 h-8 bg-[#DAD7CD]/10 rounded-full flex items-center justify-center hover:bg-[#0A612B] hover:scale-110 transition-all duration-300">
            <i class="fab fa-facebook-f text-[#DAD7CD] text-sm"></i>
          </a>
          <a href="https://twitter.com" target="_blank" class="w-8 h-8 bg-[#DAD7CD]/10 rounded-full flex items-center justify-center hover:bg-[#0A612B] hover:scale-110 transition-all duration-300">
            <i class="fab fa-twitter text-[#DAD7CD] text-sm"></i>
          </a>
          <a href="https://linkedin.com" target="_blank" class="w-8 h-8 bg-[#DAD7CD]/10 rounded-full flex items-center justify-center hover:bg-[#0A612B] hover:scale-110 transition-all duration-300">
            <i class="fab fa-linkedin-in text-[#DAD7CD] text-sm"></i>
          </a>
          <a href="https://youtube.com" target="_blank" class="w-8 h-8 bg-[#DAD7CD]/10 rounded-full flex items-center justify-center hover:bg-[#0A612B] hover:scale-110 transition-all duration-300">
            <i class="fab fa-youtube text-[#DAD7CD] text-sm"></i>
          </a>
          <a href="https://instagram.com" target="_blank" class="w-8 h-8 bg-[#DAD7CD]/10 rounded-full flex items-center justify-center hover:bg-[#0A612B] hover:scale-110 transition-all duration-300">
            <i class="fab fa-instagram text-[#DAD7CD] text-sm"></i>
          </a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="lg:col-span-1">
        <h3 class="text-lg font-semibold mb-4 border-b border-[#0A612B] pb-2 flex items-center">
          <i class="fas fa-link mr-2 text-[#0A612B] text-sm"></i>
          Quick Links
        </h3>
        <ul class="space-y-2">
          <li>
            <a href="{{route('home')}}" class="hover:text-[#0A612B] transition-colors duration-300 block flex items-center">
              <i class="fas fa-angle-right mr-2 text-xs text-[#0A612B]"></i>
              Home
            </a>
          </li>
          <li>
            <a href="{{ route('about', 'overview') }}" class="hover:text-[#0A612B] transition-colors duration-300 block flex items-center">
              <i class="fas fa-angle-right mr-2 text-xs text-[#0A612B]"></i>
              About Us
            </a>
          </li>
          <li>
            <a href="{{ route('projects.index', 'all') }}" class="hover:text-[#0A612B] transition-colors duration-300 block flex items-center">
              <i class="fas fa-angle-right mr-2 text-xs text-[#0A612B]"></i>
              Projects
            </a>
          </li>
          <li>
            <a href="{{ route('tenders', 'active') }}" class="hover:text-[#0A612B] transition-colors duration-300 block flex items-center">
              <i class="fas fa-angle-right mr-2 text-xs text-[#0A612B]"></i>
              Tenders
            </a>
          </li>
          <li>
            <a href="{{ route('news.index') }}" class="hover:text-[#0A612B] transition-colors duration-300 block flex items-center">
              <i class="fas fa-angle-right mr-2 text-xs text-[#0A612B]"></i>
              News & Updates
            </a>
          </li>
          <li>
            <a href="{{route('contact')}}" class="hover:text-[#0A612B] transition-colors duration-300 block flex items-center">
              <i class="fas fa-angle-right mr-2 text-xs text-[#0A612B]"></i>
              Contact Us
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="lg:col-span-1">
        <h3 class="text-lg font-semibold mb-4 border-b border-[#0A612B] pb-2 flex items-center">
          <i class="fas fa-address-card mr-2 text-[#0A612B] text-sm"></i>
          Contact Us
        </h3>
        <ul class="space-y-3">
          <li class="flex items-start">
            <i class="fas fa-map-marker-alt text-[#0A612B] mr-3 mt-0.5 text-sm"></i>
            <span class="text-sm md:text-base">PPP Complex, Sector G-5, Peshawar, Khyber Pakhtunkhwa, Pakistan</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-phone-alt text-[#0A612B] mr-3 text-sm"></i>
            <span class="text-sm md:text-base">+92 91 921 1234</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-envelope text-[#0A612B] mr-3 text-sm"></i>
            <span class="text-sm md:text-base">info@pppdepartmentkpk.gov.pk</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-clock text-[#0A612B] mr-3 text-sm"></i>
            <span class="text-sm md:text-base">Mon-Fri: 9:00 AM - 5:00 PM</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-fax text-[#0A612B] mr-3 text-sm"></i>
            <span class="text-sm md:text-base">+92 91 921 1235</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Copyright and Credits -->
    <div class="border-t border-[#0A612B] pt-6 mt-8">
      <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-xs md:text-sm text-center md:text-left">
          <i class="far fa-copyright mr-1"></i> {{ date('Y') }} PPP Department Khyber Pakhtunkhwa. All rights reserved.
        </p>
        <div class="flex space-x-6 text-xs">
          <a href="#" class="hover:text-[#0A612B] transition-colors duration-300">
            <i class="fas fa-shield-alt mr-1"></i> Privacy Policy
          </a>
          <a href="#" class="hover:text-[#0A612B] transition-colors duration-300">
            <i class="fas fa-file-alt mr-1"></i> Terms of Use
          </a>
          <a href="#" class="hover:text-[#0A612B] transition-colors duration-300">
            <i class="fas fa-sitemap mr-1"></i> Sitemap
          </a>
        </div>
      </div>
    </div>
  </div>
</footer>