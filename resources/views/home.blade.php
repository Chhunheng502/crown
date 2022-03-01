

<x-layout>
    <x-slot name="title"> Home Page </x-slot>
    <x-slot name="content">
        <x-section-layout>
            <x-slot name="section_left">
                <div>
                    <div>
                        <h1 class="text-lg"> <i class="fas fa-user-friends"></i> Friend Requests </h1>
                    </div>
                    <div class="space-y-2">
                    </div>
                </div>
            </x-slot>
            <x-slot name="section_middle">
                <x-news-feed />
            </x-slot>
            <x-slot name="section_right">
                <div>
                    <div>
                        <h1 class="text-xl"> Contact </h1>
                    </div>
                    <x-contact-list />
                </div>
            </x-slot>
        </x-section-layout>
    </x-slot>
</x-layout>