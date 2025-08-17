/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    corePlugins: { preflight: false },
    content: [],
    safelist: [
        'text-gray-700', 'text-gray-900',
        'dark:text-gray-200', 'dark:text-gray-100',
        'divide-gray-200', 'dark:divide-white/10', 'dark:divide-white/5',
        'divide-x', 'divide-y', 'rtl:divide-x-reverse',
        'border-gray-200', 'dark:border-gray-600',
        'bg-gray-500/10',
        'table-auto','w-full','w-1/2',
        'px-3','py-2','p-2','pr-1','my-2','my-3','mt-2',
        'text-sm','text-center','font-medium','font-mono','whitespace-normal','rounded-md','inline-block','tracking-tight',
    ],
    theme: { extend: {} },
};
