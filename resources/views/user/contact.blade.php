@extends('layouts.app')

@section('title', 'PPP Department KPK - Contact Us')

@section('content')
<!-- Hero Section -->
<section class="relative h-[45vh] lg:h-[60vh] bg-gray-900 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
            alt="Office Building" class="object-cover w-full h-full">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    <div class="relative z-10 h-full flex items-center justify-center">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Contact Us</h1>
            <p class="text-xl text-white max-w-3xl mx-auto">Get in touch with the PPP Department of Khyber Pakhtunkhwa</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-[#DAD7CD]/50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Contact Information (Left) -->
            <div class="bg-white p-8 rounded-lg shadow-md flex-1">
                <h2 class="text-2xl md:text-3xl font-bold text-[#0D2818] mb-6">Our Office</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-2">
                        <div class="flex-shrink-0 bg-[#0A612B] p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-[#0D2818]">Address</h3>
                            <p class="mt-1 text-gray-700">
                                PPP Department,<br>
                                Civil Secretariat,<br>
                                Peshawar, Khyber Pakhtunkhwa,<br>
                                Pakistan
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-2">
                        <div class="flex-shrink-0 bg-[#0A612B] p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-[#0D2818]">Phone</h3>
                            <p class="mt-1 text-gray-700">
                                Main Office: +92 91 921 1234<br>
                                Help Desk: +92 91 921 5678<br>
                                Fax: +92 91 921 9876
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-2">
                        <div class="flex-shrink-0 bg-[#0A612B] p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-[#0D2818]">Email</h3>
                            <p class="mt-1 text-gray-700">
                                General Inquiries: <a href="mailto:info@pppdepartmentkpk.gov.pk" class="text-[#0A612B] hover:underline">info@pppdepartmentkpk.gov.pk</a><br>
                                Support: <a href="mailto:support@pppdepartmentkpk.gov.pk" class="text-[#0A612B] hover:underline">support@pppdepartmentkpk.gov.pk</a>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-2">
                        <div class="flex-shrink-0 bg-[#0A612B] p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-[#0D2818]">Office Hours</h3>
                            <p class="mt-1 text-gray-700">
                                Monday to Friday: 9:00 AM to 5:00 PM<br>
                                Saturday: 9:00 AM to 1:00 PM<br>
                                Sunday: Closed
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form (Right) -->
            <div class="bg-white p-8 rounded-lg shadow-md flex-1">
                <h2 class="text-2xl md:text-3xl font-bold text-[#0D2818] mb-6">Send Us a Message</h2>
                <form id="contactForm" class="space-y-6" novalidate>
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-[#0D2818]">First Name <span class="text-red-500">*</span></label>
                            <input type="text" id="first-name" name="first-name" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#0A612B] focus:border-[#0A612B]">
                            <p class="mt-1 text-sm text-red-600 hidden" id="first-name-error">First name is required</p>
                        </div>
                        <div>
                            <label for="last-name" class="block text-sm font-medium text-[#0D2818]">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" id="last-name" name="last-name" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#0A612B] focus:border-[#0A612B]">
                            <p class="mt-1 text-sm text-red-600 hidden" id="last-name-error">Last name is required</p>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#0D2818]">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#0A612B] focus:border-[#0A612B]">
                        <p class="mt-1 text-sm text-red-600 hidden" id="email-error">Please enter a valid email address</p>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-[#0D2818]">Phone Number</label>
                        <input type="tel" id="phone" name="phone"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#0A612B] focus:border-[#0A612B]">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-[#0D2818]">Subject <span class="text-red-500">*</span></label>
                        <select id="subject" name="subject" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#0A612B] focus:border-[#0A612B]">
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="partnership">Partnership Opportunity</option>
                            <option value="complaint">Complaint</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                        <p class="mt-1 text-sm text-red-600 hidden" id="subject-error">Please select a subject</p>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-[#0D2818]">Message <span class="text-red-500">*</span></label>
                        <textarea id="message" name="message" rows="4" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#0A612B] focus:border-[#0A612B]"></textarea>
                        <p class="mt-1 text-sm text-red-600 hidden" id="message-error">Message is required</p>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#0A612B] hover:bg-[#0D2818] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A612B] transition-colors duration-300">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-[#0D2818] mb-8 text-center">Our Location</h2>
        <div class="rounded-lg overflow-hidden shadow-lg">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d211666.42563838646!2d71.26957338671872!3d34.01082021950449!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38d917cfa4d808eb%3A0x86f9bfa38ce3dd08!2sP%20%26%20D%20Department%20Civil%20Secretariat%20Peshawar!5e0!3m2!1sen!2s!4v1751817521809!5m2!1sen!2s" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;
            
            // Reset error messages
            document.querySelectorAll('[id$="-error"]').forEach(el => {
                el.classList.add('hidden');
            });
            
            // Validate first name
            const firstName = document.getElementById('first-name');
            if (!firstName.value.trim()) {
                document.getElementById('first-name-error').classList.remove('hidden');
                isValid = false;
            }
            
            // Validate last name
            const lastName = document.getElementById('last-name');
            if (!lastName.value.trim()) {
                document.getElementById('last-name-error').classList.remove('hidden');
                isValid = false;
            }
            
            // Validate email
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !emailRegex.test(email.value)) {
                document.getElementById('email-error').classList.remove('hidden');
                isValid = false;
            }
            
            // Validate subject
            const subject = document.getElementById('subject');
            if (!subject.value) {
                document.getElementById('subject-error').classList.remove('hidden');
                isValid = false;
            }
            
            // Validate message
            const message = document.getElementById('message');
            if (!message.value.trim()) {
                document.getElementById('message-error').classList.remove('hidden');
                isValid = false;
            }
            
            if (isValid) {
                // For static website, show success message
                alert('Form submitted successfully!');
                form.reset();
                
                // If you want to submit via AJAX, uncomment the code below
                /*
                const formData = new FormData(form);
                fetch('{{ url("contact/submit") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Message sent successfully!');
                        form.reset();
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
                */
            }
        });
        
        // Add real-time validation for better UX
        document.getElementById('email').addEventListener('input', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value.trim() && !emailRegex.test(this.value)) {
                document.getElementById('email-error').classList.remove('hidden');
            } else {
                document.getElementById('email-error').classList.add('hidden');
            }
        });
    });
</script>
@endpush