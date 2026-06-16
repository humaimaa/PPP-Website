<footer class="bg-background-primary text-text-secondary pt-12 pb-6 overflow-hidden w-full">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[40%_28%_28%] gap-8 mb-8">
      <!-- Logo and About -->
      <div class="lg:col-span-1 mr-8">
        <div class="flex items-center mb-4">
          <img src="{{ asset('images/logo.png') }}" alt="PPP Unit KP Logo" class="h-12 mr-3">
          <span class="text-2xl font-bold text-text-primary">PPP Unit</span>
        </div>
        <p class="mb-4 text-sm md:text-base text-text-secondary text-justify">The Public-Private Partnership Department of Khyber Pakhtunkhwa facilitates sustainable development through collaborative projects between government and private sector.</p>
        <div class="flex space-x-4">
          <a href="https://www.facebook.com/profile.php?id=61585963196702" target="_blank" class="w-8 h-8 bg-text-secondary/10 rounded-full flex items-center justify-center hover:bg-accent-1 hover:scale-110 transition-all duration-300">
            <i class="fab fa-facebook-f text-text-secondary text-sm"></i>
          </a>
          {{-- <a href="https://x.com" target="_blank" class="w-8 h-8 bg-text-secondary/10 rounded-full flex items-center justify-center hover:bg-accent-1 hover:scale-110 transition-all duration-300">
            <i class="fa-brands fa-x-twitter text-text-secondary text-sm"></i>
          </a> --}}
          <a href="https://www.linkedin.com/company/ppp-unit-gokp/?viewAsMember=true" target="_blank" class="w-8 h-8 bg-text-secondary/10 rounded-full flex items-center justify-center hover:bg-accent-1 hover:scale-110 transition-all duration-300">
            <i class="fab fa-linkedin-in text-text-secondary text-sm"></i>
          </a>
          
          
          </a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="lg:col-span-1">
        <!-- External Websites Links -->
        <h3 class="text-lg font-semibold mb-4 border-b border-accent-1 pb-2 flex items-center text-text-primary">
          <i class="fas fa-external-link-alt mr-2 text-accent-1 text-sm"></i>
          Quick Links
        </h3>
        <ul class="space-y-2">
          <li>
            <a href="https://www.pndkp.gov.pk" target="_blank" class="hover:text-accent-1 transition-colors duration-300 block flex items-center text-text-secondary">
              <i class="fas fa-external-link-alt mr-2 text-xs text-accent-1"></i>
              Planning & Development Department, KP
            </a>
          </li>
          <li>
            <a href="https://kp.gov.pk/" target="_blank" class="hover:text-accent-1 transition-colors duration-300 block flex items-center text-text-secondary">
              <i class="fas fa-external-link-alt mr-2 text-xs text-accent-1"></i>
              Government of Khyber Pakhtunkhwa
            </a>
          </li>

          <li>
            <a href="https://www.adb.org" target="_blank" class="hover:text-accent-1 transition-colors duration-300 block flex items-center text-text-secondary">
              <i class="fas fa-external-link-alt mr-2 text-xs text-accent-1"></i>
              Asian Development Bank (ADB)
            </a>
          </li>
          <li>
            <a href="https://www.worldbank.org" target="_blank" class="hover:text-accent-1 transition-colors duration-300 block flex items-center text-text-secondary">
              <i class="fas fa-external-link-alt mr-2 text-xs text-accent-1"></i>
              World Bank
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact Info & External Links -->
      <div class="lg:col-span-1">
        <h3 class="text-lg font-semibold mb-4 border-b border-accent-1 pb-2 flex items-center text-text-primary">
          <i class="fas fa-address-card mr-2 text-accent-1 text-sm"></i>
          Contact Us
        </h3>
        <ul class="space-y-3 mb-6">
          <li class="flex items-start">
            <i class="fas fa-map-marker-alt text-accent-1 mr-3 mt-0.5 text-sm"></i>
            <span class="text-sm md:text-base text-text-secondary">PPP Unit,
                                P & D Department,
                                Civil Secretariat,
                                Peshawar, Khyber Pakhtunkhwa,
                                Pakistan</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-phone-alt text-accent-1 mr-3 text-sm"></i>
            <span class="text-sm md:text-base text-text-secondary">+92 91 921 1234</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-envelope text-accent-1 mr-3 text-sm"></i>
            <span class="text-sm md:text-base text-text-secondary">chief.ppp@pndkp.gov.pk</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-clock text-accent-1 mr-3 text-sm"></i>
            <span class="text-sm md:text-base text-text-secondary">Mon-Fri: 9:00 AM - 5:00 PM</span>
          </li>
          <li class="flex items-center">
            <i class="fas fa-fax text-accent-1 mr-3 text-sm"></i>
            <span class="text-sm md:text-base text-text-secondary">+92 91 921 1235</span>
          </li>
        </ul>

        
      </div>
    </div>

    <!-- Copyright and Credits -->
    <div class="border-t border-accent-1 pt-6 mt-8">
      <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-xs md:text-sm text-center md:text-left text-text-secondary">
          <i class="far fa-copyright mr-1"></i> {{ date('Y') }} PPP Unit Khyber Pakhtunkhwa. All rights reserved.
        </p>
        <p class="text-xs md:text-sm text-center md:text-right text-text-secondary">
          Designed & Developed by <a href="#" class="text-accent-1 hover:text-accent-2 transition-colors duration-300">PPP Unit IT Team</a>
        </p>
      </div>
    </div>
  </div>
</footer>