<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Maintenance Record Details') }}
            </h2>
            <div class="space-x-4">
                <a href="{{ route('maintenance-records.edit', $maintenanceRecord) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Record
                </a>
                <a href="{{ route('maintenance-records.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Equipment</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('equipment.show', $maintenanceRecord->equipment) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $maintenanceRecord->equipment->name }}
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Maintenance Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $maintenanceRecord->maintenance_date->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Maintenance Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($maintenanceRecord->maintenance_type) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $maintenanceRecord->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($maintenanceRecord->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($maintenanceRecord->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Maintenance Details</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Technician</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $maintenanceRecord->technician }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Cost</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($maintenanceRecord->cost, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $maintenanceRecord->created_at->format('M d, Y H:i:s') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $maintenanceRecord->updated_at->format('M d, Y H:i:s') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $maintenanceRecord->description }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $maintenanceRecord->notes }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 