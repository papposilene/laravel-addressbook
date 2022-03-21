<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center border-gray-300 border-transparent rounded-md active:bg-bluegray-900 focus:outline-none focus:border-bluegray-900 focus:ring focus:ring-bluegray-300 disabled:opacity-25 transition text-white']) }}>
    {{ $slot }}
</button>
