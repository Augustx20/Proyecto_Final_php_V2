@props(['type' => 'success', 'message' => ''])

<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 3500)"
    class="fixed top-5 right-5 z-50 px-6 py-4 rounded shadow-lg text-white text-base font-semibold transition-all duration-300"
    :class="{
        'bg-green-500': $props.type === 'success',
        'bg-red-500': $props.type === 'error',
        'bg-yellow-500': $props.type === 'warning',
        'bg-blue-500': $props.type === 'info',
    }"
>
    <span x-text="$props.message"></span>
    <button @click="show = false" class="ml-4 font-bold">&times;</button>
</div>
