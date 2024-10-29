<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Banks or Methods') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Banks or Methods') }}</h3>
                    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-bank-method')">
                        {{ __('Create Bank Method') }}
                    </x-primary-button>
                </div>

                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($banksMethod as $bank)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $bank->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $bank->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <x-primary-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'edit-bank-method-{{ $bank->id }}')">
                                                {{ __('Edit') }}
                                            </x-primary-button>
                                            <form action="{{ route('banks.destroy', $bank) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button class="ms-2" onclick="return confirm('Are you sure you want to delete this bank method?');">
                                                    {{ __('Delete') }}
                                                </x-danger-button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Bank Method Modal -->
    <x-modal name="create-bank-method" focusable>
        <form method="POST" action="{{ route('banks.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Create Bank Method') }}</h2>

            <div class="mt-4">
                <x-input-label for="name" value="{{ __('Name') }}" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                <x-primary-button class="ms-3">{{ __('Create Bank Method') }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Bank Method Modal -->
    @foreach ($banksMethod as $bank)
        <x-modal name="edit-bank-method-{{ $bank->id }}" focusable>
            <form method="POST" action="{{ route('banks.update', $bank) }}" class="p-6">
                @csrf
                @method('PUT')
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Edit Bank Method') }}</h2>

                <div class="mt-4">
                    <x-input-label for="name" value="{{ __('Name') }}" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ $bank->name }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                    <x-primary-button class="ms-3">{{ __('Update Bank Method') }}</x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach
</x-app-layout>
