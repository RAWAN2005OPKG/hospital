@extends('layouts.app')

@section('title', __('mediflow.doctor_patients_title'))

@section('content')
<div class="container" style="padding: 2rem 0;">
    <h1 class="text-2xl font-bold mb-6">{{ __('mediflow.doctor_patients_title') }}</h1>
    <div class="card overflow-hidden">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('mediflow.name') }}</th>
                    <th>{{ __('mediflow.phone') }}</th>
                    <th>{{ __('mediflow.email') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->phone ?? '—' }}</td>
                        <td>{{ $patient->email ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-gray-500 py-8">{{ __('mediflow.no_patients_yet') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $patients->links() }}</div>
</div>
@endsection
