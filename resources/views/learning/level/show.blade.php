{{-- resources/views/learning/level/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Niveau : {{ $level->name }}</h1>

    @if($level->chapters->isEmpty())
        <p class="text-gray-600">Aucun chapitre disponible pour ce niveau.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($level->chapters as $chapter)
                <div class="p-4 border rounded-lg shadow-sm hover:shadow-md">
                    <h2 class="text-xl font-semibold mb-2">{{ $chapter->name }}</h2>
                    <p class="text-sm text-gray-500 mb-2">
                        {{ $chapter->lessons_count }} leçon(s)
                    </p>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $chapter->progress_percentage }}%;"></div>
                    </div>
                    <p class="text-sm text-gray-700">{{ $chapter->progress_percentage }}% complété</p>
                    <a href="{{ route('chapter.show', $chapter->slug) }}" class="mt-2 inline-block text-indigo-600 hover:underline">Voir le chapitre</a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
