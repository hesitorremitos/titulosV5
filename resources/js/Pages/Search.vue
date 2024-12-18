<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { FilterMatchMode } from '@primevue/core/api';
import { Column, DataTable, FloatLabel, InputText } from 'primevue';
import { ref } from 'vue';
const { titulos } = defineProps(['titulos']);
const filters = ref({
	ci: { value: null, matchMode: FilterMatchMode.CONTAINS },
	'persona.nombres': { value: null, matchMode: FilterMatchMode.CONTAINS },
	'persona.paterno': { value: null, matchMode: FilterMatchMode.CONTAINS },
	'persona.materno': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>

<template>
	<AuthenticatedLayout>
		<section class="flex max-w-full flex-col rounded-lg bg-blue-500 p-4">
			<DataTable
				scrollable
				class="flex-grow"
				scrollHeight="350px"
				size="small"
				:value="titulos"
				:rows="10"
				:rowsPerPageOptions="[5, 10, 20]"
				filterDisplay="menu"
				v-model:filters="filters"
				:globalFilterFields="[
					'ci',
					'persona.nombres',
					'persona.paterno',
					'persona.materno',
				]"
			>
				<template #header>
					<div class="flex justify-between bg-blue-500 p-4">
						<FloatLabel variant="on">
							<InputText
								placeholder="Carnet de Identidad"
								v-model="filters['ci'].value"
							/>
						</FloatLabel>
						<FloatLabel>
							<InputText
								placeholder="Paterno"
								v-model="filters['persona.paterno'].value"
							/>
						</FloatLabel>
						<FloatLabel>
							<InputText
								placeholder="Materno"
								v-model="filters['persona.materno'].value"
							/>
						</FloatLabel>
						<FloatLabel>
							<InputText
								placeholder="Nombres"
								v-model="filters['persona.nombres'].value"
							/>
						</FloatLabel>
					</div>
				</template>
				<Column field="ci" header="CI"></Column>
				<Column field="persona.nombres" header="Nombres"></Column>
				<Column field="persona.paterno" header="Paterno"></Column>
				<Column field="persona.materno" header="Materno"></Column>
				<Column
					class="overflow-hidden"
					field="mencion.nombre"
					header="Mencion"
				></Column>
				<Column field="fecha_emision" header="Fecha de emision"></Column>
				<Column header="Accion">
					<template #body="slotProps">
						<div class="card flex justify-center">
							<a
								v-if="slotProps.data.verificado"
								class="rounded-md bg-red-500 px-1 py-2 text-gray-200 hover:bg-red-700"
								:href="route('diploma-academico.show', slotProps.data.id)"
								target="_blank"
							>
								Ver
							</a>
							<p v-else class="text-sm text-red-500">No Doc</p>
						</div>
					</template>
				</Column>
			</DataTable>
		</section>
	</AuthenticatedLayout>
</template>

<style scoped>
:root {
	--primary-color: #ff0000; /* Rojo */
	--secondary-color: #0000ff; /* Azul */
	--font-size: 16px;
	--p-datatable-header-padding: 0;
}

/* Personalizar el DataTable */
.p-datatable {
	--p-datatable-header-padding: 10px;
	--p-datatable-header-background-color: var(--primary-color);
	--p-datatable-header-text-color: #ffffff;
	--p-datatable-row-hover-background-color: var(--secondary-color);
}

/* Personalizar el Column */
.p-column {
	--p-column-padding: 10px;
	--p-column-background-color: #f0f0f0;
	--p-column-text-color: #333333;
}

/* Usar variables CSS */
section {
	color: var(--primary-color);
	font-size: var(--font-size);
}

.text-red-500 {
	color: var(--secondary-color);
}
</style>
