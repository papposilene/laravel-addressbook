<div id="modalShowAbout">
    <div id="modalButtonShowAbout">
        <a id="modalOpenShowAbout" class="hover:text-red-600 dark:hover:text-red-400 cursor-pointer"
            title="@ucfirst(__('app.about'))">
            @ucfirst(__('app.about'))
        </a>
    </div>

    <div id="modalWindowShowAbout"
        class="fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-bluegray-900 bg-opacity-50 transform scale-0 transition-transform duration-300 z-1000">
        <!-- Modal -->
        <div class="bg-white dark:bg-gray-700 dark:text-white overflow-auto w-1/2 h-1/2 p-12">
            <!-- Close modal button-->
            <button id="modalCloseShowAbout" type="button" class="focus:outline-none float-right">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            <h5 class="text-xl text-bold">
                @ucfirst(__('app.about'))
            </h5>
            <!-- Modal content -->
            <form method="POST" action="" class="flex flex-col w-full">
                @csrf

                <div class="mt-4">
                    <x-forms.label class="dark:text-gray-100" for="name">@ucfirst(__('auth.names'))</x-forms.label>
                    <x-forms.input id="name" class="dark:text-gray-800 dark:bg-bluegray-300 block mt-1 w-full" type="text" name="name" :placeholder="@ucfirst(__('auth.names'))" required />
                </div>

                <div class="mt-4">
                    <x-forms.label class="dark:text-gray-100" for="email">@ucfirst(__('auth.email'))</x-forms.label>
                    <x-forms.input id="email" class="dark:text-gray-800 dark:bg-bluegray-300 block mt-1 w-full" type="text" name="email" :placeholder="@ucfirst(__('auth.email'))" required />
                </div>

                <div class="mt-4">
                    <x-forms.label class="dark:text-gray-100" for="message">@ucfirst(__('app.message'))</x-forms.label>
                    <x-forms.textarea id="message" class="dark:text-gray-800 dark:bg-bluegray-300 block mt-1 w-full" type="text" name="message" :placeholder="@ucfirst(__('app.loremipsum'))" required />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-forms.button class="ml-4 bg-bluegray-500 p-2">
                        @ucfirst(__('app.send'))
                    </x-forms.button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:load', function () {
    const modalOpenShowAbout = document.getElementById('modalOpenShowAbout')
    const modalCloseShowAbout = document.getElementById('modalCloseShowAbout')
    const modalWindowShowAbout = document.getElementById('modalWindowShowAbout')

    modalOpenShowAbout.addEventListener('click',()=>modalWindowShowAbout.classList.remove('scale-0'))
    modalCloseShowAbout.addEventListener('click',()=>modalWindowShowAbout.classList.add('scale-0'))
})
</script>
