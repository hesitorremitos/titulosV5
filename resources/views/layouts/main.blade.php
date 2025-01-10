<main class="flex-1 h-screen overflow-y-hidden">
    @include('layouts.navigation')
    <div class="p-4 h-[calc(100vh-64px)] overflow-y-hidden">
        {{ $slot }}
    </div>
</main>
