@extends('layouts.app')

@section('content')
<div class="relative min-h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/background.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-50">
    </div>

    <!-- Content Layer -->
    <div class="relative z-10 bg-gradient-to-br from-green-200/80 to-blue-300/80 py-20">
        <div class="text-center mb-16 px-4">
            <h1 class="text-5xl font-bold text-gray-900 drop-shadow-lg">Welcome to FieldBooker</h1>
            <p class="text-lg text-gray-800 mt-4 drop-shadow">Find and book your favorite sport field easily!</p>
        </div>

        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($fields as $field)
                <div class="bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $field->name }}</h2>
                        <p class="text-gray-600 mb-1">📍 {{ $field->location }}</p>
                        <p class="text-gray-800 font-semibold mb-4">💰 Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/hour</p>
                        <a href="{{ route('guest.fields.show', $field->id) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition">
                            View Schedule
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
