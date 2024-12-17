<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { FilterMatchMode } from '@primevue/core/api';
import { Column, DataTable, FloatLabel, InputText } from 'primevue';
import { ref } from 'vue';
const { titulos } = defineProps(['personas', 'titulos']);
const filters = ref({
	ci: { value: null, matchMode: FilterMatchMode.CONTAINS },
	'persona.nombres': { value: null, matchMode: FilterMatchMode.CONTAINS },
	'persona.paterno': { value: null, matchMode: FilterMatchMode.CONTAINS },
	'persona.materno': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>

<template>
	<AuthenticatedLayout>
		<section class="w-full bg-red-400">
			<DataTable
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
					<div class="flex justify-between">
						<FloatLabel variant="on">
							<InputText
								placeholder="Carnet de Identidad"
								v-model="filters['ci'].value"
							/>
						</FloatLabel>
						<FloatLabel>
							<InputText
								placeholder="Nombres"
								v-model="filters['persona.nombres'].value"
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
					</div>
				</template>
				<Column field="ci" header="ID"></Column>
				<Column field="persona.nombres" header="Nombres"></Column>
				<Column field="persona.paterno" header="Paterno"></Column>
				<Column field="persona.materno" header="Materno"></Column>
				<Column field="mencion.nombre" header="Mencion"></Column>
				<Column field="fecha_emision" header="Fecha de emision"></Column>
			</DataTable>
		</section>
	</AuthenticatedLayout>
</template>
