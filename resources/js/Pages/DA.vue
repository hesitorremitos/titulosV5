<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineOptions({
	layout: MainLayout,
});

const props = defineProps({
	titulos: {
		type: Object,
	},
	request: {
		type: Object,
	},
});

const search = ref({
	ci: props.request?.ci || '',
	nombres: props.request?.nombres || '',
	paterno: props.request?.paterno || '',
	materno: props.request?.materno || '',
});

const handleSearch = () => {
	router.get(route('diploma-academico.index'), search.value, {
		preserveState: true,
		preserveScroll: true,
	});
};

const handleClear = () => {
	search.value = {
		ci: '',
		nombres: '',
		paterno: '',
		materno: '',
	};
	handleSearch();
};
</script>

<template>
	<div class="flex h-full flex-col p-4">
		<div class="mb-4 flex-none">
			<div class="flex gap-2">
				<input
					v-model="search.ci"
					type="text"
					placeholder="Buscar CI..."
					class="w-full rounded border p-2 focus:border-blue-500 focus:outline-none"
					@keyup.enter="handleSearch"
				/>

				<input
					v-model="search.paterno"
					type="text"
					placeholder="Paterno"
					class="w-full rounded border p-2 focus:border-blue-500 focus:outline-none"
					@keyup.enter="handleSearch"
				/>
				<input
					v-model="search.materno"
					type="text"
					placeholder="Materno"
					class="w-full rounded border p-2 focus:border-blue-500 focus:outline-none"
					@keyup.enter="handleSearch"
				/>
				<input
					v-model="search.nombres"
					type="text"
					placeholder="Nombres"
					class="w-full rounded border p-2 focus:border-blue-500 focus:outline-none"
					@keyup.enter="handleSearch"
				/>
				<button
					@click="handleSearch"
					class="whitespace-nowrap rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
				>
					Buscar
				</button>
				<button
					@click="handleClear"
					class="whitespace-nowrap rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700"
				>
					Limpiar
				</button>
			</div>
		</div>

		<div class="flex-1 overflow-hidden">
			<div class="relative h-full overflow-y-auto">
				<table
					class="min-w-full divide-y divide-gray-200 border border-gray-200"
				>
					<thead class="sticky top-0 z-10 bg-gray-800">
						<tr>
							<th
								class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white"
							>
								CI
							</th>
							<th
								class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white"
							>
								Nombres
							</th>
							<th
								class="text-nowrap px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white"
							>
								Paterno
							</th>
							<th
								class="text-nowrap px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white"
							>
								Materno
							</th>

							<th
								class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white"
							>
								Mencion
							</th>
							<th
								class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white"
							>
								F. Emisión
							</th>
							<th
								class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white"
							>
								Acciones
							</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 bg-white">
						<tr
							v-for="titulo in titulos.data"
							:key="titulo.id"
							class="hover:bg-gray-50"
						>
							<td class="whitespace-nowrap px-2 py-2">{{ titulo.ci }}</td>
							<td class="whitespace-nowrap px-2 py-2">
								{{ titulo.persona.nombres }}
							</td>
							<td class="whitespace-nowrap px-6 py-4">
								{{ titulo.persona.paterno }}
							</td>
							<td class="whitespace-nowrap px-6 py-4">
								{{ titulo.persona.materno }}
							</td>
							<td class="px-6 py-4">
								{{ titulo.mencion.nombre }}
							</td>
							<td class="whitespace-nowrap px-6 py-4">
								{{ titulo.fecha_emision }}
							</td>
							<td class="whitespace-nowrap px-6 py-4">
								<a
									v-if="titulo.verificado"
									:href="route('diploma-academico.show', titulo.id)"
									target="_blank"
									class="mr-2 rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700"
								>
									Ver
								</a>
								<span v-else class="text-red-500">No Doc</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="mt-4 flex flex-none items-center justify-between">
			<div v-for="(link, i) in titulos.links" :key="i">
				<Link
					v-if="link.url"
					:href="link.url"
					v-html="link.label"
					:class="[
						'rounded px-3 py-1',
						link.active
							? 'bg-blue-600 text-white'
							: 'text-gray-700 hover:bg-gray-100',
					]"
				/>
				<span v-else v-html="link.label"></span>
			</div>
		</div>
	</div>
</template>
