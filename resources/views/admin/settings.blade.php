@extends('contensio::admin.layout')
@section('title', 'Back to Top')
@section('breadcrumb')
<a href="{{ route('contensio.settings') }}" class="text-gray-500 hover:text-gray-700">Settings</a>
<span class="mx-2 text-gray-300">/</span>
<span class="font-medium text-gray-700">Back to Top</span>
@endsection
@section('content')

@if(session('success'))
<div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
    <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
    <svg class="w-4 h-4 shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <div>{{ $errors->first() }}</div>
</div>
@endif

<form method="POST" action="{{ route('contensio-back-to-top.settings.update') }}">
@csrf
<div class="space-y-4">
    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-6">
        <h2 class="text-base font-bold text-gray-900">Back to Top Button</h2>

        {{-- Position --}}
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Button position</label>
            <div class="flex flex-wrap gap-3">
                @foreach($positions as $pos)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="position" value="{{ $pos }}"
                           {{ $config['position'] === $pos ? 'checked' : '' }}
                           class="accent-ember-500">
                    <span class="text-sm text-gray-700 capitalize">{{ str_replace('-', ' ', $pos) }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Scroll threshold --}}
        <div class="space-y-2">
            <label for="threshold" class="block text-sm font-medium text-gray-700">
                Scroll threshold
                <span class="font-normal text-gray-400">(px scrolled before button appears)</span>
            </label>
            <div class="flex items-center gap-3">
                <input type="number" id="threshold" name="threshold"
                       value="{{ old('threshold', $config['threshold']) }}"
                       min="100" max="2000" step="50"
                       class="w-28 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ember-500 focus:border-transparent">
                <span class="text-sm text-gray-400">px &mdash; min 100, max 2000</span>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-ember-500 hover:bg-ember-600 text-white font-semibold text-sm px-5 py-2 rounded-lg transition-colors">
            Save settings
        </button>
    </div>
</div>
</form>

@endsection
