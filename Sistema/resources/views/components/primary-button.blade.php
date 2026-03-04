<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center px-6 py-2.5 bg-primary-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-md shadow-primary-500/30 hover:bg-primary-700 hover:shadow-lg hover:shadow-primary-600/40 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 ease-in-out']) }}>
    {{ $slot }}
</button>
