<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Column, DataTable } from 'primevue';
const props = defineProps(['personas']);
</script>

<template>
	<AuthenticatedLayout>
		<section class="w-full bg-red-400">
			<DataTable
				:value="props.personas"
				:rows="10"
				:rowsPerPageOptions="[5, 10, 20]"
			>
				<Column field="ci" header="ID"></Column>
				<Column field="nombres" header="Nombres"></Column>
				<Column field="paterno" header="Paterno"></Column>
				<Column field="materno" header="Materno"></Column>
				<Column field="diplomas_academicos" header="Diplomas"></Column>
			</DataTable>
		</section>
	</AuthenticatedLayout>
</template>
