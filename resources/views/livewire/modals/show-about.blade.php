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
                <i data-fa-symbol="close" class="fas fa-circle-xmark fa-fw"></i>
                <svg class="h-6 w-6"><use xlink:href="#close"></use></svg>
            </button>
            <h5 class="text-xl text-bold">
                @ucfirst(__('app.about'))
            </h5>
            <div class="">
                <p class="">
                    ...
                </p>
            </div>
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
