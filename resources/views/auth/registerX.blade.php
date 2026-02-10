{{-- resources/views/auth/register.blade.php --}}

@extends('layouts.guest')

@section('title', 'Inscription')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">
            <i class="fas fa-user-plus text-indigo-600 mr-2"></i>Inscription
        </h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Nom complet</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-medium mb-2">Téléphone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition">
                S'inscrire
            </button>
        </form>

        <p class="text-center mt-6 text-gray-600">
            Déjà un compte ? 
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Se connecter</a>
        </p>
    </div>
</div>
@endsection