@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors duration-200 ease-in-out px-4 py-2.5']) }}>
