<div id="modalShowAbout">
    <div id="modalButtonShowAbout">
        <a id="modalOpenShowAbout" class="hover:text-red-600 hover:text-red-400 cursor-pointer"
            title="@ucfirst(__('app.about'))">
            @ucfirst(__('app.about'))
        </a>
    </div>

    <div id="modalWindowShowAbout"
        class="fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-slate-900 bg-opacity-75 transform scale-0 transition-transform duration-300 z-1000">
        <!-- Modal -->
        <div class="bg-slate-900 text-white overflow-auto w-1/2 h-1/2 p-12">
            <!-- Close modal button-->
            <button id="modalCloseShowAbout" type="button" class="focus:outline-none float-right">
                <i data-fa-symbol="close" class="fas fa-circle-xmark fa-fw"></i>
                <svg class="h-6 w-6"><use xlink:href="#close"></use></svg>
            </button>
            <h5 class="text-xl text-bold text-left mb-5">
                @ucfirst(__('app.about'))
            </h5>
            <div class="text-left w-full">
                <p class="mb-3">
                    Créée par <a href="https://dev.psln.nl/" class="hover:text-red-500" target="_blank">Philippe-Alexandre Pierre</a>
                    en 2022 pour son usage personnel, cette application web de carnet d'adresses personnel a été réalisée avec le concours du
                    <a href="https://laravel.com/docs/9.x" class="hover:text-red-500" target="_blank">framework Laravel 9</a>, de
                    <a href="https://laravel-livewire.com/docs/2.x/" class="hover:text-red-500" target="_blank">Livewire 2</a>, et de
                    <a href="https://tailwindcss.com/" class="hover:text-red-500" target="_blank">TailwindCSS 3</a>.
                </p>
                <p class="mb-3">
                    Enfin, son code-source complet, sous licence MIT, est <a href="https://github.com/papposilene/laravel-addressbook" class="hover:text-red-500" target="_blank">disponible sur Github</a>.
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
