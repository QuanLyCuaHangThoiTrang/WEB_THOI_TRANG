@extends('layouts.app')

@section('content')
<div">
    <div class="relative mt-32 pb-16 px-10 "> <!-- Increased padding-bottom -->
        <div id="yody-page-info-content" class="relative">
            <section class="relative mt-4 ">
                <!-- Google Maps Background -->
                <div class="absolute inset-0 z-0">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3726.2254875492617!2d106.306125!3d20.943458!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31359bb68fda84c3%3A0x8d93c9a66571a4e6!2sYody%20Office!5e0!3m2!1svi!2sus!4v1726280125935!5m2!1svi!2sus"
                        width="100%" 
                        height="100%" 
                        style="border:0; position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <!-- Form Container -->
                <div class="relative z-10 max-w-6xl mx-auto flex flex-col lg:flex-row">
                    <!-- Empty Space on the Left Side -->
                    <div class="flex-1 lg:w-1/2"></div>

                    <!-- Form Section -->
                    <div class="p-10 rounded-2xl flex-1">
                        <div class="bg-gray-200 p-8 rounded-lg shadow-2xl shadow-gray-800">
                            <h2 class="mb-4 text-3xl sm:text-4xl md:text-5xl lg:text-6xl tracking-tight font-extrabold text-center uppercase text-blue-900">
                                Yo<span class="text-yellow-500">dy</span>
                            </h2>
                            <p class="text-gray-400 text-center">Bạn đang gặp vấn đề? Liên hệ ngay!</p>
                            <form class="mt-8 space-y-4 flex-col flex flex-grow-0">
                                <input type='text' placeholder='Name'
                                    class="w-full rounded-lg py-3 px-4 text-gray-800 text-sm outline-blue-800" />
                                <input type='email' placeholder='Email'
                                    class="w-full rounded-lg py-3 px-4 text-gray-800 text-sm outline-blue-800" />
                                <input type='text' placeholder='Subject'
                                    class="w-full rounded-lg py-3 px-4 text-gray-800 text-sm outline-blue-800" />
                                <textarea placeholder='Message' rows="6"
                                    class="w-full rounded-lg px-4 text-gray-800 text-sm pt-3 outline-blue-800"></textarea>
                                <button type='button'
                                    class="text-white bg-blue-900 hover:bg-blue-800 tracking-wide rounded-lg text-sm px-4 py-3 flex items-center justify-center w-full !mt-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill='#fff' class="mr-2" viewBox="0 0 548.244 548.244">
                                        <path fill-rule="evenodd" d="M392.19 156.054 211.268 281.667 22.032 218.58C8.823 214.168-.076 201.775 0 187.852c.077-13.923 9.078-26.24 22.338-30.498L506.15 1.549c11.5-3.697 24.123-.663 32.666 7.88 8.542 8.543 11.577 21.165 7.879 32.666L390.89 525.906c-4.258 13.26-16.575 22.261-30.498 22.338-13.923.076-26.316-8.823-30.728-22.032l-63.393-190.153z" clip-rule="evenodd" />
                                    </svg>
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
