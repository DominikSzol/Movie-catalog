<x-guest-layout>
    <x-slot name="title">
        Új Film
    </x-slot>

    <div class="container mx-auto p-3 lg:px-36 overflow-hidden min-h-screen">
        <div class="mb-5">
            <h1 class="font-semibold text-3xl mb-4">Új film</h1>
            <p class="mb-2">Ezen az oldalon tudsz új film leírást létrehozni.</p>
            <a href="/" class="text-blue-400 hover:text-blue-600 hover:underline"><i class="fas fa-long-arrow-alt-left"></i> Vissza a főoldalra</a>
        </div>

        <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label for="title" class="block text-lg font-medium text-gray-700">Film címe</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm @error('title') border-red-400 @else border-gray-400 @enderror">
                @error('title')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="director" class="block text-lg font-medium text-gray-700">Rendező</label>
                <input type="text" name="director" id="director" value="{{ old('director') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm @error('director') border-red-400 @else border-gray-400 @enderror">
                @error('director')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="block text-lg font-medium text-gray-700">Film leírása</label>
                <textarea rows="5" name="description" id="description" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm @error('description') border-red-400 @else border-gray-400 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="year" class="block text-lg font-medium text-gray-700">Kiadás éve</label>
                <input type="number" name="year" id="year" value="{{ old('year') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm @error('year') border-red-400 @else border-gray-400 @enderror">
                @error('year')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="length" class="block text-lg font-medium text-gray-700">Film hossza</label>
                <input type="number" name="length" id="length" value="{{ old('length') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm @error('length') border-red-400 @else border-gray-400 @enderror">
                @error('length')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <div class="flex flex-col gap-1.5 mt-2">
                    <div class="flex items-center gap-1.5">
                        <input type="checkbox" id="ratings_enabled" name="ratings_enabled" {{ old('ratings_enabled') ? 'checked' : '' }}>
                        <label for="ratings_enabled">
                            Értékelések engedélyezése
                        </label>
                    </div>
                </div>
                @error('ratings_enabled')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="name" class="block  text-lg font-medium text-gray-700">Kép</label>
                <input type="file" class="form-control-file" id="image" name="image">
                @error('image')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="mt-6 bg-blue-500 hover:bg-blue-600 text-gray-100 font-semibold px-2 py-1 text-xl">Létrehozás</button>
        </form>
    </div>

</x-guest-layout>
