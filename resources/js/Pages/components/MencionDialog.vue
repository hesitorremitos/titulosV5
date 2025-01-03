<script setup lang="ts">
import { Button, Dialog, InputText, Select } from 'primevue';

const props = defineProps<{
	mencionForm: any;
	mencionDoalog: boolean;
	submitMencion: () => void;
	carreras: any[];
}>();
</script>

<template>
	<Dialog
		v-model:visible="mencionDoalog"
		modal
		header="Edit Profile"
		:style="{ width: '25rem' }"
	>
		<span class="text-surface-500 dark:text-surface-400 mb-8 block"
			>Añadir mencion</span
		>
		<div class="mb-4 flex items-center gap-4">
			<label for="carrera_tpn" class="w-24 font-semibold">Carrera</label>
			<Select
				id="carrera_tpn"
				class="flex-auto"
				:options="
					carreras.map((c, i) => ({
						label: c.nombre,
						value: c.id,
					}))
				"
				optionLabel="label"
				optionValue="value"
				v-model="mencionForm.carrera_tpn"
			/>
		</div>
		<div class="mb-8 flex items-center gap-4">
			<label for="mencion_tpn" class="w-24 font-semibold"
				>Mencion Titulo Provision Nacional</label
			>
			<InputText
				id="email"
				class="flex-auto"
				autocomplete="off"
				name="mencion_tpn"
				v-model="mencionForm.mencion_tpn"
			/>
		</div>
		<div class="flex justify-end gap-2">
			<Button
				type="button"
				label="Cancel"
				severity="secondary"
				@click="mencionDoalog = false"
			></Button>
			<Button type="button" label="Guardar" @click="submitMencion"></Button>
		</div>
	</Dialog>
</template>
