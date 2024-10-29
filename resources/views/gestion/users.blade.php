<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Users') }}</h3>
                    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-user')">
                        {{ __('Create User') }}
                    </x-primary-button>
                </div>

                <!-- Tabla de Usuarios -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-50">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Name') }}</th>
                                <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Email') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Username') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Role') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->role->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <x-primary-button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'edit-user-{{ $user->id }}')">
                                            {{ __('Edit') }}
                                        </x-primary-button>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button class="ms-1"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
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

    <!-- Create User Modal -->
    <x-modal name="create-user" focusable>
        <form method="POST" action="{{ route('users.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Create User') }}</h2>

            <div class="mt-4">
                <x-input-label for="name" value="{{ __('Name') }}" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" value="{{ __('Email') }}" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="username" value="{{ __('Username') }}" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            @if (!isset($user))
                <div class="mt-4">
                    <x-input-label for="password" value="{{ __('Password') }}" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            @endif

            <div class="mt-4">
                <x-input-label for="role_id" :value="__('Role')" />
                <select id="role_id" name="role_id" class="block mt-1 w-full">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                <x-primary-button class="ms-3">{{ __('Create User') }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit User Modal -->
    @foreach ($users as $user)
        <x-modal name="edit-user-{{ $user->id }}" focusable>
            <form method="POST" action="{{ route('users.update', $user) }}" class="p-6">
                @csrf
                @method('PATCH')
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Edit User') }}</h2>

                <div class="mt-4">
                    <x-input-label for="name" value="{{ __('Name') }}" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        value="{{ $user->name }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" value="{{ __('Email') }}" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                        value="{{ $user->email }}" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="username" value="{{ __('Username') }}" />
                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                        value="{{ $user->username }}" required />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="role_id" value="{{ __('Role') }}" />
                    <select id="role_id" name="role_id" class="block mt-1 w-full">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                </div>

                <!-- Password Change Section -->
                <div class="mt-4">
                    <x-input-label for="password" value="{{ __('New Password') }}" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                    <x-primary-button class="ms-3">{{ __('Update User') }}</x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach

</x-app-layout>
