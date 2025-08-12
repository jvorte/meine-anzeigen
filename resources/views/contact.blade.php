<x-app-layout>
    {{-- This slot populates the header section of your main layout --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- {{ __('Contact Us') }} -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Contact Form Container -->
                    <div class="w-full max-w-2xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-200">
                        <h1 class="text-4xl sm:text-5xl font-bold text-gray-800 text-center mb-6">Contact Us</h1>
                        <p class="text-center text-gray-600 mb-8 sm:mb-12 max-w-md mx-auto">
                            We'd love to hear from you! Please fill out the form below and we'll get back to you as soon as possible.
                        </p>
                        
                        <!-- The form itself -->
                        <form id="contactForm" class="space-y-6">
                            <!-- Blade directive for CSRF protection -->
                            @csrf
                            <!-- Full Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" id="name" name="name" placeholder="John Doe" required
                                       class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            </div>
                            
                            <!-- Email Address Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="you@example.com" required
                                       class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            </div>
                            
                            <!-- Subject Field -->
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" placeholder="Question about your services" required
                                       class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            </div>
                            
                            <!-- Message Field -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea id="message" name="message" rows="5" placeholder="Your message here..." required
                                          class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-y"></textarea>
                            </div>
                            
                            <!-- Message container for success/error feedback -->
                            <div id="formMessage" class="text-center text-sm font-semibold mt-4"></div>
                            
                            <!-- Submit Button -->
                            <button type="submit" id="submitBtn"
                                    class="w-full py-3 mt-6 bg-blue-600 text-white font-bold text-lg rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 disabled:bg-blue-400">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const formMessage = document.getElementById('formMessage');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        contactForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;
            submitBtn.classList.add('animate-pulse');
            formMessage.textContent = '';

            const formData = new FormData(contactForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('/contact', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    formMessage.textContent = result.message;
                    formMessage.classList.add('text-green-600');
                    formMessage.classList.remove('text-red-600');
                    contactForm.reset();
                } else {
                    const errorMessages = Object.values(result.errors).flat();
                    formMessage.textContent = errorMessages.join(' ');
                    formMessage.classList.add('text-red-600');
                    formMessage.classList.remove('text-green-600');
                }
            } catch (error) {
                console.error('Submission failed:', error);
                formMessage.textContent = 'Oops! Something went wrong. Please check your connection and try again.';
                formMessage.classList.add('text-red-600');
                formMessage.classList.remove('text-green-600');
            } finally {
                submitBtn.textContent = 'Send Message';
                submitBtn.disabled = false;
                submitBtn.classList.remove('animate-pulse');
            }
        });
    </script>
</x-app-layout>
