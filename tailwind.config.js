/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    corePlugins: { preflight: false },
    content: [],
    safelist: [
        '!text-gray-700','!text-gray-900','dark:!text-gray-200','dark:!text-gray-100',
        '!opacity-100',
        '!border-gray-200','dark:!border-gray-600',
    ],
    theme: { extend: {} },
}
