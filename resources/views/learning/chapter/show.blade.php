{{-- resources/views/learning/chapter/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Titre du chapitre --}}
    <h1 class="text-3xl font-bold mb-4">{{ $chapter->name }}</h1>
    
    {{-- Description --}}
    @if($chapter->description)
        <p class="text-gray-600 mb-6">{{ $chapter->description }}</p>
    @endif

    {{-- Liste des leçons --}}
    @if($chapter->lessons->isEmpty())
        <p class="text-gray-500">Aucune leçon disponible pour ce chapitre.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($chapter->lessons as $lesson)
                <div class="p-4 border rounded-lg shadow-sm hover:shadow-md transition">
                    <h2 class="text-xl font-semibold mb-2">{{ $lesson->name }}</h2>
                    <p class="text-sm text-gray-500 mb-4">{{ Str::limit($lesson->description ?? 'Pas de description.', 100) }}</p>
                    
                    {{-- Bouton pour voir la leçon --}}
                    <a href="{{ route('lesson.show', [$chapter->slug, $lesson->slug]) }}" 
                       class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                        Commencer la leçon
                    </a>
                    
                    {{-- Progression si disponible --}}
                    @if(auth()->check())
                        @php
                            $progress = auth()->user()->lessonProgress()->where('lesson_id', $lesson->id)->first();
                        @endphp
                        @if($progress)
                            <p class="text-sm text-green-600 mt-2">
                                Statut : {{ ucfirst($progress->status) }}
                            </p>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Retour au niveau --}}
    <div class="mt-6">
        <a href="{{ url()->previous() }}" class="text-indigo-600 hover:underline">&larr; Retour</a>
    </div>
</div>
@endsection
