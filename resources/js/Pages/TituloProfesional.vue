<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { ref } from 'vue';
import MencionDialog from './components/MencionDialog.vue';
import TituloForm from './components/TituloForm.vue';

const props = defineProps<{
	menciones: {
		nombre: string;
		carrera_id: number;
	}[];
	carreras: {
		nombre: string;
		id: number;
	}[];
}>();

const form = useForm({
	ci: '',
	nombres: '',
	apellido_paterno: '',
	apellido_materno: '',
	fecha_nacimiento: '',
	pais: '',
	departamento: '',
	provincia: '',
	facultad: '',
	localidad: '',
	fojas: '',
	libro: '',
	nivel: '',
	programa: '',
	mencion: '',
	file: null,
	sexo: '',
});

const programas = ref([]);
const selectedPrograma = ref('');
const isLoading = ref(false);
const isReadonly = ref(false);
const toast = useToast();
const mencionDoalog = ref(false);

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
	form.facultad = person.facultad;
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
	form.fojas = '';
	form.libro = '';
	form.nivel = '';
	form.mencion = '';
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

const onFileSelect = (event) => {
	form.file = event.files[0];
};

const mencionForm = useForm({
	carrera_tpn: '',
	mencion_tpn: '',
});

const submitMencion = () => {
	console.log(mencionForm);
	mencionForm.post(route('tpn.store'));
	mencionForm.reset();
	mencionDoalog.value = false;
};

watch(
	() => form.mencion,
	(form) => {
		console.log(form);
	},
);
</script>

<template>
	<AuthenticatedLayout>
		<section class="w-1/2">
			<TituloForm
				:form="form"
				:programas="programas"
				:selected-programa="selectedPrograma"
				:is-loading="isLoading"
				:is-readonly="isReadonly"
				:buscar-persona="buscarPersona"
				:on-programa-change="onProgramaChange"
				:on-file-select="onFileSelect"
				:menciones="props.menciones"
				:mencion-doalog="mencionDoalog"
			/>
			<MencionDialog
				:mencion-form="mencionForm"
				:mencion-doalog="mencionDoalog"
				:submit-mencion="submitMencion"
				:carreras="props.carreras"
			/>
		</section>
	</AuthenticatedLayout>
</template>

<style>
.p-invalid {
	border-color: red;
}
</style>
