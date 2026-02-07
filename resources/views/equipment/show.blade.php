<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Equipment Details') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('equipment.edit', $equipment) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Equipment
                </a>
                <a href="{{ route('equipment.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $equipment->status === 'available' ? 'bg-green-100 text-green-800' : 
                                               ($equipment->status === 'in_use' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($equipment->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->location }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->category ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Condition</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($equipment->condition ?? 'N/A') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Technical Details</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Serial Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->serial_number ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Model Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->model_number ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Manufacturer</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->manufacturer ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Maintenance Information</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Maintenance</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->last_maintenance_date ? $equipment->last_maintenance_date->format('M d, Y') : 'Never' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Next Maintenance</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->next_maintenance_date ? $equipment->next_maintenance_date->format('M d, Y') : 'Not Scheduled' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Purchase Information</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Purchase Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->purchase_date ? $equipment->purchase_date->format('M d, Y') : 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Warranty Expiry</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $equipment->warranty_expiry_date ? $equipment->warranty_expiry_date->format('M d, Y') : 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                            <p class="text-sm text-gray-900">{{ $equipment->description ?? 'No description available.' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                            <p class="text-sm text-gray-900">{{ $equipment->notes ?? 'No notes available.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 