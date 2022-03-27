<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center border-gray-300 border-transparent rounded-md active:bg-slate-900 focus:outline-none focus:border-slate-900 focus:ring focus:ring-slate-300 disabled:opacity-25 transition text-white']) }}>
    {{ $slot }}
</button>
