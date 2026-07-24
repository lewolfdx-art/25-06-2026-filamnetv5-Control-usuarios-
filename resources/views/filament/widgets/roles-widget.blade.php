<div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
    <!-- Encabezado -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            👑 Roles del Sistema
        </h3>
        <div class="flex items-center gap-2">
            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                {{ $this->getRoles()->count() }} roles
            </span>
            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                {{ $this->getTotalUsers() }} usuarios
            </span>
        </div>
    </div>

    <!-- Grid de Tarjetas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($this->getRoles() as $role)
            @php
                $colores = [
                    'super_admin' => ['bg' => 'bg-red-500', 'text' => 'text-red-500'],
                    'admin' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-500'],
                    'Editor' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-500'],
                    'Author' => ['bg' => 'bg-green-500', 'text' => 'text-green-500'],
                    'Vendedor' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-500'],
                ];
                $color = $colores[$role->name] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-500'];
                $total = $this->getTotalUsers();
                $porcentaje = $total > 0 ? round(($role->users_count / $total) * 100) : 0;
            @endphp

            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $role->name }}
                    </span>
                    <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ $role->users_count }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $role->users_count == 1 ? 'usuario' : 'usuarios' }}
                </p>
                <div class="mt-3">
                    <div class="w-full h-2 bg-gray-200 rounded-full dark:bg-gray-700 overflow-hidden">
                        <div class="h-2 rounded-full transition-all duration-500 {{ $color['bg'] }}"
                             style="width: {{ max($porcentaje, 2) }}%;">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>