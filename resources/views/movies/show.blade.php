<x-guest-layout>
    <x-slot name="title">
       A(z) {{ $movie->title }} film részletei
    </x-slot>
        <div class="container mx-auto p-3 lg:px-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 mb-4">
                    <div>
                        <h1 class="font-bold my-4 text-4xl">Filmkatalógus</h1>
                        <a href="/" class="text-blue-400 hover:text-blue-600 hover:underline"><i class="fas fa-long-arrow-alt-left"></i> Vissza a főoldalra</a>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4 gap-3">
                    <!-- Részletek -->
                    <div class="col-span-1">
                        <img
                                src="{{ asset(
                                    $movie->image
                                    ? 'storage/thumbnails/' . $movie->image
                                    : 'images/placeholder.jpg') }}"  class="min-h-48 h-48 max-h-48 object-cover"
                            >
                        <h3 class="text-xl mb-0.5 font-semibold">
                            {{ $movie['title'] }}
                        </h3>
                        <h4 class="text-gray-400">
                            <span class="mr-2"><i class="fas fa-user"></i> {{ $movie['director'] }}</span>
                            <span><i class="fa fa-calendar-alt"></i> {{ $movie['year'] }}</span>
                            @if (count($movie->ratings) > 0)
                                <br><span><i class="far ">Értékelés: </i> {{ floor($movie->ratings->sum('rating') / count($movie->ratings)) }} / 5</span>
                            @else
                                <div >
                                    Nincs értékelve!
                                </div>
                            @endif
                        </h4>
                        <span><i></i>Leírás:  {{ $movie['description'] }}</span>
                        <br><span><i> Játékidő: </i> {{ ceil($movie['length'] / 60) }} perc</span>
                    </div>

                    <!-- Ratings -->
                    <div class="col-span-1">
                        <h2 class="font-semibold text-3xl my-2">Értékelések</h2>
                        @forelse ($ratings as $rating)
                            <br><span></i>Értékelés időpontja: {{ $rating->updated_at }}; Értékelés: {{ $rating->rating }} / 5</span><br>
                        @empty
                        <div class="col-span-3 px-2 py-4 bg-blue-100">
                            Ez a film még nincs értékelve!
                        </div>
                        @endforelse
                        {{ $ratings->links() }}
                    </div>

                    <!-- Sidebar -->
                    <div class="col-span-1">
                        <h2 class="font-semibold text-3xl my-2">Menü</h2>
                        @if($movie->trashed())
                            <h3 class="mt-3 bg-red-500 text-gray-100 font-semibold text-center px-2 py-1">
                                Törölve
                            </h3>
                        @endif
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
                            @can('edit', $movie)
                                <div class="border px-2.5 py-2 border-gray-400">
                                    <h3 class="mb-0.5 text-xl font-semibold">
                                        <a href="{{ route('movies.edit', ['movie' => $movie]) }}" class="mt-3 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1"><i class="fas fa-angle-right"></i>Módosítás</a>
                                    </h3>
                                </div>
                                <div class="border px-2.5 py-2 border-gray-400">
                                    <h3 class="mb-0.5 text-xl font-semibold">
                                    <form method="POST" action="{{ route('ratings.destroy', $movie) }}" id="ratings-destroy-form">
                                        @method('DELETE')
                                        @csrf
                                        <input name="id" value="{{ $movie->id }}" type="hidden" />
                                        <a
                                            href="#"
                                            onclick="event.preventDefault(); document.querySelector('#ratings-destroy-form').submit();"
                                            class="mt-3 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1">
                                            <i class="far fa-trash-alt"></i> Értékelések törlése
                                        </a>
                                    </form>
                                    </h3>
                                </div>
                                @if($movie->trashed())
                                    <div class="border px-2.5 py-2 border-gray-400">
                                        <h3 class="mb-0.5 text-xl font-semibold">
                                            <a href="{{ route('movies.restore', $movie->id) }}" class="mt-3 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1">Visszaállítás</a>
                                        </h3>
                                    </div>
                                @else
                                    <div class="border px-2.5 py-2 border-gray-400">
                                        <h3 class="mb-0.5 text-xl font-semibold">
                                        <form method="POST" action="{{ route('movies.destroy', $movie) }}" id="movie-destroy-form">
                                            @method('DELETE')
                                            @csrf
                                            <a
                                                href="#"
                                                onclick="event.preventDefault(); document.querySelector('#movie-destroy-form').submit();"
                                                class="mt-3 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1">
                                                <i class="far fa-trash-alt"></i> Film törlése
                                            </a>
                                        </form>
                                        </h3>
                                    </div>
                                @endif
                            @endcan
                            @auth
                            @if($movie->ratings_enabled)
                                <div class="border px-2.5 py-2 border-gray-400">
                                    <form action="{{ route('ratings.store') }}" method="POST">
                                        @csrf
                                        <input name="id" value="{{ $movie->id }}" type="hidden" />
                                        <div class="mb-5">
                                            <p>Mennyire értékeled a filmet?</p>
                                            <input type="radio" id="1" name="rating" value="1" >
                                            <label for="1">1</label><br>
                                            <input type="radio" id="2" name="rating" value="2" >
                                            <label for="2">2</label><br>
                                            <input type="radio" id="3" name="rating" value="3" >
                                            <label for="3">3</label><br>
                                            <input type="radio" id="4" name="rating" value="4" >
                                            <label for="4">4</label><br>
                                            <input type="radio" id="5" name="rating" value="5" >
                                            <label for="5">5</label><br>
                                            @error('rating')
                                                <p class="text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-5">
                                            <label for="text" class="block text-lg font-medium text-gray-700">Egyéb megjegyzések</label>
                                            <textarea rows="5" name="comment" id="comment" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm ">{{ old('comment') }}</textarea>
                                        </div>
                                        <button type="submit" class="mt-6 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1 text-xl">Elküld</button>
                                    </form>
                                    @if (Session::has('rating_created'))
                                        <div class="px-3 py-5 mb-5 bg-green-500 text-blue font-semibold">
                                            Az értékelés sikeresen megtörtént!
                                        </div>
                                    @endif
                                </div>
                            @else
                            <div class="col-span-1 px-2 py-4 bg-blue-100">
                                Ennél a filmnél le vannak tiltva az értéklelések!
                            </div>
                            @endif
                                @if (Session::has('movie_created'))
                                    <div class="px-3 py-5 mb-5 bg-green-500 text-blue font-semibold">
                                        A film létrehozása sikeresen megtörtént!
                                    </div>
                                @endif
                                @if (Session::has('movie_updated'))
                                    <div class="px-3 py-5 mb-5 bg-green-500 text-blue font-semibold">
                                        A film módosítása sikeresen megtörtént!
                                    </div>
                                @endif
                                @if (Session::has('ratings_deleted'))
                                    <div class="px-3 py-5 mb-5 bg-green-500 text-blue font-semibold">
                                        Az értékelések törlése sikeresen megtörtént!
                                    </div>
                                @endif
                            @endauth

                        </div>
                    </div>
                </div>
        </div>
</x-guest-layout>
