@if(Auth::user()->role === 'anggota')
<x-member-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="mb-2">
            <h2 class="text-xl font-bold text-slate-800">Profil Akun</h2>
            <p class="text-sm text-slate-500 mt-0.5">Kelola informasi pribadi dan keamanan akun Anda</p>
        </div>
        <div class="p-6 bg-white shadow-sm rounded-2xl border border-slate-100">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="p-6 bg-white shadow-sm rounded-2xl border border-slate-100">
            @include('profile.partials.update-password-form')
        </div>
        <div class="p-6 bg-white shadow-sm rounded-2xl border border-slate-100">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-member-layout>
@else
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Profile') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">@include('profile.partials.update-profile-information-form')</div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">@include('profile.partials.update-password-form')</div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">@include('profile.partials.delete-user-form')</div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
