<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($maintenanceRecord) ? 'Edit Maintenance Record' : 'Create Maintenance Record' }}
            </h2>
            <a href="{{ route('maintenance-records.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ isset($maintenanceRecord) ? route('maintenance-records.update', $maintenanceRecord) : route('maintenance-records.store') }}" method="POST">
                        @csrf
                        @if(isset($maintenanceRecord))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="equipment_id" class="block text-sm font-medium text-gray-700">Equipment</label>
                                <select name="equipment_id" id="equipment_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Equipment</option>
                                    @foreach($equipment as $item)
                                        <option value="{{ $item->id }}" {{ (old('equipment_id', $maintenanceRecord->equipment_id ?? '') == $item->id) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('equipment_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="maintenance_date" class="block text-sm font-medium text-gray-700">Maintenance Date</label>
                                <input type="date" name="maintenance_date" id="maintenance_date" value="{{ old('maintenance_date', $maintenanceRecord->maintenance_date ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('maintenance_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="maintenance_type" class="block text-sm font-medium text-gray-700">Maintenance Type</label>
                                <select name="maintenance_type" id="maintenance_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Type</option>
                                    <option value="preventive" {{ (old('maintenance_type', $maintenanceRecord->maintenance_type ?? '') == 'preventive') ? 'selected' : '' }}>Preventive</option>
                                    <option value="corrective" {{ (old('maintenance_type', $maintenanceRecord->maintenance_type ?? '') == 'corrective') ? 'selected' : '' }}>Corrective</option>
                                    <option value="predictive" {{ (old('maintenance_type', $maintenanceRecord->maintenance_type ?? '') == 'predictive') ? 'selected' : '' }}>Predictive</option>
                                </select>
                                @error('maintenance_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="technician" class="block text-sm font-medium text-gray-700">Technician</label>
                                <input type="text" name="technician" id="technician" value="{{ old('technician', $maintenanceRecord->technician ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('technician')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cost" class="block text-sm font-medium text-gray-700">Cost</label>
                                <input type="number" step="0.01" name="cost" id="cost" value="{{ old('cost', $maintenanceRecord->cost ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('cost')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Status</option>
                                    <option value="scheduled" {{ (old('status', $maintenanceRecord->status ?? '') == 'scheduled') ? 'selected' : '' }}>Scheduled</option>
                                    <option value="in_progress" {{ (old('status', $maintenanceRecord->status ?? '') == 'in_progress') ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ (old('status', $maintenanceRecord->status ?? '') == 'completed') ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $maintenanceRecord->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $maintenanceRecord->notes ?? '') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($maintenanceRecord) ? 'Update Record' : 'Create Record' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 