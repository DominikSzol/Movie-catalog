<x-guest-layout>
    <x-slot name="title">
        Főoldal
    </x-slot>

   @php
        $posts = [
            [
                'title' => 'Film 1',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 1',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 2',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 3',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 4',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 5',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 6',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 7',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 8',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 9',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],
            [
                'title' => 'Film 10',
                'author' => 'Rendező',
                'year' => 'Megjelenés',
            ],

        ]
    @endphp

    <div class="container mx-auto p-3 lg:px-36">
        <div class="grid grid-cols-1 lg:grid-cols-2 mb-4">
            <div>
                <h1 class="font-bold my-4 text-4xl">Filmkatalógus</h1>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-6">
            <!-- Cardok -->
            <div class="col-span-4 lg:col-span-3">
                <div class="grid grid-cols-3 gap-3">
                    @forelse ($posts as $post)
                        <div class="col-span-3 lg:col-span-1">
                            <img src="https://www.ispreview.co.uk/wp-content/uploads/london_city_2017_uk.jpg">
                            <div class="px-2.5 py-2 border-r border-l border-b border-gray-400 ">
                                <h3 class="text-xl mb-0.5 font-semibold">
                                    {{ $post['title'] }}
                                </h3>
                                <h4 class="text-gray-400">
                                    <span class="mr-2"><i class="fas fa-user"></i> {{ $post['author'] }}</span>
                                    <span class="mr-2"><i class="fas fa-user"></i> {{ $post['year'] }}</span>
                                </h4>

                                <button class="bg-blue-500 hover:bg-blue-600 px-1.5 py-1 text-white mt-3 font-semibold">Részletek <i class="fas fa-angle-right"></i></button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 px-2 py-4 bg-blue-100">
                            Jelenleg még nincsenek filmek a listában!
                        </div>
                    @endforelse

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-span-4 lg:col-span-1">
                <h2 class="font-semibold text-3xl my-2">Menü</h2>
                <div class="grid grid-cols-1 gap-3">
                    <div class="border px-2.5 py-2 border-gray-400">
                        <form>
                            <label for="name" class="block font-medium text-xl text-gray-700">Keresés</label>
                            <input type="text" name="name" id="name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300" placeholder="Bejegyzés címe">
                            <button type="submit" class="mt-3 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1"><i class="fas fa-search"></i> Keresés</button>
                        </form>
                    </div>
                    <div class="border px-2.5 py-2 border-gray-400">
                        <h3 class="mb-0.5 text-xl font-semibold">
                            Kategóriák
                        </h3>
                        <div class="flex flex-row flex-wrap gap-1 mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
