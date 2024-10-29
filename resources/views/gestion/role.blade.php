<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex flex-col md:flex-row md:justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Roles') }}</h3>
                    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-role')" class="mt-2 md:mt-0">
                        {{ __('Create Role') }}
                    </x-primary-button>
                </div>

                <!-- Roles Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($roles as $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $role->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $role->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-role-{{ $role->id }}')">
                                        {{ __('Edit') }}
                                    </x-primary-button>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button class="ms-2" onclick="return confirm('Are you sure you want to delete this role?');">
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

    <!-- Create Role Modal -->
    <x-modal name="create-role" focusable>
        <form method="POST" action="{{ route('roles.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Create Role') }}</h2>

            <div class="mt-4">
                <x-input-label for="role_name" value="{{ __('Role Name') }}" />
                <x-text-input id="role_name" name="name" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                <x-primary-button class="ms-3">{{ __('Create Role') }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Role Modal -->
    @foreach($roles as $role)
    <x-modal name="edit-role-{{ $role->id }}" focusable>
        <form method="POST" action="{{ route('roles.update', $role->id) }}" class="p-6">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Edit Role') }}</h2>

            <div class="mt-4">
                <x-input-label for="role_name" value="{{ __('Role Name') }}" />
                <x-text-input id="role_name" name="name" type="text" class="mt-1 block w-full" value="{{ $role->name }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                <x-primary-button class="ms-3">{{ __('Update Role') }}</x-primary-button>
            </div>
        </form>
    </x-modal>
    @endforeach
</x-app-layout>
