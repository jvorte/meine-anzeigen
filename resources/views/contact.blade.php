<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl md:text-3xl font-extrabold text-gray-900 dark:text-gray-800">
            {{ __('contact_us') }}
        </h2>
        <p>{{ __('contact_intro_text') }}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Contact Form Card --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-2xl">
                <div class="max-w-xl mx-auto">
                    <form id="contactForm" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-200 mb-1">
                                {{ __('full_name') }}
                            </label>
                            <input type="text" id="name" name="name" placeholder="{{ __('name_placeholder') }}" required
                                class="w-full p-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-200 mb-1">
                                {{ __('email_address') }}
                            </label>
                            <input type="email" id="email" name="email" placeholder="{{ __('email_placeholder') }}" required
                                class="w-full p-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-200 mb-1">
                                {{ __('subject') }}
                            </label>
                            <input type="text" id="subject" name="subject" placeholder="{{ __('subject_placeholder') }}" required
                                class="w-full p-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-200 mb-1">
                                {{ __('message') }}
                            </label>
                            <textarea id="message" name="message" rows="4" placeholder="{{ __('message_placeholder') }}" required
                                class="w-full p-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-y"></textarea>
                        </div>

                        <div id="formMessage" class="text-center text-sm font-semibold mt-2"></div>

                        <button type="submit" id="submitBtn"
                            class="w-full py-2.5 bg-blue-600 text-white font-bold text-lg rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 disabled:bg-blue-400">
                            {{ __('send_message') }}
                        </button>
                    </form>
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
            submitBtn.textContent = '{{ __("sending") }}';
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
                formMessage.textContent = '{{ __("contact_error") }}';
                formMessage.classList.add('text-red-600');
                formMessage.classList.remove('text-green-600');
            } finally {
                submitBtn.textContent = '{{ __("send_message") }}';
                submitBtn.disabled = false;
                submitBtn.classList.remove('animate-pulse');
            }
        });
    </script>
</x-app-layout>
