<div class="relative" x-data="{
    open: false,
    emojis: ['📧', '⚙️', '🔄', '⏰', '⚠️', '📢', '🔔', '💡', '📱', '🔥', '✨', '🎉', '📌', '🎯', '💬'],
    selectEmoji(emoji) {
        $refs.input.value = emoji;
        this.open = false;
    }
}">
    <div class="mt-1 flex rounded-md shadow-sm">
        <input type="text" {{ $attributes }}
            x-ref="input"
            class="flex-1 rounded-md border-gray-300 focus:border-accent focus:ring-accent sm:text-sm"
            placeholder="Selecciona o escribe un emoji">
        <button type="button"
            @click="open = !open"
            class="ml-3 inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent">
            <span class="sr-only">Abrir selector de emoji</span>
            😊
        </button>
    </div>

    <div x-show="open"
        @click.away="open = false"
        class="absolute z-10 mt-1 w-full overflow-auto rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        style="display: none;">
        <div class="grid grid-cols-5 gap-1 p-2">
            <template x-for="emoji in emojis" :key="emoji">
                <button type="button"
                    @click="selectEmoji(emoji)"
                    class="inline-flex items-center justify-center rounded-md p-2 text-base hover:bg-gray-100">
                    <span x-text="emoji"></span>
                </button>
            </template>
        </div>
    </div>
</div>
