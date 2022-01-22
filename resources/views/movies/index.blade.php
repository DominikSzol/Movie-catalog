<x-guest-layout>
    <x-slot name="title">
        Főoldal
    </x-slot>


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
                    @forelse ($movies as $movie)
                        <div class="col-span-3 lg:col-span-1 border border-gray-400 flex flex-col">
                            <img
                                src="{{ asset(
                                    $movie->image
                                    ? 'storage/thumbnails/' . $movie->image
                                    : 'images/placeholder.jpg') }}"  class="min-h-48 h-48 max-h-48 object-cover"
                            >
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="px-2.5 py-2">
                                        <h3 class="text-xl mb-0.5 font-semibold">
                                            {{ $movie['title'] }}
                                        </h3>
                                        <h4 class="text-gray-400">
                                            <span class="mr-2"><i class="fas fa-user"></i> {{ $movie['director'] }}</span>
                                            <span><i class="far fa-calendar-alt"></i> {{ $movie['year'] }}</span>
                                            @if (count($movie->ratings) > 0)
                                                <br><span><i class="far ">Értékelés: </i> {{ floor($movie->ratings->avg('rating')) }} / 5</span>
                                            @else
                                                <div class="far ">
                                                    Nincs értékelve!
                                                </div>
                                            @endif
                                        </h4>
                                        <a href="{{ route('movies.show', $movie->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 px-1.5 py-1 text-white mt-3 font-semibold text-center">Részletek <i class="fas fa-angle-right"></i>
                                        </a>
                                        @if($movie->trashed())
                                            <h3 class="mt-3 bg-blue-500 text-gray-100 font-semibold text-center px-2 py-1">
                                                Törölve
                                            </h3>
                                        @endif
                                    </div>

                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-3 px-2 py-4 bg-blue-100">
                            Nincsenek még filmek feltöltve!
                        </div>
                    @endforelse

                    {{ $movies->links() }}

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-span-4 lg:col-span-1">
                <h2 class="font-semibold text-3xl my-2">Menü</h2>
                <div class="grid grid-cols-1 gap-3">
                    <div class="border px-2.5 py-2 border-gray-400">
                        <form>
                            <label for="name" class="block font-medium text-xl text-gray-700">Keresés</label>
                            <input type="text" name="name" id="name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300" placeholder="Film címe">
                            <button type="submit" class="mt-3 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1"><i class="fas fa-search"></i> Keresés</button>
                        </form>
                    </div>
                    <div class="border px-2.5 py-2 border-gray-400">
                        <h3 class="mb-0.5 text-xl font-semibold">
                            Az oldal adatai
                        </h3>
                        <p> {{ $users_num }} regisztrált felhasználó  </p>
                        <p> {{ $movies_num }} megtalálható film </p>
                        <p> {{ $ratings_num }} megtörtént értékelés</p>
                    </div>
                    <div class="border px-2.5 py-2 border-gray-400">
                        <h3 class="mb-0.5 text-xl font-semibold">
                            <a href="{{ route('movies.top') }}" class="mt-3 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1"><i class="fas fa-angle-right"></i>Toplista</a>
                        </h3>
                    </div>
                    @can('create', App\Movie::class)
                        <div class="border px-2.5 py-2 border-gray-400">
                            <h3 class="mb-0.5 text-xl font-semibold">
                                <a href="{{ route('movies.create') }}" class="mt-3 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1"><i class="fas fa-angle-right"></i>Új film hozzáadása</a>
                            </h3>
                        </div>
                    @endcan
                    @if (Session::has('movie_deleted'))
                        <div class="px-3 py-5 mb-5 bg-green-500 text-red font-semibold">
                            A film sikeresen törölve lett!
                        </div>
                    @endif
                    @if (Session::has('movie_restored'))
                        <div class="px-3 py-5 mb-5 bg-green-500 text-red font-semibold">
                            A film sikeresen vissza lett állítva!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
