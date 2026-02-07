<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Equipment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('equipment.update', $equipment) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $equipment->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $equipment->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="available" {{ old('status', $equipment->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="in_use" {{ old('status', $equipment->status) == 'in_use' ? 'selected' : '' }}>In Use</option>
                                <option value="maintenance" {{ old('status', $equipment->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $equipment->location)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        <div>
                            <x-input-label for="last_maintenance_date" :value="__('Last Maintenance Date')" />
                            <x-text-input id="last_maintenance_date" name="last_maintenance_date" type="date" class="mt-1 block w-full" :value="old('last_maintenance_date', $equipment->last_maintenance_date?->format('Y-m-d'))" />
                            <x-input-error class="mt-2" :messages="$errors->get('last_maintenance_date')" />
                        </div>

                        <div>
                            <x-input-label for="next_maintenance_date" :value="__('Next Maintenance Date')" />
                            <x-text-input id="next_maintenance_date" name="next_maintenance_date" type="date" class="mt-1 block w-full" :value="old('next_maintenance_date', $equipment->next_maintenance_date?->format('Y-m-d'))" />
                            <x-input-error class="mt-2" :messages="$errors->get('next_maintenance_date')" />
                        </div>

                        <div>
                            <x-input-label for="purchase_date" :value="__('Purchase Date')" />
                            <x-text-input id="purchase_date" name="purchase_date" type="date" class="mt-1 block w-full" :value="old('purchase_date', $equipment->purchase_date?->format('Y-m-d'))" />
                            <x-input-error class="mt-2" :messages="$errors->get('purchase_date')" />
                        </div>

                        <div>
                            <x-input-label for="warranty_expiry_date" :value="__('Warranty Expiry Date')" />
                            <x-text-input id="warranty_expiry_date" name="warranty_expiry_date" type="date" class="mt-1 block w-full" :value="old('warranty_expiry_date', $equipment->warranty_expiry_date?->format('Y-m-d'))" />
                            <x-input-error class="mt-2" :messages="$errors->get('warranty_expiry_date')" />
                        </div>

                        <div>
                            <x-input-label for="serial_number" :value="__('Serial Number')" />
                            <x-text-input id="serial_number" name="serial_number" type="text" class="mt-1 block w-full" :value="old('serial_number', $equipment->serial_number)" />
                            <x-input-error class="mt-2" :messages="$errors->get('serial_number')" />
                        </div>

                        <div>
                            <x-input-label for="model_number" :value="__('Model Number')" />
                            <x-text-input id="model_number" name="model_number" type="text" class="mt-1 block w-full" :value="old('model_number', $equipment->model_number)" />
                            <x-input-error class="mt-2" :messages="$errors->get('model_number')" />
                        </div>

                        <div>
                            <x-input-label for="manufacturer" :value="__('Manufacturer')" />
                            <x-text-input id="manufacturer" name="manufacturer" type="text" class="mt-1 block w-full" :value="old('manufacturer', $equipment->manufacturer)" />
                            <x-input-error class="mt-2" :messages="$errors->get('manufacturer')" />
                        </div>

                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" :value="old('category', $equipment->category)" />
                            <x-input-error class="mt-2" :messages="$errors->get('category')" />
                        </div>

                        <div>
                            <x-input-label for="condition" :value="__('Condition')" />
                            <select id="condition" name="condition" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="excellent" {{ old('condition', $equipment->condition) == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="good" {{ old('condition', $equipment->condition) == 'good' ? 'selected' : '' }}>Good</option>
                                <option value="fair" {{ old('condition', $equipment->condition) == 'fair' ? 'selected' : '' }}>Fair</option>
                                <option value="poor" {{ old('condition', $equipment->condition) == 'poor' ? 'selected' : '' }}>Poor</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('condition')" />
                        </div>

                        <div>
                            <x-input-label for="notes" :value="__('Notes')" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $equipment->notes) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Equipment') }}</x-primary-button>
                            <a href="{{ route('equipment.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 