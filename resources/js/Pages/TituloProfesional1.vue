<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import searchPerson from './searchPerson';
interface Person {
	ci: string;
	nombres: string;
	paterno: string;
	materno: string;
	fec_nacimiento: string;
	pais: string;
	departamento: string;
	provincia: string;
	localidad: string;
	programa: string;
	// Agrega otros campos según sea necesario
}

const form = useForm({
	ci: '',
	nombres: '',
	apellido_paterno: '',
	apellido_materno: '',
	fecha_nacimiento: '',
	pais: '',
	departamento: '',
	provincia: '',
	localidad: '',
	fojas: '',
	libro: '',
	nivel: '',
	programa: '',
	mencion: '',
});

const programas = ref<Person[]>([]);
const selectedPrograma = ref<string>('');
const isLoading = ref<boolean>(false);
const isReadonly = ref<boolean>(false);

const buscarPersona = async () => {
	isLoading.value = true;
	// @ts-ignore
	const result: Person[] = await searchPerson(form.ci);
	isLoading.value = false;
	if (result && result.length > 0) {
		programas.value = result;
		const person = result[0];
		selectedPrograma.value = person.programa;
		updateForm(person);
		isReadonly.value = true;
	} else {
		clearForm();
		isReadonly.value = false;
	}
};

const updateForm = (person: Person) => {
	form.nombres = person.nombres;
	form.apellido_paterno = person.paterno;
	form.apellido_materno = person.materno;
	form.fecha_nacimiento = person.fec_nacimiento;
	form.pais = person.pais;
	form.departamento = person.departamento;
	form.provincia = person.provincia;
	form.localidad = person.localidad;
	form.programa = person.programa;
	// Actualiza otros campos según sea necesario
};

const clearForm = () => {
	form.nombres = '';
	form.apellido_paterno = '';
	form.apellido_materno = '';
	form.fecha_nacimiento = '';
	form.pais = '';
	form.departamento = '';
	form.provincia = '';
	form.localidad = '';
	form.programa = '';
	// Limpia otros campos según sea necesario
};

const onProgramaChange = () => {
	const selectedPerson = programas.value.find(
		(person) => person.programa === selectedPrograma.value,
	);
	if (selectedPerson) {
		updateForm(selectedPerson);
	}
};
</script>

<template>
	<AuthenticatedLayout>
		<section class="w-1/2">
			<form @submit.prevent="form.post(route('titulo-profesional.store'))">
				<div class="flex justify-center gap-x-3">
					<v-text-field
						v-model="form.ci"
						label="CI"
						:error-messages="form.errors.ci"
					/>
					<VBtn @click="buscarPersona" :loading="isLoading"> Buscar </VBtn>
				</div>
				<div class="grid grid-cols-1 gap-x-3">
					<v-select
						density="compact"
						v-model="selectedPrograma"
						:items="programas.map((p) => p.programa)"
						label="Programa"
						@change="onProgramaChange"
						:error-messages="form.errors.programa"
					/>
				</div>
				<v-text-field
					density="compact"
					v-model="form.nombres"
					label="Nombres"
					:readonly="isReadonly"
					:error-messages="form.errors.nombres"
				/>
				<div class="grid grid-cols-2 gap-x-3">
					<v-text-field
						density="compact"
						v-model="form.apellido_paterno"
						label="Apellido Paterno"
						:error-messages="form.errors.apellido_paterno"
						:readonly="isReadonly"
					/>
					<v-text-field
						density="compact"
						v-model="form.apellido_materno"
						label="Apellido Materno"
						:error-messages="form.errors.apellido_materno"
						:readonly="isReadonly"
					/>
				</div>
				<div class="grid grid-cols-3 gap-x-3">
					<v-text-field
						density="compact"
						v-model="form.fecha_nacimiento"
						label="Fecha de Nacimiento"
						:error-messages="form.errors.fecha_nacimiento"
						:readonly="isReadonly"
					/>
					<v-text-field
						density="compact"
						v-model="form.pais"
						label="Pais"
						:readonly="isReadonly"
						:error-messages="form.errors.pais"
					/>
					<v-text-field
						density="compact"
						v-model="form.departamento"
						label="Departamento"
						:readonly="isReadonly"
						:error-messages="form.errors.departamento"
					/>
				</div>
				<div class="grid grid-cols-2 gap-x-3">
					<v-text-field
						density="compact"
						v-model="form.provincia"
						label="Provincia"
						:readonly="isReadonly"
						:error-messages="form.errors.provincia"
					/>
					<v-text-field
						density="compact"
						v-model="form.localidad"
						label="Localidad"
						:readonly="isReadonly"
						:error-messages="form.errors.localidad"
					/>
				</div>

				<div class="grid grid-cols-3 gap-x-3">
					<v-text-field
						v-model="form.fojas"
						label="Fojas"
						density="compact"
						:error-messages="form.errors.fojas"
					/>
					<v-text-field
						v-model="form.libro"
						label="Libro"
						density="compact"
						:error-messages="form.errors.libro"
					/>
					<v-select
						v-model="form.nivel"
						:items="['Técnico', 'Tecnólogo', 'Profesional']"
						label="Nivel"
						density="compact"
						:error-messages="form.errors.nivel"
					/>
				</div>
				<v-text-field
					v-model="form.mencion"
					label="Mencion"
					density="compact"
					:error-messages="form.errors.mencion"
				/>
				<div class="flex justify-end gap-x-3">
					<v-btn class="mt-2" type="submit" block>Submit</v-btn>
				</div>
			</form>
		</section>
	</AuthenticatedLayout>
</template>
